<?php

namespace tbs_services;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		return $this->db->query("

			SELECT d.*, s.name AS supplier
			FROM `tbs_services` AS d
			INNER JOIN tbs_suppliers AS s
			ON s.id = d.supplier_id
			ORDER BY d.id DESC

		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT d.*, s.name AS supplier
			FROM `tbs_services` AS d
			INNER JOIN tbs_suppliers AS s
			ON s.id = d.supplier_id
			WHERE d.id = $id
			LIMIT 1
		")->fetchAll()[0];
	}


/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO `tbs_services` (`service_type`, `supplier_id`, `bill_number`, `bill_date`, `cost`)
			VALUES ('{$params['service_type']}', '{$params['supplier_id']}', '{$params['bill_number']}', '{$params['bill_date']}', '{$params['cost']}');

		";

		$this->db->query($sql);

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
				`tbs_services` 
			SET
				`service_type` = '{$params['service_type']}',
				`supplier_id` = '{$params['supplier_id']}',
				`bill_number` = '{$params['bill_number']}',
				`bill_date` = '{$params['bill_date']}',
				`cost` = '{$params['cost']}'
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
				`tbs_services`
			WHERE 
				`id` = $id 
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}
}
