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
 
         if ( ! empty( $_POST ) ) {
              // Insert our data
            $sql = "INSERT INTO Clerk( Clerk_id, Password, First_name, Last_Name ) 
                VALUES ( '{$mysqli->real_escape_string($_POST['clerk_id'])}', '{$mysqli->real_escape_string($_POST['password'])}',
                '{$mysqli->real_escape_string($_POST['first_name'])}', '{$mysqli->real_escape_string($_POST['last_name'])}')";
            
            $insert = $mysqli->query($sql);
  
            // Print response from MySQL
            if ( $insert ) {
               echo "Success! Row ID: {$mysqli->insert_id}";
            } else {
               die("Error: {$mysqli->errno} : {$mysqli->error}");
            }
  
            // Close our connection
            $mysqli->close();
            }
			
			if (isset($_POST['login'])) {
             session_destroy();
             echo "<script> window.location.assign('index.php'); </script>";
         }
		 
			
      ?>

      <form>
      Clerk ID: <input type="text" name="clerk_id"><br>
      Password: <input type="text" name="password"><br>
      Confirm Password: <input type="text" name="confirm_password"><br>
      First Name: <input type="text" name="first_name"><br>
      Last Name: <input type="text" name="last_name"><br>
      <div>
         <p><button type="submit" value="Submit">Submit</button></p>
         <p><button type = "submit" name = "login">Log in</button></p>
      </div>
      </form>

   </body>
</html>

  

  