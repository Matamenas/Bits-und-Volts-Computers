<?php

$host = "localhost";
$username = "DatabaseUser";
$password = "";
$dbname = "customerDB"; // will use later
$dsn = "mysql:host=$host;dbname=$dbname"; // will use later
$options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
);
?>