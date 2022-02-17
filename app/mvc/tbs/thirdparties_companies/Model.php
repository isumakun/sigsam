<?php

namespace tbs_thirdparties_companies;

class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tc.id,
						tc.nit,
						tc.name
			FROM		tbs_thirdparties_companies AS tc
			ORDER BY	tc.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tc.id,
						tc.nit,
						tc.name
			FROM		tbs_thirdparties_companies AS tc
			WHERE		tc.id = '$id'
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
			INTO		tbs_thirdparties_companies (`nit`, `name`)
			VALUES		('{$params['nit']}', '{$params['name']}')

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

		$sql = "

			UPDATE		tbs_thirdparties_companies
			SET			`nit` = '{$params['nit']}',
						`name` = '{$params['name']}'
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
			FROM		tbs_thirdparties_companies
			WHERE		id = '$id'

		");
	}
}