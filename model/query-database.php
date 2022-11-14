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

/*
 * ================
 *  Code directory
 * ================
 * Request Number - Description
 *      Recieving variables
 *      Returning variables
 * 
 * 0 - Login request
 *      username, password
 *      user_id, position
 * 
 * 1 - Insert question
 *      user_id, questiontype, difficulty, constraint, question, tc1, an1, tc2, an2, tc3, an3, tc4, an4, tc5, an5
 *      insertionStatus
 * 
 * 2 - Select questions created by a teacher
 *      user_id
 *      question_id, created, question_type, difficulty, question_text, tc1, an1, tc2, an2, tc3, an3, tc4, an4, tc5, an5
 *
 * 3 - Insert exam
 *      user_id, title, points, question_count
 *      insertionStatus
 * 
 * 4 - Insert -1 score , usually when student started exam
 *      user_id, exam_id
 *      insertionStatus
 * 
 * 5 - Select exam questions
 *      exam_id
 *      question_id, question_text, questionPoints
 *
 */

switch($request_code) {
    case 0:
        $query = $pdo->prepare("SELECT user_id, position FROM Users WHERE name = ? AND password= ?");
        $query->execute([$data->{'username'}, $data->{'password'}]);
        break;

    case 1:
        $query = $pdo->prepare("INSERT INTO Questions (creator_id, question_type, difficulty, constraint, question_text, tc1, an1, tc2, an2, tc3, an3, tc4, an4, tc5, an5) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?. ?)");
        $query->execute([$data->{'user_id'}, $data->{'questiontype'}, $data->{'difficulty'}, $data->{'constraint'}, $data->{'question_text'}, $data->{'tc1'}, $data->{'an1'}, $data->{'tc2'}, $data->{'an2'}, $data->{'tc3'}, $data->{'an3'}, $data->{'tc4'}, $data->{'an4'}, $data->{'tc5'}, $data->{'an5'}]);
        break;

    case 2:
        $query = $pdo->prepare("SELECT question_id, created, question_type, difficulty, question_text, tc1, an1, tc2, an2, tc3, an3, tc4, an4, tc5, an5 FROM Questions WHERE creator_id= ? ");
        $query->execute([$data->{'user_id'}]);
        break;

    case 3:
        $query = $pdo->prepare("INSERT INTO Exams (creator_id, title, points, question_count) VALUES (?, ?, ?, ?)");
        $query->execute([$data->{'user_id'}, $data->{'title'}, $data->{'points'}, $data->{'question_count'}]);
        break;

    case 4:
        $query = $pdo->prepare("INSERT INTO StudentExams (user_id, exam_id, score) VALUES (?, ?, -1)");
        $query->execute([$data->{'user_id'}, $data->{'exam_id'}]);
        break;

    case 5:
        $query = $pdo->prepare("SELECT q.question_id, q.question_text, eq.questionPoints FROM ExamQuestions as eq INNER JOIN Exams AS e ON eq.exam_id=e.exam_id INNER JOIN Questions AS q ON eq.question_id=q.question_id WHERE e.exam_id= ? ");
        $query->execute([$data->{'exam_id'}]);
        break;
}

$response = $query->fetch();
echo json_encode($response);