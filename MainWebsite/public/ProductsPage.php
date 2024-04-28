<?php
include 'templates/header.php';
require_once '../src/DBconnect.php';

//check if product is being added into the cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id']) && isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['email'])) {
    //get product id from the form
    $productId = filter_input(INPUT_POST, 'product_id', FILTER_SANITIZE_NUMBER_INT);
    
    try {
        //fetch customer id based on the email of the user
        $email = $_SESSION['email'];
        $sql = "SELECT id FROM customer WHERE email = :email";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':email', $email);
        $statement->execute();
        $customer = $statement->fetch(PDO::FETCH_ASSOC);
        $customerId = $customer['id'];
        
        //check if user already has a cart
        $sql = "SELECT id FROM cart WHERE customer_id = :customer_id";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':customer_id', $customerId);
        $statement->execute();
        $cart = $statement->fetch(PDO::FETCH_ASSOC);
        
        //create a new cart if the user does not have one
        if (!$cart) {
            $sql = "INSERT INTO cart (customer_id, created_at) VALUES (:customer_id, NOW())";
            $statement = $connection->prepare($sql);
            $statement->bindParam(':customer_id', $customerId);
            $statement->execute();
            //fetch new cart id
            $cartId = $connection->lastInsertId();
        } else {
            //use the existing cart id
            $cartId = $cart['id'];
        }
        
        //check if product is already in the cart
        $sql = "SELECT * FROM cart_items WHERE cart_id = :cart_id AND product_id = :product_id";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':cart_id', $cartId);
        $statement->bindParam(':product_id', $productId);
        $statement->execute();
        $existingProduct = $statement->fetch(PDO::FETCH_ASSOC);
        
        if ($existingProduct) {
            //if product is already in the cart just update the quantity
            $sql = "UPDATE cart_items SET quantity = quantity WHERE cart_id = :cart_id AND product_id = :product_id";
        } else {
            //if product not in cart create a new cart item
            $sql = "INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cart_id, :product_id, 1)";
        }

        $statement = $connection->prepare($sql);
        $statement->bindParam(':cart_id', $cartId);
        $statement->bindParam(':product_id', $productId);
        $statement->execute();
        
        //redirect to products page
        header("Location: ProductsPage.php");
        exit;
    } catch (PDOException $e) {
        
        echo "Error: " . $e->getMessage();
        exit;
    }
}

//fetch info from database
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
                   
                    <form action="" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                        <input type="submit" value="Add to Cart">
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="Cart.php" class="button">View Cart</a> &nbsp;&nbsp;&nbsp;

        <a href="indexlogged.php" class="btn">HomePage</a>

    </div>
   
</body>
</html>
 