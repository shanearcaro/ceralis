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
    <script type="text/javascript" src="scripts/update-view.js??<?php echo time();?>"></script>
    <title>Login</title>
</head>
<body>
    <?php include(dirname(__FILE__, 2) . "/views/includes/header.php");?>
    <div class="content-area">
        <div class="content-header"></div>
        <div class="content-form">
            <div class="form-area">
                <div class="form-title">
                    <p>MEMBER LOGIN</p>
                </div>
                <div class="form-body">
                    <div class="form-error disabled" id="response-handler">
                        <p class="error-text disabled" id="error-authentication">Invalid Login Credentials</p>
                    </div>
                    <form method="post" id="form-login" autocomplete="off" onsubmit="return false">
                        <label for="username" class="form-label">Username <span class="form-required">*</span></label>
                        <input name="username" type="text" id="username" class="form-input shake" max="20" onkeypress="return event.charCode != 32">
                        <label for="password" class="form-label">Password <span class="form-required">*</span></label>
                        <input name="password" type="password" id="password" class="form-input">
                        <input type="hidden" id="form-request" value="0">
                        <input type="submit" id="form-button" value="LOGIN" onclick="login();">
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>