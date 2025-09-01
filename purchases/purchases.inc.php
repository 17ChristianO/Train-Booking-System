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
                    <li><a href="http://localhost/NEA/settings/service.php">Services</a></li>
                    <li><a href="#">Settings</a></li>
                    <li><a href="http://localhost/NEA/phpscript/logout.inc.php">Log Out</a></li>
                </ul>
                <div>
        </nav>


    </header>

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
                exit;
            }
            
            $userId = $userDetails["user_id"];
            
            //execute a query to fetch bookings
            $query = "SELECT * FROM bookings WHERE user_id = :userId";
            $statement = $pdo->prepare($query);
            $statement->bindParam(':userId', $userId);
            $statement->execute();
            
            //check if there are bookings for the user
            if ($statement->rowCount() > 0) {
                // Start displaying bookings
                echo "<h2>Bookings</h2>";
                echo "<table border='1'>";
                echo "<tr><th>Start Station</th><th>Destination Station</th><th>Start Date</th><th>Start Time</th><th>Return Date</th><th>Return Time</th><th>Num Tickets</th><th>Total Price</th><th>Booked At</th</tr>";
                while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>";
                    echo "<td>".$row['startStation']."</td>";
                    echo "<td>".$row['destinationStation']."</td>";
                    echo "<td>".$row['startDate']."</td>";
                    echo "<td>".$row['startTime']."</td>";
                    echo "<td>".$row['returnDate']."</td>";
                    echo "<td>".$row['returnTime']."</td>";
                    echo "<td>".$row['numTickets']."</td>";
                    echo "<td>".'£'.$row['totalPrice']."</td>";
                    echo "<td>".$row['created_at']."</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else {
                echo "No bookings found. This user has no bookings.";
            }
        } catch (PDOException $e) {
            die("Attempt to retrieve bookings failed. Please relogin or contact customer support at eukt@gmail.com");
        }

    ?>
</body>
</html>