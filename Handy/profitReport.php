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
            echo "<h2>$year $monthName Profit Report </h2>";
            $tool_report_sql = get_tool_report($year,$month);
            $tool_report_result = $conn->query($tool_report_sql) or die("Error query database");
            if ($tool_report_result->num_rows > 0) {
                echo '<p><table border="1">';
                echo '<tr><th>Tool ID</th><th>Description</th><th>Type</th><th>Rental ($)</th>';
                echo '<th>Cost ($)</th><th>Profit ($)</th><th>Rental Days</th><th>Service Days</th></tr>';
                while ($row = $tool_report_result->fetch_assoc()) {
                    switch ($row['tool_type']) {
                        case 'hand':
                            $type = 'Hand';
                            break;
                        case 'construction':
                            $type = 'Constr';
                            break;
                        case 'power':
                            $type = 'Power';
                            break;
                    }
                    echo '<tr><td align="center">',     $row['tool_id'],
                         '</td><td align="left">&nbsp', $row['abbr'],
                         '</td><td align="left">&nbsp', $type,
                         '</td><td align="center">',    $row['rental_profit'],
                         '</td><td align="center">',    $row['cost'],
                         '</td><td align="center">',    $row['total_profit'],
                         '</td><td align="center">',    $row['rental_days'],
                         '</td><td align="center">',    $row['service_days'],'</td></tr>';
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