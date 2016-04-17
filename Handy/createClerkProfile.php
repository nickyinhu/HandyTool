<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>

   <body>
      <h2>Create a Profile</h2> 
      <h3>Handyman Tools Rental requires a valid profile for every clerk.</h3>
      <?php
         session_start();
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
               if ($password!=$confirm_password) {
                  echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Password does not match!</span>';
               } else {
                  
                     $sql = "INSERT INTO clerk( clerk_id, password, first_name, last_name ) 
                         VALUES ('$clerk_id','$password', '$first_name','$last_name')";
                     if ( mysqli_query($conn, $sql) ) {
                        echo "Successfully created new clerk profile";
						$_SESSION['login_user']= $clerk_id;
						
                     } else {
                        die("Error: " . mysqli_error($conn));
                     }
                  
               }
            }
         }
 
      ?>

      <form action = '' method = "post">
      Clerk ID: <input type="text" name="clerk_id"><br>
      Password: <input type="text" name="password"><br>
      Confirm Password: <input type="text" name="confirm_password"><br>
      First Name: <input type="text" name="first_name"><br>
      Last Name: <input type="text" name="last_name"><br>
      <div>
         <p><button type="submit" value="Submit" name="create_profile">Submit</button></p>
         
      </div>
      </form>
      
         <div>
            <label></label><button type="submit" onClick="location.href='clerk.php'">Main Menu</button>
            <label></label><button type="submit" onClick="location.href='index.php'">Exit</button>
            </div>
         </div>
         </p>

   </body>
</html>

  

  