<?php

namespace tbs_thirdparties_supports;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		ts.id,
						ts.request_id,
						tr.company_id AS 'request',
						ts.details,
						ts.file_extension,
						ts.created_at
			FROM		tbs_thirdparties_supports AS ts
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = ts.request_id
			ORDER BY	ts.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		ts.id,
						ts.request_id,
						tr.company_id AS 'request',
						ts.details,
						ts.file_extension,
						ts.created_at
			FROM		tbs_thirdparties_supports AS ts
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = ts.request_id
			WHERE		ts.id = '$id'
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_request_id($request_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		ts.id,
						ts.request_id,
						tr.company_id AS 'request',
						ts.details,
						ts.file_extension,
						ts.created_at
			FROM		tbs_thirdparties_supports AS ts
			INNER JOIN	tbs_thirdparties_requests AS tr
						ON tr.id = ts.request_id
			WHERE		ts.request_id = '$request_id'

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT
			INTO		tbs_thirdparties_supports (`request_id`, `details`, `file_extension`, `created_at`)
			VALUES		('{$params['request_id']}', '{$params['details']}', '{$params['file_extension']}', now())

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

			UPDATE		tbs_thirdparties_supports
			SET			`request_id` = '{$params['request_id']}',
						`details` = '{$params['details']}',
						`file_extension` = '{$params['file_extension']}',
						`created_at` = '{$params['created_at']}'
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
			FROM		tbs_thirdparties_supports
			WHERE		id = '$id'

		");
	}
}