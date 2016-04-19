<html lang = "en">
	<head>
		<title>Handyman Tool</title>
	</head>

	<body>
		<h2>Pick Up Reservation</h2>
		<?php
			session_start();
			include('dbconn.php');
			global $conn;
			if(empty($_SESSION['login_user'])){
				die("You are not login yet!");
				header("refresh: 3; url = index.php");
			}
			$sql = "select * from reservation r join customer c on r.customer_email = c.email where pickup_clerk_id is null";
			$result = $conn->query($sql) or die("Error query database");
			if ($result->num_rows > 0) {
				echo '<p>Please select a reservation to pickup</p>';
				echo '<p><select id="one" name="resv" method="post">';
                echo '<option value="">Please Select Reservation</option>';
				while ($row = $result->fetch_assoc()) {
					$resv_num = $row['resv_number'];
					$name = $row['first_name'] . ' ' . $row['last_name'];
                	echo "<option value=\"$resv_num\">Resv # $resv_num for $name</option>";
				}
				echo '</select></p>';
			} else {
				echo '<script language="javascript">';
				echo 'alert("No Available Reservation for Pickup")';
				echo '</script>';
			}
			if (isset($_POST['pickup'])) {
				if (!$_POST['resv']) {
					echo '<script language="javascript">';
					echo 'alert("Please Select a Reservation for Pickup")';
					echo '</script>';
				} else {
					$Res = $_POST['resv'];
					echo $Res;
					// echo "<script> window.location.assign('PickUpMenu.php');</script>";
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
			<p><button type = "submit" name = "pickup">Submit</button></p>
			<div>
				<hr>
				<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Main Menu</button>
				<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
		</div>
		</form>
	</body>
</html>
