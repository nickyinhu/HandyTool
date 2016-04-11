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
         include('dbconn.php');
         global $conn;

         if (isset($_POST['addtool'])) {
            $abbr          = $_POST['abbr'];
            $purchaseprice = $_POST['purchaseprice'];
            $rentalprice   = $_POST['rentalprice'];
            $deposit       = $_POST['deposit'];
            $tool_type     = $_POST['tool_type'];
            $full          = $_POST['full'];
            
            $sql = "INSERT INTO tools(abbr_description, full_description, purchase_price, rental_price, deposit, tool_type)
                    VALUES ('$abbr','$full','$purchaseprice','$rentalprice','$deposit','$tool_type')";

            $insert = $conn->query($sql);
  
            // Print response from MySQL
            if ( $insert ) {
               echo "Success! Row ID: {$mysqli->insert_id}";
            } else {
               die("Error: {$mysqli->errno} : {$mysqli->error}");
            }
          }
      ?>

      <form action = '' method = "post">
        Abbreviated Description: <input type="text" name="abbr" required><br>
        Purchase Price ($): <input type="text" name="purchaseprice" required><br>
        Rental Price ($ per day): <input type="text" name="rentalprice" required><br>
        Deposit Amount ($): <input type="text" name="deposit" required><br>
        Full Description: <input type="text" name="full" required><br>
        Tool Type: 
           <select name="tooltype">
              <option value="construction">Construction</option>
              <option value="hand">Hand</option>
               <option value="power">Power</option>
           </select>
        <div>
        If new item is a Power Tool, then include accessorites: <button type="submit" value="Add">Add Accessories</button>
        </div>
        <div>
           <button type="submit" value = "Submit" name="addtool">Submit New Tool</button>
        </div>
      </form>

   </body>
</html>

  