<?php

namespace tbs_transport_input_forms_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				tifp.*, 
				p.name AS product, 
				wh.*, 
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.id AS wid,
				ifp.packaging_id
			FROM 
				`tbs_transport_input_forms_products` AS tifp
			INNER JOIN 
				`tbs_warehouses` AS wh
			ON wh.id = tifp.warehouse_id
			INNER JOIN 
				`tbs_input_forms` AS ip
			ON ip.id = wh.form_id
			INNER JOIN 
				`tbs_input_forms_products` AS ifp
			ON ip.id = ifp.input_form_id
			INNER JOIN 
				`tbs_products` AS p
			ON p.id = wh.product_id
			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

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
				tifp.*, 
				p.name AS product, 
				wh.*, 
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.id AS wid,
				ifp.packaging_id
			FROM 
				`tbs_transport_input_forms_products` AS tifp
			INNER JOIN 
				`tbs_warehouses` AS wh
			ON wh.id = tifp.warehouse_id
			INNER JOIN 
				`tbs_input_forms` AS ip
			ON ip.id = wh.form_id
			INNER JOIN 
				`tbs_input_forms_products` AS ifp
			ON ip.id = ifp.input_form_id
			INNER JOIN 
				`tbs_products` AS p
			ON p.id = wh.product_id
			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id
			WHERE 
				tifp.id = $id
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

			FROM `tbs_transport_input_forms_products` AS tifp

			WHERE tifp.warehouse_id = $id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_last_transport($input_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT c.name AS company, ttif.id,
				tw.*,
				tw.form_id AS iid,
				ttifp.*,
				ttif.approved_at AS approved,
				ttif.*,
				ttif.id AS tid,
				fs.name AS 'state', 
				GROUP_CONCAT(p.name SEPARATOR ' - ') AS products,
				(SELECT created_at FROM tbs_transport_input_forms_supports WHERE form_id = tid AND input_form_support_type_id = 23 LIMIT 1) AS reception_date

			FROM
				tbs_company AS c, `tbs_warehouses` tw

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
				tw.`form_id` = $input_form_id

			GROUP BY ttif.id 
			ORDER BY ttif.id DESC

			LIMIT 1
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	SET EXECUTE FORM
 ---------------------------------------------------------------------*/
	public function set_execute_form($id, $value)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transport_input_forms_products` 

			SET
					`execute` = $value
					
					WHERE `id` = $id;

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
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
				tifp.*, 
				p.name AS 'product',
				p.id AS 'product_id', 
				ip.id AS 'input_form_id', 
				tif.id AS 'tif_id', 
				tifp.id AS 'tifp_id', 
				ifp.id AS 'ifp_id',
				p.*, 
				wh.*, wh.id AS wid,
				ifp.packaging_id

			FROM 
				`tbs_transport_input_forms_products` AS tifp

			INNER JOIN 
				`tbs_transport_input_forms` AS tif
			ON tif.id = tifp.form_id

			INNER JOIN 
				`tbs_warehouses` AS wh
			ON wh.id = tifp.warehouse_id

			INNER JOIN 
				`tbs_input_forms` AS ip
			ON ip.id = wh.form_id

			INNER JOIN 
				`tbs_input_forms_products` AS ifp
			ON ip.id = ifp.input_form_id

			INNER JOIN 
				`tbs_products` AS p
			ON p.id = wh.product_id

			WHERE 
				tif.id = $id AND wh.form_type = 1
			GROUP BY 
				tifp.id
		";
		
		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($form_id, $warehouse_id, $quantity, $execute = 0)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$quantity = str_replace(',', '.', $quantity);

		$sql = "

			INSERT INTO `tbs_transport_input_forms_products` (form_id, `warehouse_id`, `quantity`, `execute`)
			VALUES ('$form_id', '$warehouse_id', '$quantity', '$execute');

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

		return $this->db->query("

			UPDATE 
				`tbs_transport_input_forms_products` 
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
				`tbs_transport_input_forms_products`
			WHERE 
				`id` = $id
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}
}
