<?php
    try {
        require_once 'C:\xampp\htdocs\NEA\phpscript\dbh.inc.php';
        require_once 'C:\xampp\htdocs\NEA\phpscript\config_session.inc.php';
                
        //check username is in session
        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
        
            //check the username is not null
            if ($username !== null) {
                require_once 'C:\xampp\htdocs\NEA\phpscript\login_model.inc.php';
                $userDetails = fetch_user($pdo, $username);

                //check user details wer correcly saved
                if ($userDetails) {
                    if (!empty($userDetails) && isset($userDetails['user_id'])) {
                        $userId = $userDetails['user_id'];
                    }
                    $userId = $userDetails['user_id'];
                }
            }
        } else {
            echo 'User is not logged in';
            header("Location: http://localhost/NEA/register/");
            exit;
        }

        $userId = $_SESSION['user_id'];

        //delete the user's account
        $query = "DELETE FROM users WHERE user_id = :user_id";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':user_id', $userId);
        $statement->execute();

        //check if the account was successfully deleted
        if ($statement->rowCount() > 0) {
            //account successfully deleted, logout the user and redirect to login page
            session_destroy();
            header("Location: http://localhost/NEA/register/");
            exit();
        } else {
            // Account deletion failed, redirect back to profile page with error message
            $_SESSION['error'] = "Failed to delete account. Please try again.";
            header("Location: http://localhost/NEA/Settings/settings.php");
            exit();
        }
    
    } catch (PDOException $e) {
        die("Error");
    }
    