<?php session_start(); ?>
<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>

   <body>
      <h2>View Tool Detail</h2> 
     
      <?php
       
         include('dbconn.php');
         global $conn;
		 
               $tool_id=$_SESSION['detail_tool_id'];
               $sql = "SELECT * FROM tools WHERE tool_id='$tool_id'";
			   $result = $conn->query($sql) or die('Error querying database.');
			   if ($result->num_rows > 0 ){
				   echo '<p><table border="1">';
                
                $row = $result->fetch_assoc();

                switch ($row['tool_type']) {
                    case 'hand':
                        $tooltype = 'Hand Tools';
                        break;
                    case 'construction':
                        $tooltype = 'Construction Equipment';
                        break;
                    case 'power':
                        $tooltype = 'Power Tools';
                        break;
                }
                  echo '<tr><th>Tool Part #</th><td align="center">',     $row['tool_id'], 
                  '</td><tr><th>Tool Type</th><td align="center">', $tooltype,
                  '</td><tr><th>Abbr. Description</th><td align="left">&nbsp', $row['abbr_description'],
                  '</td><tr><th>Full Description</th><td align="left">&nbsp', $row['full_description'],
                  '</td><tr><th>Deposit</th><td align="center">$',    $row['deposit'],
                  '</td><tr><th>Rental Per Day</th><td align="center">$', $row['rental_price'],
                  '</td></tr>';
                echo '</table></p>';
			   }
            if (isset($_POST['logout'])) {
                session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }

  
      ?>


      <div>
      <form action = '' method = "post">
      <input TYPE="button" VALUE="Back" onClick="history.go(-1);"></input>

      <p><button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout" method="post">Log Out</button></p>
      </form>
      </div>
   </body>
</html>

  