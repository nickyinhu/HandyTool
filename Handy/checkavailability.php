<html lang = "en">

    <head>
        <title>Handyman Tool</title>
    </head>

    <body>
        <h2>Customer</h2>
        <?php
            session_start();
            include('dbconn.php');
            global $conn;
            if (empty($_SESSION['login_user'])) {
                die("You are not login yet!");
            }
            $msg1;
            $msg2;
            $email = $_SESSION['login_user'];
            if (isset($_POST['submit'])) {
                if (empty($_POST['tooltype'])) {
                    echo '<span style="color:#FF0000;text-align:center;">Please select your Tool Category!</span>';
                }
                elseif (!validateDate($_POST['startdate'])) {
                    $msg1 = '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please select a valid Start Date!</span>';
                }
                elseif (!validateDate($_POST['enddate'])) {
                    $msg2 = '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please select a valid End Date!</span>';
                }
                elseif (checkStartEnd($_POST['startdate'],$_POST['enddate'])) {
                    $msg1 = '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Start Date cannot be greater than End Date!</span>';
                } else {
                    $_SESSION['tooltype']= $_POST['tooltype'];
                    $_SESSION['startdate']= $_POST['startdate'];
                    $_SESSION['enddate']= $_POST['enddate'];
                    echo "<script> window.location.assign('toolavailability.php'); </script>";
                }
            }

            function validateDate($date)
            {
                $d = DateTime::createFromFormat('Y-m-d', $date);
                return $d && $d->format('Y-m-d') === $date;
            }
            function checkStartEnd($start,$end)
            {
                $timestamp1 = strtotime($start);
                $timestamp2 = strtotime($end);
                return ($timestamp1>$timestamp2);
            }

        ?>

      
        <div class = "container">
            <form class = "form-signin" role = "form" action = "" method = "post">
                <p>Select Tool Category</p>
                <hr>
                <p>
                <input type="radio" name="tooltype" value="hand">Hand Tools
                </p>
                <p>
                <input type="radio" name="tooltype" value="construction" >Construction Equipment
                </p>
                <p>
                <input type="radio" name="tooltype" value="power">Power Tools
                </p>
                <hr>

                <p>
                Start Date&nbsp<input type = "text" class = "form-control" placeholder="YYYY-MM-DD"
                   name = "startdate" required autofocus><?php echo $msg1; ?>
                </p>
                <p>
                End Date &nbsp<input type = "text" class = "form-control" placeholder="YYYY-MM-DD" 
                   name = "enddate" required><?php echo $msg2; ?>
                </p>   
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "submit">Submit</button>
            </form>
        </div>
   </body>
</html>