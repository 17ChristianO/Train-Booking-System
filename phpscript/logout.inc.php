<?php
    try {
        session_start();
        session_unset();
        session_destroy();
        header("Location: http://localhost/NEA/register/index.php");
    
    } catch (\Throwable $th) {
        header("Location: http://localhost/NEA/register/index.php");
        die(); //terminate the script
    }
    //start then end session with pre-built functions
   /* session_start();
    session_unset();
    session_destroy();

    header("Location: http://localhost/NEA/register/index.php");
    die(); //terminate the script*/