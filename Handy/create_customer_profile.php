<?php
   ob_start();
   session_start();
?>

<?
   // error_reporting(E_ALL);
   // ini_set("display_errors", 1);
?>

<html lang = "en">

   <head>
      <title>Handyman Tool</title>
   </head>

   <body>
      <h2>Create a Profile</h2> 
      <h3>Handyman Tools Rental requires a valid profile for every user before they can make reservations</h3>>
      <?php
         include('dbconn.php');
         global $conn;
         $msg = '';
         if (isset($_POST['accounttype']) && isset($_POST['login']) && !empty($_POST['username']) 
            && !empty($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $database = $_POST['accounttype'];
            $sql = '';
            if ($database == 'clerk') {
               $sql = "SELECT clerk_id, first_name from $database where clerk_id = '$username' and password = '$password'";
            } else {
               $sql = "SELECT email, first_name from $database where email = '$username' and password = '$password'";
            }
            $result = $conn->query($sql) or die('Error querying database.');;
            if ($result->num_rows > 0 ) {
               if ($database == 'clerk' ) {
                  echo "<script> window.location.assign('clerk.php'); </script>";
               } else {
                  echo "<script> window.location.assign('customer.php'); </script>";
               }
            }else {
               $msg = 'Wrong credentials! Redirecting to registration...';
               if ($database == 'clerk' ) {
                  header("refresh:3;url=clerk_reg.php");
               } else {
                  header("refresh:3;url=customer_reg.php");
               }
            }
         }
      ?>

      <div class = "container">
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <h4 class = "form-signin-heading"><?php echo $msg; ?></h4>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "User ID"
               required autofocus></br>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "Password" required>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
            <br>
               Account Type
               <input type="radio" name="accounttype" required
               <?php if (isset($accounttype) && $accounttype=="clerk") echo "checked";?>
               value="clerk">Clerk
               <input type="radio" name="accounttype"
               <?php if (isset($accounttype) && $accounttype=="customer") echo "checked";?>
               value="customer" CHECKED >Customer
         </form>
      </div>
   </body>
</html>
