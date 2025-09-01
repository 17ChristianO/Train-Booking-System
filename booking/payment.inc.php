<?php

require_once 'C:\xampp\htdocs\NEA\phpscript\dbh.inc.php';
require_once 'C:\xampp\htdocs\NEA\phpscript\config_session.inc.php';

$errors_payment = [];

//check if session is not started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    $errors_payment[] = 'There was no session before';
}

//check if there is total price
$totalPrice = isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : 0;
//unset($_SESSION['totalPrice']); // clear total weight from session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //process payment
    $cardNumber = $_POST['cardNumber'];
    $expiryDate = $_POST['expiryDate'];
    $cvv = $_POST['cvv'];

    $paymentDetails = [

        'cardNumber' => $cardNumber,
        'expiryDate' => $expiryDate,
        'cvv' => $cvv,
    ];

    //check if there is ticket information

    $startStation = $_SESSION['ticketInformation']['startStation'];
    $destinationStation = $_SESSION['ticketInformation']['destinationStation'];
    $startDate = $_SESSION['ticketInformation']['startDate'];
    $startTime = $_SESSION['ticketInformation']['startTime'];
    $returnDate = $_SESSION['ticketInformation']['returnDate'];
    $returnTime = $_SESSION['ticketInformation']['returnTime'];
    $numTickets = $_SESSION['ticketInformation']['numTickets'];

    $ticketInformation = [
        'startStation' => $startStation,
        'destinationStation' => $destinationStation,
        'startDate' => $startDate,
        'startTime' => $startTime,
        'returnDate' => $returnDate,
        'returnTime' => $returnTime,
        'numTickets' => $numTickets,
        'totalPrice' => $totalPrice,
    ];


    //require_once 'C:\xampp\htdocs\NEA\phpscript\login_model.inc.php';
    // Fetch user_id using the username (assuming you have the username available)
    //$username = $_SESSION['result']['user_username'];

    // Check if the session variable is set
    if (isset($_SESSION["username"])) {
        //retrieves the username from the session
        $username = $_SESSION["username"];

        if ($username !== null) {
            echo 'username is not null <br>';
            require_once 'C:\xampp\htdocs\NEA\phpscript\login_model.inc.php';
            // Fetch user data
            $userDetails = fetch_user($pdo, $username);

            echo '<pre>';
            print_r($userDetails);
            echo '</pre>';
            
            if ($userDetails) {
                // Extract user_id from user details
                echo 'User details worked <br>';

                if (!empty($userDetails) && isset($userDetails['user_id'])) {
                    echo 'User details worked <br>';
                    $userId = $userDetails['user_id'];
                } else {
                    echo 'Error retrieving user data or user_id not found';
                }

                //$userId = $userDetails[0]["user_id"];
                    $userId = $userDetails['user_id'];
                    //$userId = $userDetails[0]('user_id');
                    //$userId = $userDetails["user_id"];
                    if (!isset($userDetails['user_id'])) {
                        echo 'Error retrieving user data - user_id not found';
                    }

            } else {
                echo 'Error retrieving user data';
            }
        }
        //return $userDetails;
    } else {
        $errors_payment[] ='username is not set in session';
    }

    //$username = isset($_SESSION['username']) ? $_SESSION['username'] : 0;
    //$username = $_SESSION["username"]; // Replace with the actual way you identify the user (e.g., from login)
    //$username = $_SESSION['result']['username'];
    //$userDetails = fetch_user($pdo, $username);

    /*$username = $_SESSION["username"];
    require_once 'C:\xampp\htdocs\NEA\phpscript\login_model.inc.php';
    $userDetails = fetch_user($pdo, $username); */

    // Check if the user was found
    if (!$userDetails) {
        $errors_payment = [];
        $errors_payment[] = 'User could not be found';
        $_SESSION['errors_payment'] = $errors_payment;
        exit;
    }

    // Extract user_id from user details
    $userId = $userDetails["user_id"];

    /*if (isset($userDetails[0]['user_id'])) {
        $userId = $userDetails[0]['user_id'];
        //$userId = $userDetails["user_id"];
    } else {
        echo 'Error retrieving user data - user_id not found';
    }*/

    try {

        //require_once 'C:\xampp\htdocs\NEA\phpscript\dbh.inc.php';
        require_once 'payment_model.inc.php';

        //payment validation


        //if validation works then validation is successful
        $paymentSuccessful = true;

        if ($paymentSuccessful) {
            //function to store details in database

            //create an instance of Payment
            $payment = new Payment($pdo);
            // Create payment
            $paymentId = $payment->createPayment($paymentDetails, $cardNumber, $cvv, $expiryDate,  $ticketInformation, $startStation, $destinationStation, $startDate, $startTime, $returnDate, $returnTime, $numTickets, $totalPrice);

            //check if payment creation was successful
            if (!$paymentId || $paymentId === null) {
                echo 'Payment Id has issues';
                //handle the case where payment creation failed
                $errors_payment [] = 'Error: Purchase unsuccessful';
                $_SESSION['errors_payment'] = $errors_payment;
                exit;
            }

            try {
                $bookingStored = $payment->storeBookingDetails($paymentId);

            } catch (PDOException $e) {
                //check booking was successful
                if ($bookingStored === null) {
                    echo 'Error: Failed to store booking information';
                    $errors_payment[] = 'Error: Failed to store booking information';
                    $_SESSION['errors_payment'] = $errors_payment;
                    exit;
                }
                
            }

            //check errors array is empty
            if (!empty($errors_payment)) {

                $errors_payment[] = "Payment failed. Please try again.";

                // handle errors here and display them to the user
                foreach ($errors_payment as $error) {
                    echo $error . "<br>";
                }
                $_SESSION['errors_payment'] = $errors_payment;

            } else {
            header("Location: http://localhost/NEA/booking/payment_view.inc.php");
            exit;}

        } else {
            // Payment failed, handle accordingly
            echo "Payment failed. Please try again.";
        }

    } catch (PDOException $e) {
        $errors_payment[] = "Error: " . $e->getMessage();
        //die($errors_booking);
    }
} else {
    // Invalid request method
    echo "Invalid request method, you must resubmit you information from the start to continue";
}
