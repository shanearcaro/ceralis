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
echo $result;
