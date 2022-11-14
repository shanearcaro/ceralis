<?php
    session_start();

    $db_credentials = include 'credentials.php';

    $connection = new mysqli($db_credentials['HOST'], $db_credentials['NAME'], $db_credentials['PASS'], $db_credentials['DATABASE']);

    // Prompt error if database connection doesn't work and exit the script
    if ($connection->connect_error) {
	    echo "Failed to connect to MYSQL: " . mysqli_connect_error();
        exit();
    }

    // Read posted user data from the front end
    $user_data = json_decode(file_get_contents('php://input'));

    $accountID = array_pop($user_data);
    $studentExamID = array_pop($user_data); //  StudentExams.submission_id
    $totalPoints = 0;

    $response = "Success";

    // Loop through every reviewed question and update the score in the database
    // Since this is not DB access related I am not editing the values here 
    // so the old middleend script can be used with minimal edit
    for ($i = 0; $i < count($user_data); $i++) {
        $record = $user_data[$i];
        $score = $record->{'score'};
        $comment = $record->{'comment'};
        $questionID = $record->{'questionID'};
        $result1 = $record->{'result1'};
        $result2 = $record->{'result2'};
        $result3 = $record->{'result3'};
        $result4 = $record->{'result4'};
        $result5 = $record->{'result5'};
        $totalPoints += $score;

        $query = "UPDATE CompletedExam SET score='{$score}', comment='{$comment}', result1='{$result1}', result2='{$result2}', result3='{$result3}', result4='{$result4}', result5='{$result5}' WHERE question_id='{$questionID}' AND submission_id='{$studentExamID}'";
        $result = mysqli_query($connection, $query);
        if (!$result)
            $response = "Failure";
    }
    // Update the students overall exam score
    $query = "UPDATE StudentExams SET score='{$totalPoints}' WHERE submission_id='{$studentExamID}'";
    $result = mysqli_query($connection, $query);
    if (!$result)
            $response = "Failure";
    
    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>