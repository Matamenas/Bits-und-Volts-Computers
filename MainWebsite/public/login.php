<?php
session_start();
// Include necessary files
include "templates/header.php";
include "../config.php"; // Include your database configuration file

// Check if form is submitted
if (isset($_POST['submit'])) {
    $email = trim($_POST['email']);
    $userPassword = trim($_POST['password']);

    try {
        require_once '../src/DBconnect.php';
        // Create a PDO connection to the database
        $connection = new PDO($dsn, $username, $password, $options);

        // Prepare and execute SQL query to retrieve user by email
        $statement = $connection->prepare("SELECT * FROM customer WHERE email = :email");
        $statement->execute(['email' => $email]);
        $user = $statement->fetch();

        // Verify password
        if ($user && password($userPassword, $user['password'])) {
            // Password is correct, start session or perform other actions
            $_SESSION['loggedin'] = true;
            $_SESSION['email'] = $email;
            // Redirect to dashboard or any other page
            header("Location: dashboard.php");
            exit;
        } else {
            // Incorrect email or password
            $error = "Incorrect email or password";
        }
    } catch(PDOException $error) {
        // Handle database connection error
        $error = "Database error: " . $error->getMessage();
    }
}
?>
    <!-- HTML form for login -->
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