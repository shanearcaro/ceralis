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
    <link rel="Stylesheet" href="style/style.css?<?php echo time();?>">
    <link rel="Stylesheet" href="style/student/student.css?<?php echo time();?>"> 
    <link rel="Stylesheet" href="style/teacher/review.css?<?php echo time();?>">
    <?php include(dirname(__FILE__, 3) . "/style/includes/stylesheets.php");?>
    <script type="text/javascript" src="scripts/review.js??<?php echo time();?>"></script>
    <title>Review Questions</title>
</head>
<body>
    <?php include(dirname(__FILE__, 3) . "/views/includes/header.php");?>
    <div class="content-area">
        <table id="Results">
            <tr id="First">
                <td> Name </td>
                <td id="function-name" > Function Name </td>
                <td id="worth"> Worth </td>
                <td id="earned"> Earned </td>
            </tr>
        </table>
        <input type="button" value="BUTTON" onclick="displayResults();">
    </div>
</body>