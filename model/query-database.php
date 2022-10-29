<?php
require_once('vendor/autoload.php');

// Read credentials
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

// Create connection string
$dsn = "mysql:host={$_ENV['HOST']};dbname={$_ENV['DATABASE']};charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

// Try connection
try {
     $pdo = new PDO($dsn, $_ENV['NAME'], $_ENV['PASS'], $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Get variables and request code
$data = json_decode(file_get_contents('php://input'));
$request_code = $data->{'request'};

/**
 * ================
 *  Code directory
 * ================
 * Request Number - Description
 *      Recieving variables
 *      Returning variables
 * 
 * 0 - Login request
 *      username, password
 *      accountID
 */

switch($request_code) {
    case 0:
        $query = $pdo->prepare("SELECT accountID FROM Users WHERE username = ? AND password= ?");
        $query->execute([$data->{'username'}, $data->{'password'}]);
        break;

}

$response = $query->fetch();
echo json_encode($response);