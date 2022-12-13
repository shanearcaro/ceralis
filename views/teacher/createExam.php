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
    <link rel="Stylesheet" href="https://afsaccess4.njit.edu/~sma237/CS490/style/teacher/createExam.css">
    <link rel="Stylesheet" href="https://afsaccess4.njit.edu/~sma237/CS490/style/style.css">
    <link rel="Stylesheet" href="https://afsaccess4.njit.edu/~sma237/CS490/style/includes/header.css">
    <script type="text/javascript" src="https://afsaccess4.njit.edu/~sma237/CS490/scripts/create-exam.js"></script>
    <title>Create Exam</title>
</head>
<body>
    <div class="banner-container banner-element">
        <div class="banner banner-element">
            <div class="banner-frame banner-element">
                <img class="banner-element" id="banner-image" src="https://afsaccess4.njit.edu/~sma237/CS490/assets/njit_new.png" alt="njit logo">
            </div>
            <div class="banner-title banner-element">
                <div class="banner-description banner-element">
                    <h1 class="banner-element" id="class-name">CERALIS</h1>
                    <h1 class="banner-element" id="project-name">Autograder</h1>
                </div>
            </div>
        </div>
    </div>
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