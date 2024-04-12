<?php
require '../common.php';

if (isset($_POST['submit'])) {
    require_once '../src/DBconnect.php';

    try {
        $new_user = array(
            "firstname" => $_POST['firstname'],
            "lastname" => $_POST['lastname'],
            "address" => $_POST['address'],
            "email" => $_POST['email'],
            //PROTECTION: Hashing Password for data integrity
            "password" => $_POST['password']
        );

        $sql = "INSERT INTO customer (firstname, lastname, address, email, password) VALUES (:firstname, :lastname, :address, :email, :password)";

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

        header("Location: dashboard.php");
        exit;
    } catch(PDOException $error) {
        echo "Error: " . $error->getMessage();
    }
}

require "templates/header.php";
?>

<h2>Create an Account</h2>
<form method="post">
    <label for="firstname">First Name</label>
    <input type="text" name="firstname" id="firstname" required>
    <label for="lastname">Last Name</label>
    <input type="text" name="lastname" id="lastname" required>
    <label for="address">Address</label>
    <input type="text" name="address" id="address" required>
    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" required>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" name="submit" value="Submit">
</form>
<a href="index.php">Back to home</a>

<?php include "templates/footer.php"; ?>
