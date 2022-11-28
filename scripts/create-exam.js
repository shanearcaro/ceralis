//Element normally don't allow other elements to be dragged into them, this fixes that
function allowDrop(ev){
    ev.preventDefault();
}

//Allows for dragging of element
function drag(ev){
    ev.dataTransfer.setData("text", ev.target.id);
}

// Generate points div if in exam div
function dropInExam(ev) {

    //Get ID of element being dragged
    const data = ev.dataTransfer.getData("text");

    //Create a cell for the question
    const examCell = document.createElement("div");

    //Create div for the points cell
    const pointsDiv = document.createElement("div");

    //Create input box for points-div
    const pointsInput = document.createElement("input");
    
    //Get the exam div where element is being dragged to
    const getExamDiv = document.getElementById("exam-div");

    //If being dragged to the same table, do nothing
    if(document.getElementById(data).parentNode.className == "exam-cell")
        return;
    
    document.getElementById(data).className = "exam-question-div";
    
    //Set class name for examCell and pointsDiv
    examCell.className = "exam-cell";
    pointsDiv.className = "points-div";
    pointsDiv.id = data + "-points"

    //Set attributes for pointsInput
    pointsInput.type = "number";
    pointsInput.required = true;
    pointsInput.className = "points-input";
    pointsInput.id = data + "-input";
    pointsInput.name = data + "-input";

    getExamDiv.appendChild(examCell);
    examCell.appendChild(document.getElementById(data));
    examCell.appendChild(pointsDiv);
    pointsDiv.appendChild(pointsInput);
}

function dropInQuestions(ev) {
    const data = ev.dataTransfer.getData("text");
    const pointsId = data + "-points";
    const inputId = data + "-input";
    const getPointsDiv = document.getElementById(pointsId);
    const getInputDiv = document.getElementById(inputId);
    const examCell = getPointsDiv.parentNode;

    if(document.getElementById(data).parentNode.id == "question-box-div")
        return;

    //Change classname to question-div if moved to the question box
    document.getElementById(data).className = "question-div";
    //Get ID of the question box
    const getQuestionsDiv = document.getElementById("question-box-div");

    getQuestionsDiv.appendChild(document.getElementById(data));

    //Remove the points cell created in the exam table
    getPointsDiv.removeChild(getInputDiv);
    getPointsDiv.parentNode.removeChild(getPointsDiv);
    examCell.parentNode.removeChild(examCell);
}

function populateQuestionTable(data, i){
    const questionBoxDiv = document.getElementById("question-box-div")
    const text = document.createElement("p");
    const questionIndex = i;
    const questionText = data.text;
    const questionId = data.question_id;

    text.innerHTML = questionIndex + ": " + questionText;

    const questionDiv = document.createElement("div");
    questionDiv.className = "question-div";
    questionDiv.draggable = true;
    questionDiv.setAttribute("ondragstart", "drag(event);");
    questionDiv.id = questionId;
    
    questionBoxDiv.appendChild(questionDiv);
    questionDiv.appendChild(text);

}

function loadQuestions(){
    // Get questions request code
    const requestCode = 8;

    // Format request
    const credentials = `request=${requestCode}`;
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
                console.log(questionsCache[0].text);
                for(let i=0; i<questionsCache.length; i++) {
                    populateQuestionTable(questionsCache[i], i+1);
                }
            }
        }
    }

    // Send request
    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}

function addExam(){
    const requestCode = 9;
    const userid = sessionStorage.getItem("user_id");
    const title = document.getElementById("title").value;
    const points = document.getElementsByClassName("points-input");
    const questions = document.getElementsByClassName("exam-question-div");
    var total=0;

    //Tallies up total points and if a box is a non-number value, return
    for(let i = 0; i < points.length; i++) {
        if(!points[i].value){
            //Need to make this an onscreen notification
            console.log("Please enter a value for all questions");
            return;
        }
        total += parseInt(points[i].value);
    }

    //Make sure title is not just an empty string
    if(!title || title.trim().length==0){
        console.log("Please enter a title");
        return;
    }

    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            const examid = JSON.parse(ajax.responseText);

            //The response text will be the id of the last exam created
            console.log(ajax.responseText);
            if (ajax.responseText == "false") {
                /**
                 * This should also never fail. The best way of dealing with this would be to make the
                 * answers get added to sesssion data and then reload the page and answers on a failure
                 * and try again. This might get added in a later version if I have time.
                 */
                window.location.href = "/404";
            }

            addExamQuestions(examid, questions, points);
        }
    }

    const credentials = `userid=${userid}&title=${title}&points=${total}&request=${requestCode}`;
    console.log(credentials);

    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);

}

function addExamQuestions(exam_id, questions, points){
    const examid = parseInt(exam_id);
    const requestCode = 10;
    for (let i = 0; i < questions.length; i++){
        var questionid = parseInt(questions[i].id);
        var questionPoints = points[i].value;
        var credentials = `examid=${examid}&questionid=${questionid}&points=${questionPoints}&request=${requestCode}`;
        postQuestions(credentials);
    }

}

function postQuestions(credentials){
    const ajax = new XMLHttpRequest();
    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}