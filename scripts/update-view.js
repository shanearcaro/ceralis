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
    const submit = document.getElementById("form-button");
    submit.classList.remove("apply-shake");

    // Request code for database
    const requestCode = document.getElementById("form-request").value;

    // Start AJAX call
    const credentials = `username=${username}&password=${password}&request=${requestCode}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200)
            if (ajax.responseText == "false") {
                // User fails to log in
                error.classList.remove("disabled");
                authentication.classList.remove("disabled");

                submit.classList.add("apply-shake");
            }
            else {
                // Log the user in
                window.location = "/success";
            }
        else
            return;
    }

    // Send request
    ajax.open("POST", "/login/request", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}