<html lang = "en">

    <head>
        <title>Handyman Tool</title>
    </head>

    <body>
        <h2>Customer</h2>
        <?php
            session_start();
            include('dbconn.php');
            include('functions.php');
            global $conn;
            if (empty($_SESSION['login_user'])) {
                die("You are not login yet!");
            }
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
            $msg1;
            $msg2;
            $email = $_SESSION['login_user'];
            if (isset($_POST['checkavai'])) {
                if (empty($_POST['tooltype'])) {
                    echo '<span style="color:#FF0000;text-align:center;">Please select your Tool Category!</span>';
                }
                elseif (!validateDate($_POST['startdate'])) {
                    $msg1 = '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please select a valid Start Date!</span>';
                }
                elseif (!validateDate($_POST['enddate'])) {
                    $msg2 = '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please select a valid End Date!</span>';
                }
                elseif (!laterthantoday($_POST['startdate'])) {
                    $msg1 = '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Start Date must be today or in the future!</span>';
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
                   name = "startdate" autofocus><?php echo $msg1; ?>
                </p>
                <p>
                End Date &nbsp<input type = "text" class = "form-control" placeholder="YYYY-MM-DD" 
                   name = "enddate"><?php echo $msg2; ?>
                </p>   
                <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "checkavai">Submit</button>
                <p>
                <hr>
                    <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
                </p>
            </form>
        </div>
   </body>
</html>