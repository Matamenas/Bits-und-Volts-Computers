
<script src="Javascript/extraFunctionality.js"></script>

<?php

    try {
        require "../func/dbconn.php";
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

    echo "Aye man, well done on the account creation.";

        header("Location: ../home.php");
        exit(); // Make sure that subsequent code doesn't execute after redirection
} catch(PDOException $e) {
    // Print PDO exception message
    echo "Error: " . $e->getMessage();
}
?>