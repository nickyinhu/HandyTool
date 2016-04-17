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

		<h4><i>HANDYMAN TOOLS RECEIPT</i></h4>

		<?php
			session_start();
			include('dbconn.php');
			global $conn;
			if(empty($_SESSION['login_user'])){
				die("You are not login yet!");
				header("refresh: 3; url = index.php");
			}
			//display reseravation number
			if(isset($_SESSION['res_num']))
				echo "Reservation Number: ".$_SESSION['res_num'];
			$res_num = $_SESSION['res_num'];
			$clerk_id = $_SESSION['login_user'];
			//find clerk name according to clerk id
			$sql_clerk = "select first_name, last_name from clerk where clerk_id = $clerk_id";
			$result_clerk = $conn->query($sql_clerk) or die("Error querying the database");
			$row_clerk = $result_clerk->fetch_assoc();
			//display clerk name
			echo "Clerk on Duty: ".$row_clerk['first_name']." ".$row_clerk['last_name']."<br>";
			//update reservation table, add dropoff clerk id
			$sql_dropoff_clerk = "UPDATE reservation SET dropoff_clerk_id = '$clerk_id' where resv_number = $res_num";
			$conn->query($sql_dropoff_clerk) or die("Error update database");

			//customer name
			//find out customer email
			$sql_customer = "select customer_email from reservation where resv_number = $res_num";
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
			$sql_date = "select start_date, end_date from Reservation where resv_number = $res_num";
			$result_date = $conn->query($sql_date)；
			$row_date = $result_date->fetch_assoc()；
			echo "Start Date: ".$row_date['start_date']."  End Date: ".$row_date['end_date']."<br>";

			//display rental price and deposit held 
			$sql_price = "select total_price, total_deposit from reservation where resv_number = $res_num";
			$result_price = $conn->query($sql_price);
			$row_price = $result_price->fetch_assoc();

			$total = $row_price['total_price'];
			$deposit_held = $row_price['total_deposit'];
			$rental_price = $total + $deposit_held;

			echo "Rental Price: $".$rental_price."<br>";
			echo "Deposit Held: $".$deposit_held."<br>";
			echo "             --------------------";
			echo "Total:        $".$total."<br>";
	
		?>
			}
	
	</body>
</html>
