<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Users</title>
    <link rel="stylesheet" href="css/DeletesStyling.css"> <!-- Link your CSS file -->
</head>
<body>
    <?php
    require "../common.php";
    $success = "";

    // Check if a user is logged in
    session_start();
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true && isset($_SESSION['email'])) {
        $email = $_SESSION['email'];

        if (isset($_GET["id"])) {
            try {
                require_once '../src/DBconnect.php';
                $id = $_GET["id"];
                $sql = "DELETE FROM customer WHERE id = :id AND email = :email";
                $statement = $connection->prepare($sql);
                $statement->bindValue(':id', $id);
                $statement->bindValue(':email', $email);
                $statement->execute();
                $success = "User " . $id . " successfully deleted";
            } catch(PDOException $error) {
                echo $sql . "<br>" . $error->getMessage();
            }
        }

        try {
            require_once '../src/DBconnect.php';
            $sql = "SELECT * FROM customer WHERE email = :email";
            $statement = $connection->prepare($sql);
            $statement->bindValue(':email', $email);
            $statement->execute();
            $result = $statement->fetchAll();

            // Debugging output
            var_dump($result);
        } catch(PDOException $error) {
            echo $sql . "<br>" . $error->getMessage();
        }
    }

    // Initialize $result as an empty array if it's not set
    $result = $result ?? [];
    ?>

    <?php require "templates/header.php"; ?>
    <div class="container">
        <h2>Delete Users</h2>
        <?php if ($success) echo "<p>" . $success . "</p>"; ?>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>Email Address</th>
                    <th>Password</th>
                    <th>Delete</th>
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
                        <td><a href="delete.php?id=<?php echo escape($row["id"]); ?>">Delete</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <a href="dashboard.php" class="btn">Back</a>
    </div>
    <?php require "templates/footer.php"; ?>
</body>
</html>
