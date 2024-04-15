<?php
session_start();
require_once '../src/DBconnect.php';

// Check if the product is being added to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['email'])) {
    // Get product ID from POST data
    $productId = $_POST['product_id'];
    
    // Fetch customer ID from the database based on the logged-in user's email
    $email = $_SESSION['email'];
    $sql = "SELECT id FROM customer WHERE email = :email";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':email', $email);
    $statement->execute();
    $customer = $statement->fetch(PDO::FETCH_ASSOC);
    $customerId = $customer['id'];
    
    // Insert the product into the cart table for the current customer
    $sql = "INSERT INTO cart (customer_id, product_id, quantity) VALUES (:customer_id, :product_id, 1) ON DUPLICATE KEY UPDATE quantity = quantity + 1";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':customer_id', $customerId);
    $statement->bindParam(':product_id', $productId);
    $statement->execute();
}

// Fetch product information from the database
$sql = "SELECT * FROM products";
$statement = $connection->prepare($sql);
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    <link rel="stylesheet" href="css/Products.css">
</head>
<body>
    <div class="container">
        <h1>Products Page</h1>
        <div class="products">
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="uploads/<?php echo $product['name']; ?>.jpg" alt="<?php echo $product['name']; ?>">
                    <h2><?php echo $product['name']; ?></h2>
                    <p><?php echo $product['description']; ?></p>
                    <p>Price: $<?php echo $product['price']; ?></p>
                    <!-- Add to Cart button -->
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="submit" value="Add to Cart">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Display a link to the cart page -->
        <a href="Cart.php">View Cart</a>
    </div>
</body>
</html>
