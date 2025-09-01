<?php

$host = 'localhost';
$dbname = 'nea';
$dbusername = 'root';
$dbpassword = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //check the database connection
    if (!$pdo) {
        die("Error in database connection");
    } else {
        echo 'Database connection is successful';
    }
    
} catch (PDOException $e) {
    die("Error establishing connection: " . $e->getMessage());
}
