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
 
         if ( ! empty( $_POST ) ) {
              // Insert our data
            $sql = "INSERT INTO Customer( Email, Password, First_name, Last_Name, Home_phone, Work_phone, Address ) 
                VALUES ( '{$mysqli->real_escape_string($_POST['email'])}', '{$mysqli->real_escape_string($_POST['password'])}',
                '{$mysqli->real_escape_string($_POST['first_name'])}', '{$mysqli->real_escape_string($_POST['last_name'])}','{$mysqli->real_escape_string($_POST['home_phone'])}','{$mysqli->real_escape_string($_POST['work_phone'])}','{$mysqli->real_escape_string($_POST['address'])}')";
            
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
      ?>

      <form>
      Email Address (Login): <input type="text" name="email"><br>
      Password: <input type="text" name="password"><br>
      Confirm Password: <input type="text" name="confirm_password"><br>
      First Name: <input type="text" name="first_name"><br>
      Last Name: <input type="text" name="last_name"><br>
      Home Phone: <input type="text" name="home_phone"><br>
      Work Phone: <input type="text" name="work_phone"><br>
      Address: <input type="text" name="address"><br>
      <div>
         <button type="submit" value="Submit">Submit</button>
      </div>
      </form>

   </body>
</html>

  