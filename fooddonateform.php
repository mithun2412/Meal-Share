<?php
// Include the login script
include("login.php"); 

// Redirect to signin page if user is not logged in
if($_SESSION['name'] == ''){
    header("location: signin.php");
}

// Get user email from session
$emailid = $_SESSION['email'];

// Establish connection to the database
$connection = mysqli_connect("localhost", "root", "", "demo");
if (!$connection) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['submit'])) {
    // Sanitize form inputs
    $foodname = mysqli_real_escape_string($connection, $_POST['foodname']);
    $meal = mysqli_real_escape_string($connection, $_POST['meal']);
    $category = $_POST['image-choice']; // Image choice (assumed sanitized)
    $quantity = mysqli_real_escape_string($connection, $_POST['quantity']);
    $phoneno = mysqli_real_escape_string($connection, $_POST['phoneno']);
    $district = mysqli_real_escape_string($connection, $_POST['district']);
    $address = mysqli_real_escape_string($connection, $_POST['address']);
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    
    // Prepare the SQL query to insert data into the food_donations table
    $query = "INSERT INTO food_donations (email, food, type, category, phoneno, location, address, name, quantity) 
              VALUES ('$emailid', '$foodname', '$meal', '$category', '$phoneno', '$district', '$address', '$name', '$quantity')";

    // Execute the query
    $query_run = mysqli_query($connection, $query);

    // Check if the query was successful
    if ($query_run) {
        echo '<script type="text/javascript">alert("Data saved")</script>';
        header("location: delivery.php"); // Redirect on success
        exit;
    } else {
        // Output detailed error message
        echo '<script type="text/javascript">alert("Data not saved: ' . mysqli_error($connection) . '")</script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Donate</title>
    <link rel="stylesheet" href="loginstyle1.css">
</head>
<body style="background-color: rgb(231, 205, 171);">
  
    <div class="container">
        <div class="regformf">
            <form action="" method="post">
                <div class="logo">
                    <b>Meal </b><b class="meal" style="color: rgb(231, 205, 171);">Share</b>
                </div>

                <div class="input">
                    <label for="foodname">Food Name:</label>
                    <input type="text" id="foodname" name="foodname" required/>
                </div>
                
                <div class="radio">
                    <label for="meal">Meal type:</label> 
                    <br><br>
                    <input type="radio" name="meal" id="veg" value="veg" required/>
                    <label for="veg" style="padding-right: 40px;">Veg</label>
                    <input type="radio" name="meal" id="Non-veg" value="Non-veg">
                    <label for="Non-veg">Non-veg</label>
                </div>
                <br>
                
                <div class="input">
                    <label for="food">Select the Category:</label>
                    <br><br>
                    <div class="image-radio-group">
                        <input type="radio" id="raw-food" name="image-choice" value="raw-food">
                        <label for="raw-food">
                            <img src="img/raw-food.png" alt="raw-food">
                        </label>
                        <input type="radio" id="cooked-food" name="image-choice" value="cooked-food" checked>
                        <label for="cooked-food">
                            <img src="img/cooked-food.png" alt="cooked-food">
                        </label>
                        <input type="radio" id="packed-food" name="image-choice" value="packed-food">
                        <label for="packed-food">
                            <img src="img/packed-food.png" alt="packed-food">
                        </label>
                    </div>
                    <br>
                </div>
                
                <div class="input">
                    <label for="quantity">Quantity (number of person/kg):</label>
                    <input type="text" id="quantity" name="quantity" required/>
                </div>
                
                <b><p style="text-align: center;">Contact Details</p></b>
                <div class="input">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $_SESSION['name']; ?>" required/>
                </div>
                <div class="input">
                    <label for="phoneno">PhoneNo:</label>
                    <input type="text" id="phoneno" name="phoneno" maxlength="10" pattern="[0-9]{10}" required/>
                </div>
                
                <div class="input">
                    <label for="district">District:</label>
                    <select id="district" name="district" style="padding: 10px;">
                        <option value="Bengaluru">Bengaluru</option>
                        <option value="Mysuru">Mysuru</option>
                        <option value="Tumkur">Tumkur</option>
                        <option value="Mangaluru">Mangaluru</option>
                        <option value="Shimoga">Shimoga</option>
                        <option value="Haveri">Haveri</option>
                        <option value="Udupi">Udupi</option>
                        <option value="Kolar">Kolar</option>
                        <!-- Add more options as needed -->
                    </select> 
                    
                    <label for="address" style="padding-left: 10px;">Address:</label>
                    <input type="text" id="address" name="address" required/>
                </div>

                <div class="btn">
                    <button type="submit" name="submit">Submit</button>
                </div>
            </form>
        </div>
    </div>
    
</body>
</html>
