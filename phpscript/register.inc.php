<?php

//check page was accessed by user submitting the form
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST["email"]; //Retrieve email input from form
    $username = $_POST["username"]; //Retrieve the username input from form
    $password = $_POST["password"]; //Retrieve user password input from form
    
    //instruct database to run an instruction and a correspinding error message
    try {
        require_once 'dbh.inc.php'; //link to nea database
        require_once 'register_model.inc.php'; //link to model file for registration
        require_once 'register_contr.inc.php'; //link to controller for registration

        //use error handlers to ensure processes are running correctly inside the code
        //handle security back-end

        //1D array to store errors
        $errors = [];

        

        //check if the input is null
        if (is_input_null($username, $password, $email)) {
            $errors["null_input"] = "Please fill in all fields of data!";
        }
        
        //check if the email is valid
        if (is_email_invalid($email)) {
            $errors["invalid_email"] = "Please use a valid email";
        }

        //check if the username is already in use
        if (check_username_taken($pdo, $username)) {
            $errors["user_taken"] = "Username is already in use! Try again with a different username";
        }
 
        //check if email is already associated with an account
        if (check_email_taken($pdo, $email)) {
            $errors["email_taken"] = "An account has already been registered with this email! Try again with a different email";
        }

        //link to session
        require_once 'config_session.inc.php';

        if ($errors) {
            //OUTPUT then store session data
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
           $_SESSION["error"] = $errors;
           die();
        }

        create_user($pdo, $username, $password, $email);

        header("Location: http://localhost/NEA/booking/index.php");

        $pdo = null;//ending the database connnection as no longer needed
        //this will help prevent further issues
        $statement = null;//this way i can use this same variable later on in the program if needed
        die(); //terminate script after redirect


    } catch (PDOException $e) {
        die("Query Unsuccessful"); //indicate to terminate the function if the query is unsuccessful
    }

} else {
    //this branch is for if the user did not access this page by submitting the form
    header("Location: http://localhost/NEA/register/index.php");
    die(); //terminate the script
}