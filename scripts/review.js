function displayResults(){
    const getContentArea = document.getElementsByClassName("content-area");
    const table = document.createElement("table");
    table.id = "results";

    var row = table.insertRow(-1);
    row.id = "First";

    var cell1 = row.insertCell(-1);
    cell1.id = "Name";
    cell1.innerHTML = "Name"

    const seid = 1;
    getExamQuestions(seid);

}

function getExamQuestions(studentExamId){
    const requestCode = 17;
    const studentexamid = studentExamId;

    const credentials = `studentexamid=${studentexamid}&request=${requestCode}`

    const ajax=new XMLHttpRequest();

    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200) {
            const examid = JSON.parse(ajax.responseText);

            //The response text will be the id of the last exam created
            console.log(examid);
            if (ajax.responseText == "false") {
                /**
                 * This should also never fail. The best way of dealing with this would be to make the
                 * answers get added to sesssion data and then reload the page and answers on a failure
                 * and try again. This might get added in a later version if I have time.
                 */
                window.location.href = "/404";
            }
            for(let i=0; i<examid.length; i++){
                getTestCases(examid[i].question_id);
            }
        }
    }

    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);

}

function getTestCases(question_id){
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
            console.log(testCases);
            for(let i=0; i < testCases.length; i++) {
                insertTestCase(testCases[i]);
                if(testCases[i].case == "None" || testCases[i].case == "For" || testCases[i].case == "While" || testCases[i].case == "Recursion" ){
                    //insertConstraint(testCases[i]);
                }
                else if(testCases[i].case == testCases[i].answer){
                    //addFunctionName(testCases[i]);
                }
                else{
                    //insertTestCase(testCases[i]);
                }
            }
        }
    }

    ajax.open("POST", "/post", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}

function insertTestCase(testCase){
    console.log("HI");
    const table = document.getElementById("results");
    const edit  = document.createElement("input");
    const area = document.getElementById("content-area");

    //area.append(table);
    var row = table.insertRow(-1);

    var caseText = row.insertCell(-1);
    var expected = row.insertCell(-1);
    var actual = row.insertCell(-1);
    var worth = row.insertCell(-1);
    var points = row.insertCell(-1);
    var editPoints = row.insertCell(-1);

    caseText.innerHTML = testCase.case;
    expected.innerHTML = testCase.answer;
    actual.innerHTML = "expected x";
    worth.innerHTML = "worth x";
    points.innerHTML = "10";

    edit.className = "points-input";
    edit.type = "number";
    edit.id = testCase.case + "-input";
    edit.name = testCase.case + "-input";

    editPoints.appendChild(edit);
}

function insertConstraint(testCase){
    const table = document.getElementById("table");
}

function addFunctionName(testCase){
    const row = document.getElementById("First");
}