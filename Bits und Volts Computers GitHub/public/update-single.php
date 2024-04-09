<?php
/**
 * Use an HTML form to edit an entry in the
 * customer table.
 *
 */
require "../common.php";
if (isset($_POST['submit'])) {
    try {
        require_once '../src/DBconnect.php';
        $user =[
            "id" => escape($_POST['id']),
            "firstname" => escape($_POST['firstname']),
            "lastname" => escape($_POST['lastname']),
            "address" => escape($_POST['address']),
            "email" => escape($_POST['email']),
            "password" => escape($_POST['password'])
        ];
        $sql = "UPDATE customer
                 SET id = :id,
                 firstname = :firstname,
                 lastname = :lastname,
                 address = :address,
                 email = :email,
                 password = :password
                 WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->execute($user);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
}
if (isset($_GET['id'])) {
    try {
        require_once '../src/DBconnect.php';
        $id = $_GET['id'];
        $sql = "SELECT * FROM customer WHERE id = :id";
        $statement = $connection->prepare($sql);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $user = $statement->fetch(PDO::FETCH_ASSOC);
    } catch(PDOException $error) {
        echo $sql . "<br>" . $error->getMessage();
    }
} else {
    echo "Something went wrong!";
    exit;
}
?>
<?php require "templates/header.php"; ?>
<?php if (isset($_POST['submit']) && $statement) : ?>
    <?php echo escape($_POST['firstname']); ?> successfully updated.
<?php endif; ?>
<h2>Edit a user</h2>
<form method="post">
    <?php foreach ($user as $key => $value) : ?>
        <label for="<?php echo $key; ?>"><?php echo ucfirst($key); ?></label>
        <input type="text" name="<?php echo $key; ?>" id="<?php echo $key;
        ?>" value="<?php echo escape($value); ?>" <?php echo ($key === 'id' ?
            'readonly' : null); ?>>
    <?php endforeach; ?>
    <input type="submit" name="submit" value="Submit">
</form>
<a href="index.php">Back to home</a>
<?php require "templates/footer.php"; ?>
