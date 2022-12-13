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
    <link rel="Stylesheet" href="https://afsaccess4.njit.edu/~sma237/CS490/style/student/takeExam.css">
    <link rel="stylesheet" href="https://afsaccess4.njit.edu/~sma237/CS490/style/includes/header.css">
    <script type="text/javascript" src="https://afsaccess4.njit.edu/~sma237/CS490/scripts/render-examquestion.js"></script>
    <title id="page-title">Student Portal</title>
</head>
<body onload="onLoad()">
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
    <div class="content-area">
        <p class="disabled" id="table-rc">1</p>
        <div class="area-column" id="left-column"></div>
        <div class="area-column" id="middle-column">
            <div class="middle-content" id="middle-question-container">
                <div class="exam-info">
                    <h2 id="exam-title"></h2>
                </div>
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