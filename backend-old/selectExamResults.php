<?php
    //It is likely this file will cause link problems
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
    $user_data2 = file_get_contents('php://input');

    // Get the accountID and the examID the user selected to get the StudentExamID
    $accountID = $user_data->{'accountID'};
    $examID = $user_data->{'examID'}[0];

    $query = "SELECT se.submission_id FROM StudentExams AS se
                INNER JOIN Users AS u ON se.user_id=u.user_id
                WHERE u.user_id='{$accountID}' AND se.exam_id='{$examID}'";
    $result = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($result);
    $studentExamID = $row['submission_id'];

    $questionAnswers = array();
    
    // Get all answers for the exam
    $query = "SELECT ce.submission_id, ce.question_id, ce.answer, ce.result1, ce.result2, ce.result3, ce.result4, ce.result5, ce.score, ce.comment, 
                se.score AS studentGrade, eq.questionPoints, q.question_text, q.tc1, q.an1, q.tc2, q.an2, q.tc3, q.an3, q.tc4, q.an4, q.tc5, q.an5, e.points
                FROM CompletedExam AS ce
                INNER JOIN StudentExams AS se ON ce.submission_id=se.submission_id
                INNER JOIN ExamQuestions AS eq ON se.exam_id=eq.exam_id AND ce.question_id=eq.question_id
                INNER JOIN Questions AS q ON ce.question_id=q.question_id
                INNER JOIN Exams AS e ON e.exam_id=se.exam_id
                WHERE ce.submission_id='{$studentExamID}'";

    /**
     * Results are not being added into the database properly after the auto grader is run 
     * ** Results meaning the result of running the python script
     */

    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $questionID     = $row['question_id'];
        $question       = $row['question_text'];
        $answer         = $row['answer'];
        $result1        = $row['result1'];
        $result2        = $row['result2'];
        $result3        = $row['result3'];
        $result4        = $row['result4'];
        $result5        = $row['result5'];
        $score          = $row['score'];
        $studentGrade   = $row['studentGrade'];
        $comment        = $row['comment'];
        $examPoints     = $row['points'];
        $points         = $row['questionPoints'];
        $testcase1      = $row['tc1'];
        $caseAnswer1    = $row['an1'];
        $testcase2      = $row['tc2'];
        $caseAnswer2    = $row['an2'];
        $testcase3      = $row['tc3'];
        $caseAnswer3    = $row['an3'];
        $testcase4      = $row['tc4'];
        $caseAnswer4    = $row['an4'];
        $testcase5      = $row['tc5'];
        $caseAnswer5    = $row['an5'];
        
        // Since this is not DB access related I am not editing the values here 
        // so the old middleend script can be used with minimal edit
        $questionResponse = array(
            'questionID'    => $questionID, 
            'question'      => $question,
            'answer'        => $answer,
            'result1'       => $result1, 
            'result2'       => $result2, 
            'result3'       => $result3, 
            'result4'       => $result4, 
            'result5'       => $result5, 
            'score'         => $score,
            'studentGrade'  => $studentGrade,
            'comment'       => $comment, 
            'examPoints'    => $examPoints,
            'points'        => $points,
            'testcase1'     => $testcase1,
            'caseAnswer1'   => $caseAnswer1,
            'testcase2'     => $testcase2,
            'caseAnswer2'   => $caseAnswer2,
            'testcase3'     => $testcase3,
            'caseAnswer3'   => $caseAnswer3,
            'testcase4'     => $testcase4,
            'caseAnswer4'   => $caseAnswer4,
            'testcase5'     => $testcase5,
            'caseAnswer5'   => $caseAnswer5,

        );
        array_push($questionAnswers, $questionResponse);
    }

    $response = json_encode($questionAnswers);
    echo $response;

    $connection->close();
 ?>