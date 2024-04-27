<?php
// Start session
session_start();

// Redirect to index.php if user is not logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit;
}

// Include header
include "templates/header.php";

// Initialize the uploaded image path
$uploadedImagePath = '';

// Check if there is already an uploaded image stored in the session
if (isset($_SESSION['uploaded_image'])) {
    $uploadedImagePath = $_SESSION['uploaded_image'];
}

// Logout logic
if(isset($_POST['logout'])) {
    // Unset all session variables
    $_SESSION = array();

    // Destroy the session
    session_destroy();

    // Redirect to index.php
    header("Location: index.php");
    exit;
}

// Check if file is uploaded
if(isset($_FILES['upload'])) {
    $targetDir = "uploads/profile/";
    $targetFile = $targetDir . basename($_FILES["upload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["upload"]["tmp_name"]);
    if ($check === false) {
        echo "<p class='error'>File is not an image.</p>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["upload"]["size"] > 500000) {
        echo "<p class='error'>Sorry, your file is too large.</p>";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "<p class='error'>Sorry, only JPG, JPEG, PNG & GIF files are allowed.</p>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "<p class='error'>Sorry, your file was not uploaded.</p>";
    } else {
        // If everything is ok, try to upload file
        if (move_uploaded_file($_FILES["upload"]["tmp_name"], $targetFile)) {
            // Store the uploaded image path in session variable
            $_SESSION['uploaded_image'] = $targetFile;
            $uploadedImagePath = $targetFile; // Update the uploaded image path variable
            echo "<p>The file ". htmlspecialchars(basename( $_FILES["upload"]["name"])). " has been uploaded.</p>";

            // Update customer table with the uploaded image path
            if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['email'])) {
                // Get the email of the logged-in user
                $email = $_SESSION['email'];
        
                $sql = "UPDATE customer SET profilepic = ? WHERE email = ?";
                

            }
        } else {
            echo "<p class='error'>Sorry, there was an error uploading your file.</p>";
        }
    }
}
?>

<link rel="stylesheet" type="text/css" href="css/index.css"> <!-- Link your index.css file -->

<div class="navbar">
  <div class="navbar-left">
    <a href="index.php">Home Page</a>
    <a href="dashboard.php">Dashboard</a>
    <a href="ProductsPage.php">Products</a>
  </div>
  <div class="navbar-right">
    <?php
    // Display welcome message if user is logged in
    if(isset($_SESSION['email'])) {
        echo "<div class='login-btn'>";
        if (!empty($uploadedImagePath)) {
            echo "<img class='profile-image' src='" . $uploadedImagePath . "' alt='Profile Image'>";
        }
        echo "<p>Welcome " . $_SESSION['email'] . "</p></div>";
    }
    ?>
    <form method="post">
      <input type="submit" name="logout" value="Logout">
    </form>
  </div>
</div>

<!-- Add this form where you want to allow users to upload an image -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
    <input type="file" name="upload" id="upload">
    <input type="submit" value="Upload Image" name="submit">
</form>

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