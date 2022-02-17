<?php

namespace tbs_thirdparties_works_types;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		twt.id,
						twt.name
			FROM		tbs3.tbs_thirdparties_works_types AS twt
			ORDER BY	twt.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		twt.id,
						twt.name
			FROM		tbs3.tbs_thirdparties_works_types AS twt
			WHERE		twt.id = '$id'
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			INSERT
			INTO		tbs3.tbs_thirdparties_works_types (`name`)
			VALUES		('{$params['name']}')

		");
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			UPDATE		tbs3.tbs_thirdparties_works_types
			SET			`name` = '{$params['name']}'
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
			FROM		tbs3.tbs_thirdparties_works_types
			WHERE		id = '$id'

		");
	}
}