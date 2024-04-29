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


<?php include "templates/indexMiddleRow.php";?>

<?php
function checkLogin() {
    echo "alert('You must be logged in to manage your account.');";
    return false;
}
?>

<div class="footer">
    <?php include "templates/footer.php"; ?>
</div>



