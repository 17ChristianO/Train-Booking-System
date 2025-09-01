<?php
//for functions that will interact and query with the database
//use of hierarchy chart and the mvc model in the design stage for sign up module
//to prevent lots of syntax errors
declare(strict_types=1);

//retrieve username from database, user table
//using object data type as using PDOs
function retrieve_username(object $pdo, string $username)
{
    try{
        //use pseudocode reference from design to query the database
        $query = "SELECT username FROM users WHERE username = :username";
        $statement = $pdo->prepare($query);
        $statement->bindParam(":username", $username);
        $statement->execute();

        //refer to data from the field
        $result = $statement->fetch(PDO::FETCH_ASSOC); 
        return $result;
    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

function retrieve_email(object $pdo, string $email)
{
    try{
    //use pseudocode reference from design to query the database
    $query = "SELECT username FROM users WHERE email = :email";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":email", $email);
    $statement->execute();

    //refer to data from the field
    $result = $statement->fetch(PDO::FETCH_ASSOC); 
    return $result;

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }
}

function set_user(object $pdo,  string $email, string $username, string $password)
{
    try{
    $query = "INSERT INTO users (email, username, password) VALUES (:email, :username, :password)";

    //secure the password before storing
    $options = [
        'cost' => 12
    ];
    //hash password using BCRYPT hashing algorithm
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, $options);

    $statement = $pdo->prepare($query);
    $statement->bindParam(":email", $email);
    $statement->bindParam(":username", $username);
    $statement->bindParam(":password", $hashedPassword);
    $statement->execute(); 

    } catch (PDOException $e) {
        die("Query failed: " . $e->getMessage());
    }

}