<?php
include 'templates/header.php';
require_once '../src/DBconnect.php';

//check login status
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

//customer id based on email address
$email = $_SESSION['email'];
$sql = "SELECT id FROM customer WHERE email = :email";
$statement = $connection->prepare($sql);
$statement->bindParam(':email', $email);
$statement->execute();
$customer = $statement->fetch(PDO::FETCH_ASSOC);

//fetch the cart items of user based on id
$customerId = $customer['id'] ?? null;
if ($customerId) {
    $sql = "SELECT products.*, cart_items.quantity 
            FROM products 
            INNER JOIN cart_items ON products.id = cart_items.product_id 
            WHERE cart_items.cart_id = :cart_id AND cart_items.quantity > 0";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':cart_id', $customerId);
    $statement->execute();
    $cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);
} else {
    $cartItems = [];
}

//if cart is empty redirect to products page
if (empty($cartItems)) {
    header("Location: ProductsPage.php");
    exit;
}

//calculate the cart total 
$totalAmount = 0;
foreach ($cartItems as $item) {
    $totalAmount += $item['price'] * $item['quantity'];
}

//calculate shippping costs //removed fast shipping option
$shippingCost = 0;
if (isset($_POST['shipping']) && $_POST['shipping'] === 'fast') {
    $shippingCost = 7;
} else {
    $shippingCost = 4;
}

//add both the costs together
$totalAmount += $shippingCost;

//insert order into orders table
$orderDate = date('Y-m-d H:i:s');
$status = 'pending'; //initial status set to pending //update in admin panel
$sql = "INSERT INTO orders (customer_id, order_date, total_amount, status) VALUES (:customer_id, :order_date, :total_amount, :status)";
$statement = $connection->prepare($sql);
$statement->bindParam(':customer_id', $customerId);
$statement->bindParam(':order_date', $orderDate);
$statement->bindParam(':total_amount', $totalAmount);
$statement->bindParam(':status', $status);
$statement->execute();
$orderId = $connection->lastInsertId();

//insert order items into the order_items table based on order id
foreach ($cartItems as $item) {
    $productId = $item['id'];
    $quantity = $item['quantity'];
    $sql = "INSERT INTO order_items (order_id, product_id, quantity) VALUES (:order_id, :product_id, :quantity)";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':order_id', $orderId);
    $statement->bindParam(':product_id', $productId);
    $statement->bindParam(':quantity', $quantity);
    $statement->execute();
}

//clear the cart 
$sql = "DELETE FROM cart_items WHERE cart_id = :cart_id";
$statement = $connection->prepare($sql);
$statement->bindParam(':cart_id', $customerId);
$statement->execute();
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
        <p>Your order has been placed successfully!</p>
        <p>Reference ID: <?php echo $orderId; ?></p>
        <p>Total Amount: $<?php echo number_format($totalAmount, 2); ?></p>
        <a href="index.php" class="continue-shopping-btn">Continue Shopping</a>
    </div>
</body>
</html>
