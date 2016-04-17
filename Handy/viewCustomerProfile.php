<html lang = "en">


    <head>
        <title>Handyman Tool</title>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>


    <body>
        <h2>Prifile</h2>
   
        <?php
            session_start();
            include('dbconn.php');
            
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
			
			
			$sql_resv_history = "SELECT resv_number, start_date, end_date, total_price, total_deposit  FROM reservation WHERE customer_email='$email' ORDER BY create_date DESC";

            $result2 = $conn->query($sql_resv_history) or die('Error querying database.');
            
            $resv_no = array();
            if ($result2->num_rows > 0 ) {
              
                echo '<p><table border="1">';
                echo '<tr><th>Resv_#</th><th>Tools</th><th>Start</th><th>End</th></tr>Rental Price($)</th></tr>Deposit($)</th></tr>Pick-up Clerk</th></tr>Drop-off Clerk</th></tr>';
                while ($row2 = $result2->fetch_assoc()) {
                    echo '<tr><td align="center">',     $row['resv_number'],
                         '</td><td align="left">&nbsp', $row['start_date'],
                         '</td><td align="center">',    $row['end_date'],
                         '</td><td align="center">',    $row['total_price'],
						 '</td><td align="center">',    $row['total_deposit'],
						 '</td></tr>';
                    $resv_no[] = $row['resv_number'];
                }
                echo '</table></p>';
           
            } 

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
                <p>Email Address:  <?php echo $email ?></p>
                <p>First Name:  <?php echo $first_name ?></p>
                <p>Last Name:  <?php echo $last_name ?></p>
                <p>Home Phone:  <?php echo $home_phone ?></p>
                <p>Work Phone:  <?php echo $work_phone ?></p>
                <p>Address:  <?php echo $address ?></p>
           
      
             <hr>
             <h3> Reservation History</h3>
  
             <hr>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
                </p>
          </form>
        </div>
   </body>
</html>