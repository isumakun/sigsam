<?php

namespace tbs_thirdparties_requests_tools;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		trt.id,
						trt.request_id,
						tr.company_id AS 'request',
						trt.tool_id,
						tt.name AS 'tool',
						trt.quantity,
						trt.created_at,
						trt.entry
			FROM		tbs_thirdparties_requests_tools AS trt
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = trt.request_id
			INNER JOIN	tbs_thirdparties_tools AS tt
						ON tt.id = trt.tool_id
			ORDER BY	trt.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		trt.id,
						trt.request_id,
						tr.company_id AS 'request',
						trt.tool_id,
						tt.name AS 'tool',
						trt.quantity,
						trt.created_at,
						trt.physical_unit,
						trt.entry
			FROM		tbs_thirdparties_requests_tools AS trt
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = trt.request_id
			INNER JOIN	tbs_thirdparties_tools AS tt
						ON tt.id = trt.tool_id
			WHERE		trt.id = '$id'
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_request_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		trt.id,
						trt.request_id,
						tr.company_id AS 'request',
						trt.tool_id,
						tt.name AS 'tool',
						trt.quantity,
						trt.created_at,
						trt.physical_unit,
						pu.symbol AS 'unit',
						trt.entry
			FROM		tbs_thirdparties_requests_tools AS trt
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = trt.request_id
			INNER JOIN	tbs_thirdparties_tools AS tt
						ON tt.id = trt.tool_id
			INNER JOIN	tbs3.tbs_physical_units AS pu
						ON pu.id = trt.physical_unit
			WHERE		trt.request_id = '$id'

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_all_allowed()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT		com.name AS 'user', com.id AS 'nit',
						trt.id,
						trt.request_id,
						c.name AS 'company',
						trt.tool_id,
						tt.name AS 'tool',
						trt.quantity,
						trt.created_at,
						trt.entry,
						pu.symbol AS 'unit'
			FROM		tbs_company AS com, tbs_thirdparties_requests_tools AS trt
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = trt.request_id
			INNER JOIN	tbs_thirdparties_tools AS tt
						ON tt.id = trt.tool_id
			INNER JOIN	tbs_thirdparties_companies AS c
						ON c.id = tr.company_id
			INNER JOIN	tbs3.tbs_physical_units AS pu
						ON pu.id = trt.physical_unit
			WHERE 		(tr.form_state_id = 3) AND (tr.schedule_to >= CURRENT_DATE())
			AND 		trt.entry = 0

		";

		return $this->db->query($sql)->fetchAll();
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT
			INTO		tbs_thirdparties_requests_tools (`request_id`, `tool_id`, `quantity`, `physical_unit`, `created_at`)
			VALUES		('{$params['request_id']}', '{$params['tool_id']}', '{$params['quantity']}', '{$params['physical_unit']}', now())

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

			UPDATE		tbs_thirdparties_requests_tools
			SET			`request_id` = '{$params['request_id']}',
						`tool_id` = '{$params['tool_id']}',
						`physical_unit` = '{$params['physical_unit']}',
						`quantity` = '{$params['quantity']}'
			WHERE		id = '$id'

		");
	}

/*------------------------------------------------------------------------------
	CHECK
------------------------------------------------------------------------------*/
	public function check_entry($id, $observations)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE		tbs_thirdparties_requests_tools
			SET			entry = now(),
						observations = '$observations'
			WHERE		id = '$id'

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	CHECK
------------------------------------------------------------------------------*/
	public function no_enter($id, $observations)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE		tbs_thirdparties_requests_tools
			SET			observations = 'No ingresó'
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
			FROM		tbs_thirdparties_requests_tools
			WHERE		id = '$id'

		");
	}
}