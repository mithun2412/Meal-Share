<?php
// $connection = mysqli_connect("localhost:3307", "root", "");
// $db = mysqli_select_db($connection, 'demo');
 include("connect.php"); 
if($_SESSION['name']==''){
	header("location:signin.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">

    <title>Document</title>
</head>
<style>
  .received-btn{
    background-color: rgb(122, 92, 84);
    cursor:pointer;
  }  
</style>
<body>
    <nav>
        <div class="logo-name">
            <div class="logo-image">
                <!--<img src="images/logo.png" alt="">-->
            </div>

            <span class="logo_name">ADMIN</span>
        </div>

        <div class="menu-items">
            <ul class="nav-links">
                <li><a href="admin.php">
                    <i class="uil uil-estate"></i>
                    <span class="link-name">Dahsboard</span>
                </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-files-landscapes"></i>
                    <span class="link-name">Content</span>
                </a></li> -->
                <li><a href="analytics.php">
                    <i class="uil uil-chart"></i>
                    <span class="link-name">Contributions</span>
                </a></li>
                <li><a href="donate.php">
                    <i class="uil uil-heart"></i>
                    <span class="link-name">Donates</span>
                </a></li>
                <li><a href="feedback.php">
                    <i class="uil uil-comments"></i>
                    <span class="link-name">Feedbacks</span>
                </a></li>
                <li><a href="#">
                    <i class="uil uil-user"></i>
                    <span class="link-name">Profile</span>
                </a></li>
                <!-- <li><a href="#">
                    <i class="uil uil-share"></i>
                    <span class="link-name">Share</span>
                </a></li> -->
            </ul>
            
            <ul class="logout-mode">
                <li><a href="../logout.php">
                    <i class="uil uil-signout"></i>
                    <span class="link-name">Logout</span>
                </a></li>

                <li class="mode">
                    <a href="#">
                        <i class="uil uil-moon"></i>
                    <span class="link-name">Dark Mode</span>
                </a>

                <div class="mode-toggle">
                  <span class="switch"></span>
                </div>
            </li>
            </ul>
        </div>
    </nav>

    <section class="dashboard">
        
        <div class="top">
            <i class="uil uil-bars sidebar-toggle"></i>
            <!-- <p>Food Donate</p> -->
            <p  class ="logo" style="color:rgb(122, 92, 84);"><b>Your</b> <b style="color:rgb(231, 205, 171);">History</b></p>
             <p class="user"></p>
            <!-- <div class="search-box">
                <i class="uil uil-search"></i>
                <input type="text" placeholder="Search here...">
            </div> -->
            
            <!--<img src="images/profile.jpg" alt="">-->
        </div>
        <br>
        <br>
        <br>
        <div class="activity">
        <div class="table-container">
         
         <div class="table-wrapper">
         <table class="table">
        <thead>
        <tr>
            <th >Name</th>
            <th>food</th>
            <th>Category</th>
            <th>phoneno</th>
            <th>date/time</th>
            <th>address</th>
            <th>Quantity</th>
            <th>Status</th>
         
          
           
        </tr>
        </thead>
         <?php
          


          // Define the SQL query to fetch unassigned orders
          $id=$_SESSION['Aid'];
          $sql = "SELECT * FROM food_donations WHERE assigned_to =$id";
          
          // Execute the query
          $result=mysqli_query($connection, $sql);
      
          
          // Check for errors
          if (!$result) {
            die("Error executing query: " . mysqli_error($connection));
        }

        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td data-label='Name'>{$row['name']}</td>
                    <td data-label='Food'>{$row['food']}</td>
                    <td data-label='Category'>{$row['category']}</td>
                    <td data-label='Phone No'>{$row['phoneno']}</td>
                    <td data-label='Date/Time'>{$row['date']}</td>
                    <td data-label='Address'>{$row['address']}</td>
                    <td data-label='Quantity'>{$row['quantity']}</td>
                    <td data-label='Status'>";
            if ($row['status'] == 1) {
                echo "Completed";
            } else {
                echo "<button  class='received-btn' onclick='updateStatus(this)'>Received</button>";
            }
            echo "</td></tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</div>
</div>
</section>

<script>
function updateStatus(button) {
    // AJAX request to update the status
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_status.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Replace the button with the "Completed" text
            button.parentNode.innerHTML = 'Completed';
        }
    };
    xhr.send();
}


</script>
</body>
</html>