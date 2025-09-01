<?php
//helps show information to users on the website
//use of hierarchy chart and the mvc model in the design stage for login module
//to prevent lots of syntax errors
declare(strict_types=1);

function output_username()
{
    if (isset($_SESSION["user_id"])) {
        echo "You are loggin in as " . $_SESSION["user_username"];
    } else {
        echo "You are not currently logged in";
    }
}


function check_login_errors()
{
    if (isset($_SESSION["errors_login"])) {
        $errors = $_SESSION["errors_login"];

        echo "<br>";

        //loop to output error into form
        foreach ($errors as $error) {
            echo '<p class="form-error">' . $error . '</p>';
        }

        unset($_SESSION['errors_login']);
    } else if (isset($_GET['login']) && $_GET['login'] === "success") {
        
    }
}