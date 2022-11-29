<?php
require_once("config/browser-config.php");

// Get form data
$post_data = $_POST;

// Encode
$encoded = json_encode($post_data);

// Curl
$url = $post_url . "/login/query";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $encoded);

// Decode the results of sending the data
$result = curl_exec($ch);
curl_close($ch);

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
    $data = json_decode($result);
    $responseArray = array();

    foreach ($data as $row) {
        array_push($responseArray, autograde($row));
    }

    print_r($responseArray);
}
else {
    echo $result;
}

function autograde($row) {
    // Create a new file to run test cases
    $fileName = "question.py";

    // Python file result and error code
    $execResult = array();
    $return_code = 0;

    // Attempt to open the file in write mode
    $file = fopen($fileName, "w") or die("Unable to open file!");

    // Set file permissions 
    chmod($fileName, 0755);
    
    // Write shell shebang
    $shebang = "#!/usr/bin/env python3" . PHP_EOL;

    // Write everything to file
    fwrite($file, $shebang);
    fwrite($file, $row->{"answer"} . PHP_EOL);
    fwrite($file, "print(" . $row->{"case"} . ")");

    // Close file after writting
    fclose($file);

    // Run python file and record output
    exec("./question.py" . ' 2>&1', $execResult, $return_code);

    // Delete the file
    unlink($fileName);

    // If the file contains a syntax error report it instead of the actual output
    if ($return_code == 1)
        return "Syntax Error: invalid syntax";

    // Return python file output
    return $execResult[0];
}