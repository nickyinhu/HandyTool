<html lang = "en">

   <head>
      <title>Handyman Tool</title>
   </head>

   <body>
      <h2>Clerk</h2> 
      <?php
         session_start();
         if (!empty($_SESSION['login_user'])) {
            die("You are not login yet!");
         }
         include('dbconn.php');
         global $conn;
         $login_user = $_SESSION['login_user'];
         $sql = "SELECT clerk_id, first_name, last_name from clerk where clerk_id = '$login_user'";
         $result = $conn->query($sql) or die('Error querying database.');;
         if ($result->num_rows > 0 ) {
            while($row = $result->fetch_assoc()) {
               echo "id: " . $row["clerk_id"]. " - Name: " . $row["first_name"]. " " . $row["last_name"]. "<br>";
            }
         }
      ?>
   </body>
</html>