<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      <style type="text/css">
        label{
          display:inline-block;
          height: 35px;
          margin: 0 auto;
        }
      </style>
   </head>

   <body>
      <h2>Customer Menu</h2>
      <?php
         session_start();
         include('dbconn.php');
         global $conn;
         if (empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         if (isset($_POST['logout'])) {
             session_destroy();
             echo "<script> window.location.assign('index.php'); </script>";
         }
      ?>

      
      <div class = "container">
         <div>
            <label><button type="submit" onClick="location.href='viewprofile.php'">View Profile</button></label>
         </div>
         <div>
            <label><button type="submit" onClick="location.href='checkavailability.php'">Check Tool Availability</button></label>
         </div>
         <div>
            <label><button type="submit" onClick="location.href='makereservation.php'">Make Reservation</button></label>
         </div>
         <form class = "form-signin" role = "form" action = "" method = "post">
         <div><p>
            <label><button type="submit" name="logout">Log Out</button></label>
         </p></div>
         </form>

      </div>
   </body>
</html>