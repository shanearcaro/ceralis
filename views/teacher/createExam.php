<!DOCTYPE html>
<html lang="en">
<head>
    <base href="">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet"> 
    <link rel="Stylesheet" href="style/teacher/createExam.css?<?php echo time();?>">
    <link rel="Stylesheet" href="style/style.css?<?php echo time();?>">
    <?php include(dirname(__FILE__, 3) . "/style/includes/stylesheets.php");?>
    <script type="text/javascript" src="scripts/create-exam.js??<?php echo time();?>"></script>
    <title>Create Exam</title>
</head>
<body>
    <?php include(dirname(__FILE__, 3) . "/views/includes/header.php");?>
    <div class="exam-area">
        <div class="left-side">
            <div class="exam-name">
                <label for="title" class="form-label">Exam Name<span class="form-required">*</span></label>
                <input name="title" type="text" id="title" class="form-input" required>
            </div> 
            <div id="exam-div" ondrop="dropInExam(event)" ondragover="allowDrop(event)">
                <div class="exam-cell">
                    <div class="header">Questions</div>
                    <div class="header-points">Points</div>
                </div>
            </div>
            <div class="submission">
                <input type="button" id="form-button" value="Submit" onclick="addExam()">
            </div>
        </div>
        <div id="question-box-div" ondrop="dropInQuestions(event)" ondragover="allowDrop(event)">
            <script> loadQuestions(); </script>
        </div>
    </div>

</body>