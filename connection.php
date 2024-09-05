

<?php
//change mysqli_connect(host_name,username, password); 
$servername = "localhost";
$username = "root";
$password = "";

$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'demo');
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}
?>
