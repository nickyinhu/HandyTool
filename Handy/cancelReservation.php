<?php session_start(); ?>
<html lang = "en">
    <head>
        <title>Handyman Tool</title>
    </head>

    <body>
        <h2>Cancel Reservation</h2>
        <?php
            include('dbconn.php');
            global $conn;
            if(empty($_SESSION['login_user'])){
                die("You are not login yet!");
                header("refresh: 3; url = index.php");
            }
            $condition = 0;
            $email = $_SESSION['login_user'];
            $sql = "select * from reservation where customer_email = '$email' and pickup_clerk_id is null and start_date >= curdate()";
            $result = $conn->query($sql) or die("Error query database");
            if ($result->num_rows > 0) {
                $condition = 1;
            } else {
                echo '<script language="javascript">';
                echo 'alert("No Available Reservation for Cancellation")';
                echo '</script>';
                echo "<script> window.location.assign('customer.php'); </script>";
            }
            if (isset($_POST['cancel'])) {
                if (!$_POST['resv']) {
                    echo '<script language="javascript">';
                    echo 'alert("Please Select a Reservation for Cancellation")';
                    echo '</script>';
                } else {
                    $resv_number = $_POST['resv'];
                    $resv_contains_del_sql = "Delete From reservation_contains where resv_number = $resv_number";
                    $resv_del_sql = "Delete From reservation where resv_number = $resv_number";
                    $delete_result = $conn->query($resv_contains_del_sql) or die("Error delete from database");
                    $delete_result = $conn->query($resv_del_sql) or die("Error delete from database");
                    echo '<script language="javascript">';
                    echo 'alert("Reservation ' . $resv_number . ' has been Canceled")';
                    echo '</script>';
                    $result = $conn->query($sql) or die("Error query database");
                }
            }
            if (isset($_POST['back'])) {
                    echo "<script> window.location.assign('customer.php'); </script>";
            }
            if (isset($_POST['logout'])) {
                    session_destroy();
                    echo "<script> window.location.assign('index.php'); </script>";
            }
        ?>

        <form action = '' method = "post">
            <?php if ($condition) {
                echo '<p><select name="resv">';
                echo '<option value="">Please Select Reservation</option>';
                while ($row = $result->fetch_assoc()) {
                    $resv_num = $row['resv_number'];
                    $start_date = $row['start_date'];
                    echo "<option value=\"$resv_num\">Resv #$resv_num Start on $start_date</option>";
                }
                echo '</select></p>';
                echo '<p><button type = "submit" name = "cancel">Submit</button></p>';
            } ?>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
        </form>
    </body>
</html>
