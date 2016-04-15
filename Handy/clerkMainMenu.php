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
          
		  if (isset($_POST['pick_up'])) {
             
             echo "<script> window.location.assign('pick_up_reservation.php'); </script>";
         }
		 if (isset($_POST['drop_off'])) {
  
             echo "<script> window.location.assign('drop_off_reservation.php'); </script>";
         }
		 if (isset($_POST['service_order'])) {
      
             echo "<script> window.location.assign('serviceorder.php'); </script>";
         }
		 if (isset($_POST['add_new_tool'])) {
      
             echo "<script> window.location.assign('addnewtool.php'); </script>";
         }
		 if (isset($_POST['sell_tool'])) {
      
             echo "<script> window.location.assign('selltool.php'); </script>";
         }
		 if (isset($_POST['generate_reports'])) {
      
             echo "<script> window.location.assign('generatereports.php'); </script>";
         }
         if (isset($_POST['exit'])) {
             session_destroy();
             echo "<script> window.location.assign('index.php'); </script>";
         }
        
      ?>

      <form action = '' method = "post">
  
         <div>
            <p><button type="submit" value="pick_up" name="pick_up">Pick-up Reservation</button></p>
            <p><button type="submit" value="drop_off" name="drop_off">Drop-off Reservation</button></p>
            <p><button type="submit" value="service_order" name="service_order">Service Order</button></p>
            <p><button type="submit" value="add_new_tool" name="add_new_tool">Add New Tool</button></p>
            <p><button type="submit" value="sell_tool" name="sell_tool">Sell Tool</button></p>
            <p><button type="submit" value="generate_reports" name="generate_reports">Generate Reports</button></p>
            <p><button type="submit" value="exit" name="exit">Exit</button></p>

            <hr>
         
         </div>
      </form>

   </body>
</html>

  