<?php
// session_start();
// $connection=mysqli_connect("localhost:3307","root","");
// $db=mysqli_select_db($connection,'demo');
include '../connection.php';
$msg=0;
if(isset($_POST['sign']))
{

    $username=$_POST['username'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $location=$_POST['district'];

    // $location=$_POST['district'];

    $pass=password_hash($password,PASSWORD_DEFAULT);
    $sql="select * from delivery_persons where email='$email'" ;
    $result= mysqli_query($connection, $sql);
    $num=mysqli_num_rows($result);
    if($num==1){
        // echo "<h1> already account is created </h1>";
        // echo '<script type="text/javascript">alert("already Account is created")</script>';
        echo "<h1><center>Account already exists</center></h1>";
    }
    else{
    
    $query="insert into delivery_persons(name,email,password,city) values('$username','$email','$pass','$location')";
    $query_run= mysqli_query($connection, $query);
    if($query_run)
    {
        // $_SESSION['email']=$email;
        // $_SESSION['name']=$row['name'];
        // $_SESSION['gender']=$row['gender'];
       
        header("location:deliverylogin.php");
        // echo "<h1><center>Account does not exists </center></h1>";
        //  echo '<script type="text/javascript">alert("Account created successfully")</script>'; -->
    }
    else{
        echo '<script type="text/javascript">alert("data not saved")</script>';
        
    }
}


   
}
?>





<!DOCTYPE html>
<html lang="en">


  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Animated Login Form | CodingNepal</title>
    <link rel="stylesheet" href="deliverycss.css">
  </head>
  <body>
    <div class="center">
      <h1>Register</h1>
      <form method="post" action=" ">
        <div class="txt_field">
          <input type="text" name="username" required/>
          <span></span>
          <label>Username</label>
        </div>
        <div class="txt_field">
          <input type="password" name="password" required/>
          <span></span>
          <label>Password</label>
        </div>
        <div class="txt_field">
            <input type="email" name="email" required/>
            <span></span>
            <label>Email</label>
          </div>
          <div class="">
                           <label for="district">District:</label>
                           <select id="district" name="district" style="padding:10px; padding-left: 20px;">
                          
                          <option value="Bengaluru">Bengaluru</option>
  <option value="Mysuru">Mysuru</option>
  <option value="Tumkur">Tumkur</option>
  <option value="Mangaluru">Mangaluru</option>
  <option value="Shimoga">Shimoga</option>
  <option value="Haveri">Haveri</option>
  <option value="Udupi">Udupi</option>
  <option value="Kolar">Kolar</option>
  <option value="Koppal">Koppal</option>
  <option value="Uttara Kannada">Uttara Kannada</option>
  <option value="Mandya">Mandya</option>
  <option value="Chikkaballapur">Chikkaballapur</option>
  <option value="Bellary">Bellary</option>
  <option value="Bijapur">Bijapur</option>
  <option value="Bellary">Bellary</option>
  <option value="Belgaum">Belgaum</option>
  <option value="Davangere">Davangere</option>
  <option value="Hassan">Hassan</option>
  <option value="Chamarajanagar">Chamarajanagar</option>
  <option value="Raichur">Raichur</option>
  <option value="Bagalkot">Bagalkot</option>
  <option value="Bidar">Bidar</option>
  <option value="Ramanagara">Ramanagara</option>
  <option value="Chitradurga">Chitradurga</option>
  <option value="yadgir">yadgir</option>
  <option value="Coorg">Coorg</option>
  <option value="Chikkamagaluru">Chikkamagaluru</option>
                        </select> 
                        
          </div>
          <br>
        <!-- <div class="pass">Forgot Password?</div> -->
        <input type="submit" name="sign" value="Register">
        <div class="signup_link">
          Alredy a member? <a href="deliverylogin.php">Sigin</a>
        </div>
      </form>
    </div>
    <script src="deliverylogin.php" ></script>
  </body>
</html>
