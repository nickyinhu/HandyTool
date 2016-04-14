<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>

   <body>
      <h2>Service Order Request</h2> 
      <?php
         session_start();
         if (empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         $login_user = $_SESSION['login_user'];
         include('dbconn.php');
         global $conn;

         if (isset($_POST['submit'])) {

            $toolid = $_POST['toolid']
            $startdate = $_POST['startdate']
            $enddate = $_POST['enddate']
            $cost = $_POST['cost']
            $clerkid = $_SESSION['login_user']
         
              // Insert our data
            $sql = "INSERT INTO service_request( tool_id, start_date, end_date, cost, clerk_id ) 
                VALUES ('$toolid','startdate', 'enddate','cost','clerkid')";
            
            $insert = $conn->query($sql);
  
            // Print response from MySQL
            if ( $insert ) {
               echo "Success! Row ID: {$mysqli->insert_id}";
            } else {
               die("Error: {$mysqli->errno} : {$mysqli->error}");
            }

         }
      ?>

      <form action = '' method = "post">
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

  