<?php
    session_start();

    $db_credentials = include 'credentials.php';

    $connection = new mysqli($db_credentials['HOST'], $db_credentials['NAME'], $db_credentials['PASS'], $db_credentials['DATABASE']);

    // Prompt error if database connection doesn't work and exit the script
    if ($connection->connect_error) {
	    echo "Failed to connect to MYSQL: " . mysqli_connect_error();
        exit();
    }


    // Get max id from Exams table
    $query = "SELECT * FROM Exams WHERE exam_id=(SELECT max(exam_id) FROM Exams)";
    $result = mysqli_query($connection, $query);

    // Page variables
    $total = mysqli_num_rows($result);
    $numberOfQuestions = 0;
    $accountID = -1;
    $teacherID = -1;
    $questionList = array();
    $pointsList = array();

    // Calculate the exam id for the new entry
    $examID = -1;
    if ($total == 1) {
        while ($row = mysqli_fetch_array($result)) {
            $maxID = $row['exam_id'];
        }
        $examID = $maxID + 1;
    }
    else
        $examID = 1;


    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'));

    // Separate data into two different arrays, one for questions and one for points
    foreach($user_data as $key => $value) {
        array_push($questionList, $key);
        array_push($pointsList, $value);
    }
    // Calculate number of questions and account id from input data
    $numberOfQuestions = count($questionList) - 1;
    $accountID = $pointsList[$numberOfQuestions];

    /*
    // We have the accountID but to create an exam we need the teacherID
    $query = "SELECT teacherID FROM Teachers WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $teacherID = $row['teacherID'];
    }*/
    $teacherID = $user_data->{'userID'};
    
    // The last element in questionList is just a regular array index not a questionID
    // The corresponding element in pointsList is the accountID for the currently signed in user
    // These elements need to be popped from the ends of the arrays
    array_pop($questionList);
    array_pop($pointsList);

    $totalPointValue = array_sum($pointsList);

    // No questions were selected when creating an exam
    if ($numberOfQuestions == 0) {
        $response = "Empty Exam";
    }
    else {
        // Create an Exam and ExamQuestions that link questions to a specific exam
        $query = "INSERT INTO Exams (exam_id, creator_id, title, points, question_count) VALUES ('{$examID}', '{$teacherID}', '{$examID}', '{$totalPointValue}', '{$numberOfQuestions}')";
        mysqli_query($connection, $query);
        for ($i = 0; $i < $numberOfQuestions; $i++) {
            $questionID = $questionList[$i];
            $pointValue = $pointsList[$i];
            $query = "INSERT INTO ExamQuestions (exam_id, question_id, questionPoints) VALUES ('{$examID}', '{$questionID}', '{$pointValue}')";
            mysqli_query($connection, $query);
        }
        $response = "Exam Created";
    }
    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>