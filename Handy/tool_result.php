<?php
    session_start();
    echo '<p>Tool Added: </p>';
    if (!empty($_SESSION['tool_list'])) {
        foreach ($_SESSION['tool_list'] as $tool_id => $abbr) {
            echo '<p># ' . $tool_id . ' ' . $abbr . '</p>';
        }
    }
?>