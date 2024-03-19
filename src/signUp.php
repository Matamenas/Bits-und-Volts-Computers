<?php
require "Template/header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" type="text/css" href="CSS/computerShop.css">
    <script src="Javascript/extraFunctionality.js"></script>
</head>

<body>
<h2>Sign Up</h2>
<form action="lib/process_signup.php" method="POST">
    <label for="firstName">First Name:</label><br>
    <input type="text" id="firstName" name="firstName" required><br><br>

    <label for="lastName">Last Name:</label><br>
    <input type="text" id="lastName" name="lastName" required><br><br>

    <label for="address">Address:</label><br>
    <input type="text" id="address" name="address" required><br><br>

    <label for="email">Email Address:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="paymentType">Payment Type:</label><br>
    <input type="text" id="paymentType" name="paymentType" required><br><br>

    <label for="paymentDetails">Payment Details:</label><br>
    <input type="text" id="paymentDetails" name="paymentDetails" required><br><br>

    <label for="userPassword">Password:</label><br>
    <input type="password" id="userPassword" name="userPassword" required><br><br>

    <input type="submit" value="Submit" href="login.php">
</form>
</body>
</html>