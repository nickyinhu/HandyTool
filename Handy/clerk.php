<?php session_start(); ?>
<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      <style type="text/css">
        label{
          display:inline-block;
          height: 28px;
          margin: 0 auto;
        }
      </style>
   </head>

   <body>
      <h2>Clerk</h2> 
      <?php
         if (empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         $login_user = $_SESSION['login_user'];
         echo "<h4>Clerk On Duty $login_user</h4>";
      ?>


      <div class = "container">
         <div>
            <label></label><button type="submit" onClick="location.href='pickup.php'">Pick-up Reservation</button></div>
         </div>
         <div>
            <label></label><button type="submit" onClick="location.href='dropoff.php'">Drop-Off Reservation</button></div>
         </div>
         <div>
            <label></label><button type="submit" onClick="location.href='serviceorder.php'">Service Order</button></div>
         </div>
         <div>
            <label></label><button type="submit" onClick="location.href='addnewtool.php'">Add New Tool</button></div>
         </div>
         <div class = "container">
         <div>
            <label></label><button type="submit" onClick="location.href='selltool.php'">Sell Tool</button></div>
         </div>
         <div>
            <label></label><button type="submit" onClick="location.href='reportMenu.php'">Generate Report</button></div>
         </div>
         <p>
         <div>
            <label></label><button type="submit" onClick="location.href='index.php'">Exit</button></div>
         </div>
         </p>
      

      </div>
   </body>
</html>