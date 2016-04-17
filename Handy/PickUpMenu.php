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
			
			//did not find the reservation, go back to main menu
			if(empty($_SESSION['res_num'])){
				echo "<script> window.location.assign('clerkMainManu.php'); </script>";
			}
			$Res = $_SESSION['res_num'];
			$sql_res = "select * from reservation where Resv_number = $Res"; 
			$result_res = $conn->query($sql_res);

			echo "Reservation Number: ".$Res."<br>";

			//tools required
			$sql_res_contains = "select * from reservation_contains where resv_number = $Res";
			$result_res_contains = $conn->query($sql_res_contains);
			$num = 1;
			echo "Tools Required<br>";
			while($row_res_contains = $result->fetch_assoc()){
				//each row has a resNum and toolID
				$tool_id = $row_res_contains['tool_id'];
				//find tool info according to tool id
				$sql_tool = "select * from tools where tool_id = $tool_id";
				$result_tool = $conn->query($sql_tool);
				$row_tool = $result_tool->fetch_assoc();
				//echo tool id and abbr
				echo $num.". <".$tool_id."> <".$row_tool['abbr_description']."<br>";
				$num = $num + 1;
			}

			//deposit required and estimated cost
			$row_res = $result_res->fetch_assoc();
			$deposit = $row_res['total_deposit'];
			$cost = $row_res['total_price'] + $deposit;

			echo "Deposit Required:		$".$deposit."<br>";
			echo "Estimated Cost: 		$".$cost."<br>";

			//tool ID detail
			if(isset($_POST['detail'])){
				$tool_id = $_POST['detail'];
				$sql_tool = "select full_description from tools where tool_id = $tool_id";
				$result_tool = $conn->query($sql_tool);
				$row = $result_tool->fetch_assoc();
				$tool_full = $row['full_description'];
				echo "<".$tool_id."> ".$tool_full."<br>";
			}
			if(isset($_POST["credit_card"]) && $_POST["expire_date"])
			{
				$credit = $_POST["credit_card"];
				$expire_date = $_POST["expire_date"];
				//add credit card and expire date to the reservation table加上信用卡信息
			}
			if(isset($_POST["complete"]))
				echo "<script> window.location.assign('RentalContract.php');</script>";
		?>

		<form action = '' method = "post">
			<label> Tool ID</label><input type = "text" name = "detail">
			<input type = "submit" value = "View Details">
			<br>
			<br>
			<label>Credit Card Number</label><input type = "text" name = "credit_card"><br>
			<label>Expiration expire_date</label><input type = "text" name = "expire_date"><br>
			<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "complete">Complete Pick-Up</button>
		</form>

		



	</body>
</html>
