<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="css/ProductAddition.css">
</head>

<body>
    <div class="container">
        <h2>Add Product</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="product_name">Product Name:</label>
            <input type="text" id="product_name" name="product_name" required>

            <label for="product_description">Product Description:</label>
            <textarea id="product_description" name="product_description" required></textarea>

            <label for="product_price">Product Price:</label>
            <input type="number" id="product_price" name="product_price" step="0.01" required>

            <label for="product_image">Product Image:</label>
            <input type="file" id="product_image" name="product_image" accept="image/*" required>

            <input type="submit" value="Add Product" name="submit">
        </form>

        <div class="button-container">
            <a href="DeleteProduct.php" class="btn">Go to Delete Products Page</a><br>
            <a href="Orders.php" class="btn">Go to Orders Page</a><br>
            <a href="indexlogged.php">Back to HomePage</a>
        </div>

   

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productName = $_POST["product_name"];
            $productDescription = $_POST["product_description"];
            $productPrice = $_POST["product_price"];

            // Handle file upload for product image
            $targetDir = "uploads/";
            $targetFile = $targetDir . basename($_FILES["product_image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["product_image"]["tmp_name"]);
            if ($check !== false) {
                $uploadOk = 1;
            } else {
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["product_image"]["size"] > 500000) {
                echo "<p class='error'>Sorry, your file is too large.</p>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif") {
                echo "<p class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<p class='error'>Sorry, your file was not uploaded.</p>";
                // if everything is ok, try to upload file
            } else {
                if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $targetFile)) {
                    // Include database connection file
                    require_once '../src/DBconnect.php';

                    // Prepare SQL statement to insert product details
                    $sql = "INSERT INTO products (name, description, price, stock) VALUES (:name, :description, :price, :stock)";
                    $statement = $connection->prepare($sql);

                    // Bind parameters and execute the statement
                    $statement->bindValue(':name', $productName);
                    $statement->bindValue(':description', $productDescription);
                    $statement->bindValue(':price', $productPrice);
                    // Assuming stock is 0 initially for a new product
                    $statement->bindValue(':stock', 0);

                    if ($statement->execute()) {
                        echo "<p>The product " . htmlspecialchars($productName) . " has been added.</p>";
                    } else {
                        echo "<p class='error'>Failed to add the product.</p>";
                    }
                } else {
                    echo "<p class='error'>Sorry, there was an error uploading your file.</p>";
                }
            }
        }
        ?>
    </div>
</body>

</html>
