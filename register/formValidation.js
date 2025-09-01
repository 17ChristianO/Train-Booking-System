
function validateLoginForm() {
    var username = document.forms["loginForm"]["username"].value;
    var password = document.forms["loginForm"]["password"].value;

    if (username === "" || password === "") {
        alert("Username and password are required!");
        return false;
    }
    return true;
}

function validateRegistrationForm() {
    var email = document.forms["registerForm"]["email"].value;
    var username = document.forms["registerForm"]["username"].value;
    var password = document.forms["registerForm"]["password"].value;

    if (email === "" || username === "" || password === "") {
        alert("All fields are required!");
        return false;
    }
    return true;
}
