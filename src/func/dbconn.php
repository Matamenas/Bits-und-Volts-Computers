<?php

$host = '127.0.0.1';
$dbname = 'bitsundvoltsfinal2';
$username = 'root';
$password = null;

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {
    // Print PDO exception message
    echo "Error: " . $e->getMessage();
}
