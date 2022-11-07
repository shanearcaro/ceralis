// Number of columns the table in student dashboard will have
const MAX_TABLE_ELEMENTS_STUDENT = 5;

/**
 * Sleep for a specified duration of time
 * @param {int} time - the number of milliseconds to sleep
 * @returns promise
 */
function sleep (time) {
    return new Promise((resolve) => setTimeout(resolve, time));
  }

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
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Don't shake first time
            if (!error.classList.contains("disabled"))
                text.classList.add("apply-shake");
                
            error.classList.remove("disabled");
            error.classList.add("apply-fade");

            // User fails to log in
            if (ajax.responseText == "false") {
                error.classList.add("form-login-invalid");

                authentication.classList.remove("disabled");
            }
            // User logs in
            else {
                // Decode json response
                const allResponses = JSON.parse(ajax.responseText);
                const response = allResponses[0];
                console.log(response);
                const properAuth = document.getElementById("proper-authentication");

                // Change from error to accept message
                error.classList.remove("form-login-invalid");
                error.classList.add("form-login-valid");

                properAuth.classList.remove("disabled");
                authentication.classList.add("disabled");

                properAuth.classList.add("apply-color");

                // Store for checking later
                storeSessionLogin(response.user_id);

                sleep(1250).then(() => {
                    // Redirect based on position
                    if (response.position == "student") window.location.href = "/student";
                    if (response.position == "teacher") window.location.href = "/teacher";
                });
            }
        }
        else
            return;
    }

    // Send request
    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}

/**
 * Log a user out of their account and clear their session data
 */
function logout() {
    sessionStorage.removeItem("user_id");
    window.location.href="/";
}

/**
 * Validate that a user has proper session data
 */
function validateSession() {
    // Run for every page except login
    if (!document.getElementById("index-login-title") && !sessionStorage.getItem("user_id")) {
        // TODO: Display a warning here about invalid session data
        logout();
    }
}

/**
 * Store a user's id into session
 * @param {number} user_id - user's id number
 */
function storeSessionLogin(user_id) {
    console.log("USER ID: " + user_id);
    sessionStorage.setItem('user_id', user_id);
}

/**
 * Disable the back button
 */
function disableBack() {
    window.history.forward();
}

function loadTables() {
    const credentials = `request=${1}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            console.log("LOADING TABLES");
            console.log(ajax.responseText);

            // If exams exist print table dynamically
            if (ajax.responseText == "false") {
                // If no exams exist display empty table
                const empty = document.getElementById("table-empty-records");
                const table = document.getElementById("table");

                empty.classList.remove("disabled");
                table.classList.add("disabled");
            }
            else {
                // Display results
                const response = JSON.parse(ajax.responseText);
                const table = document.getElementById("table");
                for (let i = 0; i < response.length; i++) {
                    const element = response[i];
                    const exam = response[i];

                    const prefix = "cell";
                    const delim = "-";
                    const data = ["index", "title", "name", "points", "date"];
                    const row = table.insertRow(-1);
                    row.classList.add("exam-student-row");
                    row.classList.add("row-" + (i % 2 == 0 ? "light" : "dark"));
                    for (let i = 0; i < MAX_TABLE_ELEMENTS_STUDENT; i++) {
                        const cell = row.insertCell(-1);
                        cell.classList.add(prefix + delim + data[i]);
                        cell.classList.add(prefix);
                        cell.innerHTML = "s";
                    }
                    row.cells[0].innerHTML = i;
                    row.cells[1].innerHTML = "Mr. " + exam.name;
                    row.cells[2].innerHTML = exam.title;
                    row.cells[3].innerHTML = exam.points;
                    row.cells[4].innerHTML = exam.date;
                    
                    // TODO: Create and add elements to table
                }
            }
        }
        else
            return;
    }

    // Send request
    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}

// Validate session on every focus of each page
document.addEventListener("focus", validateSession);