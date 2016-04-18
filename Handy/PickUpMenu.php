<html lang = "en">
    <head>
        <title>Handyman Tool</title>
        <style type="text/css">
           label {
                display:inline-block;
                height: 8px;
                margin: 10 auto;
                width: 150px;
                font-weight: normal;
            }
        </style>
    </head>

    <body>
        <h4>Reservation Pickup</h4>
        <?php
            session_start();
            include('dbconn.php');
            global $conn;
            if(empty($_SESSION['login_user'])){
                die("You are not login yet!");
                header("refresh: 3; url = index.php");
            }

            //did not find the reservation, go back to main menu
            if(empty($_SESSION['res_num'])){
                echo "<script> window.location.assign('clerk.php'); </script>";
            }
            $Res = $_SESSION['res_num'];
            $sql_res = "select * from reservation where resv_number = '$Res'"; 
            $result_res = $conn->query($sql_res) or die("Error querying the database");

            echo "Reservation Number: ".$Res."<br>";

            //tools required
            $sql_res_contains = "select * from reservation_contains where resv_number = $Res";
            $result = $conn->query($sql_res_contains) or die("Error querying the database");
            $num = 1;
            echo "<p>Tools Required:</p>";
            if ($result->num_rows > 0) {
                while($row_res_contains = $result->fetch_assoc()){
                    //each row has a resNum and toolID
                    $tool_id = $row_res_contains['tool_id'];
                    //find tool info according to tool id
                    $sql_tool = "select * from tools where tool_id = $tool_id";
                    $result_tool = $conn->query($sql_tool);
                    $row_tool = $result_tool->fetch_assoc();
                    $abbr = $row_tool['abbr_description'];
                    //echo tool id and abbr
                    echo "<p><h4>$num: Tool [$tool_id] $abbr</h4></p>";
                    $num = $num + 1;
                }
            }
            //deposit required and estimated cost
            $row_res = $result_res->fetch_assoc();
            $deposit = $row_res['total_deposit'];
            $cost = $row_res['total_price'] + $deposit;
            $_SESSION['deposit'] = $deposit;
            $_SESSION['cost'] = $cost;

            echo "<label>Deposit Required:</label>$ $deposit<br>";
            echo "<label>Estimated Cost:</label>$ $cost<br>";

            $tool_detail = "";
            //tool ID detail
            if(isset($_POST['viewdetail'])){
                $_SESSION['detail_tool_id']= $_POST['detail'];
                echo "<script> window.location.assign('tooldetail.php'); </script>";
            }
                
                
            if(isset($_POST["complete"])) {
                if ($_POST['credit_card']
                    && $_POST['expire_date']
                    && is_numeric($_POST['credit_card'])
                    && is_numeric($_POST['expire_date'])
                    && strlen($_POST['expire_date']) == 4
                    && strlen($_POST['credit_card']) >= 15
                    && strlen($_POST['credit_card']) <= 16) {
                    $credit_card = $_POST['credit_card'];
                    $expire_date = $_POST['expire_date'];
                    $clerk_id = $_SESSION['login_user'];
                    $contract_sql = "UPDATE reservation SET pickup_clerk_id = '$clerk_id',
                        credit_card = '$credit_card', exp_date = '$expire_date' WHERE resv_number = '$Res'";
                    $conn->query($contract_sql) or die("Error update database");
                    unset($_SESSION['res_num']);
                    $_SESSION['contract_num'] = $Res;
                    $_SESSION['credit_card_number'] = $credit_card; 
                    echo "<script> window.location.assign('RentalContract.php');</script>";
                } else {
                    echo '<script language="javascript">';
                    echo 'alert("Please Enter Credit card number and Expiration Date")';
                    echo '</script>';
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

        <div>
            <form action = '' method = "post">
            <hr>
                <label>Tool ID</label><input type = "text" name = "detail">
                <input type = "submit" name = "viewdetail" value = "View Details">
                <h4><p><?php echo $tool_detail ?></p></h4>
                <label>Credit Card Number</label><input type = "text" name = "credit_card"><br>
                <label>Expiration</label><input type = "text" name = "expire_date" placeholder="YYMM"><br>
                <br><button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "complete">Complete Pick-Up</button>
                <hr>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
            </form>
        </div>
    </body>
</html>
