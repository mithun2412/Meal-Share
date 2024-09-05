<?php
session_start();
include 'connection.php';

if (isset($_POST['feedback'])) {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $msg = $_POST['message'];
    
    // Sanitize input to prevent SQL injection
    $sanitized_emailid = mysqli_real_escape_string($connection, $email);
    $sanitized_name = mysqli_real_escape_string($connection, $name);
    $sanitized_msg = mysqli_real_escape_string($connection, $msg);
    
    $query = "INSERT INTO user_feedback(name, email, message) VALUES('$sanitized_name', '$sanitized_emailid', '$sanitized_msg')";
    $query_run = mysqli_query($connection, $query);
    
    if ($query_run) {
        echo '<script type="text/javascript">alert("Data saved successfully!");</script>';
        header("Location: contact.html");
        exit();
    } else {
        echo '<script type="text/javascript">alert("Data not saved. Please try again.");</script>';
    }
}
?>
