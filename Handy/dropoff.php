<html lang = "en">
	<head>
		<title>Handyman Tool</title>
	</head>

	<body>
		<h2>Drop off</h2>
		<?php
			session_start();
			include('dbconn.php');
			global $conn;
			if(empty($_SESSION['login_user'])){
				die("You are not login yet!");
				header("refresh: 3; url = index.php");
			}
			if (isset($_POST['drop_off'])) {
				if($_POST['ResNum']){
					$Res = $_POST["ResNum"];
					//read from db
					$sql = "select resv_number from reservation where resv_number = '$Res'";
					$result = $conn->query($sql) or die('Error querying database.');
					if($result->num_rows > 0){
						$_SESSION['res_num'] = $Res;
						echo "<script> window.location.assign('rental_receipt.php');</script>";
					}
					else{
						echo '<script language="javascript">';
						echo "alert(\"Cannot find reservation for number $Res\")";
						echo '</script>';
					}
				} else {
					echo '<script language="javascript">';
					echo 'alert("Please Enter Reservation Number")';
					echo '</script>';
				}
			}
			if (isset($_POST['back'])) {
             			unset($_SESSION['res_num']);
             			echo "<script> window.location.assign('clerk.php'); </script>";
         		}
         		if (isset($_POST['logout'])) {
                	session_destroy();
                	echo "<script> window.location.assign('index.php'); </script>";
            		}
		?>

		<form action = '' method = "post">
			<p>Reservation number for DropOff: </label> 
			<input type = "text" name = "ResNum"><br>
			<p><button type = "submit" name = "drop_off">Submit</button></p>
			<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Back</button>
			<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
		</form>
	</body>
</html>