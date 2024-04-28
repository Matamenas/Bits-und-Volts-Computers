<?php
include "templates/header.php";
require_once '../src/DBconnect.php';

//check login status
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}




//display logged in users details
echo "<h2>Account Dashboard</h2>";
echo "<p>You are logged in as " . $_SESSION['email'] . "</p>";

//fetch id based on email address 
$email = $_SESSION['email'];
$sql = "SELECT id FROM customer WHERE email = :email";
$statement = $connection->prepare($sql);
$statement->bindParam(':email', $email);
$statement->execute();
$customer = $statement->fetch(PDO::FETCH_ASSOC);

//fetch cart id for selected customer id
$customerId = $customer['id'] ?? null;
if ($customerId) {
    //fetch cart items from cart_items table based on cart id
    $sql = "SELECT products.*, cart_items.quantity 
        FROM products 
        INNER JOIN cart_items ON products.id = cart_items.product_id 
        INNER JOIN cart ON cart.id = cart_items.cart_id 
        WHERE cart.customer_id = :customer_id AND cart_items.quantity > 0";

    $statement = $connection->prepare($sql);
    $statement->bindParam(':customer_id', $customerId);
    $statement->execute();
    $cartItems = $statement->fetchAll(PDO::FETCH_ASSOC);;
} else {
    $cartItems = [];
}
//decrease quantity of items in cart and database
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    //get product id
    $productId = $_POST['product_id'];

    
    $sql = "UPDATE cart_items SET quantity = quantity WHERE cart_id = :cart_id AND product_id = :product_id";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':cart_id', $customerId);
    $statement->bindParam(':product_id', $productId);
    $statement->execute();

    //check if the amount has reached 0 
    $sql = "DELETE FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id AND quantity = 0";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':cart_id', $customerId);
    $statement->bindParam(':product_id', $productId);
    $statement->execute();

    //update the info
    header("Location: Cart.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <link rel="stylesheet" href="css/CartCss.css">
</head>
<body>
    <div class="container">
        <h1>Shopping Cart</h1>
        <div class="cart-items">
            <?php if (empty($cartItems)): ?>
                <p>Your cart is empty.</p>
            <?php else: ?>
                <?php $total = 0; ?>
                <?php foreach ($cartItems as $item): ?>
                    <div class="cart-item">
                        <img src="uploads/<?php echo $item['name']; ?>.jpg" alt="<?php echo $item['name']; ?>">
                        <h2><?php echo $item['name']; ?></h2>
                        <p><?php echo $item['description']; ?></p>
                        <p>Price: $<?php echo $item['price']; ?></p>
                        <p>Quantity: <?php echo $item['quantity']; ?></p>
                        
                        
                        <form action="Cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $item['id']; ?>">
                            <input type="submit" value="Remove">
                        </form>
                    </div>
                    <?php $total += $item['price'] * $item['quantity']; ?>
                <?php endforeach; ?>
                <?php
                    //calculate shipping cost //removed fast shipping
                    $shippingCost = 0;
                    if (isset($_POST['shipping']) && $_POST['shipping'] === 'fast') {
                        $shippingCost = 7;
                    } else {
                        $shippingCost = 4;
                    }
                    
                    $total += $shippingCost;
                ?>
                <div class="subtotal">
                    <h2>Subtotal: $<?php echo number_format($total, 2); ?></h2>
                    <div class="shipping-options">
                        <h2>Shipping Options</h2>
                        <form action="Cart.php" method="post">
                            <input type="radio" id="normalShipping" name="shipping" value="normal" checked>
                            <label for="normalShipping">Normal Shipping ($4)</label><br>
                            <input type="submit" value="Calculate Shipping">
                        </form>
                    </div>
                </div>

                
                <a href="Checkout1.php" class="checkout-btn">Proceed to Checkout</a><br>

                
            <?php endif; ?>
        </div>
        <a href="indexlogged.php" class="button">HomePage</a>
    </div>
</body>
</html>
