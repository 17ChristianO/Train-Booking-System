<?php
//session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="payment.css">
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

    <form action="payment.inc.php" method="post">
        <h2>Enter Your Card Information</h2>

        <label for="cardNumber">Card Number:</label>
        <input type="text" id="cardNumber" name="cardNumber" pattern="[0-9]{4} [0-9]{4} [0-9]{4} [0-9]{4}" placeholder="1234 5678 9012 3456" required>

        <label for="expiryDate">Expiry Date:</label>
        <input type="text" id="expiryDate" name="expiryDate" pattern="(0[1-9]|1[0-2])\/[0-9]{4}" placeholder="MM/YYYY" required>

        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" pattern="[0-9]{3}" placeholder="123" required>


        <button type="submit">Submit Payment</button>
    </form>
</body>
</html>