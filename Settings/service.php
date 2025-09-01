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
                    <li><a href="http://localhost/NEA/Settings/settings.php">Settings</a></li>
                    <li><a href="http://localhost/NEA/phpscript/logout.inc.php">Log Out</a></li>
                </ul>
                <div>
        </nav>


    </header>




    <?php
    // Include database connection
    require_once 'C:\xampp\htdocs\NEA\phpscript\dbh.inc.php';

    //select all announcements
    $query = "SELECT * FROM announcements ORDER BY date DESC, time DESC";
    $statement = $pdo->query($query);

    //check if there are any announcements
    if ($statement->rowCount() > 0) {
        //displaying the table
        echo "<h2>Announcements</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Announcement</th><th>Date</th><th>Time</th></tr>";
        
        //iterate through each announcement and display its details
        while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>".$row['announcement']."</td>";
            echo "<td>".$row['date']."</td>";
            echo "<td>".$row['time']."</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "No announcements found.";
    }
    ?>
</body>
</html>