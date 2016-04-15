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

            include('sql.php');
            $sql = get_availability($tooltype,$startdate,$enddate);

            $result = $conn->query($sql) or die('Error querying database.');

            if ($result->num_rows > 0 ) {
                echo '<p><table border="1">';
                echo '<tr><th>Tool ID</th><th>Abbr. Description</th><th>Deposit ($)</th><th>Price/Day ($)</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr><td align="center">',     $row['tool_id'],
                         '</td><td align="left">&nbsp', $row['abbr'],
                         '</td><td align="center">',    $row['deposit'],
                         '</td><td align="center">',    $row['price'],'</td></tr>';
                }
                echo '</table></p><hr>';
                $condition = 1;
                if (isset($_POST['submit'])) {
                    if (isset($_POST['tool_id']) && is_numeric($_POST['tool_id'])) {
                        $_SESSION['detail_tool_id']= $_POST['tool_id'];
                        echo "<script> window.location.assign('tooldetail.php'); </script>";
                    } else {
                        echo '<script language="javascript">';
                        echo 'alert("Please Enter a Valid Tool ID!")';
                        echo '</script>';
                    }
                }
            } elseif (isset($_POST['return'])) {
                echo "<script> window.location.assign('checkavailability.php'); </script>";
            }
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
        ?>
     
        <div class = "container">
            <form class = "form-signin" role = "form" action = "" method = "post">
                <?php if($condition == 1) { ?>
                    <p>
                    Part # <input type = "text" class = "form-control" name = "tool_id" autofocus>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "submit">Submit</button>
                    </p>
                <?php } else { ?>
                    <h4></p>Your search returns no results, please adjust your search</p></h4>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "return">Return</button>
                <?php } ?>
                <p>
                <hr>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
                </p>
            </form>
        </div>
   </body>
</html>