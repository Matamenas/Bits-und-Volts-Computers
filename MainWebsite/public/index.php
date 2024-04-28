<?php include "templates/header.php"; ?>

<link rel="stylesheet" type="text/css" href="css/Index.css">

<div class="navbar">
  <div class="navbar-left">
    <a href="index.php">Home Page</a>
    <a href="dashboard.php" onclick="return checkLogin()">Dashboard</a>
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
      <h2>Column 1</h2>
      <p>Content for column 1 goes here.</p>
    </div>
    <div class="column">
      <h2>Column 2</h2>
      <p>Content for column 2 goes here.</p>
    </div>
    <div class="column">
      <h2>Column 3</h2>
      <p>Content for column 3 goes here.</p>
    </div>
  </div>

<?php include "templates/homePageFooter.php"; ?>

