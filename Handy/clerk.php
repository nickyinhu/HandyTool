<html lang = "en">

   <head>
      <title>Handyman Tool</title>
   </head>

   <body>
      <h2>Clerk</h2> 
      <?php
         session_start();
         if (!empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         include('dbconn.php');
         global $conn;
         $login_user = $_SESSION['login_user'];
         $sql = "SELECT clerk_id, first_name, last_name from clerk where clerk_id = '$login_user'";
         $result = $conn->query($sql) or die('Error querying database.');;
         if ($result->num_rows > 0 ) {
            while($row = $result->fetch_assoc()) {
               echo "id: " . $row["clerk_id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
            }
         }
      ?>


      <div class = "container">
         <div>
            <button type="submit" value="Submit">Pick-up Reservation</button>
         </div>
         <div>
            <button type="submit" value="Submit">Drop-Off Reservation</button>
         </div>
         <div>
            <button type="submit" value="Submit">Service Order</button>
         </div>
         <div>
            <button type="submit" value="Submit">Add New Tool</button>
         </div>
         <div class = "container">
         <div>
            <button type="submit" value="Submit">Sell Tool</button>
         </div>
         <div>
            <button type="submit" value="Submit">Generate Report</button>
         </div>
         <div>
            <button type="submit" value="Submit">Exit</button>
         </div>
      

      </div>
   </body>
</html>