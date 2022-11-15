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
    $accountID = $user_data[0];

    // Get the username
    $query = "SELECT name FROM Users WHERE user_id='{$accountID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $username = $row['name'];

    $response = json_encode($username);
    echo $response;

    $connection->close();
 ?>