/**
 * Query database for user account information. If the account is found, log the user into
 * their respective hub. If the database fails to authenticate the user display an error message.
 */
function login() {
    // Get credentials
    const username = document.getElementById("username").value;
    const password = document.getElementById("password").value;
    
    // Error handling
    const error = document.getElementById("response-handler");
    const authentication = document.getElementById("error-authentication");

    // Shake effect
    const text = document.getElementById("error-authentication");
    text.classList.remove("apply-shake");

    // Request code for database
    const requestCode = document.getElementById("form-request").value;

    // Start AJAX call
    const credentials = `username=${username}&password=${password}&request=${requestCode}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200)
        // User fails to log in
            if (ajax.responseText == "false") {
                // Don't shake first time
                if (!error.classList.contains("disabled"))
                    text.classList.add("apply-shake");
                
                error.classList.remove("disabled");
                error.classList.add("apply-fade");
                authentication.classList.remove("disabled");
            }
            // User logs in
            else {
                // Decode json response
                const response = JSON.parse(ajax.responseText);
                
                // Redirect based on position
                if (response.position == "student") window.location.href = "/student";
                if (response.position == "teacher") window.location.href = "/teacher";
            }
        else
            return;
    }

    // Send request
    ajax.open("POST", "/login/request", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}