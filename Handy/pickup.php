<html lang = "en">
	<head>
		<title>Handyman Tool</title>
	</head>

	<body>
		<?php
			session_start();
			include('dbconn.php');
			global $conn;
			if(empty($_SESSION['login_user'])){
				die("You are not login yet!");
				header("refresh: 3; url = index.php");
			}
			if(isset($_POST["ResNum"])){
				$Res = $_POST["ResNum"];
				//read from db
				$sql = "select Resv_number from Reservation where $row[Resv_number] = $Res";
				$result = $conn->query($sql) or die('Error querying database.');
				if($result->num_rows > 0)
					echo "<script> window.location.assign('PickUpMenu.php');</script>";
				else{
					echo "Cannot find the reservation!!";
				}
					
			}		
		?>

		<form action = '' method = "post">
			<label> Please input Reservation number: </label> 
			<input type = "text" name = "ResNum"><br>
			<input type = "submit">
		</form>



	</body>
</html>
