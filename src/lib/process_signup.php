<script src="Javascript/extraFunctionality.js"></script>
<?php

// Database connection parameters
$host = '127.0.0.1';
$dbname = 'bitsundvoltsfinal';
$username = 'root';
$password = null;

try {
    // Connect to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Set PDO to throw exceptions on errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Prepare SQL statement for insertion
    $stmt = $pdo->prepare("INSERT INTO Customer (firstName, lastName, address, emailAddress, paymentType, paymentDetails, userPassword) VALUES (?, ?, ?, ?, ?, ?,?)");

    // Bind parameters and execute the statement
    $stmt->bindParam(1, $_POST['firstName']);
    $stmt->bindParam(2, $_POST['lastName']);
    $stmt->bindParam(3, $_POST['address']);
    $stmt->bindParam(4, $_POST['email']);
    $stmt->bindParam(5, $_POST['paymentType']);
    $stmt->bindParam(6, $_POST['paymentDetails']);
    $stmt->bindParam(7, $_POST['userPassword']);

    $stmt->execute();

} catch(PDOException $e) {
    // Print PDO exception message
    echo "Error: " . $e->getMessage();
}
?>