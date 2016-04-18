<html lang = "en">

    <head>
        <title>Handyman Tool</title>
        <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    </head>


    <body>
        <?php
            session_start();
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
            echo "<h2>$year $monthName Clerk Report </h2>";
            $clerk_report_sql = get_clerk_report($year,$month);
            echo $clerk_report_sql;
            $clerk_report_result = $conn->query($clerk_report_sql) or die("Error query database");
            if ($clerk_report_result->num_rows > 0) {
                echo '<p><table border="1">';
                echo '<tr><th>Clerk ID</th><th>First Name</th><th>Last Name</th><th>Pickups</th><th>Dropoffs</th>';
                while ($row = $clerk_report_result->fetch_assoc()) {
                    echo '<tr><td align="left">&nbsp',  $row['clerk_id'],
                         '</td><td align="left">&nbsp', $row['first_name'],
                         '</td><td align="left">&nbsp', $row['last_name'],
                         '</td><td align="center">',    $row['pickup'],
                         '</td><td align="center">',    $row['dropoff'],'</td></tr>';
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