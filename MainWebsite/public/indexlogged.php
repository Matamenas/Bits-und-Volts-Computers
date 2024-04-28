<?php
include 'templates/header.php';

//check login status
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

//logout logic
if(isset($_POST['logout'])) {
   
    $_SESSION = array();

 
    session_destroy();

    
    header("Location: index.php");
    exit;
}

?>

<link rel="stylesheet" type="text/css" href="css/index.css"> 

<div class="navbar">
  <div class="navbar-left">
    <a href="indexlogged.php">Home Page</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="ProductsPage.php">Products</a>
    <a href="Tickets.php">Customer Service</a>
    <?php
    //checks if user is admin and displays admin panel link on nav bar
    if(isset($_SESSION['email']) && $_SESSION['email'] === 'Admin123@gmail.com') {
        echo '<a href="AddProducts.php">Admin Panel</a>';
    }
    ?>
  </div>
  <div class="navbar-right">
    <?php
    //display welcome message
    if(isset($_SESSION['email'])) {
        echo "<div class='login-btn'>";
        echo "<p>Welcome " . $_SESSION['email'] . "</p></div>";
    }
    ?>
    <form method="post">
      <input type="submit" name="logout" value="Logout">
    </form>
  </div>
</div>


<div class="row">
    <div class="column">
        <h2>Bits Und Volts</h2>
        <h3>Who Are We?</h3>
        <p>Bits Und Volts powered by Byte Incorporated aims to provide the Personal Desktop community a wide range of high quality computer parts. From Graphics Cards (GPU) to Central Processing Units (CPU), from Cases to RGB Fans. Customize. Create. GAME!</p>
    </div>
    <div class="column">
        <h2>What We Have To Offer?</h2>
        <p>If you would like to explore our products click the button below.</p><br>
        <a href="ProductsPage.php" class="product-btn">Explore!</a>
    </div>
    <div class="column">
        <h2>Welcome To The Bits Und Volts Club</h2>
        <p>we provide cheap delivery and products at the best price. We value you... Our loyal customer.</p>
    </div>
</div>

<div class="footer">
    <?php include "templates/footer.php"; ?>
</div>



