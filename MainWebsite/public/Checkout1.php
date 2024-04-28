<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="css/Checkout1.css">
<title>Redirect Form</title>

</head>
<body>

<div class="container">
    <h2>Redirect Form</h2>
    <form id="paymentForm" action="checkout.php" method="GET">
        <label for="cardNumber">Card Number:</label>
        <input type="text" id="cardNumber" name="cardNumber" required><br><br>
        
        <label for="expDate">Expiration Date:</label>
        <input type="text" id="expDate" name="expDate" placeholder="MM/YYYY" required><br><br>
        
        <label for="cvv">CVV:</label>
        <input type="text" id="cvv" name="cvv" required><br><br>
        
        <input type="submit" value="Submit">
    </form>
</div>

<a href="indexlogged.php" class="button">HomePage</a>

</body>
</html>
