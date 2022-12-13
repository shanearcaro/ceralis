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
    <link rel="Stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/includes/header.css">
    <script type="text/javascript" src="scripts/authenticate-user.js"></script>
    <title>Ceralis</title>
</head>
<body onload="clearSessionLogin()">
    <div class="banner-container banner-element">
        <div class="banner banner-element">
            <div class="banner-frame banner-element">
                <img class="banner-element" id="banner-image" src="assets/njit_new.png" alt="njit logo">
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
        <div class="content-header"></div>
        <div class="content-form">
            <div class="form-area">
                <div class="form-title">
                    <p id="index-login-title">MEMBER LOGIN</p>
                </div>
                <div class="form-body">
                    <div class="form-error disabled" id="response-handler">
                        <p class="error-text disabled" id="error-authentication">Invalid Login Credentials</p>
                        <p class="error-text disabled" id="proper-authentication">User Authenticated</p>
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