<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>

   <body>
      <h2>Add new tool</h2> 
      <?php
         session_start();
         $login_user = $_SESSION['login_user'];
         include('dbconn.php');
         global $conn;
         echo $login_user;
         if (!$login_user) {
            die("You are not login yet!");
         }

         if ( ! empty( $_POST ) and ! empty($_POST['tooltype'])) {
              // Insert our data
            $sql = "INSERT INTO tools( tool_id, abbr_description, full_description, purchase_price, rental_price, deposit, tool_type ) 
                VALUES ( '{$mysqli->real_escape_string($_POST['toolid'])}', '{$mysqli->real_escape_string($_POST['abbr'])}',
                '{$mysqli->real_escape_string($_POST['full'])}','{$mysqli->real_escape_string($_POST['purchaseprice'])}', 
                '{$mysqli->real_escape_string($_POST['rentalprice'])}',
                '{$mysqli->real_escape_string($_POST['deposit'])}', '{$mysqli->real_escape_string($_POST['tool_type'])}')";
            
            $insert = $mysqli->query($sql);
  
            // Print response from MySQL
            if ( $insert ) {
               echo "Success! Row ID: {$mysqli->insert_id}";
            } else {
               die("Error: {$mysqli->errno} : {$mysqli->error}");
            }
  
            // Close our connection
            $mysqli->close();
            }
      ?>

      <form>
      Abbreviated Description: <input type="text" name="abbr"><br>
      Purchase Price ($): <input type="text" name="purchaseprice"><br>
      Rental Price ($ per day): <input type="text" name="rentalprice"><br>
      Deposit Amount ($): <input type="text" name="deposit"><br>
      Full Description: <input type="text" name="full"><br>
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
         <button type="submit" value="Submit">Submit New Tool</button>
      </div>
      </form>

   </body>
</html>

  