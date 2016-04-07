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
      ?>

      <form>
      Abbreviated Description: <input type="text" name="abbr"><br>
      Purchase Price ($): <input type="text" name="purchaseprice"><br>
      Rental Price ($ per day): <input type="text" name="rentalprice"><br>
      Deposit Amount ($): <input type="text" name="deposit"><br>
      Full Description: <input type="text" name="full"><br>
      Tool Type: 
         <select>
            <option name="construction">Construction</option>
            <option name="hand">Hand</option>
             <option name="power">Power</option>
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

  