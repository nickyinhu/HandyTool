<html lang = "en">

   <head>
      <title>Handyman Tool</title>
      
   </head>

   <body>
      <h2>View Tool Detail</h2> 
     
      <?php
         session_start();
         include('dbconn.php');
         global $conn;
		 
               $tool_id=$_SESSION['detail_tool_id'];
               $sql = "SELECT * FROM tools WHERE tool_id='$tool_id'";
			   $result = $conn->query($sql) or die('Error querying database.');
			   if ($result->num_rows > 0 ){
				   echo '<p><table border="1">';
                echo '<tr><th>Tool ID</th><th>Abbr. Description</th><th>Full Description</th><th>Deposit</th><th>Purchase Price($)</th><th>Rental Price($)</th><th>Tool Type</th><th>Sold Date</th></tr>';
                while ($row = $result->fetch_assoc()) {
                    echo '<tr><td align="center">',     $row['tool_id'],
                         '</td><td align="left">&nbsp', $row['abbr_description'],
						 '</td><td align="left">&nbsp', $row['full_description'],
                         '</td><td align="center">',    $row['deposit'],
                         '</td><td align="center">',    $row['purchase_price'],
						 '</td><td align="center">', $row['rental_price'],
						 '</td><td align="center">', $row['tool_type'],
						 '</td><td align="center">', $row['sold_date'],
						 '</td></tr>';
                }
                echo '</table></p>';
			   }

  
      ?>


      </form>
      <div>
      <INPUT TYPE="button" VALUE="Back" onClick="history.go(-1);">
            
            
            </div>
            </div>
         </p>
      </form>
      <div>
            <label></label><button type="submit" onClick="location.href='customer.php'">Main Menu</button>
            <label></label><button type="submit" onClick="location.href='index.php'">Exit</button>
            </div>
            </div>
         </p>


   </body>
</html>

  