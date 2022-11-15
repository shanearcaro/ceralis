<?php
    //gets untaken exams by student
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
    // We have the accountID but to create an exam we need the studentID
    $query = "SELECT studentID FROM Students WHERE accountID='{$accountID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);*/
    $studentID = $user_data->{'accountID'};

    $query = "SELECT e.exam_id, e.points, e.question_count, e.creator_id, u.name
                FROM Exams as e 
                INNER JOIN Users as u ON u.user_id=e.creator_id
                WHERE exam_id NOT IN (
                    SELECT sei.exam_id FROM Exams AS ei JOIN StudentExams AS sei ON ei.exam_id=sei.exam_id WHERE sei.user_id='{$studentID}'
                )
                ORDER BY e.exam_id ASC;";
                
    $result = mysqli_query($connection, $query);

    $exams = array();

    while ($row = mysqli_fetch_array($result)) {
        $exam = array('exam_id' => $row['exam_id'], 'points' => $row['points'], 
        'question_count' => $row['question_count'], 'creator_id' => $row['creator_id'], 'name' => $row['name']);
        array_push($exams, $exam);
    }

    $response = count($exams) == 0 ? "Empty" : $exams;
    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>