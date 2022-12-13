<?php

// Get form data
$post_data = $_POST;

// $post_data = array(
//     "request" => 0,
//     "username" => "studentshane",
//     "password" => "studentpassword"
// );

// Encode
$encoded = json_encode($post_data);

// Curl
$url = "https://afsaccess4.njit.edu/~sma237/CS490/model/query-database.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

// Decode the results of sending the data
$result = curl_exec($ch);
// curl_close($ch);

// User is not authenticated
if(!isset($_SESSION['user_id'])) {
    $response = json_decode($result);
    if (isset($response->{'user_id'}))
        $_SESSION['user_id'] = $response->{'user_id'};
} 

/**
 * Request code 7 is an autograde request. The query will be handled normally
 * but before the information is returned to the user the autograder must be run.
 */
if ($post_data['request'] == 7) {
    // print_r($post_data);
    $data = json_decode($result);
    $responseArray = array();

    // Get points for all questions
    $post_data["request"] = 15;

    // Encode
    $encoded = json_encode($post_data);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
    $result = curl_exec($ch);

    foreach ($data as $row) {
        $grade = autograde($row);
        $index = array(
            "studentexamid"    => $row->{"studentexam_id"}, 
            "questionid"       => $row->{"question_id"}, 
            "testcaseid"       => $row->{"testcase_id"},
            "answer"           => $row->{"case_answer"}, 
            "autoresult"       => $grade[0]
        );

        // Auto grade is complete
        array_push($responseArray, $index);
    }

    $questionsArray = json_decode($result);

    $pointsCount = array();
    $pointsValue = array();

    foreach ($responseArray as $question) {
        $val = $question["questionid"];
        if (!array_key_exists($val, $pointsCount))
            $pointsCount[$val] = 0;
        $pointsCount[$val] += 1;
    }

    foreach ($questionsArray as $question) {
        $val = number_format((float)$question->{"points"}, 2, '.', '');
        if (!array_key_exists($val, $pointsValue))
            $pointsValue[$question->{"question_id"}] = $val;
    }

    for ($i = 0; $i < count($responseArray); $i++) {
        // print_r($responseArray[$i]);
        $id = $responseArray[$i]["questionid"];
        $responseArray[$i]["points"] = $pointsValue[$id] / $pointsCount[$id];

        if ($responseArray[$i]["answer"] == $responseArray[$i]["autoresult"])
            $responseArray[$i]["score"] = $responseArray[$i]["points"];
        else
        $responseArray[$i]["score"] = 0;

        // Update request code
        $responseArray[$i]["request"] = 19;

        // Encode
        $encoded = json_encode($responseArray[$i]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
        curl_exec($ch);
    }

    $studentExams = array();

    foreach ($responseArray as $examResults) {
        $studentExams["studentexamid"] = $examResults["studentexamid"];
        $score = $examResults["score"];

        if (!array_key_exists("score", $studentExams))
            $studentExams["score"] = $score;
        else
            $studentExams["score"] += $score;
    }
    $studentExams["request"] = 6;
    
    // Encode
    $encoded = json_encode($studentExams);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);
    $result = curl_exec($ch);
    echo $result;
}
else {
    echo $result;
}

function autograde(object $row): array {
    // print_r($row);
    // Create a new file to run test cases
    $fileName = "question.py";

    // Python file result and error code
    $execResult = array();
    $return_code = 0;

    // Attempt to open the file in write mode
    $file = fopen($fileName, "w") or die("Unable to open file!");

    // Set file permissions 
    chmod($fileName, 0755);
    
    // Test whether the answer and case have the correct name
    $functionName = testFunctionName($row->{"answer"}, $row->{"case"});

    // Write the student's function into the file
    fwrite($file, $row->{"answer"} . PHP_EOL);

    // Write the correct case for the function and take off points if necessary
    if ($functionName == -1) 
        fwrite($file, "print(" . $row->{"case"} . ")");
    else
        fwrite($file, "print(" . $functionName . ")");

    // Close file after writting
    fclose($file);

    // Run python file and record output
    exec("python ./question.py" . ' 2>&1', $execResult, $return_code);

    // Delete the file
    unlink($fileName);

    // If the file contains a syntax error report it instead of the actual output
    if ($return_code == 1) {
        if (!strpos($row->{"case"}, "(")) {
            $case = $row->{"case"};

            if ($case == "None" || $case == "For" || $case == "While" || $case == "Recursion")
                return array(testConstraint($row->{"answer"}, getCorrectFunctionName($row->{"answer"}), $row->{"case"}));
            else {
                return array(getCorrectFunctionName($row->{"answer"}));
            }

        }
        return array("Syntax Error: invalid syntax");
    }

    // Return python file output
    return array($execResult[0]);
}

function getCorrectFunctionName(string $answer): string {
    // Get the function name of the test case
    $offset = strpos($answer, "def") + 4;
    return substr($answer, $offset, strpos($answer, "(") - $offset);
}

/**
 * Give the answer and a test case check to see if the function names of both are the same.
 * If this is not the case the auto grader will fail because the python file will contain a unknown function which will cause a syntax error. 
 * 
 * Return -1 if the function names are the same and no changes need to be made
 * Return the updated function name if the function names are not the same and need to be updated
 */
function testFunctionName(string $answer, string $testcase) {
    $answer = getCorrectFunctionName($answer);

    // Get the function name of the test case
    $case = substr($testcase, 0, strpos($testcase, "("));

    // If the case function name and the answer function name are the same return -1, no changes need to be made
    if ($case == $answer)
        return -1;
    // else return the name of the new function name to user
    $answer .= substr($testcase, strpos($testcase, "("));
    return $answer;
}

function testConstraint(string $answer, string $functionName, string $constraint): string {
    // If there is not constraint no testing needs to be done
    if ($constraint == "None")
        return "None";

    if ($constraint == "While") {
        if (strpos($answer, "while"))
            return "While";
    }

    if ($constraint == "For") {
        if (strpos($answer, "for"))
            return "For";
    }

    if ($constraint == "Recursion") {
        $offset = strpos($answer, $functionName);

        if (!$offset)
            return "false";

        if (strpos($answer, $functionName, $offset))
            return "Recursion" ;
    }

    return "false";
}