<?php
session_start();
require_once '../src/DBconnect.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['email'])) {
    header("Location: index.php");

    exit;
}

// Include header
include "templates/header.php";

// Fetch customer details from the database based on the logged-in user's email
$email = $_SESSION['email'];
$sql = "SELECT * FROM customer WHERE email = :email";
$statement = $connection->prepare($sql);
$statement->bindParam(':email', $email);
$statement->execute();
$customer = $statement->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="css/Checkout.css">
</head>
<body>
    <div class="container">
        <h1>Checkout</h1>
        <h2>Shipping Information</h2>
        <form action="process_checkout.php" method="post">
            <label for="fullname">Full Name:</label>
            <input type="text" id="fullname" name="fullname" value="<?php echo htmlspecialchars($customer['fullname']); ?>" required><br>
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($customer['address']); ?>" required><br>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($customer['city']); ?>" required><br>
            <label for="zipcode">Zip Code:</label>
            <input type="text" id="zipcode" name="zipcode" value="<?php echo htmlspecialchars($customer['zipcode']); ?>" required><br>
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" value="<?php echo htmlspecialchars($customer['country']); ?>" required><br>

            <h2>Payment Information</h2>
            <label for="cardname">Name on Card:</label>
            <input type="text" id="cardname" name="cardname" required><br>
            <label for="cardnumber">Card Number:</label>
            <input type="text" id="cardnumber" name="cardnumber" required><br>
            <label for="expdate">Expiration Date:</label>
            <input type="text" id="expdate" name="expdate" placeholder="MM/YYYY" required><br>
            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" required><br>

            <button type="submit" class="checkout-btn">Place Order</button>
        </form>
    </div>
</body>
</html>

<?php
// Include footer
include "templates/footer.php";
?>
