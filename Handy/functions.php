<?php
    function validateDate($date)
    {
        date_default_timezone_set('America/New_York');
        $d = DateTime::createFromFormat('Y-m-d', $date);
        return $d && $d->format('Y-m-d') === $date;
    }
    function laterthantoday($date)
    {
        date_default_timezone_set('America/New_York');
        return strtotime($date) >= strtotime("today");
    }
    function checkStartEnd($start,$end)
    {
        date_default_timezone_set('America/New_York');
        $timestamp1 = strtotime($start);
        $timestamp2 = strtotime($end);
        return ($timestamp1>$timestamp2);
    }
    function get_start_of_month($year, $month)
    {
        date_default_timezone_set('America/New_York');
        $timestamp = strtotime("first day of $year-$month-01");
        return date("Y-m-d", $timestamp);
    }
    function get_end_of_month($year, $month)
    {
        date_default_timezone_set('America/New_York');
        $timestamp = strtotime("last day of $year-$month-01");
        return date("Y-m-d", $timestamp);
    }
?>