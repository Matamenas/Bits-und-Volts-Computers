<?php
require "header.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <link rel="stylesheet" type="text/css" href="CSS/computerShop.css">
    <script src="Javascript/extraFunctionality.js"></script>
</head>
<div class="wrapper">
    <h2>Login</h2>
    <?php if(isset($login_err)) echo $login_err; ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label>Email</label>
        <input type="text" name="email" required><br>
        <label>Password</label>
        <input type="password" name="password" required><br>
        <input type="submit" value="Login">
    </form>
</div>
</body>
</html>
</body>
</html>