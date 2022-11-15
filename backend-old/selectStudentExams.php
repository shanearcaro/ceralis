<?php
    //adding file for reference and recordkeeping reasons
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
    /*
    // We have the accountID but to view graded exams we need the studentID
    $query = "SELECT studentID FROM Students WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);*/
    $studentID = $user_data->{'accountID'};

    // Query to pull all exams that are graded and linked to this student
    $query = "SELECT se.submission_id, u.name, se.user_id, se.exam_id, se.score, e.points FROM StudentExams AS se
                INNER JOIN Exams AS e on se.exam_id=e.exam_id
                INNER JOIN Users AS u ON e.creator_id=u.user_id
                WHERE se.score != -1 AND se.user_id='{$studentID}'
                ORDER BY se.exam_id ASC";
    
    $result = mysqli_query($connection, $query);

    $exams = array();

    while ($row = mysqli_fetch_array($result)) {
        $exam = array(
            'studentExamID' => $row['submission_id'], 
            'examID'        => $row['exam_id'], 
            'score'         => $row['score'], 
            'examPoints'    => $row['points'],
            'username'      => $row['name']);
        array_push($exams, $exam);
    }

    $response = count($exams) == 0 ? "Empty" : $exams;
    $response = json_encode($response);
    echo $response;

    $connection->close();
?>