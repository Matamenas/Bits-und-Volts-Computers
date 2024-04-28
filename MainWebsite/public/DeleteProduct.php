<?php

require_once '../src/DBconnect.php';

//fetch all products from the database
$sql = "SELECT * FROM products";
$statement = $connection->prepare($sql);
$statement->execute();
$products = $statement->fetchAll(PDO::FETCH_ASSOC);

//product deletion
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["delete_product"]) && isset($_POST["product_id"])) {
        $product_id = $_POST["product_id"];

        
        $sql = "DELETE FROM products WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $product_id);

       
        if ($statement->execute()) {
            echo "<p>Product deleted successfully.</p>";
        } else {
            echo "<p>Failed to delete product.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link rel="stylesheet" href="css/DeleteStyling.css">
</head>
<body>
    <div class="container">
        <h2>Delete Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="product_id">Select Product to Delete:</label>
            <select name="product_id" id="product_id" required>
                <?php foreach ($products as $product): ?>
                    <option value="<?php echo $product['id']; ?>"><?php echo $product['name']; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="submit" name="delete_product" value="Delete Product">
        </form>
        <a href="AddProducts.php">Back to AddProducts</a>
    </div>
</body>
</html>
