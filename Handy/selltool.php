<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>

   <body>
      <h2>Service Order Request</h2> 
      <?php
         session_start();
		 include('dbconn.php');
         global $conn;
		 
         if (empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         $login_user = $_SESSION['login_user'];
        
         if (isset($_POST['sell'])) {
            $toolid = $_POST['toolid'];
         
            $sql = "UPDATE tools SET purchase_price = purchase_price * 0.5, sold_date = CURDATE() WHERE tool_id = '$toolid'";
			if ( mysqli_query($conn, $sql) ) {
                        echo "tool sold successfully!";
                     } else {
                        die("Error: " . mysqli_error($con));
                     }
			
            $sql_sold = "SELECT tool_id, purchase_price,sold_date FROM tools WHERE tool_id = '$toolid'";
            $result = $conn->query($sql) or die('Error querying database.');
			if ($result->num_rows > 0 ){
            echo "<table>";
            while($row = mysql_fetch_array($result)){   //Creates a loop to loop through results
            echo "<tr><td>" . $row['tool_id'] . "</td><td>" . $row['purchase_price'] . "</td></tr>".$row['sold_price']."</td></tr>";  //$row['index'] the index here is a field name
            }
            echo "</table>";
			}
         }
      ?>

      <form action = '' method = "post">
      Tool ID: <input type="text" name="toolid"><br>
      <div>
         <button type="submit" value="Submit" name＝"sell">Sell</button>
      </div>
      </form>
      
      </form>
      <div>
            <label></label><button type="submit" onClick="location.href='clerk.php'">Main Menu</button>
            <label></label><button type="submit" onClick="location.href='index.php'">Exit</button>
            </div>
            </div>
         </p>

   </body>
</html>
