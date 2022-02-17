<?php

namespace tbs_warehouses;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				wh.*, p.name AS 'product', pt.name AS 'product_type', pu.symbol AS 'product_unit'
			FROM 
				`tbs_warehouses` AS wh
			INNER JOIN `tbs_products` AS p
				ON p.id = wh.product_id
			INNER JOIN tbs3.`tbs_products_types` AS pt
				ON pt.id = p.product_type_id
			INNER JOIN tbs3.`tbs_physical_units` AS pu
				ON pu.id = p.physical_unit_id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	get_forms_from_transport
 ---------------------------------------------------------------------*/
	public function get_forms_from_transport($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT ip.id FROM tbs_warehouses AS w
			INNER JOIN tbs_input_forms AS ip
			ON ip.id = w.form_id
			INNER JOIN tbs_input_forms_products AS ifp
			ON ifp.input_form_id = ip.id
			INNER JOIN tbs_transport_input_forms_products AS tifp
			ON tifp.warehouse_id = w.id
			INNER JOIN tbs_transport_input_forms AS tif
			ON tif.id= tifp.form_id
			WHERE tif.id = $id AND w.form_type = 1
			GROUP BY ip.id

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	get_forms_from_transport
 ---------------------------------------------------------------------*/
	public function get_forms_from_transport_out($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT tofp.output_form_id, tof.*
		    FROM tbs_transport_output_forms AS tof
			INNER JOIN tbs_transport_output_forms_products AS tofp
			ON tofp.form_id = tof.id
			WHERE tof.id = $id
			GROUP BY tofp.output_form_id

		";
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	get_last_transport
 ---------------------------------------------------------------------*/
	public function get_last_transport($output_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT tofp.id
		    FROM tbs_transport_output_forms_products AS tofp
			WHERE tofp.output_form_id = $output_form_id
			ORDER BY tofp.id DESC

		";
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	get_products_form
 ---------------------------------------------------------------------*/
	public function get_products_form($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT w.id AS wid, w.*
			FROM tbs_warehouses AS w
			INNER JOIN 
			tbs_input_forms AS ip
				ON ip.id = w.form_id
			INNER JOIN tbs_input_forms_products AS ifp
				ON ifp.input_form_id = ip.id
			WHERE ip.id = $form_id 
				AND w.form_type = 1
			GROUP by product_id

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	get_sum_virtual
 ---------------------------------------------------------------------*/
	public function get_sum_virtual($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT SUM(w.virtual) FROM tbs_warehouses AS w
			INNER JOIN tbs_input_forms AS ip
			ON ip.id = w.form_id
			WHERE w.form_type = 1
			AND ip.id = $id
			LIMIT 1
		")->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT *
			FROM 
				`tbs_warehouses` AS wh
			WHERE 
				id = $id
			LIMIT 1
		";

		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params, $form_type)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$params['quantity'] = str_replace(',', '.', $params['quantity']);

		return $this->db->query("

			INSERT INTO 
				`tbs_warehouses` 
			(`product_id`, `form_type`, `form_id`, `virtual`, `stock`,`reserved`)

			VALUES
			('{$params['product_id']}', '$form_type', '{$params['input_form_id']}', '{$params['quantity']}', '', '');

		");
	}

/*----------------------------------------------------------------------
	CREATE EMPTY
 ---------------------------------------------------------------------*/
	public function create_empty($product_id, $form_type)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$this->db->query("

			INSERT INTO 
				`tbs_warehouses` 
				(`product_id`, `form_type`, `form_id`)

				VALUES
				('$product_id', '$form_type', '0');

		");

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	create_reserved
 ---------------------------------------------------------------------*/
	public function create_reserved($product_id, $form_type, $form_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql = "

			INSERT INTO 
				`tbs_warehouses` 
			(`product_id`, `form_type`, `form_id`, `reserved`)

			VALUES
			('$product_id', '$form_type', '$form_id', '$quantity');

		";
		
		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	create_stock
 ---------------------------------------------------------------------*/
	public function create_stock($product_id, $form_type, $form_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql = "

			INSERT INTO 
				`tbs_warehouses` 
			(`product_id`, `form_type`, `form_id`, `stock`)

			VALUES
			('$product_id', '$form_type', '$form_id', '$quantity');

		";

		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	update_stock
 ---------------------------------------------------------------------*/
	public function update_stock($id, $form_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`form_id` = $form_id,
				`stock` = `stock` + '$quantity'
			WHERE 
				id = $id

		";
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	update_nac
 ---------------------------------------------------------------------*/
	public function update_nac($id, $approved, $inspected_to_output, $reserved_to_output, $dispatched)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$inspected_to_output = str_replace(',', '.', $inspected_to_output);
		$reserved_to_output = str_replace(',', '.', $reserved_to_output);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`approved` = $approved,
				`inspected_to_output` = $inspected_to_output,
				`reserved_to_output` = $reserved_to_output,
				`dispatched` = $dispatched
			WHERE 
				id = $id

		";
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	reserved_to_0
 ---------------------------------------------------------------------*/
	public function reserved_to_0($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`reserved` = 0
			WHERE 
				id = $id

		";
		
		return $this->db->query($sql);
	}


/*----------------------------------------------------------------------
	stock_to_0
 ---------------------------------------------------------------------*/
	public function stock_to_0($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`stock` = 0
			WHERE 
				id = $id

		";
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	MOVE ALL TO SCALE DIFF
 ---------------------------------------------------------------------*/
	public function move_all_to_scale_difference($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`scale_difference` = `virtual`,
				`virtual` = 0,
				`virtual_reserved` = 0,
				`locked` = 0,
				`inspected_to_input` = 0
			WHERE 
				id = $id

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	MOVE TO STOCK
 ---------------------------------------------------------------------*/
	public function from_virtual_to_stock_id($id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`stock` = `stock` + $quantity,
				`virtual` = `virtual` - $quantity
			WHERE 
				id = $id

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	from_virtual_to_stock
 ---------------------------------------------------------------------*/
	public function from_virtual_to_stock($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`stock` = stock + $quantity,
				`virtual` = `virtual` - $quantity
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	move_all_from_locked_to_stock
 ---------------------------------------------------------------------*/
	public function move_all_from_locked_to_stock($warehouse_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`stock` = `stock` +  `locked`,
				`locked` = 0
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	insert_lol
 ---------------------------------------------------------------------*/
	public function insert_lol($form_id, $product_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`stock` = $quantity
			WHERE 
				form_id = $form_id AND product_id = $product_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	add_to_locked
 ---------------------------------------------------------------------*/
	public function add_to_locked($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`locked` = `locked` +  $quantity
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	move_all_from_locked_to_stock
 ---------------------------------------------------------------------*/
	public function move_all_from_virtual_to_virtual_reserved($warehouse_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`virtual_reserved` = `virtual_reserved` +  `virtual`,
				`virtual` = 0
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	move_all_from_virtual_to_locked
 ---------------------------------------------------------------------*/
	public function move_all_from_virtual_to_locked($warehouse_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`locked` = `locked` +  `virtual`,
				`virtual` = 0
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	move_all_from_virtual_reserved_to_locked
 ---------------------------------------------------------------------*/
	public function move_all_from_virtual_reserved_to_locked($warehouse_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`locked` = `locked` +  `virtual_reserved`,
				`virtual_reserved` = 0
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	move_all_from_virtual_reserved_to_locked
 ---------------------------------------------------------------------*/
	public function move_all_from_virtual_to_scale_difference($warehouse_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`scale_difference` = `scale_difference` +  `virtual`,
				`virtual` = 0
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}


/*----------------------------------------------------------------------
	from_virtual_to_scale_difference
 ---------------------------------------------------------------------*/
	public function from_virtual_to_scale_difference($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`virtual` = `virtual` - $quantity,
				`scale_difference` = `scale_difference` + $quantity
			WHERE 
				id = $warehouse_id

		";
		/*if ($_SESSION['user']['company_id']=='900162578') {
			echo "ESTAMOS ARREGLANDO ALGO... ESPERE POR FAVOR :)";
			echo $_SESSION['user']['company_schema'];
			echo '<pre>'.print_r($sql, TRUE).'</pre>';
			die();
		}*/
		
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	FROM `virtual` TO `virtual` RESERVED
 ---------------------------------------------------------------------*/
	public function from_virtual_to_virtual_reserved($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`virtual_reserved` = virtual_reserved + '$quantity',
				`virtual` = `virtual` - '$quantity'
			WHERE 
				id = $warehouse_id

		";
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	FROM `virtual` RESERVED TO `virtual` 
 ---------------------------------------------------------------------*/
	public function from_virtual_reserved_to_virtual($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`virtual` = `virtual` + $quantity,
				`virtual_reserved` = `virtual_reserved` - $quantity
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	FROM VIRTUAL RESERVED TO LOCKED
 ---------------------------------------------------------------------*/
	public function from_virtual_reserved_to_locked($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`locked` = `locked` + $quantity,
				`virtual_reserved` = `virtual_reserved` - $quantity
			WHERE 
				id = $warehouse_id

		";
		
		return $this->db->query($sql);
	}


/*----------------------------------------------------------------------
	subtract_virtual_reserved
 ---------------------------------------------------------------------*/
	public function subtract_virtual_reserved($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`virtual_reserved` = `virtual_reserved` - $quantity
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	FROM `virtual` TO LOCKED
 ---------------------------------------------------------------------*/
	public function from_virtual_to_locked($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`locked` = `locked` + $quantity,
				`virtual` = `virtual` - $quantity
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	from_locked_to_inspected_to_input
 ---------------------------------------------------------------------*/
	public function from_locked_to_inspected_to_input($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`inspected_to_input` = `inspected_to_input` + $quantity,
				`locked` = `locked` - $quantity
			WHERE 
				`id` = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	from_approved_to_inspected_to_output
 ---------------------------------------------------------------------*/
	public function from_approved_to_inspected_to_output($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`approved` = `approved` - $quantity,
				`inspected_to_output` = `inspected_to_output` + $quantity
				
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	FROM INSPECTED TO INPUT TO STOCK
 ---------------------------------------------------------------------*/
	public function from_inspected_to_input_to_stock($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`stock` = `stock` + $quantity,
				`inspected_to_input` = `inspected_to_input` - $quantity
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	from_inspected_to_output_to_reserved_to_output
 ---------------------------------------------------------------------*/
	public function from_inspected_to_output_to_reserved_to_output($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`reserved_to_output` = `reserved_to_output` + $quantity,
				`inspected_to_output` = `inspected_to_output` - $quantity
			WHERE 
				id = $warehouse_id

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	from_inspected_to_output_to_reserved_to_output
 ---------------------------------------------------------------------*/
	public function from_reserved_to_output_to_inspected_to_output($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`inspected_to_output` = `inspected_to_output` + $quantity,
				`reserved_to_output` = `reserved_to_output` - $quantity
			WHERE 
				id = $warehouse_id

		";
		return $this->db->query($sql);
	}


/*----------------------------------------------------------------------
	MOVE TO RESERVED
 ---------------------------------------------------------------------*/
	public function from_stock_to_reserved($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`reserved` = `reserved` + $quantity,
				`stock` = `stock` - $quantity
			WHERE 
				id = $warehouse_id

		";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	MOVE FROM RESERVED TO STOCK
 ---------------------------------------------------------------------*/
	public function from_reserved_to_stock($warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql= "

			UPDATE 
				`tbs_warehouses` 
			SET
				`reserved` = `reserved` - $quantity,
				`stock` = `stock` + $quantity
			WHERE 
				id = $warehouse_id

		";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	FROM APPROVED TO DISPATCHED
 ---------------------------------------------------------------------*/
	public function from_reserved_to_output_to_dispatched($warehouse_id, $quantity)
	{
		$quantity = str_replace(',', '.', $quantity);

		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

			$sql= "

				UPDATE 
					`tbs_warehouses`
				SET
					`reserved_to_output` = `reserved_to_output` - $quantity,
					`dispatched` = `dispatched` + $quantity
				WHERE
					id = $warehouse_id

			";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	MOVE TO DISPATCHED
 ---------------------------------------------------------------------*/
	public function from_reserved_to_dispatched($warehouse_id, $quantity, $waste=0)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$dispatched = $quantity - $waste;

		if ($waste==0) {
			$sql= "

				UPDATE 
					`tbs_warehouses`
				SET
					`reserved` = reserved - $quantity,
					`dispatched` = dispatched + $dispatched
				WHERE
					id = $warehouse_id

			";
		}else{
			$sql= "

				UPDATE 
					`tbs_warehouses`
				SET
					`reserved` = reserved - $quantity,
					`dispatched` = dispatched + $dispatched,
					`waste` = waste + $waste
				WHERE
					id = $warehouse_id

			";
		}

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	MOVE TO APPROVE
 ---------------------------------------------------------------------*/
	public function from_reserved_to_approved($warehouse_id, $quantity)
	{
		$quantity = str_replace(',', '.', $quantity);

		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses`
			SET
				`reserved` = reserved - $quantity,
				`approved` = approved + $quantity
			WHERE
				id = $warehouse_id

		";

		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	FROM RESERVED TO INSPECTED_TO_OUTPUT
 ---------------------------------------------------------------------*/
	public function from_reserved_to_inspected_to_output($warehouse_id, $quantity)
	{
		$quantity = str_replace(',', '.', $quantity);

		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses`
			SET
				`reserved` = reserved - $quantity,
				`inspected_to_output` = inspected_to_output + $quantity
			WHERE
				id = $warehouse_id

		";

		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	FROM RESERVED TO NATIONALIZED
 ---------------------------------------------------------------------*/
	public function from_reserved_to_nationalized($warehouse_id, $quantity)
	{
		$quantity = str_replace(',', '.', $quantity);
		
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses`
			SET
				`reserved` = reserved - $quantity,
				`nationalized` = nationalized + $quantity
			WHERE
				id = $warehouse_id

		";
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	FROM DISPATCHED TO STOCK
 ---------------------------------------------------------------------*/
	public function from_dispatched_to_stock($warehouse_id, $quantity)
	{
		$quantity = str_replace(',', '.', $quantity);
		
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql= "

			UPDATE 
				`tbs_warehouses`
			SET
				`dispatched` = dispatched - $quantity,
				`stock` = stock + $quantity
			WHERE
				id = $warehouse_id

		";
		
		return $this->db->query($sql);
	}
}
