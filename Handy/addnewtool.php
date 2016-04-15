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
         include('dbconn.php');
         global $conn;

         if (isset($_POST['addacc'])) {
            
         }

         if (isset($_POST['addtool'])) {
            $abbr          = $_POST['abbr'];
            $purchaseprice = $_POST['purchaseprice'];
            $rentalprice   = $_POST['rentalprice'];
            $deposit       = $_POST['deposit'];
            $tool_type     = $_POST['tooltype'];
            $full          = $_POST['full'];

          if (is_numeric($purchaseprice) && is_numeric($rentalprice) && is_numeric($deposit)) {
              $sql = "INSERT INTO tools(abbr_description, full_description, purchase_price, rental_price, deposit, tool_type)
                      VALUES ('$abbr','$full','$purchaseprice','$rentalprice','$deposit','$tool_type')";

              // Print response from MySQL
              if ( mysqli_query($conn, $sql) ) {
                 $last_id = $conn->insert_id;
                echo '<script language="javascript">';
                echo 'alert("Tool ' . $abbr . ' was added successfully! Tool ID: ' . $last_id . '")';
                echo '</script>';
              } else {
                 die("Error: " . mysqli_error($con));
              }
          } else {
            echo '<h4>&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Purchase Price, Rental Price and Deposit must be numeric value!</span></h4>';
          }
        }
      ?>

      <form action = '' method = "post">
        <label>Abbreviated Description:</label>
          <input type="text" name="abbr" align="right" required><br>
        <label>Purchase Price ($):</label>
          <input type="text" name="purchaseprice" required><br>
        <label>Rental Price ($ per day):</label>
          <input type="text" name="rentalprice" required><br>
        <label>Deposit Amount ($):</label>
          <input type="text" name="deposit" required><br>
        <label>Full Description:</label>
          <input type="text" name="full" required><br>
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
      </form>
   </body>
</html>

  