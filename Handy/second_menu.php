<?php
    include('dbconn.php');
    include('functions.php');
    global $conn;
    session_start();

    $tooltype = $_GET["tooltype"];
    $startdate = $_GET["startdate"];
    $enddate = $_GET["enddate"];
    if (isset($_SESSION['startdate']) && $_SESSION['startdate'] != $startdate) {
        echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">You cannot have different start date in one reservation!</span>';
    } elseif (isset($_SESSION['enddate']) && $_SESSION['enddate'] != $enddate) {
        echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">You cannot have different end date in one reservation!</span>';
    }
    elseif (!validateDate($startdate)) {
        echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please type a valid Start Date!</span>';
    }
    elseif (!validateDate($enddate)) {
        echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Please type a valid End Date!</span>';
    }    
    elseif (!laterthantoday($startdate)) {
        echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Start Date must be today or in the future!</span>';
    }
    elseif (checkStartEnd($startdate,$enddate)) {
        echo '&nbsp&nbsp<span style="color:#FF0000;text-align:center;">Start Date cannot be greater than End Date!</span>';
    } else {
        $_SESSION['startdate'] = $startdate;
        $_SESSION['enddate'] = $enddate;
        $sql = "
        select t.tool_id, t.abbr_description as abbr, t.rental_price as price
        from tools as t
        where t.sold_date is null
        and t.tool_type = '$tooltype'
        and not exists
        (
            select t.tool_id
            from reservation_contains as rc
            inner join reservation as r on r.resv_number = rc.resv_number
            inner join service_request as sr on sr.tool_id = rc.tool_id
            where rc.tool_id = t.tool_id
            and (
                   (r.start_date <= '$startdate' and r.end_date >= '$startdate')
                or (r.start_date <= '$enddate' and r.end_date >= '$enddate')
                or (r.start_date >= '$startdate' and r.start_date <= '$enddate')
                or (sr.start_date <= '$startdate' and sr.end_date >= '$startdate')
                or (sr.start_date <= '$enddate' and sr.end_date >= '$enddate')
                or (sr.start_date >= '$startdate' and sr.start_date <= '$enddate')
            )
        )";
        echo '<p>Tool</p>';
        echo '<p><select id="one" name="tool" action="makereservation.php" method="get">';
        // echo '<option value="">Please select</option>';
        $result = $conn->query($sql) or die('Error querying database.');
        if ($result->num_rows > 0 ) {
            while ($row = $result->fetch_assoc()) {
                $abbr = $row['abbr'];
                $name = $row['tool_id'] . '. ' . $row['abbr'] . ' $' . $row['price'];
                $tool_id = $row['tool_id'];
                echo "<option value=\"$tool_id\" abbr=\"$abbr\">$name</option>";
            }
        }
        echo '</select></p>';
    }
?>
