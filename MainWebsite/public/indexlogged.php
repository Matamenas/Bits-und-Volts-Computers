<?php

session_start();

//check login status
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

include "templates/header.php";



//logout logic
if(isset($_POST['logout'])) {
   
    $_SESSION = array();

 
    session_destroy();

    
    header("Location: index.php");
    exit;
}

?>

<link rel="stylesheet" type="text/css" href="css/index.css"> <!-- Link your index.css file -->

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
    <h2>Column 1</h2>
    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ut ultricies lacus. Fusce in aliquam velit. Quisque eget eros nec odio semper gravida.</p>
  </div>
  <div class="column">
    <h2>Column 2</h2>
    <p>Nullam vel risus leo. Maecenas in efficitur odio. Sed nec turpis at velit fermentum dapibus. Morbi nec rutrum quam, vel semper velit.</p>
  </div>
  <div class="column">
    <h2>Column 3</h2>
    <p>Curabitur convallis nisi nec nunc fermentum, sit amet molestie lacus elementum. Ut dignissim orci nec nulla laoreet auctor. Donec sit amet vehicula elit.</p>
  </div>
</div>

<div class="footer">
  <p>This is the footer.</p>
</div>

<?php include "templates/footer.php"; ?>

<script>
  function checkLogin() {
    alert("You must be logged in to manage your account.");
    return false; 
  }
</script>
