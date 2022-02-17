<?php

namespace tbs_transport_output_forms_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_transport_output_forms_products`

		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT 
				tofp.*, p.name AS product, wh.*, wh.id AS wid
			FROM 
				`tbs_transport_output_forms_products` AS tofp
			INNER JOIN 
				`tbs_warehouses` AS wh
			ON wh.id = tofp.warehouse_id
			INNER JOIN 
				`tbs_output_forms` AS op
			ON tofp.output_form_id = op.id
			INNER JOIN 
				`tbs_products` AS p
			ON p.id = wh.product_id
			WHERE 
				tofp.id = $id
			LIMIT 1
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET PRODUCT ID
 ---------------------------------------------------------------------*/
	public function get_by_product_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *

			FROM `tbs_transport_output_forms_products` AS tofp

			WHERE tofp.warehouse_id = $id

		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_last_transport($output_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT 
				tof.*
			FROM 
				`tbs_transport_output_forms_products` AS tofp
			INNER JOIN 
				`tbs_transport_output_forms` AS tof
			ON tof.id = tofp.form_id
			INNER JOIN 
				`tbs_output_forms` AS op
			ON tofp.output_form_id = op.id
			
			WHERE 
				tofp.output_form_id = $output_form_id
			ORDER BY tofp.id DESC
			LIMIT 1
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	change_ext_to_nac
 ---------------------------------------------------------------------*/
	public function change_ext_to_nac($old_wid, $new_wid)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE
				`tbs_transport_output_forms_products`

			SET
					warehouse_id  = $new_wid

					WHERE `warehouse_id` = $old_wid;

		";
		return $this->db->query($sql);
	}
	
/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT 
				tofp.*, p.name AS 'product', p.id AS 'product_id', tof.id AS 'tof_id', tofp.id AS 'tofp_id', p.*
			FROM 
				`tbs_transport_output_forms_products` AS tofp
			INNER JOIN 
				`tbs_transport_output_forms` AS tof
			ON tof.id = tofp.form_id
			INNER JOIN 
				`tbs_warehouses` AS wh
			ON wh.id = tofp.warehouse_id
			INNER JOIN 
				`tbs_products` AS p
			ON p.id = wh.product_id
			WHERE 
				tof.id = $id
			GROUP BY
				tofp.id
		";
		
		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	
 ---------------------------------------------------------------------*/
	public function get_sum_transports($output_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT 
				SUM(tofp.quantity) AS sum
			FROM 
				`tbs_transport_output_forms_products` AS tofp
			INNER JOIN 
				`tbs_transport_output_forms` AS tof
					ON tof.id = tofp.form_id
			WHERE 
				tofp.output_form_id = $output_form_id AND tof.form_state_id = 3
		";
		
		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($form_id, $warehouse_id, $quantity, $output_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);
		
		$sql = "

			INSERT INTO `tbs_transport_output_forms_products` (form_id, `warehouse_id`, `output_form_id`, `quantity`)
			VALUES ('$form_id', '$warehouse_id', '$output_form_id', '$quantity');

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$params['quantity'] = str_replace(',', '.', $params['quantity']);
		/*echo '<pre>'.print_r($params, TRUE).'</pre>';
		die();*/
		return $this->db->query("

			UPDATE 
				`tbs_transport_output_forms_products` 
			SET
				`form_id` = '{$params['form_id']}',
				`warehouse_id` = '{$params['warehouse_id']}',
				`quantity` = '{$params['quantity']}'
			WHERE 
				`id` = '{$params['id']}';

		");
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "
			DELETE FROM 
				`tbs_transport_output_forms_products`
			WHERE 
				`id` = $id
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}
}
