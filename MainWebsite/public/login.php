<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - BitsUndVolts</title>
    <link rel="stylesheet" href="css/LoginStyling.css">
</head>

<body>
    <?php
    session_start();
    include "templates/header.php";
    include "../config.php";

    if (isset($_POST['submit'])) {
        $email = trim($_POST['email']);
        $userPassword = trim($_POST['password']);

        try {
            require_once '../src/DBconnect.php';
            $connection = new PDO($dsn, $username, $password, $options);

            $statement = $connection->prepare("SELECT * FROM customer WHERE email = :email");
            $statement->execute(['email' => $email]);
            $user = $statement->fetch();

            if ($user && $userPassword === $user['password']) {
                $_SESSION['loggedin'] = true;
                $_SESSION['email'] = $email;
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Incorrect email or password";
            }
        } catch (PDOException $error) {
            $error = "Database error: " . $error->getMessage();
        }
    }
    ?>

    <div class="container">
        <h2>Login</h2>
        <form method="post">
            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Password</label>
            <input type="password" name="password" id="password" required>
            <input type="submit" name="submit" value="Submit">
        </form>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <a href="index.php">Back to home</a>
        <br><br>
        <a href="create.php" class="register-link"><strong>Register Here</strong></a> - new to BitsUndVolts
    </div>
</body>

</html>
