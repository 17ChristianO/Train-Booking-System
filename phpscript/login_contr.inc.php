<?php
//handles information
//use of hierarchy chart and the mvc model in the design stage for sign up module
//to prevent lots of syntax errors
declare(strict_types=1);

//function to check that all inputs are not null
function is_input_null (string $username, string $password) {

    if(empty($username) || empty($password)) {
        return true; //if true then there is an invalid input
    } else {
        return false;// all inputs are valid
    }

} 

//combine the data types to accept either because if it only accepts $result as an array an error will occur if username does not exist
function is_username_incorrect(bool|array $result)
{
    if(!$result) {
        return true; //if true then there is an invalid input
    } else {
        return false;// all inputs are valid
    }
}

function is_password_incorrect(string $password, string $hashedpassword)
{
    // check if either $password or $hashedpassword is null
    if ($password === null || $hashedpassword === null) {
        return true; // invalid input
    }

    try {
        $hash = $hashedpassword;

        //use built in php verification operation to compare
        if(!password_verify($password, $hash)) {
            return true; //if true then there is an invalid input
        } else {
            return false;// all inputs are valid
        }
    } catch (PDOException $e) {
        //this branch is for if the user did not access this page by submitting the form
        //header("Location: http://localhost/NEA/register/index.php");
        die(); //terminate the script
    }
}
/*
$userData = fetch_user($pdo, $username);

if ($userData && isset($userData['password'])) {
    // User found and password retrieved
    $hashedPassword = $userData['password'];

}*/