<?php
require_once 'C:\xampp\htdocs\NEA\phpscript\config_session.inc.php';
// require_once 'C:\xampp\htdocs\NEA\phpscript\dbh.inc.php';
require_once 'C:\xampp\htdocs\NEA\phpscript\register_view.inc.php';
require_once 'C:\xampp\htdocs\NEA\phpscript\login_view.inc.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <script src="formValidation.js"></script>
    <title>EUKT</title>

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
                    <li><a href="http://localhost/NEA/settings/settings.php">Settings</a></li>
                    <li><a href="http://localhost/NEA/phpscript/logout.inc.php">Log Out</a></li>
                    <li><a href="http://localhost/NEA/settings/index.php">MOD</a></li>
                </ul>
                <div>
        </nav>


    </header>

    <h3>
        <?php
        //output_username();
        ?>
    </h3>
    <div class="container">
        <div class="left-section">
            <h3>Login</h3>

            <form action="../phpscript/login.inc.php" method="post" onsubmit="return validateLoginForm()">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <a href="http://localhost/NEA/booking/index.php" ><button type="submit">Login</button></a>
            </form>

            <?php
            check_login_errors(); //output errors into website
            ?>
        </div>

        <div class="right-section">
            <h3>Register</h3>

            <form action="../phpscript/register.inc.php" method="post" onsubmit="return validateRegistrationForm()">
                <input type="text" name="email" placeholder="E-Mail">
                <input type="text" name="username" placeholder="Username">
                <input type="password" name="password" placeholder="Password">
                <a href="http://localhost/NEA/booking/index.php" ><button type="submit">Register</button></a>
            </form>

            <?php
            check_signup_errors();
            ?>

        </div>

        <div class="bottom-left-section">
            <h3>Logout</h3>

            <form action="C:\xampp\htdocs\NEA\phpscript\logout.inc.php" method="post">
                <button>Logout</button>
            </form>
        </div>
    </div>

</body>
</html>

<?php
//output_username();
?>