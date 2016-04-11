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
            <button type="submit" onClick="location.href='pickup.html'">Pick-up Reservation</button>
         </div>
         <div>
            <button type="submit" onClick="location.href='dropoff.html'">Drop-Off Reservation</button>
         </div>
         <div>
            <button type="submit" onClick="location.href='serviceorder.html'">Service Order</button>
         </div>
         <div>
            <button type="submit" onClick="location.href='addnewtool.html'">Add New Tool</button>
         </div>
         <div class = "container">
         <div>
            <button type="submit" onClick="location.href='selltool.html'">Sell Tool</button>
         </div>
         <div>
            <button type="submit" onClick="location.href='report.html'">Generate Report</button>
         </div>
         <div>
            <button type="submit" onClick="location.href='index.html'">Exit</button>
         </div>
      

      </div>
   </body>
</html>