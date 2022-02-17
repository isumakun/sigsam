<?php

namespace tbs_warehouses_tools;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		return $this->db->query("

			SELECT *
			FROM `tbs_warehouses_tools`

		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT t.*
			FROM `tbs_warehouses_tools` AS t
			WHERE t.id = $id
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

			INSERT INTO `tbs_warehouses_tools` (`name`, `stock`)
			VALUES ('{$params['name']}', '{$params['stock']}');

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
				`tbs_warehouses_tools` 
			SET
				`name` = '{$params['name']}',
				`stock` = '{$params['stock']}'
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
				`tbs_warehouses_tools`
			WHERE 
				`id` = $id 
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}
}
