<?php session_start(); ?>
<html lang = "en">

    <head>
        <title>Handyman Tool</title>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>


    <body>
        <?php
           
            include('dbconn.php');
            include('sql.php');
            global $conn;
            if (empty($_SESSION['login_user'])) {
                die("You are not login yet!");
                header("refresh:3;url=index.php");
            }
            $year_month = $_SESSION['year_month'];
            list($year, $month) = explode('-', $year_month);
            $monthName = date("F", mktime(0, 0, 0, date($month), 10));
            echo "<h2>$year $monthName Customer Report </h2>";
            $customer_report_sql = get_customer_report($year,$month);
            $customer_report_result = $conn->query($customer_report_sql) or die("Error query database");
            if ($customer_report_result->num_rows > 0) {
                echo '<p><table border="1">';
                echo '<tr><th>Customer Email</th><th>First Name</th><th>Last Name</th><th>Rentals</th>';
                while ($row = $customer_report_result->fetch_assoc()) {
                    echo '<tr><td align="left">&nbsp',  $row['email'],
                         '</td><td align="left">&nbsp', $row['first_name'],
                         '</td><td align="left">&nbsp', $row['last_name'],
                         '</td><td align="center">',    $row['resvation_count'],'</td></tr>';
                }
                echo '</table></p>';
            }

            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
            if (isset($_POST['back'])) {
                unset($_SESSION['year_month']);
                echo "<script> window.location.assign('reportMenu.php'); </script>";
            }
        ?>

        <div class = "container">
            <form class = "form-signin" role = "form" method = "post">
                <p>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Report Menu</button>
                </p>
                <p>
                <hr>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
                </p>
            </form>
        </div>
   </body>
</html>