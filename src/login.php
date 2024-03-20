<?php
require "Template/header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <link rel="stylesheet" type="text/css" href="CSS/computerShop.css">
    <script src="Javascript/extraFunctionality.js"></script>
</head>

    <h2>Login</h2>
    <form action="lib/process_login.php" method="POST">
        <label for="email">Email Address:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="userPassword">Password:</label><br>
        <input type="password" id="userPassword" name="userPassword" required><br><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>