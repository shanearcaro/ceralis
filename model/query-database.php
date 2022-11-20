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
 *      user_id, questiontype, difficulty, constraint, question
 *      insertionStatus
 * 
 * 2 - Select questions created by a teacher
 *      user_id
 *      question_id, created, question_type, difficulty, question_text
 *
 * 3 - Insert exam
 *      user_id, title, points, question_count
 *      insertionStatus
 * 
 * 4 - Insert -1 exam score (when student started exam)
 *      user_id, exam_id
 *      insertionStatus
 * 
 * 5 - Select exam questions
 *      exam_id
 *      question_id, question_text, questionPoints
 * 
 * 6 - Update score (by StudentExams.studentexam_id)
 *      studentexam_id, score
 *      insertionStatus
 * 
 * 7 - Update score (by user_id and exam_id)
 *      user_id, exam_id, score
 *      insertionStatus 
 * 
 * 8 - Select completed exam
 *      studentexam_id
 *      question_id, answer, questionPoints, created, question_text
 *
 * 9 - Select name
 *      user_id
 *      name
 * 
 * 10 - Select teachers exam (given user id teachers, sent user id and name is students)
 *      user_id
 *      studentexam_id, user_id, exam_id, score, name
 * 
 * 11 - Select students exam (sent name is teachers name) (aka selectExamsStudent.php)
 *      user_id
 *      exam_id, points, question_count, user_id, name
 * 
 * 12 - Select exam submissions (given user id students, sent name is teachers) (points is out-of-XX) (aka selectStudentExams.php)
 *      user_id
 *      studentexam_id, name, user_id, exam_id, score, points
 * 
 * 13 - Get studentexam_id (from StudentExams) (Used formerly by both insertCompleteExam.php and selectExamResults.php)
 *      user_id, exam_id
 *      studentexam_id
 * 
 * 14 - Get question_id list (from ExamQuestions) (Used formerly by insertCompleteExam.php)
 *      exam_id
 *      question_id[]
 * 
 * 15 - Insert completed exam (Loop previously handled in insertCompleteExam.php needs to be implemented middle-end)
 *      studentexam_id, question_id, answer, question_count, result1, result2, result3, result4, result5, score, comment
 *      insertionStatus
 * 
 * 16 - Select exam results
 *      studentexam_id
 *      question_id, answer, result1, result2, result3, result4, result5, \
 *         \ score, comment, studentGrade, questionPoints, question_text, points
 * 
 * 17 - Insert test case
 *      question_id, case_input, case_answer
 *      insertionStatus
 * 
 * 18 - Select test cases
 *      question_id
 *      (case_input, case_answer)[]
 * 
 */

switch($request_code) {
    
    case 0:
        $query = $pdo->prepare("SELECT user_id, position FROM Users WHERE name = ? AND password= ?");
        $query->execute([$data->{'username'}, $data->{'password'}]);
        break;


    case 1:
        $query = $pdo->prepare("INSERT INTO Questions (user_id, question_type, difficulty, constraint, question_text) 
            VALUES (?, ?, ?, ?, ?)");

        $query->execute([$data->{'user_id'}, $data->{'questiontype'}, $data->{'difficulty'}, 
            $data->{'constraint'}, $data->{'question_text'}]);

        break;

        
    case 2:
        $query = $pdo->prepare("SELECT question_id, created, question_type, difficulty, question_text
            FROM Questions WHERE user_id= ? ");

        $query->execute([$data->{'user_id'}]);
        break;


    case 3:
        $query = $pdo->prepare("INSERT INTO Exams (user_id, title, points, question_count) VALUES (?, ?, ?, ?)");
        $query->execute([$data->{'user_id'}, $data->{'title'}, $data->{'points'}, $data->{'question_count'}]);
        break;


    case 4:
        $query = $pdo->prepare("INSERT INTO StudentExams (user_id, exam_id, score) VALUES (?, ?, -1)");
        $query->execute([$data->{'user_id'}, $data->{'exam_id'}]);
        break;


    case 5:
        $query = $pdo->prepare("SELECT q.question_id, q.question_text, eq.questionPoints FROM ExamQuestions as eq 
            INNER JOIN Exams AS e ON eq.exam_id=e.exam_id 
            INNER JOIN Questions AS q ON eq.question_id=q.question_id 
            WHERE e.exam_id= ? ");

        $query->execute([$data->{'exam_id'}]);
        break;


    case 6:
        $query = $pdo->prepare("UPDATE StudentExams SET score = ? WHERE studentexam_id= ? ");
        $query->execute([$data->{'score'}, $data->{'studentexam_id'}]);
        break;


    case 7:
        $query = $pdo->prepare("UPDATE StudentExams SET score = ? WHERE user_id = ? and exam_id = ? ");
        $query->execute([$data->{'score'}, $data->{'user_id'}, $data->{'exam_id'}]);
        break;


    case 8:
        $query = $pdo->prepare("SELECT ce.studentexam_id, ce.question_id, ce.answer, eq.questionPoints, q.question_text, 
            FROM CompletedExam AS ce 
            INNER JOIN StudentExams AS se ON ce.studentexam_id=se.studentexam_id 
            INNER JOIN ExamQuestions AS eq ON se.exam_id=eq.exam_id AND ce.question_id=eq.question_id 
            INNER JOIN Questions AS q ON ce.question_id=q.question_id 
            WHERE ce.studentexam_id= ? ");

        $query->execute([$data->{'studentexam_id'}]);
        break;


    case 9:
        $query = $pdo->prepare("SELECT name FROM Users WHERE user_id = ? ");
        $query->execute([$data->{'studentexam_id'}]);
        break;


    case 10:
        $query = $pdo->prepare("SELECT se.studentexam_id, se.user_id, se.exam_id, e.score, u.name FROM StudentExams AS se 
            INNER JOIN Exams AS e on se.exam_id=e.exam_id 
            INNER JOIN Users AS u on se.user_id=u.user_id 
            WHERE se.score=-1 AND e.user_id = ? 
            ORDER BY se.examID ASC");

        $query->execute([$data->{'user_id'}]);
        break;


    case 11:
        $query = $pdo->prepare("SELECT e.exam_id, e.points, e.question_count, e.user_id, u.name FROM Exams as e 
            INNER JOIN Users as u ON u.user_id=e.user_id 
            WHERE exam_id NOT IN (
                SELECT sei.exam_id FROM Exams AS ei JOIN StudentExams AS sei ON ei.exam_id=sei.exam_id 
                WHERE sei.user_id = ? 
            )
            ORDER BY e.exam_id ASC;");

        $query->execute([$data->{'user_id'}]);
        break;
    

    case 12:
        $query = $pdo->prepare("SELECT se.studentexam_id, u.name, se.user_id, se.exam_id, se.score, e.points FROM StudentExams AS se
            INNER JOIN Exams AS e on se.exam_id=e.exam_id
            INNER JOIN Users AS u ON e.user_id=u.user_id
            WHERE se.score != -1 AND se.user_id = ?
            ORDER BY se.exam_id ASC");
        
        $query->execute([$data->{'user_id'}]);
        break;
    

    case 13:
        $query = $pdo->prepare("SELECT studentexam_id FROM StudentExams WHERE user_id = ? AND exam_id = ? ");
        $query->execute([$data->{'user_id'}, $data->{'exam_id'}]);
        break;


    case 14:
        $query = $pdo->prepare("SELECT question_id FROM ExamQuestions WHERE exam_id= ? ");
        $query->execute([$data->{'exam_id'}]);
        break;


    case 15: 
        $query = $pdo->prepare("INSERT INTO CompletedExam (studentexam_id, question_id, answer, result1, result2, 
            result3, result4, result5, score, comment) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?");

        $query->execute([$data->{'studentexam_id'}, $data->{'question_id'}, $data->{'answer'}, 
            $data->{'result1'}, $data->{'result2'}, $data->{'result3'}, $data->{'result4'}, 
            $data->{'result5'}, $data->{'score'}, $data->{'comment'}]);

        break;
    

    case 16:
        $query = $pdo->prepare("SELECT ce.studentexam_id, ce.question_id, ce.answer, ce.result1, ce.result2, ce.result3,
            ce.result4, ce.result5, ce.score, ce.comment, se.score AS studentGrade, eq.questionPoints, q.question_text, e.points 
            FROM CompletedExam AS ce
            INNER JOIN StudentExams AS se ON ce.studentexam_id=se.studentexam_id
            INNER JOIN ExamQuestions AS eq ON se.exam_id=eq.exam_id AND ce.question_id=eq.question_id
            INNER JOIN Questions AS q ON ce.question_id=q.question_id
            INNER JOIN Exams AS e ON e.exam_id=se.exam_id
            WHERE ce.studentexam_id = ? ");

        $query->execute([$data->{'studentexam_id'}]);
        break;
    

    case 17:
        $query = $pdo->prepare("INSERT INTO TestCases(question_id, case_input, case_answer) VALUES (?, ?, ?)");
        $query->execute([$data->{'question_id'}, $data->{'case_input'}, $data->{'case_answer'}]);
        break;
    
    
    case 18:
        $query = $pdo->prepare("SELECT case_input, case_answer FROM TestCases WHERE question_id = ? ");
        $query->execute([$data->{'question_id'}]);
        break;
    
}

$response = $query->fetch();
echo json_encode($response);
