<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>

   <body>
      <h2>Service Order Request</h2> 
      <?php
         session_start();
         $login_user = $_SESSION['login_user'];
         include('dbconn.php');
         global $conn;
         echo $login_user;
         if (!$login_user) {
            die("You are not login yet!");
         }

         if ( ! empty( $_POST ) ) {
              // Insert our data
            $sql = "INSERT INTO service_request( tool_id, start_date, end_date, cost, clerk_id ) 
                VALUES ( '{$mysqli->real_escape_string($_POST['toolid'])}', '{$mysqli->real_escape_string($_POST['startdate'])}',
                '{$mysqli->real_escape_string($_POST['enddate'])}', '{$mysqli->real_escape_string($_POST['cost'])}')";
            
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
      Tool ID: <input type="text" name="toolid"><br>
      Starting Date: <input type="text" name="startdate"><br>
      Ending Date: <input type="text" name="enddate"><br>
      Estimated Cost of Repair ($): <input type="text" name="cost"><br>
      <div>
         <button type="submit" value="Submit">Submit New Tool</button>
      </div>
      </form>

   </body>
</html>

  