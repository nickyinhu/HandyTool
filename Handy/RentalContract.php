<?php session_start(); ?>
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
			
			include('dbconn.php');
			global $conn;
			if(empty($_SESSION['login_user']) || empty($_SESSION['contract_num'])){
				die("You are not login yet!");
				header("refresh: 3; url = index.php");
			}
			//display reseravation number
			$contract_num = $_SESSION['contract_num'];
			$clerk_id = $_SESSION['login_user'];
			echo "<p><label>Reservation Number:</label> $contract_num</p>";
			//find clerk name according to clerk id
			$sql_clerk = "select first_name, last_name from clerk where clerk_id = '$clerk_id'";
			$result_clerk = $conn->query($sql_clerk) or die("Error querying the database");
			$row_clerk = $result_clerk->fetch_assoc();
			//display clerk name
			echo "<p><label>Clerk on Duty:</label> ".$row_clerk['first_name']." ".$row_clerk['last_name']."</p>";

			//customer name
			//find out customer email
			$sql_customer = "select * from reservation r join customer c on c.email = r.customer_email where resv_number = '$contract_num'";
			$result_reservation = $conn->query($sql_customer);
			$row_reservation = $result_reservation->fetch_assoc();
			$customer_email = $row_reservation['customer_email'];

			//find out customer name according to email
			echo "<p><label>Customer Name:</label> ". $row_reservation['first_name']." ".$row_reservation['last_name']."</p>";
			echo "<p><label>Credit Card #:</label> ".$row_reservation['credit_card']."</p>";
			//start date and end date
			echo "<p><label>Start Date:</label> ".$row_reservation['start_date']."</p><p><label>End Date:</label> ".$row_reservation['end_date']."</p>";

			//tools rented
			$sql_res_contains = "select t.tool_id, t.abbr_description from reservation_contains rc join tools t on t.tool_id = rc.tool_id where resv_number = '$contract_num'";
			$result = $conn->query($sql_res_contains) or die("Error querying the database");
			$num = 1;
			echo "<p>Tools Rented:</p>";
			if ($result->num_rows > 0) {
				while($row_res_contains = $result->fetch_assoc()){
					//each row has a resNum and toolID
					$tool_id = $row_res_contains['tool_id'];
					$abbr = $row_res_contains['abbr_description'];
					//echo tool id and abbr
					echo "<p><h4>$num: Tool [$tool_id] " . $abbr . "</h4></p>";
					$num = $num + 1;
				}
			}

			//deposit and cost
			echo "<p><label>Deposit Held:</label> $".$row_reservation['total_deposit']."</p>";
			echo "<p><label>Estimated Rental:</label> $".$row_reservation['total_price']."</p>";
			//signature
			echo "<p><label>Signature:</label> ___________________________________________</p>";
			if (isset($_POST['back'])) {
             			echo "<script> window.location.assign('clerk.php'); </script>";
         	}
         	if (isset($_POST['logout'])) {
				session_destroy();
                echo "<script> window.location.assign('index.php'); </script>";
            }

		?>
		<form action = '' method = "post">
			<div>
            			<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "back">Back to Main</button>
            			<button class = "btn btn-lg btn-primary btn-block" type = "submit" name = "logout">Log Out</button>
         		</div>
		</form>
	
	</body>
</html
