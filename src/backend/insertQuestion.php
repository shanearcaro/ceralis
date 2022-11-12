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
    
    // Data received is already json encoded
    // Instead of decoding to just encode just send encoded data
    $userID = $user_data->{'userID'};
    $questiontype = $user_data->{'questiontype'};
    $questiondiff = $user_data->{'questiondiff'};
    $questionconst = $user_data->{'questionconst'};
    $questiontext = $user_data->{'questiontext'};
    $tc1 = $user_data->{'tc1'};
    $an1 = $user_data->{'an1'};
    $tc2 = $user_data->{'tc2'};
    $an2 = $user_data->{'an2'};
    $tc3 = $user_data->{'tc3'}; // It is crucial these are passed here as NULL and not left blank
    $an3 = $user_data->{'an3'};
    $tc4 = $user_data->{'tc4'}; 
    $an4 = $user_data->{'an4'};
    $tc5 = $user_data->{'tc5'};
    $an5 = $user_data->{'an5'};
    
    

/*
    // // We have the accountID but to create an exam we need the teacherID
    $query = "SELECT user_id FROM Users WHERE user_ID='{$teacherID}' and position='teacher'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $teacherID = $row['teacherID'];
*/

    // //Insert question data into question table
    $query = "INSERT INTO Questions (creator_id, question_type, difficulty, question_text, tc1, an1, tc2, an2, tc3, an3, tc4, an4, tc5, an5) 
              VALUES ('{$userID}', '{$questiontype}', '{$questiondiff}', '{$questiontext}', '{$tc1}', '{$an1}', '{$tc2}', '{$an2}', '{$tc3}', '{$an3}', '{$tc4}', '{$an4}', '{$tc5}', '{$an5}')"; 

    $result = mysqli_query($connection, $query);
    $response = $result ? "Success" : "Failure";

    echo json_encode($response);

    $connection->close();
 ?>