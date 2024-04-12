<?php
session_start();
include "templates/header.php";
include "../config.php"; // Include your database configuration file

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    //PROTECTION: Hashing Password for data integrity
    $userPassword = trim($_POST['password']);

    try {
        require_once '../src/DBconnect.php';
        $connection = new PDO($dsn, $username, $password, $options);

        // Prepare and execute SQL query to retrieve user by email
        $statement = $connection->prepare("SELECT * FROM customer WHERE email = :email");
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        // Debug output to check if user is retrieved
        var_dump($user);

        if ($user) {
            // Verify password
            if (password_verify($userPassword, $user['password'])) {
                echo "User Logged In!";
            } else {
                // Incorrect password
                $error = "Incorrect password";
            }
        } else {
            // User not found
            $error = "User not found";
        }
    } catch(PDOException $error) {
        // Handle database connection error
        $error = "Database error: " . $error->getMessage();
    }
}
?>

<h2>Log In</h2>
<form method="post">
    <label for="email">Email Address</label>
    <input type="email" name="email" id="email" required>
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required>
    <input type="submit" name="submit" value="Submit">
</form>

<?php
// Display error message if exists
if (isset($error)) {
    echo '<p>' . $error . '</p>';
}
?>

<a href="index.php">Back to home</a>
<br><br>
<a href="create.php"><strong>Register Here</strong></a> - new to BitsUndVolts

<?php include "templates/footer.php"; ?>
