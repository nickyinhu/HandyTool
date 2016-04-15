<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      <style type="text/css">
        label{
          display:inline-block;
          height: 28px;
          margin: 0 auto;
          width: 100px;
      }
      </style>
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
         include('functions.php');
         global $conn;

         if (isset($_POST['service'])) {
            if (!($_POST['toolid']) || empty($_POST['startdate']) ||empty($_POST['enddate']) ||empty($_POST['cost'])){
                echo '<script language="javascript">';
                echo 'alert("Please fill all fields")';
                echo '</script>';
            } else {
               $toolid    = $_POST['toolid'];
               $startdate = $_POST['startdate'];
               $enddate   = $_POST['enddate'];
               $cost      = $_POST['cost'];
               if (!validateDate($startdate)) {
                  echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please type a valid Start Date!</span>';
               } elseif (!validateDate($enddate)) {
                  echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please type a valid End Date!</span>';
               } elseif (!laterthantoday($startdate)) {
                  echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Start Date must be today or in the future!</span>';
               } elseif (checkStartEnd($startdate,$enddate)) {
                  echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Start Date cannot be greater than End Date!</span>';
               } elseif (!is_numeric($cost)) {
                  echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please Enter valid Cost Amount!</span>';
               } elseif (!is_numeric($toolid)) {
                  echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please Enter a valid Tool ID!</span>';
               } else {
                  include('sql.php');
                  # Check availability first
                  $check_tool_avai_sql = get_single_tool_availability($toolid, $startdate, $enddate);
                  $result = $conn->query($check_tool_avai_sql) or die('Error querying database.');
                  if ($result->num_rows > 0 ) {
                     # Insert new order into DB
                     $sql = "INSERT INTO service_request( tool_id, start_date, end_date, cost, clerk_id ) 
                         VALUES ('$toolid','$startdate', '$enddate','$cost','$login_user')";
                     if ( mysqli_query($conn, $sql) ) {
                        echo "Successfully added Service Order";
                     } else {
                        die("Error: " . mysqli_error($con));
                     }
                  } else {
                     echo '<script language="javascript">';
                     echo 'alert("Your order is conflict with an existing reservation or service order")';
                     echo '</script>';
                  }
               }
            }
         }
         if (isset($_POST['logout'])) {
             session_destroy();
             echo "<script> window.location.assign('index.php'); </script>";
         }
         if (isset($_POST['back'])) {
             unset($_SESSION['detail_tool_id']);
             echo "<script> window.location.assign('clerk.php'); </script>";
         }
      ?>

      <form action = '' method = "post">
         <label>Tool ID: </label><input type="text" name="toolid"><br>
         <label>Starting Date: </label><input type="text" name="startdate"><br>
         <label>Ending Date: </label><input type="text" name="enddate"><br>
         <label>Estimated Cost of Repair ($): </label><input type="text" name="cost"><br>
         <div>
            <p><button type="submit" value="Submit" name="service">Submit New Service Order</button></p>

            <hr>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button></p>
         </div>
      </form>

   </body>
</html>

  