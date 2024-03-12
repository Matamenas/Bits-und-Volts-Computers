<?php
// Database connection parameters
$host = '127.0.0.1';
$dbname = 'bitsundvoltsfinal';
$username = 'root';
$password = null;

$conn=mysqli_connect($host,$username,$password,"$dbname");
if(!$conn){
    die('Could not Connect MySql Server:' .mysql_error());
}
?>