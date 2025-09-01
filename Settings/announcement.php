<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //run database so connection variable can be used
    require_once 'C:\xampp\htdocs\NEA\phpscript\dbh.inc.php';

    //retrieve form input
    $announcement = htmlspecialchars(trim($_POST["announcement"]));
    $date = $_POST["date"];
    $time = $_POST["time"];

    //insert the announcement into the database
    $query = "INSERT INTO announcements (announcement, date, time) VALUES (:announcement, :date, :time)";
    $statement = $pdo->prepare($query);
    $statement->bindParam(":announcement", $announcement);
    $statement->bindParam(":date", $date);
    $statement->bindParam(":time", $time);

    //check if successful
    if ($statement->execute()) {
        echo "Announcement submitted successfully.";
    } else {
        echo "Error: Unable to submit announcement.";
    }
} else {
    //redirect the user back to the form page
    header("Location: form_page.php");
    exit();
}