<?php session_start(); ?>
<html lang = "en">

   <head>
      <title>Handyman Tool</title>
   </head>

   <body>
      <h2>Enter User ID and Password</h2> 
      <?php
      
        
         include('dbconn.php');
         global $conn;
         if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
            $username = $_POST['username'];
            $password = $_POST['password'];
            if (empty($_POST['accounttype'])) {
               echo '<span style="color:#FF0000;text-align:center;">Please select Account Type!</span>';
            } else {
               $database = $_POST['accounttype'];
               $sql = '';
               if ($database == 'clerk') {
                  $sql = "SELECT clerk_id, first_name, password from $database where clerk_id = '$username'";
               } else {
                  $sql = "SELECT email, first_name, password from $database where email = '$username'";
               }
               $result = $conn->query($sql) or die('Error querying database.');
               if ($result->num_rows > 0 ) {
                  $row = $result->fetch_assoc();
                  if ($row['password'] == $password) {
                     $_SESSION['login_user']= $username;
                     if ($database == 'clerk' ) {
                        echo "<script> window.location.assign('clerk.php'); </script>";
                     } else {
                        echo "<script> window.location.assign('customer.php'); </script>";
                     }
                  } else {
                     echo '<script language="javascript">';
                     echo 'alert("Please check your password")';
                     echo '</script>';
                  }
               }else {
                  echo '<script language="javascript">';
                  echo 'alert("Wrong credentials! Redirecting to registration")';
                  echo '</script>';
                  if ($database == 'clerk' ) {
                    echo "<script> window.location.assign('createClerkProfile.php')</script>";
                  } else {
                    echo "<script> window.location.assign('createCustomerProfile.php')</script>";
                  }
               }
            }
         }
         if (isset($_POST['reg'])) {
           $database = $_POST['accounttype'];
           if ($database == 'clerk') {
                echo "<script> window.location.assign('createClerkProfile.php')</script>";
           } else {
                echo "<script> window.location.assign('createCustomerProfile.php')</script>";
           }
         }
      ?>

      <div class = "container">
         <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
            ?>" method = "post">
            <p>
            <input type = "text" class = "form-control" 
               name = "username" placeholder = "User ID"
               required autofocus>
            </p>
            <p>
            <input type = "password" class = "form-control"
               name = "password" placeholder = "Password" required>
            </p>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "login">Login</button>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" 
               name = "reg">Register</button>
            <br>
               Account Type
               <input type="radio" name="accounttype"
               value="clerk">Clerk
               <input type="radio" name="accounttype"
               value="customer" checked="checked">Customer
         </form>
      </div>
   </body>
</html>
