<?php
session_start();
require_once '../src/DBconnect.php'; // Include the file containing database connection logic

// Check if user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

// Fetch customer ID from the database based on the logged-in user's email
$email = $_SESSION['email']; // Assuming the email is stored in the session
if (!empty($email)) {
    $sql = "SELECT id FROM customer WHERE email = :email"; // SQL query to select customer ID based on email
    $statement = $connection->prepare($sql); // Prepare the SQL statement
    $statement->bindParam(':email', $email); // Bind the email parameter
    $statement->execute(); // Execute the statement
    $customer = $statement->fetch(PDO::FETCH_ASSOC); // Fetch the result as an associative array

    // Check if a customer ID is found
    if ($customer) {
        $customer_id = $customer['id'];
    } else {
        echo "Error: Customer ID not found.";
        exit;
    }
} else {
    echo "Error: Email not set in session.";
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $order_id = $_POST["order_id"];
    $issue_text = $_POST["issue_text"];

    // Validate form data
    if (empty($order_id) || empty($issue_text)) {
        $error_message = "Please fill in all required fields.";
    } else {
        // Insert ticket into the database
        $sql = "INSERT INTO Tickets (customer_id, order_id, issue_text) VALUES (?, ?, ?)";
        $stmt = $connection->prepare($sql);
        if ($stmt->execute([$customer_id, $order_id, $issue_text])) {
            $success_message = "Ticket submitted successfully!";
        } else {
            $error_message = "Error submitting ticket. Please try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/Ticketscss.css">
    <title>Customer Support</title>
</head>
<body>
    <h1>Customer Support</h1>
    <?php
    // Display error message if any
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    // Display success message if any
    if (isset($success_message)) {
        echo "<p style='color: green;'>$success_message</p>";
    }
    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="order_id">Order ID:</label>
        <input type="text" id="order_id" name="order_id" required><br><br>
        
        <label for="issue_text">Issue Description:</label><br>
        <textarea id="issue_text" name="issue_text" rows="4" cols="50" required></textarea><br><br>
        
        <input type="submit" value="Submit Ticket">
        <a href="indexlogged.php" class="button">HomePage</a>
    </form>
</body>
</html>
