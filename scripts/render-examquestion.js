/**
 * The id of the exam that the student requested to take
 */
let examid;

/**
 * The id of the student that requested to take the exam
 */
let studentid;

/**
 * The index of which question is currently being loadeded within the question cache
 */
let questionIndex = 0;

/**
 * The total number of questions retrieved from the exam. This is used to determine
 * which buttons should be displayed to the user during the exam.
 */
let questionsAmount;
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
    const requestCode = 4;

    // Format request
    const credentials = `examid=${examid}&request=${requestCode}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {

            console.log(ajax.responseText);
            // If exams exist print table dynamically
            if (ajax.responseText == "false") {
                /**
                 * This should never happen as questions can only be requested once a valid exam
                 * is picked and a valid exam consists of at least a single question.
                 * If somehow it does happen redirect to error page
                 */
                window.location.href = "/404";
            }
            else {
                // Display results
                questionsCache = JSON.parse(ajax.responseText);
                questionsAmount = questionsCache.length;
                console.log(questionsAmount);
                displayQuestion();
            }
        }
    }

    // Send request
    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}

function displayQuestion() {
    // Set question attributes to those gathered from the query request
    document.getElementById("question-number").innerText = "Question " + (questionIndex + 1);
    document.getElementById("question-points").innerText = questionsCache[questionIndex].points + " pts";
    document.getElementById("question-text").innerText = questionsCache[questionIndex].text;

    // Resize text area after setting the text
    resizeTextarea();
}

/**
 * The textarea within the questions container should be the size of the question text that is being displayed.
 * This cannot be reliable done using HTML because textarea relies on both the rows and col attributes which are
 * static. To fix this the height of the textarea is set to the height of the scroll amount. The scroll amount is
 * the total height needed to display the text.
 * px is added to the end of the statement so the expression is valid HTML syntax
 */
function resizeTextarea() {
    const ta = document.getElementById("question-text");
    ta.style.height = ta.scrollHeight + 'px';
}