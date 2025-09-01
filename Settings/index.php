<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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


        <h1>Submit Service Announcement</h1>
        <form action="announcement.php" method="post">
            <label for="announcement">Announcement:</label><br>
            <textarea id="announcement" name="announcement" rows="4" cols="50" required></textarea><br>
            <label for="date">Date:</label>
            <input type="date" id="date" name="date" required><br>
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" required><br>
            <input type="submit" value="Submit">
        </form>

    </header>

</body>
</html>