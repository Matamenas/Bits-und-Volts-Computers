<?php
// TESTING 2: Registration Process Validation
function testCreateFile() {
    /*--1--*/ if (isset($_POST['submit'])) {
    /*--2--*/       require '../common.php';
    /*--3--*/       try {
    /*--4--*/           require_once '../src/DBconnect.php';
    /*--5--*/           $new_user = array(
    /*--6--*/               "firstname" => escape($_POST['firstname']),
    /*--7--*/               "lastname" => escape($_POST['lastname']),
    /*--8--*/               "address" => escape($_POST['address']),
    /*--9--*/               "email" => escape($_POST['email']),
    /*--10--*/              "password" => escape(($_POST['password']))
                        );
    /*--11--*/           $sql = sprintf("INSERT INTO %s (%s) values (%s)", "customer",
    /*--12--*/               implode(", ", array_keys($new_user)),
    /*--13--*/               ":" . implode(", :", array_keys($new_user)));
    /*--14--*/           $statement = $connection->prepare($sql);
    /*--15--*/           $statement->execute($new_user);
                     }
    /*--16--*/       catch(PDOException $error) {
    /*--17--*/           echo $sql . "<br>" . $error->getMessage();
                     }
                }
    /*--18--*/  if (isset($_POST['submit']) && $statement) {
    /*--19--*/      echo $new_user['firstname']. ' successfully added';
    /*--20--*/      header("Location: dashboard.php");
                }
    /*--21--*/  else {
    /*--22--*/      echo "User was not successfully added to our database",
                }
}
// Calling the method we created
testCreateFile();


