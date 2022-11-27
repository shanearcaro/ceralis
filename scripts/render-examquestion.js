/**
 * The id of the exam that the student requested to take
 */
let studentExamID;

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
 * Dict of the student's answer to each question. This has to be recorded at the the time
 * that any question action button gets pressed because the chained function calls will create
 * a new textarea.
 */
let studentAnswers = {};

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
    studentExamID = examRequest.substring(0, examRequest.indexOf("-"));
    studentid = sessionStorage.getItem("user_id")
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
    const credentials = `studentexamid=${studentExamID}&request=${requestCode}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
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
                updateDisplay();
            }
        }
    }

    // Send request
    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}

function updateDisplay() {
    // Set question attributes to those gathered from the query request
    document.getElementById("question-number").innerText = "Question " + (questionIndex + 1);
    document.getElementById("question-points").innerText = questionsCache[questionIndex].points + " pts";
    document.getElementById("question-text").innerText = questionsCache[questionIndex].text;

    // Resize text area after setting the text
    resizeTextarea();
    displayActionButtons();

    // 50 is just a value that works, this should probably be set up as a const 
    createAnswerTextarea(50);
    createNavBar();
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

    // Height needs to be set to 0 or it defaults to the previous scrollHeight
    // and adds the new height to the old height for some unknown reason.
    ta.style.height = "0px";
    ta.style.height = ta.scrollHeight + "px";
}

/**
 * If the student is not on the last question in the exam display previous and next buttons
 * otherwise display previous and submit buttons.
 */
function displayActionButtons() {
    // Buttons are always dynamic so use a list to display them
    let buttons = [];

    // If the current question is not the first one
    if (questionIndex != 0) {
        // Create the previous button
        const previous = createActionButton("previous");

        // Add on click to button
        previous.onclick = function() {
            saveStudentAnswer();
            questionIndex--;
            updateDisplay();
        }
        buttons.push(previous);
    }

    // If the student is on the last question in the exam
    if (questionIndex == questionsAmount - 1) {
        // Create the submit button
        const submit = createActionButton("submit");

        // Add on click to button if all questions are answered
        if (Object.keys(studentAnswers).length == questionsAmount) {
            submit.onclick = function() {
                saveStudentAnswer();
                submitExam();
            }
        }
        else {
            submit.classList.add("disabled-submit");
        }
        buttons.push(submit);
    }
    // If the student is not on the last question in the exam
    else {
        // Create the next button
        const next = createActionButton("next");

        // Add on click to button
        next.onclick = function() {
            saveStudentAnswer();
            questionIndex++;
            updateDisplay();
        }
        buttons.push(next);
    }

    // Get the buttons container and reset the HTML
    const container = document.getElementById("buttons-container");
    container.innerHTML = "";

    // Add all created buttons to the container
    for (let i = 0; i < buttons.length; i++)
        container.appendChild(buttons[i]);

    /**
     * If only one button is being created then add the shift right class to it.
     * The buttons container uses space-between to position the buttons but this
     * breaks if only one button exists. shift-right ensures that the buttons are
     * always aligned no matter the amount created.
     */
    if (buttons.length == 1)
        container.classList.add("shift-right");
    else
        container.classList.remove("shift-right");
}

/**
 * Create a action button with an initial text
 * @param {string} text name of the button
 * @returns created action button 
 */
function createActionButton(text) {
    const button = document.createElement("button");
    const buttonClass = "button-" + text;
    text = text.charAt(0).toUpperCase() + text.substring(1);

    button.innerText = text;
    button.classList.add("button");
    button.classList.add("action-button");
    button.classList.add(buttonClass);
    
    return button;
}

/**
 * Create a text area for the student to type their respose to the question. The textarea
 * height needs to be dynamic because the question height is also dynamic.
 * @param {number} offset the pixel offset that should be applied to the answer height
 */
function createAnswerTextarea(offset) {
    // Get the total height of the quesiton div
    const totalHeight = document.getElementById("middle-question-container").offsetHeight;

    // Get the height of all children within the parent div
    const headerHeight = document.getElementsByClassName("question-header")[0].offsetHeight;
    const questionHeight = document.getElementById("question-text").offsetHeight;
    const buttonsHeight = document.getElementsByClassName("question-buttons")[0].offsetHeight;

    // Calculate the remaining available space - offset
    const availableSpace = totalHeight - (headerHeight + questionHeight + buttonsHeight) - offset;

    // Create the text area based off the previous height
    const answerArea = document.createElement("textarea");
    answerArea.id = "student-answer";
    answerArea.style.height = availableSpace + "px";

    // Max length of the varchar in the sql database
    answerArea.maxLength = 2000;

    // Used to allow the textarea to use tabs
    answerArea.onkeydown = function(event) {
        textAreaPress(event);
    };

    answerArea.onkeyup = function() {
        updateNavbar();
    }

    // Get parent element for the textarea
    const parent = document.getElementsByClassName("question-answer")[0];

    // Clear parent previous HTML to avoid multiple created textareas
    parent.innerHTML = "";

    // If the current question has already been answered set the text to that answer
    if (studentAnswers[questionIndex] !== undefined)
        answerArea.innerText = studentAnswers[questionIndex];

    // Add textarea to parent
    parent.appendChild(answerArea);
}

/**
 * Allow the textarea to use the tab key
 * @param {key press event} event 
 */
function textAreaPress(event) {
    const textarea = document.getElementById("student-answer");
    if (event.key == "Tab") {
        event.preventDefault();
        textarea.setRangeText("\t", textarea.selectionStart, textarea.selectionStart, 'end');
    }
}

/**
 * Update the navbar and display buttons. This is a separate function to
 * updateDisplay because this function needs to be called on every key press
 * when the student is answering a question. updateDisplay performs updates
 * on the main page that would not need to be updated on every keypress.
 */
function updateNavbar() {
    saveStudentAnswer();
    createNavBar();
    displayActionButtons();
}

/**
 * Save the student's answer to the current question.
 */
function saveStudentAnswer() {
    // Get the value of the current answer
    const value = document.getElementById("student-answer").value;

    /**
     * Don't record non-answered questions. Althought it doesn't actually matter
     * since the textarea would be set to a blank string, if the value is added
     * to the studentAnswers dict it breaks the text loading logic at the bottom
     * of the createTextare function. 
     */
    if (value != "")
        studentAnswers[questionIndex] = value;
    else {
        // If the text within an answer is cleared delete the dictionary index
        if (studentAnswers[questionIndex] !== undefined)
            delete studentAnswers[questionIndex];
    }
}

/**
 * Create a nav bar element
 * @param {number} index question index
 * @returns nav bar element as a div
 */
function createNavElement(index) {
    // Create a div to hold the question and its icon
    const questionContainer = document.createElement("div");
    questionContainer.classList.add("nav-container");

    // Check if the corresponding question was answered
    const isAnswered = studentAnswers[index] !== undefined;
    
    // Create question icon
    const icon = document.createElement("img");

    // Create question title
    const question = document.createElement("h3");
    question.classList.add("nav-text");
    question.innerText = "Question " + (index + 1);

    // Add navigation to title
    question.onclick = function() {
        saveStudentAnswer();
        questionIndex = index;
        updateDisplay();
    }
    
    // Create an icon based on if the question was answered or not
    if (isAnswered) {
        icon.classList.add("icon-answered");
        question.classList.add("question-answered");
        icon.srcset = "../assets/check-mark.png";
        icon.innerHTML = "Check mark";
    }
    else {
        icon.classList.add("icon-unanswered");
        question.classList.add("question-unanswered");
        icon.srcset = "../assets/question-mark.png";
        icon.innerHTML = "Question Mark";
    }

    questionContainer.appendChild(icon);
    questionContainer.appendChild(question);

    return questionContainer;
}

/**
 * Create side nav bar question indexes
 */
function createNavBar() {
    // Get nav bar and reset HTML
    const nav = document.getElementById("nav-table");
    nav.innerHTML = "";

    // Append all nav elements as children
    for (let i = 0; i < questionsAmount; i++) {
        nav.appendChild(createNavElement(i));
    }
}

/**
 * Submit all student answers
 */
function submitExam() {
    // Get questions request code
    const requestCode = 5;
    for (let i = 0; i < questionsAmount; i++) {
        // Current question
        const current = questionsCache[i];

        // AJAX removes + sign so the student answer needs to be encoded to avoid this
        const answer = encodeURIComponent(studentAnswers[i]);

        // Format request
        const credentials = `studentexamid=${current.studentexam_id}&questionid=${current.question_id}&answer=${answer}&request=${requestCode}`;
        const ajax = new XMLHttpRequest();

        // Check AJAX
        ajax.onreadystatechange = function() {
            if (ajax.readyState == 4 && ajax.status == 200) {
                // If exams exist print table dynamically
                if (ajax.responseText == "false") {
                    /**
                     * This should also never fail. The best way of dealing with this would be to make the
                     * answers get added to sesssion data and then reload the page and answers on a failure
                     * and try again. This might get added in a later version if I have time.
                     */
                    window.location.href = "/404";
                }
            }
        }

        // Send request
        ajax.open("POST", "/post", true);
        ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        ajax.send(credentials);
    }
    updateExamScore();
}

/**
 * Students are able to take exams if the value of the exam is -1 meaning it hasn't been taken yet.
 * Need to update the score to -2 so that students know it is ungraded, but they won't be able to take
 * again.
 */
function updateExamScore() {
    // Get questions request code
    const requestCode = 6;

    // Ungraded score
    const score = -2;

    // Format request
    const credentials = `studentexamid=${studentExamID}&score=${score}&request=${requestCode}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            // Should also never fail
            if (ajax.responseText == "false") {
                window.location.href = "/404";
            }
            else {
                // On success go back to student page
                window.location.href = "/student";
            }
        }
    }

    // Send request
    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}