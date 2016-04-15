<html lang = "en">

   <head>
      <title>Handyman Tool</title>
   </head>

   <body>
      <h2>Customer</h2>
      <?php
         session_start();
         include('dbconn.php');
         global $conn;
         if (empty($_SESSION['login_user'])) {
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

         if (isset($_POST['logout'])) {
             session_destroy();
             echo "<script> window.location.assign('index.php'); </script>";
         }
      ?>

      
      <div class = "container">
         <div>
            <button type="submit" onClick="location.href='viewprofile.php'">View Profile</button>
         </div>
         <div>
            <button type="submit" onClick="location.href='checkavailability.php'">Check Tool Availability</button>
         </div>
         <div>
            <button type="submit" onClick="location.href='makereservation.php'">Make Reservation</button>
         </div>
         <form class = "form-signin" role = "form" action = "" method = "post">
         <div>
            <button type="submit" name="logout">Exit</button>
         </div>
         </form>

      </div>
   </body>
</html>