<?php
    $servername = "54.187.153.141";
    $username = "6400";
    $password = "our6400";
    $dbname = "Handyman";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>