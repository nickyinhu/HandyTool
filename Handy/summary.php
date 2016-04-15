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
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
            if (!isset($_SESSION['tool_list']) && empty($_)) {
                die('&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please add at least one tool to your list!</span>');
            }
            $start = $_SESSION['startdate'];
            $end = $_SESSION['enddate'];
            $tool_list = $_SESSION['tool_list'];
            $total_rental = 0;
            $total_deposit = 0;

            $id_list = join(',',array_keys($tool_list));
            $sql = "
                SELECT abbr_description as abbr,
                    (tools.rental_price * (DATEDIFF('$end', '$start') + 1)) AS rental, 
                    (tools.deposit * (DATEDIFF('$end', '$start') + 1)) AS deposit
                FROM tools
                WHERE tool_id in ($id_list)";
            $result = $conn->query($sql) or die('Error querying database.');
            if ($result->num_rows > 0 ) {
                $row = $result->fetch_assoc();
                $total_rental = $row['rental'];
                $total_deposit = $row['deposit'];
            }

            if (isset($_POST['confirm'])) {
                $_SESSION['rental'] = $total_rental;
                $_SESSION['deposit'] = $total_deposit;
                echo "<script> window.location.assign('finalize.php'); </script>";
            }
            if (isset($_POST['reset'])) {
                unset($_SESSION['tool_list']);
                unset($_SESSION['startdate']);
                unset($_SESSION['enddate']);
                echo "<script> window.location.assign('makereservation.php'); </script>";
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
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" id = "confirm" name = "confirm">Submit</button>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" id = "reset" name = "reset">Reset</button>
                </p>
            </form>
        </div>
   </body>
</html>