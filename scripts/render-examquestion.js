/**
 * The id of the exam that the student requested to take
 */
let examid;

/**
 * The id of the student that requested to take the exam
 */
let studentid;

/**
 * Questions only need to be loaded a single time because the questions will never change
 * during the exam. This means that the questions can be cached after the initial load.
 */
let questionsCache;

/**
 * Set the page up with its default values
 */
function onLoad() {
    generateID();
    loadQuestions();
}

/**
 * Get the examid and studentid from session storage
 */
function generateID() {
    // Get the requested infromation
    const examRequest = sessionStorage.getItem("exam_request");

    // Set the ids
    examid = examRequest.substring(0, examRequest.indexOf("-"));
    studentid = examRequest.substring(examRequest.indexOf("-") + 1);
}

/**
 * Set the current page title to title
 * @param {string} title new page title
 */
function setTitle(title) {
    document.getElementById("page-title").innerText = title;
}

/**
 * Load all the exam questions requested by the student
 */
function loadQuestions() {
    // Get questions request code
    const requestCode = 4

    // Format request
    const credentials = `examid=${examid}&request=${requestCode}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {

            console.log(ajax.responseText);
            // If exams exist print table dynamically
            if (ajax.responseText == "false") {

            }
            else {
                // Display results
                const response = JSON.parse(ajax.responseText);
            }
        }
    }

    // Send request
    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}