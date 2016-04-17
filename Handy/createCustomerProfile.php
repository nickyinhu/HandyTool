<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>

   <body>
      <h2>Create a Profile</h2> 
      <h3>Handyman Tools Rental requires a valid profile for every user before they can make reservaitions.</h3>
      <?php
         session_start();
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
                  echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Password does not match!</span>';
               } else {
                  
                     $sql = "INSERT INTO customer( email, password, first_name, last_name, home_phone, work_phone, address,create_date) 
                         VALUES ('$email','$password', '$first_name','$last_name','$home_phone','$work_phone', '$address','$today')";
                     if ( mysqli_query($conn, $sql) ) {
                        echo "Successfully created new clerk profile";
						$_SESSION['login_user']= $email;
						
                     } else {
                        die("Error: " . mysqli_error($conn));
                     }
                  
               }
            }
         }
 
      ?>


      <form action = '' method = "post">
      Email Address (Login): <input type="text" name="email"><br>
      Password: <input type="text" name="password"><br>
      Confirm Password: <input type="text" name="confirm_password"><br>
      First Name: <input type="text" name="first_name"><br>
      Last Name: <input type="text" name="last_name"><br>
      Home Phone: <input type="text" name="home_phone"><br>
      Work Phone: <input type="text" name="work_phone"><br>
      Address: <input type="text" name="address"><br>
      <div>
         <p><button type="submit" value="Submit" name="create_profile">Submit</button></p>
      </div>
      </form>
      <div>
            <label></label><button type="submit" onClick="location.href='customer.php'">Main Menu</button>
            <label></label><button type="submit" onClick="location.href='index.php'">Exit</button>
            </div>
            </div>
         </p>


   </body>
</html>

  