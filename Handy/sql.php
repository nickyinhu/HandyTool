<?php
    function get_sellability () {
        return "
        SELECT t.tool_id, t.abbr_description as abbr, t.rental_price as price, t.deposit
        FROM tools as t
        where t.sold_date is null
        and not exists
        (
            SELECT t.tool_id
            FROM reservation_contains as rc
            inner join reservation as r on r.resv_number = rc.resv_number
            where rc.tool_id = t.tool_id
            and r.end_date >= date(curdate())
        )
        and not exists
        (
            SELECT t.tool_id
            FROM service_request as sr
            WHERE sr.tool_id = t.tool_id
            and sr.end_date >= date(curdate())
        )
        ";
    }

    function get_availability ($tooltype, $startdate, $enddate) {
        if (!isset($tooltype) || !isset($startdate) || !isset($enddate)) {
            die("You need to provide tooltype, startdate, and enddate");
        }
        return "
        SELECT t.tool_id, t.abbr_description as abbr, t.rental_price as price, t.deposit
        FROM tools as t
        where t.sold_date is null
        and t.tool_type = '$tooltype'
        and not exists
        (
            SELECT t.tool_id
            FROM reservation_contains as rc
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
            SELECT t.tool_id
            FROM service_request as sr
            WHERE sr.tool_id = t.tool_id
            and (
                   (sr.start_date <= '$startdate' and sr.end_date >= '$startdate')
                or (sr.start_date <= '$enddate' and sr.end_date >= '$enddate')
                or (sr.start_date >= '$startdate' and sr.start_date <= '$enddate')
            )
        )
        ";
    }

    function get_single_tool_availability ($tool_id, $startdate, $enddate) {
        if (!isset($tool_id) || !isset($startdate) || !isset($enddate)) {
            die("You need to provide tool_id, startdate, and enddate");
        }
        return "
        SELECT t.tool_id, t.abbr_description as abbr, t.rental_price as price, t.deposit
        FROM tools as t
        where t.sold_date is null
        and t.tool_id = '$tool_id'
        and not exists
        (
            SELECT t.tool_id
            FROM reservation_contains as rc
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
            SELECT t.tool_id
            FROM service_request as sr
            WHERE sr.tool_id = t.tool_id
            and (
                   (sr.start_date <= '$startdate' and sr.end_date >= '$startdate')
                or (sr.start_date <= '$enddate' and sr.end_date >= '$enddate')
                or (sr.start_date >= '$startdate' and sr.start_date <= '$enddate')
            )
        )
        ";
    }

    function get_tool_detail ($tool_id) {
        if (!isset($tool_id)) {
            die("You need to provide id_list, startdate, and enddate");
        }
        return "
            SELECT *
            FROM tools
            WHERE tool_id = '$tool_id'
        ";
    }

    function get_resv_summary ($id_list, $startdate, $enddate) {
        if (!isset($id_list) || !isset($startdate) || !isset($enddate)) {
            die("You need to provide id_list, startdate, and enddate");
        }
        return "
                SELECT abbr_description as abbr,
                    SUM(tools.rental_price * (DATEDIFF('$enddate', '$startdate') + 1)) AS rental, 
                    SUM(tools.deposit) AS deposit
                FROM tools
                WHERE tool_id in ($id_list)";
    }

    function get_customer_profile ($email) {
        return "
        SELECT
            r.resv_number,
            t.abbr_description as abbr,
            r.start_date as start,
            r.end_date as end,
            t.rental_price,
            t.deposit,
            IFNULL(pc.first_name, 'N/A') as pickup_clerk,
            IFNULL(dc.first_name, 'N/A') as dropoff_clerk
        From
            reservation_contains rc
            LEFT JOIN tools as t  on rc.tool_id = t.tool_id
            LEFT JOIN reservation r on r.resv_number = rc.resv_number
            LEFT JOIN clerk as pc on pc.clerk_id = r.pickup_clerk_id
            LEFT JOIN clerk as dc on dc.clerk_id = r.dropoff_clerk_id
            WHERE r.customer_email = '$email'
            ORDER BY r.resv_number DESC, t.tool_id
        ";
    }

    function get_tool_report ($year, $month) {
        include('functions.php');
        $month_end = get_end_of_month($year, $month);
        return "
            SELECT
            calc.tool_id,
            calc.abbr,
            calc.tool_type,
            SUM(calc.profit) AS rental_profit,
            SUM(calc.cost) AS cost,
            SUM(calc.profit) - SUM(calc.cost) AS total_profit,
            SUM(calc.rental_days) AS rental_days,
            SUM(calc.service_days) AS service_days
            FROM (
                SELECT 
                t.tool_id, t.abbr_description as abbr,t.tool_type,
                SUM( if(r.start_date is null, 0, datediff(r.end_date,r.start_date) + 1) ) * t.rental_price as profit,
                0 as cost,
                SUM( if(r.start_date is null, 0, datediff(r.end_date,r.start_date) + 1) ) as rental_days,
                0 as service_days
                FROM tools as t
                LEFT JOIN reservation_contains as rc on t.tool_id = rc.tool_id
                LEFT JOIN reservation as r on r.resv_number = rc.resv_number
                    and (r.end_date <= '$month_end' or r.end_date is null)
                GROUP BY t.tool_id
            UNION
                SELECT
                t.tool_id, t.abbr_description as abbr,t.tool_type,
                0 as profit,
                SUM(if(sr.cost is null, 0, sr.cost)) + t.purchase_price as cost,
                0 as rental_days,
                SUM( if(sr.start_date is null, 0, datediff(sr.end_date, sr.start_date) + 1) ) as service_days
                FROM tools as t
                LEFT JOIN service_request as sr on sr.tool_id = t.tool_id
                    and (sr.end_date <= '$month_end' OR sr.end_date is NULL)
                GROUP BY t.tool_id
            ) as calc
            GROUP BY calc.tool_id
			ORDER BY total_profit DESC

        ";
    }

    function get_customer_report ($year,$month) {
        include('functions.php');
        $month_start = get_start_of_month($year, $month);
        $month_end = get_end_of_month($year, $month);
        return "
            SELECT
                UPPER(customer.first_name) as first_name,
                UPPER(customer.last_name) as last_name,
                UPPER(customer.email) as email,
                count(reservation.resv_number) as resvation_count
            FROM customer INNER JOIN reservation
            on customer.email = reservation.customer_email
            WHERE reservation.end_date>='$month_start' and reservation.end_date <= '$month_end'
            GROUP BY customer.email
            ORDER by resvation_count desc, customer.last_name
        ";
    }

    function get_clerk_report ($year,$month) {
        include('functions.php');
        $month_start = get_start_of_month($year, $month);
        $month_end = get_end_of_month($year, $month);
        return "
            SELECT resv_count.clerk_id,
                UPPER(resv_count.first_name) as first_name,
                UPPER(resv_count.last_name) as last_name,
                sum(resv_count.pick_up_count) as pickup,
                sum(resv_count.drop_off_count) as dropoff
            FROM
            (
                SELECT c.clerk_id, c.first_name, c.last_name, count(pickup_clerk_id) as pick_up_count,
                0 as drop_off_count
                FROM reservation as r
                JOIN clerk as c on c.clerk_id = r.pickup_clerk_id
                and r.end_date>='$month_start' and r.end_date <= '$month_end'
                GROUP BY c.clerk_id
            union
                SELECT c.clerk_id, c.first_name, c.last_name, 0 as pick_up_count,
                count(dropoff_clerk_id) as drop_off_count
                FROM reservation as r
                JOIN clerk as c on c.clerk_id = r.dropoff_clerk_id
                    and r.end_date>='$month_start' and r.end_date <= '$month_end'
                GROUP BY c.clerk_id
            ) as resv_count
            GROUP BY resv_count.clerk_id
        ";
    }
?>