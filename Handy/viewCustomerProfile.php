<?php session_start(); ?>
<html lang = "en">


    <head>
        <title>Handyman Tool</title>
        <style type="text/css">
            label{
              display:inline-block;
              height: 20px;
              margin: 0 auto;
              width: 90px;
            }
        </style>
    </head>


    <body>
        <h2>Customer Prifile</h2>
   
        <?php
           
            include('dbconn.php');
            include('sql.php');

            global $conn;
            if (empty($_SESSION['login_user'])) {
                die("You are not login yet!");
                header("refresh:3;url=index.php");
            }
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
          
            $email = $_SESSION['login_user'];
    
            $sql = "SELECT email, first_name, last_name, home_phone, work_phone, address FROM customer WHERE email='$email' ";

            $result = $conn->query($sql) or die('Error querying database.');
            if ($result->num_rows > 0 ) {
                $row = $result->fetch_assoc();
                $email = $row['email'];
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
                $home_phone = $row['home_phone'];
                $work_phone = $row['work_phone'];
                $address = $row['address'];
                
            }
            $customer_resv_sql = get_customer_profile($email);

            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
            if (isset($_POST['back'])) {
                unset($_SESSION['tool_list']);
                unset($_SESSION['startdate']);
                unset($_SESSION['enddate']);
                unset($_SESSION['resv_number']);
                echo "<script> window.location.assign('customer.php'); </script>";
            }
        ?>

        <div class = "container">
            <form class = "form-signin" role = "form" method = "post">
            
                <hr>
                <p><label>Email:</label>  <?php echo $email ?></p>
                <p><label>First Name:</label>  <?php echo $first_name ?></p>
                <p><label>Last Name:</label>  <?php echo $last_name ?></p>
                <p><label>Home Phone:</label>  <?php echo $home_phone ?></p>
                <p><label>Work Phone:</label>  <?php echo $work_phone ?></p>
                <p><label>Address:</label>  <?php echo $address ?></p>
           
      
             <hr>
             <h3> Reservation History</h3>
             <p>
             <?php
                 $customer_resv_result = $conn->query($customer_resv_sql) or die('Error querying database.');
                if ($customer_resv_result->num_rows > 0 ) {
                    echo '<p><table border="1">';
                    echo '<tr><th>Resv #</th><th>Tools</th><th>Start</th><th>End</th><th>Rental Price</th><th>Deposit</th><th>Pick-up Clerk</th><th>Drop-off Clerk</th></tr>';
                    while ($row = $customer_resv_result->fetch_assoc()) {
                        echo '<tr><td align="center">', $row['resv_number'],
                         '</td><td align="left">&nbsp', $row['abbr'],
                         '</td><td align="center">',    $row['start'],
                         '</td><td align="center">',    $row['end'],
                         '</td><td align="center">$',    $row['rental_price'],
                         '</td><td align="center">$',    $row['deposit'],
                         '</td><td align="left">&nbsp',    $row['pickup_clerk'],
                         '</td><td align="left">&nbsp',    $row['dropoff_clerk'],
                         '</td></tr>';
                    }
                    echo '</table></p>';
                }
            ?>
            </p>
  
            <hr>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
            </p>
          </form>
        </div>
   </body>
</html>