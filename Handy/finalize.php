<html lang = "en">

    <head>
        <title>Handyman Tool</title>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>


    <body>
        <h2>Reservation Summary</h2>

        <h2>Tools Desired</h2>
        <?php
            session_start();
            include('dbconn.php');
            global $conn;
            if (empty($_SESSION['login_user'])) {
                die("You are not login yet!");
                header("refresh:3;url=index.php");
            }
            if (!isset($_SESSION['tool_list']) || empty($_SESSION['tool_list'])) {
                $email = $_SESSION['login_user'];
                $start = $_SESSION['startdate'];
                $end = $_SESSION['enddate'];
                $tool_list = $_SESSION['tool_list'];
                $total_rental = $_SESSION['rental'];
                $total_deposit = $_SESSION['deposit'];

                $id_list = join(',',array_keys($tool_list));
                $resv_sql = "
                    INSERT INTO reservation (start_date, end_date, total_price, total_deposit, customer_email)
                    VALUES ('$start', '$end', '$total_rental', '$total_deposit', '$email')";
                $last_id = 0;
                if ($conn->query($resv_sql) === TRUE) {
                    $last_id = $conn->insert_id;
                } else {
                    die("Error: " . $resv_sql . "<br>" . $conn->error);
                }
                $stmt = $conn->prepare("INSERT INTO reservation_contains (resv_number, tool_id) VALUES ('$last_id',?)");
                ksort($tool_list);
                foreach (array_keys($tool_list) as $id) {
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                }
            }
            unset($resv_sql);
            unset($tool_list);
            unset($_SESSION['tool_list']);
            unset($_SESSION['startdate']);
            unset($_SESSION['enddate']);
            unset($_SESSION['rental']);
            unset($_SESSION['deposit']);
            if (isset($_POST['back'])) {
                echo "<script> window.location.assign('customer.php'); </script>";
            }
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
        ?>

        <div class = "container">
            <form class = "form-signin" role = "form" method = "post">
                <p><h3><?php 
                ksort($tool_list);
                foreach ($tool_list as $id => $abbr) {
                    echo "<p>$id. $abbr</p>";
                }?></h3></p>
                <hr>
                <p>Start Date <?php echo $start ?></p>
                <p>End Date&nbsp <?php echo $end ?></p>
                <p>Total Rental&nbsp&nbsp <?php echo "$$total_rental" ?></p>
                <p>Total Deposit <?php echo "$$total_deposit" ?></p>
                </p>
                <br>
                <p>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" id = "back" name = "back">Back to Main Menu</button>
                </p>
                <p>
                <hr>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
                </p>
            </form>
        </div>
   </body>
</html>