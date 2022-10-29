function login() {
    console.log("Attempting Login");
    const username = document.getElementById("username");
    const password = document.getElementById("password");

    // Start AJAX call
    const credentials = `username=${username}&password=${password}`;
    const ajax = new XMLHttpRequest();

    // Check AJAX
    ajax.onreadystatechange = function() {
        if (ajax.readyState == 4 && ajax.status == 200)
            console.log(ajax.responseText);
        else
            return;
    }

    // Send request
    ajax.open("POST", "/login/request", true);
    ajax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    ajax.send(credentials);
}