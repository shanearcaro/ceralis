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
    <link rel="Stylesheet" href="https://afsaccess4.njit.edu/~sma237/CS490/style/teacher/teacher.css">
    <link rel="Stylesheet" href="https://afsaccess4.njit.edu/~sma237/CS490/style/includes/header.css">
    <script type="text/javascript" src="https://afsaccess4.njit.edu/~sma237/CS490/scripts/render-table.js"></script>
    <script type="text/javascript" src="https://afsaccess4.njit.edu/~sma237/CS490/scripts/authenticate-user.js"></script>
    <script type="text/javascript" src="https://afsaccess4.njit.edu/~sma237/CS490/scripts/review.js"></script>
    <title>Teacher Portal</title>
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
        <p class="disabled" id="table-rc">2</p>
        <div class="content-panel">
            <div class="panel-list-area">
                <ul class="panel-list">
                    <div class="panel-div panel-hover"><li class="panel-element" id='panel-dashboard' onclick='window.location.href="https://afsaccess4.njit.edu/~sma237/CS490/views/teacher/createQuestion.php"'>QUESTION</li></div>
                    <div class="panel-div panel-hover"><li class="panel-element" id='panel-exam' onclick='window.location.href="https://afsaccess4.njit.edu/~sma237/CS490/views/teacher/createExam.php"'>CREATE EXAM</li></div>
                    <div class="panel-div"><button class="panel-element button" id='logout-button' onclick="logout()">LOG OUT</button></div>
                </ul>
            </div>
        </div>
        <div class="content-dash">
            <div class="dash-table-area">
                <div class="dash-title"><h1 id='dash-table-title'>Exams List</h1></div>
                <div class="dash-searchbar">
                    <div class="searchbar-select searchbar-element">
                        <select name="resultsAmount" id='results-amount' onchange="updateDisplayAmount()">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="-1">All</option>
                        </select>
                        <p id='records-text'>records per page</p>
                    </div>
                    <div class="searchbar-search searchbar-element">
                        <p id='search-text'>Search: </p>
                        <input type="text" id='dash-search-input' onkeyup='onSearch()'>
                    </div>
                </div>
                <div class="dash-table-div">
                    <p class="disabled" id='table-empty-records'>No records</p>
                    <table id='table'><script> loadTables(); </script></table>
                    <div class="table-legend">
                        <div class="legend-text">
                            <p id='table-display-legend'></p>
                        </div>
                        <div class="legend-buttons" id='legend-buttons-container'></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>