<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Booking</title>
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
                    <li><a href="http://localhost/NEA/settings/settings.php">Settings</a></li>
                    <li><a href="http://localhost/NEA/phpscript/logout.inc.php">Log Out</a></li>
                </ul>
                <div>
        </nav>


    </header>

    <main>

        <?php

            require_once 'booking_view.inc.php';
            require_once 'C:\xampp\htdocs\NEA\phpscript\config_session.inc.php';

            check_booking_errors();


            $stations = [
                'Baker Street',
                'Bank/Monument',
                'Bond Street',
                'Camden Town',
                'Canada Water',
                'Canary Warf',
                'Canning Town',
                'Euston Square',
                'Farringdon',
                'Green Park',
                'King\'s Cross St.Pancras',
                'Liverpool Street',
                'London Bridge',
                'Moorgate',
                'Oxford Circus',
                'Paddington',
                'South Kensington',
                'Stratford',
                'Victoria',
                'Waterloo',
                'Westminister',
                'Whitechapel'
            ];

            //retrieve username from session
            $username = isset($_SESSION['username']) ? $_SESSION['username'] : [];

            //function to display username
            function output_username()
            {
                //check if session variable has been set
                if (isset($_SESSION["username"])) {
                    echo "You are logged in as " . $_SESSION["username"];
                    echo "<br>";
                } else {
                    //otherwise user most likely go to this page without logging in
                    echo "You are not currently logged in";
                }
            }

            output_username();
        ?>

        <section class="booking-form">
            <h3>Book Tickets</h3>
            <form action="booking.inc.php" method="post">
                <label for="startStation">Start Station:</label>
                <select id="startStation" name="startStation" required>
                    <?php foreach ($stations as $station) { ?>
                        <option value="<?php echo $station; ?>"><?php echo $station; ?></option>
                    <?php } ?>
                </select>

                <label for="destinationStation">Destination Station:</label>
                <select id="destinationStation" name="destinationStation" required>
                    <?php foreach ($stations as $station) { ?>
                        <option value="<?php echo $station; ?>"><?php echo $station; ?></option>
                    <?php } ?>
                </select>

                <label for="startDate">Start Date:</label>
                <input type="date" id="startDate" name="startDate" required>

                <label for="startTime">Start Time:</label>
                <input type="time" id="startTime" name="startTime" required>

                <label for="returnDate">Return Date:</label>
                <input type="date" id="returnDate" name="returnDate">

                <label for="returnTime">Return Time:</label>
                <input type="time" id="returnTime" name="returnTime">

                <label for="numTickets">Number of Tickets:</label>
                <input type="number" id="numTickets" name="numTickets" min="1" max="15" required>

                <button type="submit">Book Now</button>

            </form>
        </section>

    </main>

</body>
</html>

