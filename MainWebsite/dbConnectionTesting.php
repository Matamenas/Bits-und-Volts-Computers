<?php
//TESTING 1: Connection to the Database
function testInstallFile() {
    // Define connection parameters
    /*--1--*/ $host = "localhost";
    /*--2--*/ $username = "DatabaseUser";
    /*--3--*/ $password = "";
    /*--4--*/ $dbname = "customerDB";

    /*--5--*/ try {
                //Creating our connection called $connection to the database
    /*--6--*/   $connection = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    /*--7--*/   $sql = file_get_contents("data/init.sql");
    /*--8--*/   $connection->exec($sql);

                //If successful, return a message
    /*--9--*/   echo "Database and table users created successfully.";
                }
    /*--10--*/ catch(PDOException $error) {
                    // If connection fails, return an error message
    /*--11--*/      echo $sql . "<br>" . $error->getMessage();
    }
}

// Call the function to actually test the database connection
testInstallFile();
?>
