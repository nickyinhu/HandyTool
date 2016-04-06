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
      <link href = "css/bootstrap.min.css" rel = "stylesheet">
      
      <style>
         body {
            padding-top: 40px;
            padding-bottom: 40px;
            /*background-color: #ADABAB;*/
         }
         
         .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
            color: #017572;
         }
         
         .form-signin .form-signin-heading,
         .form-signin .checkbox {
            margin-bottom: 10px;
         }
         
         .form-signin .checkbox {
            font-weight: normal;
         }
         
         .form-signin .form-control {
            position: relative;
            height: auto;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            box-sizing: border-box;
            padding: 10px;
            font-size: 16px;
         }
         
         .form-signin .form-control:focus {
            z-index: 2;
         }
         
         .form-signin input[type="email"] {
            margin-bottom: -1px;
            border-bottom-right-radius: 0;
            border-bottom-left-radius: 0;
            border-color:#017572;
         }
         
         .form-signin input[type="password"] {
            margin-bottom: 10px;
            border-top-left-radius: 0;
            border-top-right-radius: 0;
            border-color:#017572;
         }
         
         h2{
            text-align: center;
            color: #017572;
         }
      </style>
      
   </head>
	
   <body>
      
      <h2>Enter User ID and Password</h2> 
      <div class = "container form-signin">
         
         <?php
            include('dbconn.php');
            global $conn;
            $msg = '';
            if (isset($_POST['accounttype']) && isset($_POST['login']) && !empty($_POST['username']) 
               && !empty($_POST['password'])) {
               $username = $_POST['username'];
               $password = $_POST['password'];
               $database = $_POST['accounttype'];
               // echo "You have entered '$username'" . "<br>";
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
      </div> <!-- /container -->
      
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
               value="customer">Customer
         </form>
			
         <!-- Click here to <a href = "logout.php" tite = "Logout">Logout. -->
         
      </div> 
      
   </body>
</html>
