<?php
//check page was accessed by user submitting the form
//check for a server request method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"]; //Retrieve the username input from form
    $password = $_POST["password"]; //Retrieve user password input from form

    try {
        require_once 'dbh.inc.php'; //link to nea database
        require_once 'login_model.inc.php';
        require_once 'login_contr.inc.php';

        //Use error handlers to ensure processes are running correctly inside the code
        //1D array to store errors
        $errors = [];

        if (is_input_null($username, $password)) {
            $errors["empty_field"] = "Please fill in all fields of data!";
        }

        //global variable to hold result of database query
        $result = fetch_user($pdo, $username);

        if (is_username_incorrect($result)) {
            //produce error message that can later be displayed
            $errors["login_incorrect"] = "Incorrect login credentials";
        }

        /*
        echo $result["password"];

        $hashedpassword = $result["password"];

        $password = $hashedpassword;

        //is_username_incorrect($result) || 

        //check if the username exists and if the password matches the corresponding one in the database
        if (is_username_incorrect($result) || is_password_incorrect($password, $hashedpassword)) {
            //produce error message that can later on  be displayed
            $errors["login_incorrect"]= "Incorrect login credentials, recheck your password";
        }*/

        //link to session
        require_once 'config_session.inc.php';

        if ($errors) {
            //store session data
           $_SESSION["errors_login"] = $errors;
           header("Location: ../register/index.php");
           die();
        }
        //new session when something changes to improve security
        //used to create completely new session id
        $newsessionId = session_create_id();
        //pair together the user id and the session id
        $sessionId = $newsessionId . "_" . $result["id"];
        //set the new session id
        session_id($sessionId);

        //sign up the user inside the website
        $_SESSION["user_id"] = $result["id"];
        //php prebuilt function to sanitise 
        $_SESSION["username"] = htmlspecialchars($result["username"]);
        //reset the time so the session updates every 30 mins
        $_SESSION["last_regeneration"] = time(); //Get timestamp for when each session is last generated

        $_SESSION["result"] = $result;
        
        header("Location: http://localhost/NEA/booking/index.php");
        //$pdo = null;
        //$statement = null;
        die();

    } catch (PDOException $e) {
        die("Query Unsuccessful"); //indicate to terminate the function if the query is unsuccessful
    }

} else {
    //this branch is for if the user did not access this page by submitting the form
    header("Location: http://localhost/NEA/register/index.php");
    die(); //terminate the script
}