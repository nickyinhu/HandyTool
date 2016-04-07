<html lang = "en">

   <head>
      <title>Handyman Tool</title>
   </head>

   <body>
      <h2>Clerk</h2> 
      <?php
         session_start();
         include('dbconn.php');
         global $conn;
         if (!empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         $login_user = $_SESSION['login_user'];
         $sql = "SELECT email, first_name, last_name from customer where email = '$login_user'";
         $result = $conn->query($sql) or die('Error querying database.');;
         if ($result->num_rows > 0 ) {
            while($row = $result->fetch_assoc()) {
               echo "id: " . $row["email"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
            }
         }
      ?>

      
      <div class = "container">
         <div>
            <button type="submit" value="Submit">View Profile</button>
         </div>
         <div>
            <button type="submit" value="Submit">Check Tool Availability</button>
         </div>
         <div>
            <button type="submit" value="Submit">Make Reservation</button>
         </div>
         <div>
            <button type="submit" value="Submit">Exit</button>
         </div>
         

      </div>
   </body>
</html>