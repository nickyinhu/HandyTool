<?php
    include('makereservation.php');
    if (isset($_GET['tool_id'])) {
        if (empty($_SESSION['tool_list'])) {
            $_SESSION['tool_list'] = array();
        }
        $tool_list = $_SESSION['tool_list'];
        $tool_list[$_GET['tool_id']] = $_GET['abbr'];
        $_SESSION['tool_list'] = $tool_list;
    }
    if (isset($_GET['remove'])) {
        if (!empty($_SESSION['tool_list'])) {
            array_pop($_SESSION['tool_list']);
        }
    }
?>