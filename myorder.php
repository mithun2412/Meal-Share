<?php
session_start();
include('connection.php');

// Check if user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user_id from session
$user_id = $_SESSION['id'];

// Query to get the donations made by the logged-in user
$query = "SELECT Fid, food, type, category, quantity, date, address, location, phoneno FROM food_donations WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 15px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>

<h2>My Food Donations</h2>

<!-- Check if there are any records -->
<?php if (mysqli_num_rows($result) > 0) { ?>

<table>
    <tr>
        <th>Donation ID</th>
        <th>Food</th>
        <th>Type</th>
        <th>Category</th>
        <th>Quantity</th>
        <th>Date</th>
        <th>Address</th>
        <th>Location</th>
        <th>Phone Number</th>
    </tr>
    <!-- Fetching each record and displaying it in the table -->
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
            <td><?php echo $row['Fid']; ?></td>
            <td><?php echo $row['food']; ?></td>
            <td><?php echo $row['type']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo $row['date']; ?></td>
            <td><?php echo $row['address']; ?></td>
            <td><?php echo $row['location']; ?></td>
            <td><?php echo $row['phoneno']; ?></td>
        </tr>
    <?php } ?>
</table>

<?php } else { ?>
    <p>No donations found for this user.</p>
<?php } ?>

</body>
</html>
