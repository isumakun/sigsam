<?php

namespace tbs_transport_output_forms;

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
				   u.username AS created_by

			FROM `tbs_transport_output_forms` AS tif
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = tif.form_state_id

			INNER JOIN 
				tbs3.`admin_users` AS u
				ON 
					u.id = tif.created_by

			LEFT JOIN 
				`tbs_drivers` AS d
				ON 
					d.id = tif.driver_citizen_id

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
				   com.id AS company_id,
				   com.name AS company_name,
				   p.name AS product,
				   GROUP_CONCAT(p.name SEPARATOR ' - ') AS products

			FROM tbs_company AS com, `tbs_transport_output_forms` AS tif

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = tif.form_state_id

			INNER JOIN 
				`tbs_transport_output_forms_products` AS tifp
				ON 
					tifp.form_id = tif.id

			INNER JOIN 
				`tbs_transport_output_forms_logs` AS tofl
				ON 
					tofl.form_id = tif.id

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

			WHERE tif.form_state_id = 2 AND tofl.form_state_id = 12
			GROUP BY tif.id
			ORDER BY `tif`.id DESC
		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET APPROVED
 ---------------------------------------------------------------------*/
	public function get_approved()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT tif.*, 
					fs.name AS 'state',
				   d.name AS driver_name,
				   com.id AS company_id,
				   com.name AS company_name,
				   p.name AS product,
				   GROUP_CONCAT(p.name SEPARATOR ' - ') AS products

			FROM tbs_company AS com, `tbs_transport_output_forms` AS tif

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = tif.form_state_id

			INNER JOIN 
				`tbs_transport_output_forms_products` AS tifp
				ON 
					tifp.form_id = tif.id

			INNER JOIN 
				`tbs_transport_output_forms_logs` AS tofl
				ON 
					tofl.form_id = tif.id

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

			WHERE tif.form_state_id = 3
			GROUP BY tif.id
			ORDER BY `tif`.id DESC
			LIMIT 20
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL CREATED
 ---------------------------------------------------------------------*/
	public function get_all_created()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT tif.*, 
					fs.name AS 'state',
				   d.name AS driver_name,
				   com.name AS company_name

			FROM tbs_company AS com, `tbs_transport_output_forms` AS tif

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = tif.form_state_id

			INNER JOIN 
				`tbs_drivers` AS d
				ON 
					d.id = tif.driver_citizen_id

			WHERE (tif.form_state_id = 1 OR tif.form_state_id = 4)

			ORDER BY `tif`.id DESC

			LIMIT 100
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
				   u1.username AS created_by_user,
				   u2.username AS approved_by_user
				   
			FROM `tbs_transport_output_forms` AS tif
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = tif.form_state_id

			LEFT JOIN 
				`tbs_drivers` AS d
				ON 
					d.id = tif.driver_citizen_id

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
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$this->db->query("

			INSERT INTO `tbs_transport_output_forms` (`driver_citizen_id`, `trailer_number`, `vehicle_plate`, `created_by`, `created_at`)
			VALUES ('{$params['driver_citizen_id']}', '{$params['trailer_number']}', '{$params['vehicle_plate']}', '{$_SESSION['user']['id']}', now())

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
				`tbs_transport_output_forms` 
			SET
				`driver_citizen_id` = '{$params['driver_citizen_id']}',
				`vehicle_plate` = '{$params['vehicle_plate']}',
				`trailer_number` = '{$params['trailer_number']}'
			WHERE 
				`id` = '{$params['id']}';

		";
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	APPROVE
 ---------------------------------------------------------------------*/
	public function approve($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_output_forms` 

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
	SET charge_unit_number_verified
 ---------------------------------------------------------------------*/
	public function set_charge_unit_number($charge_unit_number, $id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_output_forms` 

			SET
					`charge_unit_number_verified` = '$charge_unit_number'
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
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
				`tbs_transport_output_forms` 

			SET
					`charge_unit_number_verified` = '{$params['charge_unit_number_verified']}',
					seal_number_verified		= '{$params['seal_number_verified']}'
					
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
				`tbs_transport_output_forms` 

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
				`tbs_transport_output_forms` 

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
	PRESENT
 ---------------------------------------------------------------------*/
	public function present($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_output_forms` 

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
				`tbs_transport_output_forms` 

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
				`tbs_transport_output_forms` 

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
	VERIFIED
 ---------------------------------------------------------------------*/
	public function verified($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_output_forms` 

			SET
					form_state_id 	   = 12
					
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
				`tbs_transport_output_forms` 

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
