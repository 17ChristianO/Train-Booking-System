<?php
//where available tickets will be displayed
//require_once 'index.php';

require_once 'C:\xampp\htdocs\NEA\phpscript\config_session.inc.php';

//check if there are errors from booking.inc.php
$errors_booking = isset($_SESSION['errors_booking']) ? $_SESSION['errors_booking'] : [];
unset($_SESSION['errors_booking']); // clear errors from session

// Check if there is ticket information
$ticketInformation = isset($_SESSION['ticketInformation']) ? $_SESSION['ticketInformation'] : [];

//check if there is total weight
$totalWeight = isset($_SESSION['totalWeight']) ? $_SESSION['totalWeight'] : 0;
unset($_SESSION['totalWeight']); //clear total weight from session

//price per ticket calculation
$pricePerTicket = $totalWeight + 2;

//calculate total price
$totalPrice = isset($ticketInformation['numTickets']) ? $pricePerTicket * $ticketInformation['numTickets'] : 0;
$_SESSION['totalPrice'] = $totalPrice;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>

<body>

    <header>

        <nav>
                <a href="http://localhost/NEA/booking/"><img src="logo.jpg" alt="E-train logo"></a>
                <ul>
                    <li><a href="http://localhost/NEA/register/">Login/Signup</a></li>
                    <li><a href="http://localhost/NEA/booking/">Home</a></li>
                    <li><a href="#">Booking</a></li>
                    <li><a href="http://localhost/NEA/purchases/purchases.inc.php">Purchases</a></li>
                    <li><a href="#">Services</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="http://localhost/NEA/phpscript/logout.inc.php">Log Out</a></li>
                </ul>
                <div>
        </nav>


    </header>

    <?php if (!empty($errors_booking)): ?>
        <div>
            <h2>Booking Errors:</h2>
            <ul>
                <?php foreach ($errors_booking as $error): ?>
                    <li><?php echo htmlspecialchars($error); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($ticketInformation)): ?>
        <div>
            <h2>Your Ticket Information</h2>
            <p>Start Station: <?php echo isset($ticketInformation['startStation']) ? htmlspecialchars($ticketInformation['startStation']) : 'Not specified'; ?></p>
            <p>Destination Station: <?php echo isset($ticketInformation['destinationStation']) ? htmlspecialchars($ticketInformation['destinationStation']) : 'Not specified'; ?></p>
            <p>Start Date: <?php echo isset($ticketInformation['startDate']) ? htmlspecialchars($ticketInformation['startDate']) : 'Not specified'; ?></p>
            <p>Start Time: <?php echo isset($ticketInformation['startTime']) ? htmlspecialchars($ticketInformation['startTime']) : 'Not specified'; ?></p>            
            <p>Return Date: <?php echo isset($ticketInformation['returnDate']) ? htmlspecialchars($ticketInformation['returnDate']) : 'N/A'; ?></p>
            <p>Return Time: <?php echo isset($ticketInformation['returnTime']) ? htmlspecialchars($ticketInformation['returnTime']) : 'N/A'; ?></p>
            <p>Number of Tickets: <?php echo isset($ticketInformation['numTickets']) ? htmlspecialchars($ticketInformation['numTickets']) : 'Not specified'; ?></p>
            <p>Price Per Ticket: £<?php echo number_format($pricePerTicket); ?></p>
            <p>Total Price: £<?php echo number_format($totalPrice, 2); ?></p>

            <!-- button to purchase ticket -->
            <form action="payment.php" method="post">
                <input type="hidden" name="totalPrice" value="<?php echo $totalPrice; ?>">
                <button type="submit">Purchase Ticket</button>
            </form>
        </div>
    <?php endif; ?>

    

</body>
</html>