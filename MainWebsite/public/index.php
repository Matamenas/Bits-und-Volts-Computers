<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Bits Und Volts Computers</title>
    <link rel="stylesheet" type="text/css" href="css/style.css" />
    <link rel="stylesheet" type="text/css" href="css/Index.css" />
</head>
<body>
<h1>Bits Und Volts Computers</h1>


<div class="navbar">
  <div class="navbar-left">
    <a href="index.php">Home Page</a>
    <a href="dashboard.php" onclick="<?php echo checkLogin(); ?>">Dashboard</a>
    <a href="ProductsPage.php">Products</a>
  </div>
  <div class="navbar-right">
    <a href="login.php" class="login-btn">
      <p>Login/Register</p>
    </a>
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
      <p>If you would like to explore our products click the button below</p><br>
        <a href="ProductsPage.php" class="product-btn">Explore!</a>
    </div>
    <div class="column">
      <h2>Create An Account With Us</h2>
      <p>If you feel like we provide a good service it would mean a lot to us if you created an account. we provide cheap delivery and products at the best price</p>
    </div>
  </div>

<?php
function checkLogin() {
    echo "alert('You must be logged in to manage your account.');";
    return false;
}
?>

<div class="footer">
    <?php include "templates/footer.php"; ?>
</div>



