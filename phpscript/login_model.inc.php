<?php
//for functions that will interact and query with the database
//use of hierarchy chart and the mvc model in the design stage for sign up module
//to prevent lots of syntax errors
declare(strict_types=1);

function fetch_user(object $pdo, string $username)
{
    if ($username === null){
        $new_username = $_SESSION["username"];
    } else {
        $new_username = $username;
    }
    //use pseudocode reference from design to query the database
    $query = "SELECT * FROM users WHERE username = :new_username";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":new_username", $username);
    $statement->execute();

    //refer to data from the field
    //$result is boolean so this function can only return true or false
    //$result[] = $statement->fetch(PDO::FETCH_ASSOC); 
    //return $result->fetch(PDO::FETCH_ASSOC);;

    // Fetch the user data directly from the statement
    try {
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
} 