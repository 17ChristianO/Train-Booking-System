<?php


//ticket information
$ticketInformation = 
[
    'startStation' => $startStation,
    'destinationStation' => $destinationStation,
    'startDate' => $startDate,
    'startTime' => $startTime,
    'returnDate' => $returnDate,
    'returnTime' => $returnTime,
    'numTickets' => $numTickets,
    'totalPrice' => $totalPrice,
];

class Payment {
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }
    
    public function createPayment($paymentDetails, $cardNumber, $cvv, $expiryDate,  $ticketInformation, $startStation, $destinationStation, $startDate, $startTime, $returnDate, $returnTime, $numTickets, $totalPrice)
    {
        //insert payment details into the payments table
        $statement = $this->pdo->prepare("INSERT INTO payments (card_number, expiry_date, cvv) VALUES (:cardNumber, :expiryDate, :cvv)");
        $statement->bindParam(':cardNumber', $paymentDetails['cardNumber']);
        $statement->bindParam(':expiryDate', $paymentDetails['expiryDate']);
        $statement->bindParam(':cvv', $paymentDetails['cvv']);
        $statement->execute();

        //after successfully storing payment details, get the last inserted payment ID
        $paymentId = $this->pdo->lastInsertId();

        
        //add payment id to ticket information
        $ticketInformation = [
            'startStation' => $startStation,
            'destinationStation' => $destinationStation,
            'startDate' => $startDate,
            'startTime' => $startTime,
            'returnDate' => $returnDate,
            'returnTime' => $returnTime,
            'numTickets' => $numTickets,
            'totalPrice' => $totalPrice,
            'paymentID' => $paymentId,
        ];

        //return the ID of the newly created payment
        return $paymentId;
    }

    public function storeBookingDetails($paymentId)
    {
        try {
        //Fetch user_id using the username
        $username = $_SESSION["username"];

        require_once 'C:\xampp\htdocs\NEA\phpscript\login_model.inc.php';
        $userDetails = fetch_user($this->pdo, $username);
        $startStation = $_SESSION['ticketInformation']['startStation'];
        $destinationStation = $_SESSION['ticketInformation']['destinationStation'];
        $startDate = $_SESSION['ticketInformation']['startDate'];
        $startTime = $_SESSION['ticketInformation']['startTime'];
        $returnDate = $_SESSION['ticketInformation']['returnDate'];
        $returnTime = $_SESSION['ticketInformation']['returnTime'];
        $numTickets = $_SESSION['ticketInformation']['numTickets'];
        $totalPrice = isset($_SESSION['totalPrice']) ? $_SESSION['totalPrice'] : 0;

        // Check if the user was found
        if (!$userDetails) {
            $error_payment = [];
            $error_payment[] = 'User could not be found';
            exit;
        }

        // Extract user_id from user details
        $userId = $userDetails["user_id"];

        //Perform your booking storage logic here0
        //Use prepared statements to prevent SQL injection
        $statement = $this->pdo->prepare("INSERT INTO bookings (startStation, destinationStation, startDate, startTime, returnDate, returnTime, numTickets, totalPrice, paymentId, user_id) VALUES (:startStation, :destinationStation, :startDate, :startTime, :returnDate, :returnTime, :numTickets, :totalPrice, :paymentId, :userId)");

        //bind parameters
        $statement->bindParam(':startStation', $startStation);
        $statement->bindParam(':destinationStation', $destinationStation);
        $statement->bindParam(':startDate', $startDate);
        $statement->bindParam(':startTime', $startTime);
        $statement->bindParam(':returnDate', $returnDate);
        $statement->bindParam(':returnTime', $returnTime);
        $statement->bindParam(':numTickets', $numTickets);
        $statement->bindParam(':totalPrice', $totalPrice);
        $statement->bindParam(':paymentId', $paymentId);
        $statement->bindParam(':userId', $userId);

        $statement->execute();

    } catch (PDOException $e) {
        die();
    }
    }
}

