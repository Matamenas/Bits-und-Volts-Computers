<?php
require "Template/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer Service</title>
    <link rel="stylesheet" type="text/css" href="CSS/computerShop.css">
    <script src="Javascript/extraFunctionality.js"></script>
</head>

<body>

    <h1>Customer Service Form</h1>
    <form action="process_form.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" id="DateOf" name="name" required><br><br>
        
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        
        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="5" cols="30" required></textarea><br><br>
        
        <input type="submit" value="Submit">
    </form>
</body>
</html>
