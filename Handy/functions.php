<?php
    function validateDate($date)
    {
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
    function laterthantoday($date)
    {
        return strtotime($date) >= strtotime("today");
    }
    function checkStartEnd($start,$end)
    {
        $timestamp1 = strtotime($start);
        $timestamp2 = strtotime($end);
        return ($timestamp1>$timestamp2);
    }
?>