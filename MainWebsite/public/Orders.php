<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="css/OrderStyling.css">
    
</head>
<body>

<?php
session_start();
require_once '../src/DBconnect.php';



//check login status
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['email'] !== 'Admin123@gmail.com') {
    header("Location: index.php"); // Redirect unauthorized users
    exit;
}

//pull orders from database
function getOrders($connection) {
    $sql = "SELECT * FROM orders";
    $statement = $connection->prepare($sql);
    $statement->execute();
    return $statement->fetchAll(PDO::FETCH_ASSOC);
}

//update status on selected order
function updateOrderStatus($connection, $orderId, $status) {
    $sql = "UPDATE orders SET status = :status WHERE id = :order_id";
    $statement = $connection->prepare($sql);
    $statement->bindParam(':status', $status);
    $statement->bindParam(':order_id', $orderId);
    return $statement->execute();
}

//delete a certain order
function deleteOrder($connection, $orderId) {
    try {
        
        $connection->beginTransaction();

        
        $sql = "DELETE FROM order_items WHERE order_id = :order_id";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':order_id', $orderId);
        $statement->execute();

        
        $sql = "DELETE FROM orders WHERE id = :order_id";
        $statement = $connection->prepare($sql);
        $statement->bindParam(':order_id', $orderId);
        $statement->execute();

        
        $connection->commit();

        return true; 
    } catch (PDOException $e) {
        
        $connection->rollBack();
       
        echo "Error: " . $e->getMessage();
        return false; 
    }
}

//handle status update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['order_id'], $_POST['status'])) {
    $orderId = $_POST['order_id'];
    $status = $_POST['status'];
    updateOrderStatus($connection, $orderId, $status);
}

//handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_order_id'])) {
    $orderId = $_POST['delete_order_id'];
    deleteOrder($connection, $orderId);
}

//get orders from database
$orders = getOrders($connection);


include "templates/header.php";

//display
echo "<h2>Orders</h2>";
echo "<table>";
echo "<tr><th>ID</th><th>Customer ID</th><th>Order Date</th><th>Total Amount</th><th>Status</th><th>Action</th></tr>";
foreach ($orders as $order) {
    echo "<tr>";
    echo "<td>{$order['id']}</td>";
    echo "<td>{$order['customer_id']}</td>";
    echo "<td>{$order['order_date']}</td>";
    echo "<td>{$order['total_amount']}</td>";
    echo "<td>{$order['status']}</td>";
    echo "<td>";
    echo "<form action='' method='post'>";
    echo "<input type='hidden' name='order_id' value='{$order['id']}'>";
    echo "<select name='status'>";
    echo "<option value='pending'>Pending</option>";
    echo "<option value='processing'>Processing</option>";
    echo "<option value='completed'>Completed</option>";
    echo "<option value='cancelled'>Cancelled</option>";
    echo "</select>";
    echo "<input type='submit' value='Update Status'>";
    echo "</form>";
    echo "<form action='' method='post'>";
    echo "<input type='hidden' name='delete_order_id' value='{$order['id']}'>";
    echo "<input type='submit' value='Delete'>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";
}
echo "</table>";




?>
<a href="AddProducts.php">Back to AddProducts</a>
</body>
</html>
