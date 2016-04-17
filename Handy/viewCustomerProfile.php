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
           
            # reservation history 
             <hr>
             
              
                <hr>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
                </p>
          </form>
        </div>
   </body>
</html>