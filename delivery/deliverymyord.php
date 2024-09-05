<?php
ob_start(); 

$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'demo');
include '../connection.php';
include("connect.php"); 
if ($_SESSION['name'] == '') {
    header("location:deliverylogin.php");
}
$name = $_SESSION['name'];
$id = $_SESSION['Did'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="delivery1.css">
    <link rel="stylesheet" href="../home3.css">
    <script>
        function orderReceived(button, orderId) {
            // Hide the button after it's clicked
            button.style.display = 'none';

            // Make an AJAX request to update the order status in the database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_order_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    console.log("Order status updated successfully");
                }
            };
            xhr.send("order_id=" + orderId + "&status=received");
        }
    </script>
</head>
<body>
<header>
    <p class="logo">Meal <b style="color:rgb(231, 205, 171);">Share</b><span>Together, We Can End Hunger</span></p>
    <div class="hamburger">
        <div class="line"></div>
        <div class="line"></div>
        <div class="line"></div>
    </div>
    <nav class="nav-bar">
        <ul>
            <li><a href="delivery.php">Home</a></li>
            <li><a href="deliverymyord.php" class="active">My Orders</a></li>
        </ul>
    </nav>
</header>
<br>
<script>
    hamburger = document.querySelector(".hamburger");
    hamburger.onclick = function() {
        navBar = document.querySelector(".nav-bar");
        navBar.classList.toggle("active");
    }
</script>
<style>
    .itm {
        background-color: white;
        display: grid;
    }
    .itm img {
        width: 400px;
        height: 400px;
        margin-left: auto;
        margin-right: auto;
    }
    p {
        text-align: center;
        font-size: 28px;
        color: black;
    }
    a {
        /* text-decoration: underline; */
    }
    @media (max-width: 767px) {
        .itm img {
            width: 350px;
            height: 350px;
        }
    }
</style>

<div class="itm">
    <img src="../img/delivery.gif" alt="" width="400" height="400">
</div>

<div class="get">
    <?php
    // Define the SQL query to fetch unassigned orders
    $sql = "SELECT fd.Fid AS Fid, fd.name, fd.phoneno, fd.date, fd.delivery_by, fd.address AS From_address, 
    ad.name AS delivery_person_name, ad.address AS To_address
    FROM food_donations fd
    LEFT JOIN admin ad ON fd.assigned_to = ad.Aid WHERE delivery_by = '$id'";

    // Execute the query
    $result = mysqli_query($connection, $sql);

    // Check for errors
    if (!$result) {
        die("Error executing query: " . mysqli_error($connection));
    }

    // Fetch the data as an associative array
    $data = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
    ?>

    <div class="log">
        <a href="delivery.php" style="background-color:rgb(122, 92, 84);">Take Orders</a>
        <p>Order assigned to you</p>
        <br>
    </div>

    <!-- Display the orders in an HTML table -->
    <div class="table-container">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Phone Number</th>
                        <th>Date/Time</th>
                        <th>Pickup Address</th>
                        <th>Delivery Address</th>
                        
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data as $row) { ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['phoneno']); ?></td>
                            <td><?php echo htmlspecialchars($row['date']); ?></td>
                            <td><?php echo htmlspecialchars($row['From_address']); ?></td>
                            <td><?php echo htmlspecialchars($row['To_address']); ?></td>
                            
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <br><br>
</body>
</html>
