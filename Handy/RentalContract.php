<html lang = "en">
	<head>
		<title>Handyman Tool</title>
		<style type="text/css">
		   label {
				display:inline-block;
				height: 8px;
				margin: 10 auto;
				width: 200px;
				font-weight: normal;
			}
		</style>
	</head>
	<body>

		<h4><i>HANDYMAN TOOLS RENTAL CONTRACT</i></h4>

		<?php
			session_start();
			include('dbconn.php');
			global $conn;
			if(empty($_SESSION['login_user'])){
				die("You are not login yet!");
				header("refresh: 3; url = index.php");
			}
			//display reseravation number
			if(isset($_SESSION['contract_num']))
				echo "Reservation Number: ".$_SESSION['contract_num'];
			//find clerk name according to clerk id
			$sql_clerk = "select first_name, last_name from clerk where clerk_id = $_SESSION['login_user']";
			$result_clerk = $conn->query($sql_clerk) or die("Error querying the database");
			$row_clerk = $result_clerk->fetch_assoc();
			//display clerk name
			echo "Clerk on Duty: ".$row_clerk['first_name']." ".$row_clerk['last_name']."<br>";

			//customer name
			//find out customer email
			$sql_customer = "select customer_email from reservation where resv_number = $_SESSION['contract_num']";
			$result_customer = $conn->query($sql_customer);
			$row_customer = $result_customer->fetch_assoc()；
			$customer_email = $row_customer['customer_email'];

			//find out customer name according to email
			$sql_cus_name =  "select first_name, last_name from customer where email = $customer_email";
			$result_cus_name = $conn->query($sql_cus_name);
			$row_cus_name = $result_cus_name->fetch_assoc();
			echo "Customer Name: ". $row_cus_name['first_name']." ".$row_cus_name['last_name']." ";


			//display credit card
			if(isset($_SESSION['credit_card'])){
				echo "Credit Card #: ".$_SESSION['credit_card_number']."<br>";
				unset($_SESSION['credit_card_number']);
			}

			//start date and end date
			$sql_date = "select start_date, end_date from Reservation where resv_number = $_SESSION['contract_num']";
			$result_date = $conn->query($sql_date)；
			$row_date = $result_date->fetch_assoc()；
			echo "Start Date: ".$row_date['start_date']."  End Date: ".$row_date['end_date']."<br>";



			//tools rented
			$sql_res_contains = "select * from reservation_contains where resv_number = $_SESSION['contract_num']";
			$result = $conn->query($sql_res_contains) or die("Error querying the database");
			$num = 1;
			echo "<p>Tools Rented:</p>";
			if ($result->num_rows > 0) {
				while($row_res_contains = $result->fetch_assoc()){
					//each row has a resNum and toolID
					$tool_id = $row_res_contains['tool_id'];
					//find tool info according to tool id
					$sql_tool = "select * from tools where tool_id = $tool_id";
					$result_tool = $conn->query($sql_tool);
					$row_tool = $result_tool->fetch_assoc();
					$abbr = $row_tool['abbr_description'];
					//echo tool id and abbr
					echo "<p><h4>$num: Tool [$tool_id] $abbr</h4></p>";
					$num = $num + 1;
				}
			}

			//deposit and cost
			if(isset($_SESSION['deposit']) && isset($_SESSION['cost'])){
				echo "Deposit Held: $".$_SESSION['deposit']."<br>"
				echo "Estimated Rental: ".$_SESSION['cost']."<br>";
				unset($_SESSION['deposit']);
				unset($_SESSION['cost']);
			}
			//signature
			echo "Signature: ";
			session_destroy();
			if (isset($_POST['back'])) {
             			echo "<script> window.location.assign('clerk.php'); </script>";
         		}
         		if (isset($_POST['logout'])) {
                		echo "<script> window.location.assign('index.php'); </script>";
            }

		?>
			}
		<form action = '' method = "post">
			<div>
            			<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Back to Main</button>
            			<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
         		</div>
		</form>
	
	</body>
</html>
