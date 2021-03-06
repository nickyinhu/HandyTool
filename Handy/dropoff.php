<?php session_start(); ?>
<html lang = "en">
    <head>
        <title>Handyman Tool</title>
    </head>

    <body>
        <h2>Drop off</h2>
        <?php
            include('dbconn.php');
            global $conn;
            if(empty($_SESSION['login_user'])){
                die("You are not login yet!");
                header("refresh: 3; url = index.php");
            }
            $condition = 0;
            $sql = "select * from reservation r join customer c on r.customer_email = c.email where pickup_clerk_id is not null and dropoff_clerk_id is null and end_date = curdate()";
            $result = $conn->query($sql) or die("Error query database");
            if ($result->num_rows > 0) {
                $condition = 1;
            } else {
                echo '<script language="javascript">';
                echo 'alert("No Available Reservation for Dropoff")';
                echo '</script>';
            }
            if (isset($_POST['drop_off'])) {
                if (!$_POST['resv']) {
                    echo '<script language="javascript">';
                    echo 'alert("Please Select a Reservation for Dropoff")';
                    echo '</script>';
                } else {
                    $_SESSION['res_num'] = $_POST['resv'];
                    echo "<script> window.location.assign('rental_receipt.php');</script>";
                }
            }
            if (isset($_POST['back'])) {
                    echo "<script> window.location.assign('clerk.php'); </script>";
            }
            if (isset($_POST['logout'])) {
                    session_destroy();
                    echo "<script> window.location.assign('index.php'); </script>";
            }
        ?>

        <form action = '' method = "post">
            <?php if ($condition) {
                echo '<p><select id="one" name="resv">';
                echo '<option value="">Please Select Reservation</option>';
                while ($row = $result->fetch_assoc()) {
                    $resv_num = $row['resv_number'];
                    $name = $row['first_name'] . ' ' . $row['last_name'];
                    echo "<option value=\"$resv_num\">Resv # $resv_num for $name</option>";
                }
                echo '</select></p>';
            } ?>
            <p><button type = "submit" name = "drop_off">Submit</button></p>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
        </form>
    </body>
</html>
