<?php session_start(); ?>
<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
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
                } elseif ($_POST['tooltype'] != 'power' && $_POST['acc1']) {
                  echo '<script language="javascript">';
                  echo 'alert("You Can only add accessories for power tools")';
                  echo '</script>';
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
                        if ($tool_type == 'power') {
                          $acc_array = array();
                          for ($x = 0; $x <= 10; $x++) {
                            if (isset($_POST["acc$x"]) && $_POST["acc$x"] && !array_key_exists($_POST["acc$x"], $acc_array)) {
                              $acc = $_POST["acc$x"];
                              $acc_array[$acc] = 1;
                              $acc_sql = "INSERT INTO accessories (tool_id, accessory) VALUES ('$last_id', '$acc')";
                              mysqli_query($conn, $acc_sql) or die("Cannot Insert Accessories into Database");
                            }
                          }
                        }
                        echo '<script language="javascript">';
                        echo 'alert("Tool ' . $abbr . ' was added successfully! Tool ID: ' . $last_id . '")';
                        echo '</script>';
                    } else {
                        die("Error: " . mysqli_error($con));
                    }
                }
            }
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }
            if (isset($_POST['back'])) {
              echo "<script> window.location.assign('clerk.php'); </script>";
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
           <select name="tooltype" class="tooltype">
              <option value="construction">Construction</option>
              <option value="hand">Hand</option>
               <option value="power">Power</option>
           </select>
        <div class = "input_fields_wrap">
          If new item is a Power Tool, then include Accessories:
          <button class= "add_field_button" name="addacc">Add Accessories</button>
        </div>
        <p><button type="submit" value="Add" name="addtool">Add Tool</button></p>
        <p>
        <hr>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
            <button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
        </p>
      </form>
      <script>
        $(document).ready(function() {
            var max_fields      = 10; //maximum input boxes allowed
            var wrapper         = $(".input_fields_wrap"); //Fields wrapper
            var add_button      = $(".add_field_button"); //Add button ID

            var x = 1; //initlal text box count
            $(add_button).click(function(e){ //on add input button click
              if ($(".tooltype").val() == 'power') {
                  e.preventDefault();
                  if(x < max_fields){ //max input box allowed
                      $(wrapper).append('<div><input type="text" name="acc' + x + '" method ="post"><a href="#" class="remove_field">x</a></div>'); //add input box
                      x++; //text box increment
                  }
                } else {
                  alert("You can only add Accessories for Power Tools")
                }
            });
            $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
                e.preventDefault(); $(this).parent('div').remove(); x--;
            })
          });
    </script>
   </body>
</html>