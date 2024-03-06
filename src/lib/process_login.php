<?php
session_start(); // Start session to store user login status

// Database connection parameters
$host = '127.0.0.1';
$dbname = 'bitsundvoltsfinal';
$username = 'root';
$password = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate form inputs
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Connect to the database
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

        // Set PDO to throw exceptions on errors
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Prepare SQL statement to fetch user details
        $stmt = $pdo->prepare("SELECT * FROM Customer WHERE emailAddress = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Verify password
        if ($user && password_verify($password, $user['userPassword'])) {
            // Password is correct, set session variables and redirect to dashboard
            $_SESSION['email'] = $user['emailAddress'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];

            header("Location: home.php");
            exit();
        } else {
            $error_message = "Invalid email or password.";
        }
    } catch(PDOException $e) {
        // Print PDO exception message
        echo "Error: " . $e->getMessage();
    }
}
?>