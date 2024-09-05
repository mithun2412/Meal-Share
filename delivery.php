

<?php
// Start output buffering and establish a connection to the database
ob_start(); 
$connection = mysqli_connect("localhost", "root", "");
$db = mysqli_select_db($connection, 'demo');

// Initialize variables
$Fid = "";
$step = 1;  // Default to step 1 (Order Placed)

// Fetch the latest Fid, assigned_to, status, delivery_by from the food_donations table
$sql = "SELECT Fid, assigned_to, status, delivery_by FROM food_donations ORDER BY Fid DESC LIMIT 1";
$result = mysqli_query($connection, $sql);

// If the query fails, output the error
if (!$result) {
    die("Query failed: " . mysqli_error($connection));
}

// Check if a row is returned
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $Fid = $row['Fid']; // Get the latest Fid

    // Determine the step based on the field values
    if (!is_null($row['assigned_to'])) {
        $step = 2; // Order Accepted
    }
    if (!is_null($row['delivery_by'])) {
        $step = 3; // Food Picked Up
    }
    if ($row['status'] == 1) {
        $step = 4; // Food Delivered
    }
} else {
    echo "No orders found in the database.";
    $step = 1; // Default to step 1 if no order is found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="refresh" content="5">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Tracking</title>
    <style>
        /* General body styling */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Order tracking container styling */
        .order-tracking-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
        }

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }

        .order-details {
            font-size: 16px;
            color: #666;
            margin-bottom: 20px;
            text-align: center;
        }

        .tracking-status {
            position: relative;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .progress-line {
            position: absolute;
            top: 50%;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #dcdcdc;
            z-index: 0;
        }

        .progress {
            position: absolute;
            top: 50%;
            left: 0;
            height: 2px;
            background-color: #4caf50;
            z-index: 1;
            transition: width 0.4s ease;
            width: <?php echo $step * 25; ?>%; /* Line progresses based on the current step */
        }

        .step {
            position: relative;
            z-index: 2;
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 25%; /* Adjusted for 4 steps */
        }

        .step .icon {
            width: 30px;
            height: 30px;
            background-color: #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5px;
            transition: background-color 0.3s;
        }

        .step .icon::before {
            content: '\2713'; /* Checkmark symbol */
            font-size: 18px;
            color: transparent;
            transition: color 0.3s;
        }

        .step.completed .icon {
            background-color: #4caf50;
        }

        .step.completed .icon::before {
            color: #fff;
        }

        /* Blinking effect for the in-progress step */
        .step.in-progress .icon {
            background-color: #ffc107;
            animation: blink 1s infinite;
        }

        .step.in-progress .icon::before {
            color: #fff;
        }

        .step-label {
            font-size: 14px;
            color: #999;
        }

        .step.completed .step-label,
        .step.in-progress .step-label {
            color: #333;
        }

        /* Buttons styling */
        .buttons {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        button {
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            color: #fff;
        }

        .btn-home {
            background-color: #007bff;
        }

        .btn-home:hover {
            background-color: #0056b3;
        }

        .btn-cancel {
            background-color: #dc3545;
        }

        .btn-cancel:hover {
            background-color: #c82333;
        }

        /* Keyframes for blink animation */
        @keyframes blink {
            0% { opacity: 1; }
            50% { opacity: 0.5; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>

    <div class="order-tracking-container">
        <h1>Order Tracking</h1>

        <!-- Order Details -->
        <div class="order-details">
            <p>Order ID: <?php echo htmlspecialchars($Fid); ?></p>
        </div>

        <!-- Tracking Progress -->
        <div class="tracking-status">
            <div class="progress-line"></div>
            <div class="progress"></div> <!-- Line progresses based on step -->

            <div class="step <?php echo ($step >= 1) ? 'completed' : ''; ?>">
                <div class="icon"></div>
                <div class="step-label">Order Placed</div>
            </div>
            <div class="step <?php echo ($step >= 2) ? 'completed' : (($step == 2) ? 'in-progress' : ''); ?>">
                <div class="icon"></div>
                <div class="step-label">Order Accepted</div>
            </div>
            <div class="step <?php echo ($step >= 3) ? 'completed' : ''; ?>">
                <div class="icon"></div>
                <div class="step-label">Food Picked Up</div>
            </div>
            <div class="step <?php echo ($step >= 4) ? 'completed' : ''; ?>">
                <div class="icon"></div>
                <div class="step-label">Food Delivered</div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="buttons">
            <button class="btn-home" onclick="window.location.href='home.html';">Return to Home</button>
            
        </div>
    </div>

    <script>
        function cancelOrder() {
            if (confirm("Are you sure you want to cancel this order?")) {
                window.location.href = 'cancel_order.php?Fid=<?php echo $Fid; ?>';
            }
        }
    </script>
    <script>
    // Automatically refresh the page every 10 seconds (10000 milliseconds)
    setInterval(function() {
        window.location.reload();
    }, 5000);  // 10 seconds
</script>
</body>
</html>
