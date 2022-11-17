/**
 * Number of rows that the table in the student dashboard will display.
 * This value trumps all other display amount constraints.
 */
let MAX_TABLE_ELEMENTS_STUDENT = 5;

/**
 * Sleep for a specified duration of time
 * @param {int} time - the number of milliseconds to sleep
 * @returns promise
 */
function sleep (time) {
    return new Promise((resolve) => setTimeout(resolve, time));
}

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
    console.log("USER ID: " + user_id);
    sessionStorage.setItem('user_id', user_id);
}

/**
 * Disable the back button
 */
function disableBack() {
    window.history.forward();
}

/**
 * Load the student dashboard exams table
 */
function loadTables() {
    const credentials = `request=${1}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
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
                createTables(response);
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
 * Clear the student exams table
 */
function clearTables() {
    const table = document.getElementById('table');
    table.innerHTML = '';
}

/**
 * Populate all the rows within the student dashboard exams table
 * @param {string} response database response value with all table exam elements
 */
function createTables(response) {
    clearTables();

    // Get search bar input text
    const searchInput = document.getElementById('dash-search-input');
    const searchText = searchInput.value.toLowerCase();

    const table = document.getElementById("table");

    // Display descriptors
    const row = table.insertRow(-1);
    row.classList.add("exam-student-row");
    const headers = ['ID', 'Professor', 'Exam Title', 'Score', 'Date'];

    // Create cell class descriptors
    const prefix = "cell";
    const delim = "-";
    const data = ["index", "title", "name", "points", "date"];
    
    for (let i = 0; i < headers.length; i++) {
        const cell = row.insertCell(-1);
        cell.classList.add(prefix + delim + data[i]);
        cell.classList.add(prefix);
        cell.classList.add('row-cell');
        cell.classList.add('header-text');
        cell.innerHTML = headers[i];
    }

    // Don't display more results than gathered
    const maxDisplay = MAX_TABLE_ELEMENTS_STUDENT > response.length ? response.length : MAX_TABLE_ELEMENTS_STUDENT;
    console.log("max display: " + maxDisplay);
    let displayAmount = 0;

    // Display row results 
    for (let i = 0; i < response.length; i++) {
        if (displayAmount == maxDisplay)
            break;

        const exam = response[i];
        const examElements = [exam.exam_id, exam.name, exam.title, formatScore(exam.score, exam.points), formatDate(exam.date)];

        // If a user searches for a result, only display those
        if (searchText != "") {
            let found = false;

            // Check to see if exam contains search string
            for (let j = 0; j < examElements.length; j++) {
                let value = String(examElements[j]).toLowerCase();

                // If row contains search text, stop checking
                if (value.includes(searchText)) {
                    found = true;
                    break;
                }
            }

            // If search text is not found in the row do not display
            if (!found)
                continue;
        }
        
        // Counter for how many rows are being displayed
        displayAmount++;

        // Create row and start populating it
        const row = table.insertRow(-1);
        row.classList.add("exam-student-row");
        row.classList.add("row-" + (i % 2 == 0 ? "light" : "dark"));

        // Display only a certain number of elements
        for (let i = 0; i < data.length; i++) {
            const cell = row.insertCell(-1);
            cell.classList.add(prefix + delim + data[i]);
            cell.classList.add(prefix);
            cell.classList.add('row-cell');
        }
        
        // Display row information
        row.cells[0].innerHTML = exam.exam_id;
        row.cells[1].innerHTML = exam.name;
        row.cells[2].innerHTML = exam.title;
        row.cells[3].innerHTML = formatScore(exam.score, exam.points);

        // Need to format the date
        row.cells[4].innerHTML = formatDate(exam.date);
    }
}

/**
 * Update the amount of rows that can be displayed in the student dashboard exams table
 */
function updateDisplayAmount() {
    const displayList = document.getElementById("results-amount");
    const displayAmount = displayList.options[displayList.selectedIndex].value;
    MAX_TABLE_ELEMENTS_STUDENT = displayAmount;
    loadTables();
}

/**
 * Convert datetime string to a date string
 * @param {datetime} datetime a variable that contains the date and time
 * @returns date only as string
 */
function formatDate(datetime) {
        // Date is in format YYYY-MM-DD HOURS:MINUTES:SECONDS
        const date = new Date(datetime);
        return date.toLocaleDateString();
}

/**
 * Given the student scored points and the exam's total points amount
 * calculate the percentage that the student earned on the exam
 * @param {number} score  total points the student earned on the exam
 * @param {number} points total points the exam is worth 
 * @returns test score in percentage format
 */
function formatScore(score, points) {
    return String(score / points * 100) + "%";
}

// Validate session on every focus of each page
document.addEventListener("focus", validateSession);