<html lang = "en">

    <head>
        <title>Handyman Tool</title>
    </head>

    <body>
        <h2>Tool Availability</h2>
        <?php
            session_start();
            include('dbconn.php');
            global $conn;
            if (empty($_SESSION['login_user'])) {
                die("You are not login yet!");
            }
            $email     = $_SESSION['login_user'];            
            $tooltype  = $_SESSION['tooltype'];
            $startdate = $_SESSION['startdate'];
            $enddate   = $_SESSION['enddate'];
            $condition = 0;
            $sql = "
                select t.tool_id, t.abbr_description as abbr, t.deposit as deposit, t.purchase_price as price
                from tools as t
                where t.sold_date is null
                and t.tool_type = '$tooltype'
                and not exists
                (
                    select t.tool_id
                    from reservation_contains as rc
                    inner join reservation as r on r.resv_number = rc.resv_number
                    inner join service_request as sr on sr.tool_id = rc.tool_id
                    where rc.tool_id = t.tool_id
                    and (
                           (r.start_date <= '$startdate' and r.end_date >= '$startdate')
                        or (r.start_date <= '$enddate' and r.end_date >= '$enddate')
                        or (r.start_date >= '$startdate' and r.start_date <= '$enddate')
                        or (sr.start_date <= '$startdate' and sr.end_date >= '$startdate')
                        or (sr.start_date <= '$enddate' and sr.end_date >= '$enddate')
                        or (sr.start_date >= '$startdate' and sr.start_date <= '$enddate')
                    )
                )";

            $result = $conn->query($sql) or die('Error querying database.');

            if ($result->num_rows > 0 ) {
                echo '<p><table border="1">';
                echo '<tr><th>Tool ID</th><th>Abbr. Description</th><th>Deposit ($)</th><th>Price/Day ($)</th></tr>';
                while ($row = $result->fetch_assoc())
                    echo '<tr><td align="center">', $row['tool_id'],
                         '</td><td align="left">&nbsp', $row['abbr'],
                         '</td><td align="center">', $row['deposit'],
                         '</td><td align="center">', $row['price'],'</td></tr>';
                echo '</table></p><hr>';
                $condition = 1;
                if (isset($_POST['submit']) && isset($_POST['tool_id'])) {
                    $_SESSION['tool_id']= $_POST['tool_id'];
                    echo "<script> window.location.assign('tooldetail.php'); </script>";
                }
            } elseif (isset($_POST['return'])) {
                echo "<script> window.location.assign('checkavailability.php'); </script>";
            }
        ?>
     
        <div class = "container">
            <form class = "form-signin" role = "form" action = "" method = "post">
                <?php if($condition == 1) { ?>
                    <p>
                    Part # <input type = "text" class = "form-control" name = "tool_id" required autofocus>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "submit">Submit</button>
                    </p>
                <?php } else { ?>
                    <h4></p>Your search returns no results, please adjust your search</p></h4>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "return">Return</button>
                <?php } ?>
            </form>
        </div>
   </body>
</html>