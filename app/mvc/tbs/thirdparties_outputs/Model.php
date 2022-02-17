<?php

namespace tbs_thirdparties_outputs;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tp.id,
						tp.request_id,
						tr.id AS 'request',
						tp.company_id,
						tc.name AS 'company',
						tp.employee_id,
						te.name AS 'employee',
						tp.vehicle_plate,
						tp.created_by,
						tp.created_at,
						u.username AS created_by
			FROM		tbs_thirdparties_outputs AS tp
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = tp.request_id
			INNER JOIN	tbs_thirdparties_companies AS tc
						ON tc.id = tp.company_id
			INNER JOIN	tbs_thirdparties_employees AS te
						ON te.id = tp.employee_id
			LEFT JOIN 
						tbs3.`admin_users` AS u
						ON u.id = tr.created_by
			ORDER BY	tp.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tp.id,
						tp.request_id,
						tr.company_id AS 'request',
						tp.company_id,
						tc.name AS 'company',
						tp.employee_id,
						te.name AS 'employee',
						tp.vehicle_plate,
						tp.created_by,
						tp.created_at,
						u.username AS created_by
			FROM		tbs_thirdparties_outputs AS tp
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = tp.request_id
			INNER JOIN	tbs_thirdparties_companies AS tc
						ON tc.id = tp.company_id
			INNER JOIN	tbs_thirdparties_employees AS te
						ON te.id = tp.employee_id
			LEFT JOIN 
						tbs3.`admin_users` AS u
						ON u.id = tr.created_by
			WHERE		tp.id = '$id'
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT
			INTO		tbs_thirdparties_outputs (`request_id`, `company_id`, `employee_id`, `vehicle_plate`, `created_by`, `created_at`)
			VALUES		('{$params['request_id']}', '{$params['company_id']}', '{$params['employee_id']}', '{$params['vehicle_plate']}', '{$_SESSION['user']['id']}', now())

		";

		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			UPDATE		tbs_thirdparties_outputs
			SET			`request_id` = '{$params['request_id']}',
						`company_id` = '{$params['company_id']}',
						`employee_id` = '{$params['employee_id']}',
						`vehicle_plate` = '{$params['vehicle_plate']}'
			WHERE		id = '$id'

		");
	}

/*------------------------------------------------------------------------------
	DELETE BY ID
------------------------------------------------------------------------------*/
	public function delete_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		return $this->db->query("

			DELETE
			FROM		tbs_thirdparties_outputs
			WHERE		id = '$id'

		");
	}
}