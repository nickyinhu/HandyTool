<html lang = "en">

   <head>
      <title>Handyman Tool</title>
   </head>

   <body>
        <h2>Add new tool</h2>
        <?php
            session_start();
            if (empty($_SESSION['login_user'])) {
                die("You are not login yet!");
            }
            $login_user = $_SESSION['login_user'];
            include 'dbconn.php';
            global $conn;
            if (isset($_POST['addnewacc'])) {
                if (empty($_SESSION['last_insert_tool_id']) || empty($_SESSION['last_insert_tool_type'])) {
                    echo '<script language="javascript">';
                    echo 'alert("You reached this page by Error, redirecting..")';
                    echo '</script>';
                    echo "<script> window.location.assign('clerk.php'); </script>";
                } elseif (!isset($_POST['accessory']) || $_POST['accessory'] == "") {
                    echo '<script language="javascript">';
                    echo 'alert("You need to type the name of the Accessory")';
                    echo '</script>';
                } else {
                    if (!isset($_SESSION['acc_list'])){
                        $_SESSION['acc_list'] = array();
                    }
                    $acc = $_POST['accessory'];
                    if (array_key_exists($acc, $_SESSION['acc_list'])) {
                        echo '<script language="javascript">';
                        echo 'alert("You have added '. $acc . ' already")';
                        echo '</script>';
                    } else {
                        $last_tool_id   = $_SESSION['last_insert_tool_id'];
                        $last_tool_abbr = $_SESSION['last_insert_tool_abbr'];
                        $insert_sql = "
                            INSERT INTO accessories(tool_id, accessory)
                            VALUES ('$last_tool_id', '$acc')
                        ";
                        if (mysqli_query($conn, $insert_sql)) {
                            $last_id = $conn->insert_id;
                            $_SESSION['acc_list'][$acc] = 1;
                            echo '<script language="javascript">';
                            echo "alert(\"Accessory $acc was added for Tool: $last_tool_id $last_tool_abbr\")";
                            echo '</script>';
                        }
                    }
                }
            }
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
            if (isset($_POST['back'])) {
                unset($_SESSION['last_insert_tool_id']);
                unset($_SESSION['last_insert_tool_type']);
                unset($_SESSION['last_insert_tool_abbr']);
                unset($_SESSION['acc_list']);
                echo "<script> window.location.assign('addnewtool.php'); </script>";
            }
        ?>

      <form action = '' method = "post">
          <p>
          Accessory Name: <input type = "text" class = "form-control" name = "accessory" autofocus>
          <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "addnewacc">Add Accessory</button>
          </p>
          <p>
          <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Back to Add Tool Menu</button>
          </p>
          <hr>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
        </p>
      </form>
   </body>
</html>

