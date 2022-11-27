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
    <link rel="Stylesheet" href="style/student/takeExam.css?<?php echo time();?>">
    <?php include(dirname(__FILE__, 3) . "/style/includes/stylesheets.php");?>
    <script type="text/javascript" src="scripts/render-examquestion.js??<?php echo time();?>"></script>
    <title id="page-title">Student Portal</title>
</head>
<body onload="onLoad()">
    <?php include(dirname(__FILE__, 3) . "/views/includes/header.php");?>
    <div class="content-area">
        <p class="disabled" id="table-rc">1</p>
        <div class="area-column" id="left-column"></div>
        <div class="area-column" id="middle-column">
            <div class="middle-content" id="middle-question-container">
                <div class="question-header">
                    <div class="question-container">
                        <h1 id="question-number"></h1>
                    </div>
                    <div class="question-container">
                        <h1 id="question-points"></h1>
                    </div>
                </div>
                <div class="question-text-container">
                    <textarea name="text" id="question-text" cols="30" readonly></textarea>
                </div>
                <div class="question-answer">

                </div>
                <div class="question-buttons">
                    <div class="buttons-container" id="buttons-container">
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="area-column" id="right-column">
            <div class="questions-navbar" id="navbar">
                <h1 id="nav-display-title">Questions</h1>
                <div class="nav-table" id="nav-table"></div>
            </div>
        </div>
    </div>
</body>
</html>