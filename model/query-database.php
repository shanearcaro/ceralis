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
 *     [Recieving variables]
 *     [Returning variables]
 * 
 * 0 - Authenticate login
 *     [username, password]
 *     [user_id, position]
 * 
 * 1 - Select student tables
 *     []
 *     [exam_id, user_id, title, points, e.date, score, se.date]
 * 
 * 2 - Select teacher exams
 *     [userid]
 *     [examid, userid, title, points, score, name, ]
 * 
 * 3 - Delete Exam
 *     [userid, examid, studentid]
 *     []
 * 
 * 4 - Get exam questions
 *     [examid]
 *     [examid, questionid, points, text, difficulty]
 * 
 * 5 - Update exam questions with answer
 *     [examid, questionid answer]
 *     []
 * 
  * 6 - Update student exam score
 *     [userid, examid, score]
 *     []
 */

//  Execute queries based on request 
switch($request_code) {
    case 0:
        $query = $pdo->prepare(
            "SELECT user_id, position 
            FROM Users 
            WHERE username = ? AND password= ?");
        $query->execute([$data->{'username'}, $data->{'password'}]);
        break;
    case 1:
        $query = $pdo->prepare(
            "SELECT e.exam_id, e.user_id, e.title, e.points, e.date, u.name, se.score, se.date 
            FROM Exams AS e 
            INNER JOIN StudentExams AS se ON e.exam_id = se.exam_id 
            INNER JOIN Users AS u ON e.user_id = u.user_id
            WHERE se.user_id = ?
            ORDER BY e.exam_id ASC");
        $query->execute([$data->{'userid'}]);
        break;
    case 2:
        $query = $pdo->prepare(
            "SELECT e.exam_id, se.user_id, e.title, e.points, e.date, u.name, se.score
            FROM Exams as e
            INNER JOIN StudentExams AS se on e.exam_id = se.exam_id
            INNER JOIN Users AS u ON se.user_id = u.user_id
            WHERE e.user_id = ?
            ORDER BY e.exam_id ASC");
        $query->execute([$data->{'userid'}]);
        break;
    case 3:
        $query = $pdo->prepare(
            "DELETE FROM StudentExams 
            WHERE user_id = ? AND exam_id= ?");
        $query->execute([$data->{'studentid'}, $data->{'examid'}]);

        /**
         * Return true here and exit, don't want to use the default
         * functionality since it will always return false here
         */
        echo json_encode(true);
        exit();
    case 4:
        $query = $pdo->prepare(
            "SELECT eq.exam_id, eq.question_id, eq.points, q.text, q.difficulty
            FROM ExamQuestions as eq
            INNER JOIN Questions AS q on eq.question_id = q.question_id
            WHERE eq.exam_id = ?
            ORDER BY eq.question_id");
        $query->execute([$data->{'examid'}]);
        break;
    case 5:
        $query = $pdo->prepare(
            "UPDATE ExamQuestions
            SET answer = ?
            WHERE exam_id = ? AND question_id = ?");
        $query->execute([$data->{'answer'}, $data->{'examid'}, $data->{'questionid'}]);

        /**
         * Return true here and exit, don't want to use the default
         * functionality since it will always return false here
         */
        echo json_encode(true);
        exit();
    case 6:
        print_r($data);
        $query = $pdo->prepare(
            "UPDATE StudentExams
            SET score = ?
            WHERE user_id = ? AND exam_id = ?");
        $query->execute([$data->{'score'}, $data->{'studentid'}, $data->{'examid'}]);

        /**
         * Return true here and exit, don't want to use the default
         * functionality since it will always return false here
         */
        echo json_encode(true);
        exit();
}       

// Fetch data and return
$response = $query->fetchAll();
echo json_encode($query->rowCount() == 0 ? false : $response);