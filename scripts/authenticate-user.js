/**
 * Send a login request using the username and password provided by the user.
 * If authenticated, send the user to their respective dashboard: student, teacher.
 * If not authenticated, display error warning to user and allow them to retry.
 */
 function login() {
    // Get credentials from login form
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    
    // Acquire error handling elements
    const error = document.getElementById("response-handler");
    const authentication = document.getElementById("error-authentication");

    // Apply shake effect
    const text = document.getElementById("error-authentication");
    text.classList.remove("apply-shake");

    // Retrieve request code from document
    const requestCode = document.getElementById("form-request").value;

    // Begin AJAX call
    const credentials = `username=${username}&password=${password}&request=${requestCode}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        // If information is available and okay
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Don't shake first time
            if (!error.classList.contains("disabled"))
                text.classList.add("apply-shake");
            
            // Clear previous effects
            error.classList.remove("disabled");
            error.classList.add("apply-fade");

            // If user fails to authenticate
            if (ajax.responseText == "false") {
                error.classList.add("form-login-invalid");
                authentication.classList.remove("disabled");
            }
            // Else user authenticates
            else {
                // Decode json response
                const allResponses = JSON.parse(ajax.responseText);
                const response = allResponses[0];
                const properAuth = document.getElementById("proper-authentication");

                // Change from error to accept message
                error.classList.remove("form-login-invalid");
                error.classList.add("form-login-valid");

                properAuth.classList.remove("disabled");
                authentication.classList.add("disabled");

                properAuth.classList.add("apply-color");

                // Store for checking later
                storeSessionLogin(response.user_id);

                // Sleep to allow shake effect to animate
                sleep(1250).then(() => {
                    // Redirect based on position
                    if (response.position == "student") window.location.href = "/student";
                    if (response.position == "teacher") window.location.href = "/teacher";
                });
            }
        }
        // If information is not ready
        else
            return;
    }

    // Send request
    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}

/**
 * Log user out of their account and clear session data.
 * The user is brought to the login screen and will be unable to use the back button to relog in
 */
function logout() {
    sessionStorage.removeItem("user_id");
    window.location.href="/";
}

/**
 * Validate that a user has proper session data
 * If a user does not have a valid session id log them out
 */
function validateSession() {
    // Run for every page except login
    if (!document.getElementById("index-login-title") && !sessionStorage.getItem("user_id")) {
        logout();
    }
}

/**
 * Store a user's id into session
 * @param {number} user_id - user's id number
 */
function storeSessionLogin(user_id) {
    sessionStorage.setItem('user_id', user_id);
}

/**
 * Clear the session of the user's id number
 */
function clearSessionLogin() {
    sessionStorage.removeItem("user_id");
}

/**
 * Sleep for a specified duration of time
 * @param {int} time - the number of milliseconds to sleep
 * @returns promise
 */
function sleep (time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}

// Validate session on every focus of each page
document.addEventListener("focus", validateSession);