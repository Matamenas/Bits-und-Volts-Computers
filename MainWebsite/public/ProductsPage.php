<?php
session_start();
require_once '../src/DBconnect.php';

// Check if the product is being added to the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['email'])) {
    // Get product ID from POST data (sanitize input)
    $productId = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    
    try {
        // Fetch customer ID from the database based on the logged-in user's email
        $email = $_SESSION['email'];
        $sql = "SELECT id FROM customer WHERE email = :email";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $customer = $statement->fetch(PDO::FETCH_ASSOC);
        $customerId = $customer['id'];
        
        // Check if the customer has an existing cart
        $sql = "SELECT id FROM cart WHERE customer_id = :customer_id";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':customer_id', $customerId);
        $statement->execute();
        $cart = $statement->fetch(PDO::FETCH_ASSOC);
        
        // If the customer does not have a cart, create a new one
        if (!$cart) {
            $sql = "INSERT INTO cart (customer_id, created_at) VALUES (:customer_id, NOW())";
            $statement = $connection->prepare($sql);
            $statement->bindParam(':customer_id', $customerId);
            $statement->execute();
            // Fetch the newly created cart ID
            $cartId = $connection->lastInsertId();
        } else {
            // Use the existing cart ID
            $cartId = $cart['id'];
        }
        
        // Check if the product is already in the cart
        $sql = "SELECT * FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':cart_id', $cartId);
        $statement->bindParam(':product_id', $productId);
        $statement->execute();
        $existingProduct = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($existingProduct) {
            // If the product already exists in the cart, update the quantity
            $sql = "UPDATE cart_items SET quantity = quantity + 1 WHERE cart_id = :cart_id AND product_id = :product_id";
        } else {
            // If the product is not in the cart, insert it
            $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, 1)";
        }

        $statement = $connection->prepare($sql);
        $statement->bindParam(':cart_id', $cartId);
        $statement->bindParam(':product_id', $productId);
        $statement->execute();
        
        // Redirect back to the Products Page
        header("Location: ProductsPage.php");
        exit;
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
        exit;
    }
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
        <a href="Cart.php" class="button">View Cart</a><br>

        <a href="indexlogged.php" class="button">HomePage</a>
        

    </div>
   
</body>
</html>
 