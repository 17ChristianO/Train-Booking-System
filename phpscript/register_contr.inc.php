<?php
//handles information
//use of hierarchy chart and the mvc model in the design stage for sign up module
//to prevent lots of syntax errors
declare(strict_types=1);

//function to check that all inputs are not null
function is_input_null (string $username, string $password, string $email) {

    if(empty($username) || empty($password) || empty($email) ) {
        return true; //if true then there is an invalid input
    } else {
        return false;// all inputs are valid
    }

} 

//check if the email format is valid using built in php function
function is_email_invalid(string $email) 
{

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true; //if true then there is an invalid input
    } else {
        return false;// all inputs are valid
    }

} 

function check_username_taken(object $pdo, string $username)
{

    if(retrieve_username($pdo, $username)) {
        return true; //if true then there is an invalid input
    } else {
        return false;// all inputs are valid
    }

} 

//check email has not already been registered under a different account in the database
function check_email_taken(object $pdo, string $email)
{

    if(retrieve_email($pdo, $email)) {
        return true; //if true then there is an invalid input
    } else {
        return false;// all inputs are valid
    }

} 

function create_user(object $pdo, string $username, string $password, string $email)
{
    set_user($pdo, $username, $password, $email);
} 