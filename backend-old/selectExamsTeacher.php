<?php
    //gets exams by teacher
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
    
    // Data received is already json encoded
    // Instead of decoding to just encode just send encoded data
    $accountID = $user_data->{'accountID'};
    $response = $accountID;
    /*
    // We have the accountID but to create an exam we need the studentID
    $query = "SELECT teacherID FROM Teachers WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);*/
    $teacherID = $user_data->{'accountID'};

    $query = "SELECT se.submission_id, se.user_id, se.exam_id, e.score, u.name FROM StudentExams AS se
                INNER JOIN Exams AS e on se.exam_id=e.exam_id
                INNER JOIN Users AS u on se.user_id=u.user_id
                WHERE se.score=-1 AND e.creator_id='{$teacherID}'
                ORDER BY se.examID ASC";
                
    $result = mysqli_query($connection, $query);

    $exams = array();

    while ($row = mysqli_fetch_array($result)) {
        $exam = array('submission_id' => $row['submission_id'], 'user_id' => $row['user_id'], 
        'exam_id' => $row['exam_id'], 'score' => $row['score'], 'name' => $row['name']);
        array_push($exams, $exam);
    }

    $response = count($exams) == 0 ? "Empty" : $exams;
    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>