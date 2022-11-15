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
    $accountID = $user_data[0];
    $studentExamID = $user_data[1]; //  StudentExams.submission_id

    $questionAnswers = array();
    
    // Get all answers for the exam
    $query = "SELECT ce.submission_id, ce.question_id, ce.answer, eq.questionPoints, q.question_text, q.tc1, q.an1, q.tc2, q.an2, q.tc3, q.an3, q.tc4, q.an4, q.tc5, q.an5
                FROM CompletedExam AS ce
                INNER JOIN StudentExams AS se ON ce.submission_id=se.submission_id
                INNER JOIN ExamQuestions AS eq ON se.exam_id=eq.exam_id AND ce.question_id=eq.question_id
                INNER JOIN Questions AS q ON ce.question_id=q.question_id
                WHERE ce.submission_id='{$studentExamID}'";

    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $questionID     = $row['question_id'];
        $question       = $row['question_text'];
        $answer         = $row['answer'];
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


        // Once again
        // Since this is not DB access related I am not editing the values here 
        // so the old middleend script can be used with minimal edit
        $questionResponse = array(
            'questionID'    => $questionID, 
            'question'      => $question,
            'answer'        => $answer, 
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