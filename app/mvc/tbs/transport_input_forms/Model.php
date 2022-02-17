<?php

namespace tbs_transport_input_forms;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT tif.*, 
					fs.name AS 'state',
				   d.name AS driver_name,
				   s.name AS supplier,
				   u1.username AS created_by_user,
				   u2.username AS approved_by_user

			FROM `tbs_transport_input_forms` AS tif
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = tif.form_state_id

			LEFT JOIN 
				`tbs_drivers` AS d
				ON 
					d.id = tif.driver_citizen_id

			LEFT JOIN 
				`tbs_suppliers` AS s
				ON 
					s.id = tif.supplier_id

			LEFT JOIN 
				tbs3.`admin_users` AS u1
				ON 
					u1.id = tif.created_by

			LEFT JOIN 
				tbs3.`admin_users` AS u2
				ON 
					u2.id = tif.approved_by

			ORDER BY `tif`.id DESC
		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET ALL PRESENTED
 ---------------------------------------------------------------------*/
	public function get_all_presented()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT tif.*, 
					fs.name AS 'state',
				   d.name AS driver_name,
				   s.name AS supplier,
				   com.id AS company_id,
				   com.name AS company_name,
				   GROUP_CONCAT(p.name SEPARATOR ' - ') AS products

			FROM tbs_company AS com, `tbs_transport_input_forms` AS tif

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = tif.form_state_id

			INNER JOIN 
				`tbs_transport_input_forms_products` AS tifp
				ON 
					tifp.form_id = tif.id

			INNER JOIN 
				`tbs_warehouses` AS w
				ON 
					w.id = tifp.warehouse_id

			INNER JOIN 
				`tbs_products` AS p
				ON 
					w.product_id = p.id	

			LEFT JOIN 
				`tbs_drivers` AS d
				ON 
					d.id = tif.driver_citizen_id

			LEFT JOIN 
				`tbs_suppliers` AS s
				ON 
					s.id = tif.supplier_id

			WHERE tif.form_state_id = 2 AND tif.starting_weight_value = 0
			GROUP BY tif.id
			ORDER BY `tif`.id DESC
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT tif.*, 
				   fs.name AS 'state',
				   d.name AS driver_name,
				   s.name AS supplier,
				   u1.username AS created_by_user,
				   u2.username AS approved_by_user

			FROM `tbs_transport_input_forms` AS tif
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = tif.form_state_id

			LEFT JOIN 
				`tbs_drivers` AS d
				ON 
					d.id = tif.driver_citizen_id

			LEFT JOIN 
				`tbs_suppliers` AS s
				ON 
					s.id = tif.supplier_id

			LEFT JOIN 
				tbs3.`admin_users` AS u1
				ON 
					u1.id = tif.created_by

			LEFT JOIN 
				tbs3.`admin_users` AS u2
				ON 
					u2.id = tif.approved_by

			WHERE tif.id = $id
			LIMIT 1

		")->fetchAll()[0];
	}
	
/*----------------------------------------------------------------------
	GET ALL
	No debería estar acá, sino en su respectivo modelo
 ---------------------------------------------------------------------*/
	public function get_transports_by_form_approved($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

			$sql = "

			SELECT
				tw.*,
				tw.form_id AS iid,
				ttifp.*,
				ttif.approved_at AS approved,
				ttif.*,
				ttif.id AS tid,
				fs.name AS 'state', 
				GROUP_CONCAT(p.name SEPARATOR ' - ') AS products


			FROM
				`tbs_warehouses` tw

			INNER JOIN
				tbs_transport_input_forms_products AS ttifp
					ON
						ttifp.warehouse_id = tw.id

			INNER JOIN
				tbs_transport_input_forms AS ttif
					ON
						ttif.id =ttifp.form_id

			INNER JOIN
				tbs3.tbs_forms_states AS fs
					ON
						fs.id =ttif.form_state_id

			INNER JOIN
				tbs_products AS p
					ON
						p.id = tw.product_id

			WHERE
				tw.`form_id` = $form_id AND ttif.form_state_id = 3

			GROUP BY ttif.id 

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$this->db->query("

			INSERT INTO `tbs_transport_input_forms` (`driver_citizen_id`, `vehicle_plate`, `trailer_number`, `supplier_id`, `created_by`, `created_at`)
			VALUES ('{$params['driver_citizen_id']}', '{$params['vehicle_plate']}', '{$params['trailer_number']}', '{$params['supplier_id']}', '{$_SESSION['user']['id']}', now())

		");

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	APPROVE
 ---------------------------------------------------------------------*/
	public function approve($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`approved_by` = '{$_SESSION['user']['id']}',
					`approved_at` = now(),
					form_state_id  = 3
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}


/*----------------------------------------------------------------------
	SET STARTING WEIGHT
 ---------------------------------------------------------------------*/
	public function set_starting_weight($weight, $id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`starting_weight_value` = '$weight',
					`starting_weight_date` = now()
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	SET ENDING WEIGHT
 ---------------------------------------------------------------------*/
	public function set_ending_weight($weight, $id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`ending_weight_value` = $weight,
					`ending_weight_date` = now()
					
					WHERE `id` = $id;

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	SET QUANTITY MANIFESTED
 ---------------------------------------------------------------------*/
	public function set_quantity_manifested($quantity, $id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`quantity_manifested` = $quantity
					
					WHERE `id` = $id;

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		return $this->db->query($sql);
	}


/*----------------------------------------------------------------------
	SET IS LAST TRUCK
 ---------------------------------------------------------------------*/
	public function set_is_last_truck($id, $is_last_truck)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`is_last_truck` = $is_last_truck
					
					WHERE `id` = $id;

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 
			SET
				`driver_citizen_id` = '{$params['driver_citizen_id']}',
				`vehicle_plate` = '{$params['vehicle_plate']}',
				`trailer_number` = '{$params['trailer_number']}',
				`supplier_id` = '{$params['supplier_id']}'
			WHERE 
				`id` = '{$params['id']}';

		";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	EDIT CHARGE INFO
 ---------------------------------------------------------------------*/
	public function edit_charge_info($params, $id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`charge_unit_number_manifested` = '{$params['charge_unit_number_manifested']}',
					`charge_unit_number_verified` = '{$params['charge_unit_number_verified']}',
					seal_number_manifested 	    = '{$params['seal_number_manifested']}',
					seal_number_verified		= '{$params['seal_number_verified']}'
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	PRESENT
 ---------------------------------------------------------------------*/
	public function present($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`presented_by` = '{$_SESSION['user']['id']}',
					`presented_at` = now(),
					form_state_id  = 2
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	EXECUTE
 ---------------------------------------------------------------------*/
	public function execute($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`executed_by` = '{$_SESSION['user']['id']}',
					`executed_at` = now(),
					form_state_id  = 5
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}
/*----------------------------------------------------------------------
	RECOVER
 ---------------------------------------------------------------------*/
	public function recover($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`presented_by` = '',
					`presented_at` = '0000-00-00 00:00:00',
					form_state_id 	   = 1
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	RETURN PRESENTED
 ---------------------------------------------------------------------*/
	public function return_presented($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			UPDATE 
				`tbs_transport_input_forms` 

			SET
					`presented_by` = '',
					`presented_at` = '0000-00-00 00:00:00',
					form_state_id 	   = 4
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}
}
