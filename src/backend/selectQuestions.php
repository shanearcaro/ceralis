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
    
    $teacherID = $user_data->{'userID'};
    
    //Insert question data into question table
    $query = "SELECT * FROM Questions WHERE creator_id='{$teacherID}'"; 
    $result = mysqli_query($connection, $query);

    $questions = array();

    while ($row = mysqli_fetch_array($result)) {
        $question = array('questionID' => $row['question_id'], 'question' => 
            $row['question'], 'testcase1' => $row['testcase1'], 'testcase2' => $row['testcase2']);
        array_push($questions, $question);
    }

    $response = count($questions) == 0 ? "Empty" : $questions;
    $response = json_encode($response);
    echo $response;

    $connection->close();
 ?>