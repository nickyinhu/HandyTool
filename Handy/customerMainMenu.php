<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      <style type="text/css">
        label{
          display:inline-block;
          height: 28px;
          margin: 0 auto;
          width: 500px;
      }
      </style>
   </head>

   <body>
   
      <h2>Main Menu</h2> 
      <?php
         session_start();
         if (empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         $login_user = $_SESSION['login_user'];
         include('dbconn.php');
         include('functions.php');
         global $conn;
          
		  if (isset($_POST['view_profile'])) {
            
             echo "<script> window.location.assign('viewCustomerProfile.php'); </script>";
         }
		 if (isset($_POST['check_tool_availability'])) {
           
             echo "<script> window.location.assign('checkavailability.php'); </script>";
         }
		 if (isset($_POST['make_reservation'])) {
             
             echo "<script> window.location.assign('makereservation.php'); </script>";
         }
         if (isset($_POST['exit'])) {
             session_destroy();
             echo "<script> window.location.assign('index.php'); </script>";
         }
        
      ?>

      <form action = '' method = "post">
  
         <div>
            <p><button type="submit" value="view customer profile" name="view_profile">View Profile</button></p>
            <p><button type="submit" value="check tool availabiltiy" name="check_tool_availability">Check Tool Availability</button></p>
            <p><button type="submit" value="make reservation" name="make_reservation">Make Reservation</button></p>
            <p><button type="submit" value="exit" name="exit">Exit</button></p>

            <hr>
         
         </div>
      </form>

   </body>
</html>

  