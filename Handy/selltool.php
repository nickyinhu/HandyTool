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

         if (isset($_POST['sell'])) {

            $toolid = $_POST['toolid']
         
            $sql = "UPDATE tools SET purchase_price = purchase_price * 0.5, sold_date = getdate() WHERE tool_id = $toolid";
            
            $query = "SELECT tool_id, purchase_price FROM tools WHERE tool_id = $toolid";
            $result = mysql_query($query);

            echo "<table>";
            while($row = mysql_fetch_array($result)){   //Creates a loop to loop through results
            echo "<tr><td>" . $row['tool_id'] . "</td><td>" . $row['purchase_price'] . "</td></tr>";  //$row['index'] the index here is a field name
            }

            echo "</table>";


         }
      ?>

      <form action = '' method = "post">
      Tool ID: <input type="text" name="toolid"><br>
      <div>
         <button type="submit" value="Submit" name＝"sell">Sell</button>
      </div>
      </form>

   </body>
</html>

  