<?php
include("connect.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_SESSION['Aid']; // Use the session variable to identify the admin
    $sql = "UPDATE food_donations SET status = 1 WHERE assigned_to = $id AND status = 0";
    if (mysqli_query($connection, $sql)) {
        echo "Status updated successfully";
    } else {
        echo "Error updating status: " . mysqli_error($connection);
    }
}
?>
