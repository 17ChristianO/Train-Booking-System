<?php

$errors = [];

$errors["error_test"] = "Test error message output"; 

//link to session
require_once 'C:\xampp\htdocs\NEA\phpscript\config_session.inc.php';

if ($errors) {
    //store session data
   $_SESSION["errors_login"] = $errors;
   header("Location: http://localhost/NEA/register/index.php");
   die();
}

