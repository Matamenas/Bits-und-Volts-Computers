<?php
session_start();
include "templates/header.php";
include "../config.php";

// Check if registered query parameter is set and true
if (isset($_GET['registered']) && $_GET['registered'] == true) {
    $success_message = "Account Created Successfully. Please Login.";
}

if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $userPassword = trim($_POST['password']);

    try {
        require_once '../src/DBconnect.php';
        $connection = new PDO($dsn, $username, $password, $options);
        //login user checks
        $statement = $connection->prepare("SELECT * FROM customer WHERE email = :email");
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();
        //check if the user exists and the password is correct //added admin check that checks if a permissioned user logs in
        if ($user && $userPassword === $user['password']) {
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            if ($email === 'Admin123@gmail.com') {
                header("Location: indexlogged.php");
            } else {
                header("Location: indexlogged.php");
            }
            exit;
        } else {
            $error = "Incorrect email or password";
        }
    } catch(PDOException $error) {
        $error = "Database error: " . $error->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/LoginStyling.css">
</head>
<body>
<div class="container">
    <h2>Login</h2>
    <?php if (isset($success_message)): ?>
        <p><?php echo $success_message; ?></p>
    <?php endif; ?>
    <form method="post">
        <label for="email">Email Address</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password</label>
        <input type="password" name="password" id="password" required>
        <input type="submit" name="submit" value="Submit">
    </form>
    <?php if (isset($error)): ?>
        <p><?php echo $error; ?></p>
    <?php endif; ?>
    <a href="indexlogged.php">Back to home</a>
    <br><br>
    <a href="create.php">new to BitsUndVolts? - <strong>Register Here</strong></a>
</div>
</body>
</html>