<?php
	function get_availability ($tooltype, $startdate, $enddate) {
        if (!isset($tooltype) || !isset($startdate) || !isset($enddate)) {
            die("You need to provide tooltype, startdate, and enddate");
        }
		return "
        select t.tool_id, t.abbr_description as abbr, t.rental_price as price, t.deposit
        from tools as t
        where t.sold_date is null
        and t.tool_type = '$tooltype'
        and not exists
        (
            select t.tool_id
            from reservation_contains as rc
            inner join reservation as r on r.resv_number = rc.resv_number
            where rc.tool_id = t.tool_id
            and (
                   (r.start_date <= '$startdate' and r.end_date >= '$startdate')
                or (r.start_date <= '$enddate' and r.end_date >= '$enddate')
                or (r.start_date >= '$startdate' and r.start_date <= '$enddate')
            )
        )
        and not exists
        (
            select t.tool_id
            from service_request as sr
            WHERE sr.tool_id = t.tool_id
            and (
                   (sr.start_date <= '$startdate' and sr.end_date >= '$startdate')
                or (sr.start_date <= '$enddate' and sr.end_date >= '$enddate')
                or (sr.start_date >= '$startdate' and sr.start_date <= '$enddate')
            )
        )
        ";
	}

    function get_resv_summary ($id_list, $startdate, $enddate) {
        if (!isset($id_list) || !isset($startdate) || !isset($enddate)) {
            die("You need to provide id_list, startdate, and enddate");
        }
        return "
                SELECT abbr_description as abbr,
                    SUM(tools.rental_price * (DATEDIFF('$enddate', '$startdate') + 1)) AS rental, 
                    SUM(tools.deposit * (DATEDIFF('$enddate', '$startdate') + 1)) AS deposit
                FROM tools
                WHERE tool_id in ($id_list)";
    }
?>