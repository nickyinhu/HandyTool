<?php
	function availability ($tooltype, $startdate, $enddate) {
		return "
        select t.tool_id, t.abbr_description as abbr, t.rental_price as price
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
?>