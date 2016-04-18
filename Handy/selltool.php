<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>
   <body>
      <h2>Sell Tools</h2>
      <?php
         session_start();
		   include('dbconn.php');
         global $conn;

         if (empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         $login_user = $_SESSION['login_user'];

         if (isset($_POST['sell'])) {
            if (!$_POST['toolid']) {
              echo '<script language="javascript">';
              echo 'alert("Please the Tool ID for sale")';
              echo '</script>';
            } else {
               $toolid = $_POST['toolid'];
               $check = $conn->query("SELECT * from tools WHERE tool_id = '$toolid'");
               if ($check->num_rows > 0) {
                  $row = $check->fetch_assoc();
                  if ($row['sold_date']) {
                    echo '<script language="javascript">';
                    echo 'alert("Your tool is sold already on ' . $row['sold_date'] . '")';
                    echo '</script>';
                  } else {
                     $sql = "UPDATE tools SET purchase_price = purchase_price * 0.5, sold_date = CURDATE() WHERE tool_id = '$toolid'";
                     if ( mysqli_query($conn, $sql) ) {
                        echo "Tool sold successfully!<br>";
                        $sql_sold = "SELECT * FROM tools WHERE tool_id = '$toolid'";
                        $result = $conn->query($sql_sold);
                        if ($result->num_rows > 0 ){
                           echo '<p><table border="1">';
                           echo '<tr><th>Tool ID</th><th>Description</th><th>Sold Price</th><th>Sold Date</th>';
                           $row = $result->fetch_assoc();
                           echo "<tr><td>" . $row['tool_id'] . "</td><td>" . $row['abbr_description'] . "</td><td>$" .$row['purchase_price'] . "</td><td>".$row['sold_date']."</td></tr>";  //$row['index'] the index here is a field name                           
                           echo '</table>';
                        }
                     } else {
                        die("Error: " . mysqli_error($con));
                     }
                  }
               } else {
                    echo '<script language="javascript">';
                    echo 'alert("Cannot find Tool for ID $toolid")';
                    echo '</script>';
               }
            }
         }
         if (isset($_POST['back'])) {
             echo "<script> window.location.assign('clerk.php'); </script>";
         }
         if (isset($_POST['logout'])) {
             session_destroy();
             echo "<script> window.location.assign('index.php'); </script>";
         }
      ?>

      <form action = '' method = "post">
         Tool ID: <input type="text" name="toolid" autofocus><br>
         <p><input type = "submit" name = "sell" value = "Sell"><hr></p>
         <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
         <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
      </form>
   </body>
</html>
