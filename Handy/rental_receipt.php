<?php session_start(); ?>
<html lang = "en">
    <head>
        <title>Handyman Tool</title>
        <style type="text/css">
           label {
                display:inline-block;
                height: 8px;
                margin: 10 auto;
                width: 120px;
                font-weight: 700;
            }
        </style>
    </head>
    <body>

        <h4><i>HANDYMAN TOOLS RECEIPT</i></h4>
        <?php
           
            include('dbconn.php');
            global $conn;
            if(empty($_SESSION['login_user'])){
                die("You are not login yet!");
                header("refresh: 3; url = index.php");
            }
            //display reseravation number
            if(isset($_SESSION['res_num'])) {
                echo "<h4>Reservation Number: ".$_SESSION['res_num'] . "</h4>";
            } else {
                die("You reached this page by error!");
                header("refresh: 2; url = clerk.php");
            }
            $res_num = $_SESSION['res_num'];
            $clerk_id = $_SESSION['login_user'];
            //find clerk name according to clerk id
            $sql_clerk = "select first_name, last_name from clerk where clerk_id = '$clerk_id'";
            $result_clerk = $conn->query($sql_clerk) or die("Error querying the database");
            $row_clerk = $result_clerk->fetch_assoc();
            //display clerk name
            echo "<p><label>Clerk on Duty:</label> ".$row_clerk['first_name']." ".$row_clerk['last_name']."</p>";
            //update reservation table, add dropoff clerk id

            //customer name
            //find out customer email
            $sql_reservation = "select * from reservation where resv_number = $res_num";
            $result_reservation = $conn->query($sql_reservation);
            $reservation_row = $result_reservation->fetch_assoc();
            $customer_email = $reservation_row['customer_email'];
            //find out customer name according to email
            $sql_cus_name =  "select first_name, last_name from customer where email = '$customer_email'";
            $result_cus_name = $conn->query($sql_cus_name);
            $row_cus_name = $result_cus_name->fetch_assoc();
            echo "<p><label>Customer Name:</label> ". $row_cus_name['first_name']." ".$row_cus_name['last_name']."</p>";

            //start date and end date
            //display credit card
            echo "<p><label>Credit Card #:</label> ".$reservation_row['credit_card']."</p>";
            echo "<p><label>Start Date:</label> ".$reservation_row['start_date'];
            echo "<p><label>End Date:</label> ".$reservation_row['end_date'];

            //display rental price and deposit held 

            $rental_price = $reservation_row['total_price'];
            $deposit_held = $reservation_row['total_deposit'];
            $total = $rental_price + $deposit_held;

            echo "<p><label>Rental Price:</label> $".$rental_price."</p>";
            echo "<p><label>Deposit Held:</label> $".$deposit_held."</p>";
            echo "             --------------------";
            echo "<p><label>Total:</label>        $".$total."</p>";
            if (isset($_POST['back'])) {
                unset($_SESSION['res_num']);
                echo "<script> window.location.assign('clerk.php'); </script>";
            }
            if (isset($_POST['logout'])){
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
    
        ?>
        <form action = '' method = "post">
            <div>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
            </div>
        </form>
    </body>
</html>
