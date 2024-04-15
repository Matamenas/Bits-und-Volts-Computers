<?php
if (isset($_POST['submit'])) {
    require '../common.php';
    try {
        require_once '../src/DBconnect.php';

        // Hash the password
        $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $new_user = array(
            "firstname" => escape($_POST['firstname']),
            "lastname" => escape($_POST['lastname']),
            "address" => escape($_POST['address']),
            "email" => escape($_POST['email']),
            "password" => $hashedPassword
        );

        $sql = sprintf("INSERT INTO %s (%s) values (%s)", "customer",
            implode(", ", array_keys($new_user)),
            ":" . implode(", :", array_keys($new_user)));

        $statement = $connection->prepare($sql);
        $statement->execute($new_user);

        // Redirect after successful insertion
        header("Location: dashboard.php");
        exit;
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
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
