<?php

namespace tbs_thirdparties_employees;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		te.id,
						te.citizen_id,
						te.name
			FROM		tbs_thirdparties_employees AS te
			ORDER BY	te.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		te.id,
						te.citizen_id,
						te.name
			FROM		tbs_thirdparties_employees AS te
			WHERE		te.id = '$id'
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
			INTO		tbs_thirdparties_employees (`citizen_id`, `name`)
			VALUES		('{$params['citizen_id']}', '{$params['name']}')

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

			UPDATE		tbs_thirdparties_employees
			SET			`citizen_id` = '{$params['citizen_id']}',
						`name` = '{$params['name']}'
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
			FROM		tbs_thirdparties_employees
			WHERE		id = '$id'

		");
	}
}