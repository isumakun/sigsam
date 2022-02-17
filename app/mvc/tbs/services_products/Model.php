<?php

namespace tbs_services_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		return $this->db->query("

			SELECT * FROM tbs_services_products

		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT * FROM tbs_services_products
			WHERE id = $id
			LIMIT 1

		")->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT * FROM tbs_services_products AS sp
			INNER JOIN tbs_products AS p
			ON sp.product_id = p.id
			WHERE service_id = $id

		";

		return $this->db->query($sql)->fetchAll();
	}


/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO `tbs_services_products` (`product_id`, `service_id`)
			VALUES ('{$params['product_id']}', '{$params['service_id']}');

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
				`tbs_services_products` 
			SET
				`product_id` = '{$params['product_id']}',
				`service_id` = '{$params['service_id']}'
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
				`tbs_services_products`
			WHERE 
				`id` = $id 
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}
}
