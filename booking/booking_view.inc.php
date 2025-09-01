<?php
//helps show information to users on the website
//use of hierarchy chart and the mvc model in the design stage for sign up module
//to prevent lots of syntax errors

function check_booking_errors()
{

    if  (isset($_SESSION['errors_booking'])) {
        $errors = $_SESSION['errors_booking'];

        echo '<div class="error-messages">';

        foreach ($errors as $error) {
            echo '<p class="form-error">' . $error . '</p>';
        }

        echo '</div>';
        //data is not needed anymore so it can be removed
        unset($_SESSION['errors_booking']);
    }

}