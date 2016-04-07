<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>

   <body>
      <h2>Service Order Request</h2> 
      <?php
         session_start();
         $login_user = $_SESSION['login_user'];
         include('dbconn.php');
         global $conn;
         echo $login_user;
         if (!$login_user) {
            die("You are not login yet!");
         }
      ?>

      <form>
      Tool ID: <input type="text" name="toolid"><br>
      Starting Date: <input type="text" name="startdate"><br>
      Ending Date: <input type="text" name="enddate"><br>
      Estimated Cost of Repair ($): <input type="text" name="cost"><br>
      <div>
         <button type="submit" value="Submit">Submit New Tool</button>
      </div>
      </form>

   </body>
</html>

  