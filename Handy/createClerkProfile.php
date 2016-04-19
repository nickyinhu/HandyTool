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
      <h3>Handyman Tools Rental requires a valid profile for every clerk.</h3>
      <?php
        
         include('dbconn.php');
         global $conn;
		 
		  if (isset($_POST['create_profile'])) {
            if (!($_POST['clerk_id']) || empty($_POST['password']) ||empty($_POST['confirm_password']) ||empty($_POST['first_name'])||empty($_POST['last_name'])){
                echo '<script language="javascript">';
                echo 'alert("Please fill all fields")';
                echo '</script>';
            } else {
               $clerk_id   = $_POST['clerk_id'];
               $password = $_POST['password'];
			         $confirm_password = $_POST['confirm_password'];
               $first_name = $_POST['first_name'];
               $last_name = $_POST['last_name'];
               $result = $conn->query("SELECT clerk_id, first_name, password from clerk where clerk_id = '$clerk_id'");
               if ($result->num_rows > 0) {
                 echo '<script language="javascript">';
                 echo 'alert("Clerk ID ' . $clerk_id . ' has been taken already")';
                 echo '</script>';
               } elseif ($password!=$confirm_password) {
                       echo '<script language="javascript">';
                       echo 'alert("Password does not match")';
                       echo '</script>';
               } else {
                     $sql = "INSERT INTO clerk( clerk_id, password, first_name, last_name ) 
                         VALUES ('$clerk_id','$password', '$first_name','$last_name')";
                     if ( mysqli_query($conn, $sql) ) {
                       echo '<script language="javascript">';
                       echo 'alert("Registration Success for ' . $clerk_id . '")';
                       echo '</script>';
  				             $_SESSION['login_user']= $clerk_id;
                        echo "<script> window.location.assign('clerk.php'); </script>";
						
                     } else {
                        die("Error: " . mysqli_error($conn));
                     }
                  
               }
            }
         }
 
      ?>

      <form action = '' method = "post">
      <label>Clerk ID: </label><input type="text" name="clerk_id"><br>
      <label>Password: </label><input type = "password" name="password"><br>
      <label>Confirm Password: </label><input type = "password" name="confirm_password"><br>
      <label>First Name: </label><input type="text" name="first_name"><br>
      <label>Last Name: </label><input type="text" name="last_name"><br>
      <div>
         <p><button type="submit" value="Submit" name="create_profile">Submit</button></p>
      </div>
      </form>
      
         <div>
            <button type="submit" onClick="location.href='index.php'">Exit</button>
            </div>
         </div>
         </p>

   </body>
</html>

  

  