<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      <style type="text/css">
        label{
          display:inline-block;
          width:180px;
          height: 30px;
        }
      </style>

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

            if (isset($_POST['addtool'])) {
                if (empty($_POST['abbr']) || empty($_POST['purchaseprice']) || empty($_POST['rentalprice']) || empty($_POST['deposit']) || empty($_POST['full'])) {
                    echo '<h4>&nbsp&nbsp<span style="color:#FF0000;text-align:center;">All fileds are required!</span></h4>';
                } elseif (!is_numeric($_POST['purchaseprice']) || !is_numeric($_POST['rentalprice']) || !is_numeric($_POST['deposit'])) {
                    echo '<h4>&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Purchase Price, Rental Price and Deposit must be numeric value!</span></h4>';
                } else {
                    $abbr          = $_POST['abbr'];
                    $purchaseprice = $_POST['purchaseprice'];
                    $rentalprice   = $_POST['rentalprice'];
                    $deposit       = $_POST['deposit'];
                    $tool_type     = $_POST['tooltype'];
                    $full          = $_POST['full'];
                    $sql = "INSERT INTO tools(abbr_description, full_description, purchase_price, rental_price, deposit, tool_type)
                            VALUES ('$abbr','$full','$purchaseprice','$rentalprice','$deposit','$tool_type')";

                    // Print response from MySQL
                    if (mysqli_query($conn, $sql)) {
                        $last_id = $conn->insert_id;
                        echo '<script language="javascript">';
                        echo 'alert("Tool ' . $abbr . ' was added successfully! Tool ID: ' . $last_id . '")';
                        echo '</script>';
                        $_SESSION['last_insert_tool_id']   = $last_id;
                        $_SESSION['last_insert_tool_type'] = $tool_type;
                        $_SESSION['last_insert_tool_abbr'] = $abbr;
                    } else {
                        die("Error: " . mysqli_error($con));
                    }
                }
            }

            if (isset($_POST['addacc'])) {
                if (!isset($_SESSION['last_insert_tool_id']) || !isset($_SESSION['last_insert_tool_type'])) {
                    echo '<script language="javascript">';
                    echo 'alert("You have to add the tool first before adding accessories")';
                    echo '</script>';
                } elseif ($_SESSION['last_insert_tool_type'] != 'power') {
                    $last_id = $_SESSION['last_insert_tool_id'];
                    echo '<script language="javascript">';
                    echo 'alert("You can only add accessories for power tool")';
                    echo '</script>';
                } else {
                    echo "<script> window.location.assign('addaccessories.php'); </script>";
                }
            }
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
        ?>

      <form action = '' method = "post">
        <label>Abbreviated Description:</label>
          <input type="text" name="abbr" align="right" ><br>
        <label>Purchase Price ($):</label>
          <input type="text" name="purchaseprice" ><br>
        <label>Rental Price ($ per day):</label>
          <input type="text" name="rentalprice" ><br>
        <label>Deposit Amount ($):</label>
          <input type="text" name="deposit" ><br>
        <label>Full Description:</label>
          <input type="text" name="full" ><br>
        <label>Tool Type:</label>
           <select name="tooltype">
              <option value="construction">Construction</option>
              <option value="hand">Hand</option>
               <option value="power">Power</option>
           </select>
        <div>
        If new item is a Power Tool, then include accessorites: <button type="submit" value="Add" name="addacc">Add Accessories</button>
        </div>
        <p><div>
           <button type="submit" value = "Submit" name="addtool">Submit New Tool</button>
        </div></p>
        <p>
        <hr>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
        </p>
      </form>
   </body>
</html>

