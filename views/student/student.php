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
    <link rel="Stylesheet" href="style/student/student.css?<?php echo time();?>">
    <?php include(dirname(__FILE__, 3) . "/style/includes/stylesheets.php");?>
    <script type="text/javascript" src="scripts/update-view.js??<?php echo time();?>"></script>
    <title>Student Portal</title>
</head>
<body onload="disableBack()">
    <?php include(dirname(__FILE__, 3) . "/views/includes/header.php");?>
    <div class="content-area">
        <div class="content-panel">
            <div class="panel-list-area">
                <ul class="panel-list">
                    <div class="panel-div panel-hover"><li class="panel-element" id='panel-dashboard'>DASHBOARD</li></div>
                    <div class="panel-div panel-hover"><li class="panel-element" id='panel-exam'>TAKE EXAM</li></div>
                    <div class="panel-div"><button class="panel-element" id='logout-button' onclick="logout()">LOG OUT</button></div>
                </ul>
            </div>
        </div>
        <div class="content-dash">
            <div class="dash-table-area">
                <div class="dash-title"><h1 id='dash-table-title'>Exams List</h1></div>
                <div class="dash-searchbar">
                    <div class="searchbar-select searchbar-element">
                        <select name="resultsAmount" id='results-amount'>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                        </select>
                        <p id='records-text'>records per page</p>
                    </div>
                    <div class="searchbar-search searchbar-element">
                        <p id='search-text'>Search: </p>
                        <input type="text" id='dash-search-input'>
                    </div>
                </div>
                <div class="dash-table-div">
                    <p class="disabled" id='table-empty-records'>No records</p>
                    <table id='table'><script> loadTables(); </script></table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>