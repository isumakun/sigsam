<?php

namespace tbs_suppliers;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_suppliers`

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_suppliers`
			WHERE id = $id
			LIMIT 1

		")->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$this->db->query("

			INSERT INTO `tbs_suppliers` (`nit`, `name`)
			VALUES ('{$params['nit']}', '{$params['name']}');

		");

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_suppliers` 
			SET
				`nit` = '{$params['nit']}',
				`name` = '{$params['name']}'
			WHERE 
				`id` = '{$params['id']}';

		";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "
			DELETE FROM 
				`tbs_suppliers`
			WHERE 
				`id` = $id 
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}
}
