<?php
session_start();

//check login status //dashboard to acces different account options
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}


include "templates/header.php";
?>
<link rel="stylesheet" href="css/DashboardStyling.css">
<div class="container">
    <h2>Account Dashboard</h2>
    <p>You are logged in as <?php echo $_SESSION['email']; ?></p>
    <ul>
        <li><a href="update.php"><strong>Update</strong></a> - Update your information</li>
        <li><a href="delete.php"><strong>Delete</strong></a> - Delete your account</li>
    </ul>
    <a href="indexlogged.php" class="btn">Back to Home</a>
</div>

<?php

include "templates/footer.php";
?>
