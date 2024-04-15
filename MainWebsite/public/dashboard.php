<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

// Include header
include "templates/header.php";

// Display logged-in user's email
echo "<h2>Account Dashboard</h2>";
echo "<p>You are logged in as " . $_SESSION['email'] . "</p>";

// Include other dashboard content
?>
<li><a href="update.php"><strong>Update</strong></a> - update your info</li>
<li><a href="delete.php"><strong>Delete</strong></a> - delete your account</li>
<li><a href="ProductsPage.php"><strong>Products page</strong></a> - Products</li>
<a href="index.php">Back to home</a>

<?php
// Include footer
include "templates/footer.php";
?>
