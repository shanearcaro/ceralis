<?php
    session_start();

    $db_credentials = include 'credentials.php';

    $connection = new mysqli($db_credentials['HOST'], $db_credentials['NAME'], $db_credentials['PASS'], $db_credentials['DATABASE']);

    // Prompt error if database connection doesn't work and exit the script
    if ($connection->connect_error) {
	    echo "Failed to connect to MYSQL: " . mysqli_connect_error();
        exit();
    }

    $user_data = json_decode(file_get_contents('php://input'));
    $answers = $user_data;
    $response = "Success";

    // Get the accountID and the examID
    $accountID = array_pop($answers);
    $examID = array_pop($answers);

    // We have the accountID but to create an exam we need the studentID
    /*$query = "SELECT studentID FROM Students WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    if (!$result) $response = "Failure";
    $row = mysqli_fetch_array($result);
    $studentID = $row['studentID'];*/
    $studentID = $accountID;

    // We have the accountID but to create an exam we need the teacherID
    $query = "SELECT submission_id FROM StudentExams WHERE user_id='{$studentID}' AND exam_id='{$examID}'";
    $result = mysqli_query($connection, $query);
    if (!$result) $response = "Failure";
    $row = mysqli_fetch_array($result);
    $studentExamID = $row['submission_id'];

    // Get all the questionIDs for the current exam
    $query = "SELECT question_id FROM ExamQuestions WHERE exam_id='{$examID}'";
    $result = mysqli_query($connection, $query);
    if (!$result) $response = "Failure";

    // Need a list of questionIDs to match with the answers
    $questionIDs = array();
    while ($row = mysqli_fetch_array($result)) {
        $questionID = $row['question_id'];
        array_push($questionIDs, $questionID);
    }
    // TODO what is completedexam????
    // Loop through every question and insert the answer into the database
    for ($i = 0; $i < count($questionIDs); $i++) {
        $query = "INSERT INTO CompletedExam (submission_id, question_id, answer, result1, result2, result3, result4, result5, score, comment) 
            VALUES ('{$studentExamID}', '{$questionIDs[$i]}', '{$answers[$i]}', NULL, NULL, NULL, NULL, NULL, 0, NULL)";
        
        $result = mysqli_query($connection, $query);
        if (!$result) $response = "Failure";
    }

    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>