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

// Display logged-in user's email
echo "<h2>Account Dashboard</h2>";
echo "<p>You are logged in as " . $_SESSION['email'] . "</p>";

// Fetch customer ID from the database based on the logged-in user's email
$email = $_SESSION['email'];
$sql = "SELECT id FROM customer WHERE email = :email";
$statement = $connection->prepare($sql);
$statement->bindParam(':email', $email);
$statement->execute();
$customer = $statement->fetch(PDO::FETCH_ASSOC);

// Fetch cart items from the database for the current customer's cart
$customerId = $customer['id'] ?? null;
if ($customerId) {
    $sql = "SELECT products.*, cart.quantity 
            FROM products 
            INNER JOIN cart ON products.id = cart.product_id 
            WHERE cart.customer_id = :customer_id";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':customer_id', $customerId);
    $statement->execute();
    $cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    $cartItems = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/Cart.css">
</head>
<body>
    <div class="container">
        <h1>Shopping Cart</h1>
        <div class="cart-items">
            <?php foreach ($cartItems as $item): ?>
                <div class="cart-item">
                    <img src="uploads/<?php echo $item['name']; ?>.jpg" alt="<?php echo $item['name']; ?>">
                    <h2><?php echo $item['name']; ?></h2>
                    <p><?php echo $item['description']; ?></p>
                    <p>Price: $<?php echo $item['price']; ?></p>
                    <p>Quantity: <?php echo $item['quantity']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="Checkout.php" class="checkout-btn">Proceed to Checkout</a>
    </div>
</body>
</html>

<?php
// Include footer
include "templates/footer.php";
?>
