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
        include('sql.php');
        $sql = get_availability($tooltype,$startdate,$enddate);

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
