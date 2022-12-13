
function displayResults(){
    const studentExamId = sessionStorage.getItem('exam_request');

    getExamQuestions(studentExamId);
}

//Create a table for every question
function newTable(questionNum, text, questionId){
    const getContentArea = document.getElementById("content-area");
    const tableArea = document.createElement("div");
    const table = document.createElement("table");
    const tableHeader = document.createElement("tr");
    const question = document.createElement("p");

    const caseName = document.createElement("td");
    const expected = document.createElement("td");
    const actual = document.createElement("td");
    const worth = document.createElement("td");
    const earned = document.createElement("td");

    const commentLabel = document.createElement("label");
    const commentBox = document.createElement("div");

    submitButton.setAttribute("type", "submit");
    submitButton.value = "Submit Updates for Question " + (questionNum+1);

    commentBox.name = "comment-" + questionNum;
    commentBox.type = "text";
    commentBox.id = commentBox.name;

    commentLabel.setAttribute("for", commentBox.name);
    commentLabel.innerHTML = "Comment for question " + (questionNum + 1);


    //Create div for the table and append to content area
    tableArea.className = "table-area";
    tableArea.id = "area-" + questionNum;
    getContentArea.appendChild(tableArea);

    //Append the question to the table area
    question.innerHTML = (questionNum + 1) + ". " + text;
    tableArea.appendChild(question);

    //Append table to table area
    table.id = "table-" + questionNum;
    tableArea.appendChild(table);

    //Append comment box to the table area
    tableArea.appendChild(commentLabel);
    tableArea.appendChild(commentBox);


    //Append header row to table
    tableHeader.id = "header-" + questionNum;
    table.appendChild(tableHeader);


    //Add classes and text to headers and append them to the table
    caseName.className = "header"
    caseName.innerHTML = "Case";

    expected.className = "header";
    expected.innerHTML = "Expected";

    actual.className = "header";
    actual.innerHTML = "Student Answer";

    worth.className = "header";
    worth.innerHTML = "Worth";

    earned.className = "header";
    earned.innerHTML = "Earned";

    tableHeader.appendChild(caseName);
    tableHeader.appendChild(expected);
    tableHeader.appendChild(actual);
    tableHeader.appendChild(worth);
    tableHeader.appendChild(earned);
}

function insertTableRows(testCases, questionNum){
    for(let i=0; i < testCases.length; i++) {
        //insertTestCase(testCases[i], questionNum);
        if(testCases[i].case == "None" || testCases[i].case == "For" || testCases[i].case == "While" || testCases[i].case == "Recursion" ){
            insertConstraint(testCases[i], questionNum);
        }
        else if(testCases[i].case == testCases[i].answer){
            addFunctionName(testCases[i], questionNum);
        }
        else{
            insertTestCase(testCases[i], questionNum);
        }
    }
}

//Get exam questions
function getExamQuestions(studentExamId){
    const requestCode = 17;

    const credentials = `studentexamid=${studentExamId}&request=${requestCode}`

    const ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            const examid = JSON.parse(ajax.responseText);

            //The response text will be the id of the last exam created
            if (ajax.responseText == "false") {
                /**
                 * This should also never fail. The best way of dealing with this would be to make the
                 * answers get added to sesssion data and then reload the page and answers on a failure
                 * and try again. This might get added in a later version if I have time.
                 */
                window.location.href = "/404";
            }

            for(let i=0; i < examid.length; i++){
                newTable(i, examid[i].text, examid[i].question_id);
                insertTotalRow(examid[i].question_id,i);
                getTestCases(examid[i].question_id, i);
            }
        }

        else{
            return;
        }
    }

    ajax.open("POST", "https://afsaccess4.njit.edu/~sma237/CS490/controller/request-model.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);


}

function getTestCases(question_id, questionNum){
    const requestCode = 20;
    const credentials = `questionid=${question_id}&request=${requestCode}`;


    const ajax = new XMLHttpRequest();

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200){
            //The response text will be the id of the last exam created
            const testCases = JSON.parse(ajax.responseText);

            if (ajax.responseText == "false"){
                /**
                 * This should also never fail. The best way of dealing with this would be to make the
                 * answers get added to sesssion data and then reload the page and answers on a failure
                 * and try again. This might get added in a later version if I have time.
                 */
                //window.location.href = "/404";
            }

            console.log(ajax.responseText);
            insertTableRows(testCases, questionNum);

        }

    }

    ajax.open("POST", "https://afsaccess4.njit.edu/~sma237/CS490/controller/request-model.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}

function insertTestCase(testCase, questionNum){
    const table = document.getElementById("table-" + questionNum);

    var row = table.insertRow(-1);

    var caseText = row.insertCell(-1);
    var expected = row.insertCell(-1);
    var actual = row.insertCell(-1);
    var worth = row.insertCell(-1);
    var points = row.insertCell(-1);

    caseText.innerHTML = testCase.case;
    expected.innerHTML = testCase.answer;

    actual.id = "actual-" + testCase.testcase_id;

    worth.id = "worth-" + testCase.testcase_id;

    points.id = "points-" + testCase.testcase_id;

    studentAnswers(testCase.testcase_id, actual.id, worth.id, points.id);
}

function insertConstraint(testCase, questionNum){
    const table = document.getElementById("table-" + questionNum);
    const row = table.insertRow(2);

    var caseText = row.insertCell(-1);
    var expected = row.insertCell(-1);
    var actual = row.insertCell(-1);
    var worth = row.insertCell(-1);
    var points = row.insertCell(-1);

    caseText.innerHTML = "Constraint";
    expected.innerHTML = testCase.case;

    actual.id = "actual-" + testCase.testcase_id;

    worth.id = "worth-" + testCase.testcase_id;

    points.id = "points-" + testCase.testcase_id;

    studentAnswers(testCase.testcase_id, actual.id, worth.id, points.id);
}

function addFunctionName(testCase, questionNum){
    const table = document.getElementById("table-" + questionNum);
    const row = table.insertRow(2);

    var caseText = row.insertCell(-1);
    var expected = row.insertCell(-1);
    var actual = row.insertCell(-1);
    var worth = row.insertCell(-1);
    var points = row.insertCell(-1);
    var editPoints = row.insertCell(-1);

    caseText.innerHTML = testCase.case;
    expected.innerHTML = testCase.answer;

    actual.id = "actual-" + testCase.testcase_id;

    worth.id = "worth-" + testCase.testcase_id;

    points.id = "points-" + testCase.testcase_id;

    studentAnswers(testCase.testcase_id, actual.id, worth.id, points.id);

}

function studentAnswers(testCaseId, actualId, worthId, pointsId){
    const studentExamId = sessionStorage.getItem('exam_request');
    const requestCode = 30;
    const credentials = `studentexamid=${studentExamId}&testcaseid=${testCaseId}&request=${requestCode}`;

    const ajax = new XMLHttpRequest;
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200){
            //The response text will be the id of the last exam created
            const results = JSON.parse(ajax.responseText);

            if (ajax.responseText == "false"){
                /**
                 * This should also never fail. The best way of dealing with this would be to make the
                 * answers get added to sesssion data and then reload the page and answers on a failure
                 * and try again. This might get added in a later version if I have time.
                 */
                //window.location.href = "/404";
            }
            const actual = document.getElementById(actualId);
            const worth = document.getElementById(worthId);
            const points = document.getElementById(pointsId);

            actual.innerHTML = results[0].autoresult;
            worth.innerHTML = results[0].points;
            points.innerHTML = results[0].score;
        }
    }
    ajax.open("POST", "https://afsaccess4.njit.edu/~sma237/CS490/controller/request-model.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}

function insertTotalRow(questionId, questionNum){
    const studentExamId = sessionStorage.getItem('exam_request');
    const table = document.getElementById("table-" + questionNum);
    const requestCode = 32;
    const credentials = `studentexamid=${studentExamId}&questionid=${questionId}&request=${requestCode}`;


    var totalWorth = 0;
    var totalEarned = 0;

    var row = table.insertRow(1);

    var caseText = row.insertCell(-1);
    var expected = row.insertCell(-1);
    var actual = row.insertCell(-1);
    var worth = row.insertCell(-1);
    var points = row.insertCell(-1);
    var editPoints = row.insertCell(-1);

    caseText.innerHTML = "TOTAL";
    expected.className = "black";
    actual.className = "black";

    editPoints.className = "black";

    const ajax = new XMLHttpRequest();
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200){
            const results = JSON.parse(ajax.responseText);
            //The response text will be the id of the last exam created
            if (ajax.responseText == "false"){
                /**
                 * This should also never fail. The best way of dealing with this would be to make the
                 * answers get added to sesssion data and then reload the page and answers on a failure
                 * and try again. This might get added in a later version if I have time.
                 */
                //window.location.href = "/404";
            }
            for(let i=0; i<results.length; i++){
                totalWorth += results[i].points;
                totalEarned += results[i].score;
            }

            worth.innerHTML = totalWorth;
            points.innerHTML = totalEarned;

        }
    }
    ajax.open("POST", "https://afsaccess4.njit.edu/~sma237/CS490/controller/request-model.php", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}
