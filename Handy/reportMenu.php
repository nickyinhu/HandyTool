<?php session_start(); ?>
<html lang = "en">

    <head>
        <title>Handyman Tool</title>
        <style type="text/css">
            label{
              display:inline-block;
              height: 35px;
              margin: 0 auto;
              width: 50px;
            }
        </style>
    </head>


    <body>
        <h2>Monthly Report</h2>
        <?php
          
            include('dbconn.php');
            include('sql.php');
            global $conn;
            if (empty($_SESSION['login_user'])) {
                die("You are not login yet!");
                header("refresh:3;url=index.php");
            }
            if (isset($_POST['profit'])) {
                $_SESSION['year_month'] = $_POST['year_month'];
                echo "<script> window.location.assign('profitReport.php'); </script>";
            }
            if (isset($_POST['customer'])) {
                $_SESSION['year_month'] = $_POST['year_month'];
                echo "<script> window.location.assign('customerReport.php'); </script>";
            }
            if (isset($_POST['clerk'])) {
                $_SESSION['year_month'] = $_POST['year_month'];
                echo "<script> window.location.assign('clerkReport.php'); </script>";
            }

            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
            if (isset($_POST['back'])) {
                echo "<script> window.location.assign('clerk.php'); </script>";
            }
        ?>

        <div class = "container">
            <form class = "form-signin" role = "form" method = "post">
                <p>
                <select name="year_month">
                <?php
                  for ($i = 0; $i <= 24; $i++) {
                    $time = strtotime(sprintf("-$i months"));
                    $value = date('Y-m', $time);
                    $label = date('F Y', $time);
                    printf('<option value="%s">%s</option>', $value, $label);
                  }
                  ?>
                </select>
                </p>
                <h3><p>Please Select the Year and Month to generate the report</p></h3>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "profit">Profit Report</button>
                <p>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "customer">Customer Report</button>
                </p>
                <p>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "clerk">Clerk Progress Report</button>
                </p>
                <hr>
                
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
                </p>
            </form>
        </div>
   </body>
</html>