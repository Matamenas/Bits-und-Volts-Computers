<?php
session_start();
require_once '../src/DBconnect.php'; 

//check login status
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}

//customer id based on the users email
$email = $_SESSION['email']; 
if (!empty($email)) {
    $sql = "SELECT id FROM customer WHERE email = :email"; 
    $statement = $connection->prepare($sql); 
    $statement->bindParam(':email', $email); 
    $statement->execute(); 
    $customer = $statement->fetch(PDO::FETCH_ASSOC); 

    //check if customer id is found
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

//check if form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
 
    $order_id = $_POST["order_id"];
    $issue_text = $_POST["issue_text"];

    
    if (empty($order_id) || empty($issue_text)) {
        $error_message = "Please fill in all required fields.";
    } else {
        //insert the ticket into the database
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
    
    if (isset($error_message)) {
        echo "<p style='color: red;'>$error_message</p>";
    }
    
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
        <a href="indexlogged.php" class="button">Back To Home</a>
    </form>
</body>
</html>
