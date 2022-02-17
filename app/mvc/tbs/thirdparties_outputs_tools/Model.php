<?php

namespace tbs_thirdparties_outputs_tools;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tot.id,
						tot.output_id,
						tp.request_id AS 'output',
						tot.tool_id,
						trt.request_id AS 'tool',
						tot.quantity
			FROM		tbs_thirdparties_outputs_tools AS tot
			INNER JOIN	tbs_thirdparties_outputs AS tp
						ON tp.id = tot.output_id
			INNER JOIN	tbs_thirdparties_requests_tools AS trt
						ON trt.id = tot.tool_id
			ORDER BY	tot.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_by_output_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tot.id AS tot_id,
						tot.output_id,
						tp.request_id AS 'output',
						tot.tool_id,
						tool.name  AS 'tool',
						tot.quantity,
						trt.entry,
						trt.created_at
			FROM		tbs_thirdparties_outputs_tools AS tot
			INNER JOIN	tbs_thirdparties_outputs AS tp
						ON tp.id = tot.output_id
			INNER JOIN	tbs_thirdparties_requests_tools AS trt
						ON trt.id = tot.tool_id
			INNER JOIN	tbs_thirdparties_tools AS tool
						ON tool.id = trt.tool_id
			WHERE 		tot.output_id = $id
			ORDER BY	tot.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tot.id,
						tot.output_id,
						tp.request_id AS 'output',
						tot.tool_id,
						trt.request_id AS 'tool',
						tot.quantity
			FROM		tbs_thirdparties_outputs_tools AS tot
			INNER JOIN	tbs_thirdparties_outputs AS tp
						ON tp.id = tot.output_id
			INNER JOIN	tbs_thirdparties_requests_tools AS trt
						ON trt.id = tot.tool_id
			WHERE		tot.id = '$id'
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
			INTO		tbs_thirdparties_outputs_tools (`output_id`, `tool_id`, `quantity`)
			VALUES		('{$params['output_id']}', '{$params['id']}', '{$params['quantity']}')

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			UPDATE		tbs_thirdparties_outputs_tools
			SET			`output_id` = '{$params['output_id']}',
						`tool_id` = '{$params['tool_id']}',
						`quantity` = '{$params['quantity']}'
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
			FROM		tbs_thirdparties_outputs_tools
			WHERE		id = '$id'

		");
	}
}