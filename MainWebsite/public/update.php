<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Customer Info</title>
    <link rel="stylesheet" href="css/UpdateStyling.css"> 
</head>
<body>
    <?php
    session_start();

    //check login status
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        try {
            require "../common.php";
            require_once '../src/DBconnect.php';
            $sql = "SELECT * FROM customer WHERE email = :email";
            $statement = $connection->prepare($sql);
            $statement->bindValue(':email', $email);
            $statement->execute();
            $result = $statement->fetchAll();
        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }
    ?>

    <?php require "templates/header.php"; ?>
    <div class="container">
        <h2>Update Customer Info</h2>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Email Address</th>
                    <th>Password</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result as $row) : ?>
                    <tr>
                        <td><?php echo escape($row["id"]); ?></td>
                        <td><?php echo escape($row["firstname"]); ?></td>
                        <td><?php echo escape($row["lastname"]); ?></td>
                        <td><?php echo escape($row["address"]); ?></td>
                        <td><?php echo escape($row["email"]); ?></td>
                        <td><?php echo escape($row["password"]); ?></td>
                        <td><a href="update-single.php?id=<?php echo escape($row["id"]); ?>">Edit</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn">Back</a>
    </div>
    <?php require "templates/footer.php"; ?>
</body>
</html>
