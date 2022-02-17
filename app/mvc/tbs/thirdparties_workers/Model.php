<?php

namespace tbs_thirdparties_workers;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		com.name AS company,
						tw.id,
						tw.employee_id,
						te.citizen_id,
						te.name AS 'employee',
						tw.category_id,
						twc.name AS 'category',
						tw.request_id,
						tw.arl,
						tw.eps,
						tw.is_employee,
						tw.limit_date
			FROM		tbs_company AS com, tbs_thirdparties_workers AS tw
			INNER JOIN	tbs_thirdparties_employees AS te
						ON te.id = tw.employee_id
			INNER JOIN	tbs3.tbs_thirdparties_workers_categories AS twc
						ON twc.id = tw.category_id
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = tw.request_id
			ORDER BY	tw.id ASC

		")->fetchAll();
	}


/*------------------------------------------------------------------------------
	get_all_allowed
------------------------------------------------------------------------------*/
	public function get_all_allowed()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		com.name AS company,
						tc.name AS user_company,
						tw.id,
						tw.employee_id,
						te.citizen_id,
						te.name AS 'employee',
						te.citizen_id,
						tw.category_id,
						twc.name AS 'category',
						tw.request_id,
						tw.arl,
						tw.eps,
						tw.is_employee,
						tw.limit_date,
						tr.schedule_from,
						tr.schedule_to,
						tr.working_hours,
						tw.vehicle_plate,
						tr.access
			FROM		tbs_company AS com, tbs_thirdparties_workers AS tw
			INNER JOIN	tbs_thirdparties_employees AS te
						ON te.id = tw.employee_id
			INNER JOIN	tbs3.tbs_thirdparties_workers_categories AS twc
						ON twc.id = tw.category_id
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = tw.request_id
			INNER JOIN	tbs_thirdparties_companies AS tc
						ON tc.id = tr.company_id
			WHERE 		(tr.form_state_id = 3 OR tr.form_state_id = 12) AND (tr.schedule_to >= CURRENT_DATE())
			GROUP BY 	tw.employee_id
			ORDER BY	tw.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_by_request_id($request_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tw.id,
						tw.employee_id,
						te.name AS 'employee',
						te.citizen_id,
						tw.category_id,
						twc.name AS 'category',
						tw.request_id,
						tw.vehicle_plate,
						tw.arl,
						tw.eps,
						tw.is_employee,
						tw.limit_date
			FROM		tbs_thirdparties_workers AS tw
			INNER JOIN	tbs_thirdparties_employees AS te
						ON te.id = tw.employee_id
			INNER JOIN	tbs3.tbs_thirdparties_workers_categories AS twc
						ON twc.id = tw.category_id
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = tw.request_id
			WHERE 		tw.request_id = $request_id
			ORDER BY	tw.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tw.id,
						tw.employee_id,
						te.name AS 'employee',
						tw.category_id,
						twc.name AS 'category',
						tw.request_id,
						tr.company_id AS 'request',
						tw.vehicle_plate,
						tw.arl,
						tw.eps,
						tw.is_employee,
						tw.limit_date
			FROM		tbs_thirdparties_workers AS tw
			INNER JOIN	tbs_thirdparties_employees AS te
						ON te.id = tw.employee_id
			INNER JOIN	tbs3.tbs_thirdparties_workers_categories AS twc
						ON twc.id = tw.category_id
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = tw.request_id
			WHERE		tw.id = '$id'
			LIMIT		1

		")->fetchAll()[0];
	}


/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_employee_id($employee_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tw.id,
						tw.employee_id,
						te.name AS 'employee',
						tw.category_id,
						twc.name AS 'category',
						tw.request_id,
						tr.company_id AS 'request',
						tw.vehicle_plate,
						tw.arl,
						tw.eps,
						tw.is_employee,
						tw.limit_date
			FROM		tbs_thirdparties_workers AS tw
			INNER JOIN	tbs_thirdparties_employees AS te
						ON te.id = tw.employee_id
			INNER JOIN	tbs3.tbs_thirdparties_workers_categories AS twc
						ON twc.id = tw.category_id
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = tw.request_id
			WHERE		tw.employee_id = '$employee_id' AND (tr.form_state_id = 3 OR tr.form_state_id = 5)
			ORDER BY 	tw.id DESC
			LIMIT		1

		")->fetchAll()[0];
	}


/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$is_employee = 0;
		if ($params['is_employee']=='on') {
			$is_employee = 1;
		}
		
		$sql = "

			INSERT
			INTO		tbs_thirdparties_workers (`employee_id`, `category_id`, `vehicle_plate`, `request_id`, `arl`, `eps`, `is_employee`)
			VALUES		('{$params['employee_id']}', '{$params['category_id']}', '{$params['vehicle_plate']}', '{$params['request_id']}', '{$params['arl']}', '{$params['eps']}', '$is_employee')

		";
		
		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create_with_limit_date($params, $limit_date)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$is_employee = 0;
		if ($params['is_employee']=='on') {
			$is_employee = 1;
		}

		$sql = "

			INSERT
			INTO		tbs_thirdparties_workers (`employee_id`, `category_id`, `vehicle_plate`, `request_id`, `arl`, `eps`, `limit_date`, `is_employee`)
			VALUES		('{$params['employee_id']}', '{$params['category_id']}', '{$params['vehicle_plate']}', '{$params['request_id']}', '{$params['arl']}', '{$params['eps']}', '$limit_date', '$is_employee')

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$is_employee = 0;
		if ($params['is_employee']=='on') {
			$is_employee = 1;
		}

		$sql = "

			UPDATE		tbs_thirdparties_workers
			SET			`employee_id` = '{$params['employee_id']}',
						`category_id` = '{$params['category_id']}',
						`request_id` = '{$params['request_id']}',
						`vehicle_plate` = '{$params['vehicle_plate']}',
						`arl` = '{$params['arl']}',
						`eps` = '{$params['eps']}',
						`is_employee` = '$is_employee'
			WHERE		id = '$id'

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	update_limit_date
------------------------------------------------------------------------------*/
	public function update_limit_date($id, $limit_date)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE		tbs_thirdparties_workers
			SET			`limit_date` = '$limit_date'
			WHERE		id = '$id'

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	DELETE BY ID
------------------------------------------------------------------------------*/
	public function delete_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			DELETE
			FROM		tbs_thirdparties_workers
			WHERE		id = '$id'

		");
	}
}