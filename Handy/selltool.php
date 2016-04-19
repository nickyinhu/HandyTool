<?php session_start(); ?>
<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>
   <body>
      <h2>Sell Tools</h2>
      <?php
    
		   include('dbconn.php');
         global $conn;

         if (empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         include('sql.php');
         $login_user = $_SESSION['login_user'];
         $condition = 0;
         $sql = get_sellability();
         $result = $conn->query($sql);
         if ($result->num_rows > 0) {
           $condition = 1;
         } else {
            echo '<script language="javascript">';
            echo 'alert("No available tools for sale")';
            echo '</script>';
         }
         if (isset($_POST['sell'])) {
            if (!$_POST['selltool']) {
              echo '<script language="javascript">';
              echo 'alert("Please the Tool ID for sale")';
              echo '</script>';
            } else {
               $toolid = $_POST['selltool'];
               $sql = "UPDATE tools SET purchase_price = purchase_price * 0.5, sold_date = CURDATE() WHERE tool_id = '$toolid'";
               if ( mysqli_query($conn, $sql) ) {
                     $result = $conn->query($sql);
                     echo '<h4>Tool was Sold Successfully</h4>';
                     echo '<p><table border="1">';
                     echo '<tr><th>Tool ID</th><th>Description</th><th>Sold Price</th><th>Sold Date</th>';
                     $sold_result = $conn->query("SELECT * from tools WHERE tool_id = $toolid");
                     $row = $sold_result->fetch_assoc();
                     echo "<tr><td>" . $row['tool_id'] . "</td><td>" . $row['abbr_description'] . "</td><td>$" .$row['purchase_price'] . "</td><td>".$row['sold_date']."</td></tr>";
                     echo '</table>';
               } else {
                  die("Error: " . mysqli_error($con));
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
        <?php if ($condition) {
                echo '<p><select name="selltool">';
                echo '<option value="">Please Select Tool</option>';
                while ($row = $result->fetch_assoc()) {
                    $tool_id = $row['tool_id'];
                    $name = $row['abbr'];
                    echo "<option value=\"$tool_id\">Tool# $tool_id. $name</option>";
                }
                echo '</select></p>';
            } ?>
         <p><input type = "submit" name = "sell" value = "Sell"><hr></p>
         <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
         <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
      </form>
   </body>
</html>
