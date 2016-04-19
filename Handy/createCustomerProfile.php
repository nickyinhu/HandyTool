<?php session_start(); ?>
<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      <style type="text/css">
        label{
          display:inline-block;
          width:150px;
          height: 30px;
        }
      </style>
      
   </head>

   <body>
      <h2>Create a Profile</h2> 
      <h3>Handyman Tools Rental requires a valid profile for every user before they can make reservaitions.</h3>
      <?php
       
         include('dbconn.php');
         global $conn;
		 date_default_timezone_set('EST');
 
        if (isset($_POST['create_profile'])) {
            if (!($_POST['email']) || empty($_POST['password']) ||empty($_POST['confirm_password']) ||empty($_POST['first_name'])||empty($_POST['last_name']) ||empty($_POST['home_phone']) ||empty($_POST['work_phone']) ||empty($_POST['address'])){
                echo '<script language="javascript">';
                echo 'alert("Please fill all fields")';
                echo '</script>';
            } else {
               $email   = $_POST['email'];
               $password = $_POST['password'];
			   $confirm_password = $_POST['confirm_password'];
               $first_name = $_POST['first_name'];
               $last_name = $_POST['last_name'];
			   $home_phone = $_POST['home_phone'];
			   $work_phone = $_POST['work_phone'];
			   $address = $_POST['address'];
			   $today = date("Y-m-d");
			   
               if ($password!=$confirm_password) {
                       echo '<script language="javascript">';
                       echo 'alert("Password does not match")';
                       echo '</script>';
               } else {
                  
                     $sql = "INSERT INTO customer( email, password, first_name, last_name, home_phone, work_phone, address,create_date) 
                         VALUES ('$email','$password', '$first_name','$last_name','$home_phone','$work_phone', '$address','$today')";
                     if ( mysqli_query($conn, $sql) ) {
                       echo '<script language="javascript">';
                       echo 'alert("Registration Success for ' . $email . '")';
                       echo '</script>';
                       $_SESSION['login_user']= $email;
                        echo "<script> window.location.assign('customer.php'); </script>";
						
                     } else {
                        die("Error: " . mysqli_error($conn));
                     }
                  
               }
            }
         }
 
      ?>


      <form action = '' method = "post">
      <label>Email (Login): </label><input type="text" name="email"><br>
      <label>Password: </label><input type = "password" name="password"><br>
      <label>Confirm Password: </label><input type = "password" name="confirm_password"><br>
      <label>First Name: </label><input type="text" name="first_name"><br>
      <label>Last Name: </label><input type="text" name="last_name"><br>
      <label>Home Phone: </label><input type="text" name="home_phone"><br>
      <label>Work Phone: </label><input type="text" name="work_phone"><br>
      <label>Address: </label><input type="text" name="address"><br>
      <div>
         <p><button type="submit" value="Submit" name="create_profile">Submit</button></p>
      </div>
      </form>
      <div>
         <button type="submit" onClick="location.href='index.php'">Exit</button>
            </div>


   </body>
</html>

  