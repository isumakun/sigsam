<?php

namespace tbs_input_forms_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");


		$sql = "

			INSERT INTO
				`tbs_input_forms_products` (
					`input_form_id`,
					`product_id`,
					`product_category_id`,
					`quantity`,
					`commercial_quantity`,
					`unit_value`,
					`fob_value`,
					`net_weight`,
					`gross_weight`,
					`freights`,
					`packaging_id`,
					`insurance`,
					`other_expenses`,
					`flag_id`
					)

			VALUES (
				'{$params['input_form_id']}',
				'{$params['product_id']}',
				'{$params['product_category_id']}',
				'{$params['quantity']}',
				'{$params['commercial_quantity']}',
				'{$params['unit_value']}',
				'{$params['fob_value']}',
				'{$params['net_weight']}',
				'{$params['gross_weight']}',
				'{$params['freights']}',
				'{$params['packaging_id']}',
				'{$params['insurance']}',
				'{$params['other_expenses']}',
				'{$params['flag_id']}'
			);

		";


		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	CREATE MASSIVELY
 ---------------------------------------------------------------------*/
	public function create_massively($net_weight, $gross_weight, $fob_value, $freights, $insurance, $other_expenses, $params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO
				`tbs_input_forms_products` (
					`input_form_id`,
					`product_id`,
					`product_category_id`,
					`quantity`,
					`commercial_quantity`,
					`unit_value`,
					`fob_value`,
					`net_weight`,
					`gross_weight`,
					`freights`,
					`packaging_id`,
					`insurance`,
					`other_expenses`,
					`flag_id`
					)

			VALUES (
				{$params['input_form_id']},
				{$params['product_id']},
				{$params['product_category_id']},
				{$params['quantity']},
				{$params['commercial_quantity']},
				$unit_value,
				$fob_value,
				$net_weight,
				$gross_weight,
				$freights,
				{$params['packaging_id']},
				$insurance,
				$other_expenses,
				{$params['flag_id']}
			);

		";

		echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	CREATE ALL IN ONE
 ---------------------------------------------------------------------*/
	public function create_all_in_one($sql)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");		

		return $this->db->exec($sql);;
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				ifp.*,
				p.*,
				ifp.id AS ifp_id,
				p.id AS product_id,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				pu.symbol AS unit_symbol

			FROM
				`tbs_input_forms_products` AS ifp

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = ifp.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = ifp.input_form_id

			WHERE
				ifp.id = $id

			LIMIT 1

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET IN WAREHOUSE
 ---------------------------------------------------------------------*/
	public function get_in_warehouse($warehouse_id, $form_id = '')
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$and_form_id = '';

		if ($form_id!='') {
			$and_form_id = 'AND ifp.input_form_id = '.$form_id;
		}

		$sql = "

			SELECT
				p.id AS product_id,
				p.name AS product,
				pt.name AS product_type,
				th.id AS tariff_heading_id,
				th.physical_unit AS tariff_heading_unit,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.*

			FROM
				`tbs_warehouses` AS wh

			LEFT JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = wh.form_id

			LEFT JOIN
				`tbs_input_forms_products` AS ifp
					ON
						ifp.product_id = wh.product_id
						$and_form_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			WHERE
				wh.id = $warehouse_id

			LIMIT 1

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	get_with_warehouse_id
 ---------------------------------------------------------------------*/
	public function get_with_warehouse_id($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				f.id AS flag_id,
				w.id AS wid, w.*,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				th.id AS tariff_heading_id,
				th.physical_unit AS tariff_heading_unit,
				pc.name AS category,
				pack.name AS packing,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				pu.symbol AS unit_symbol,
				f.name AS flag,
				ifp.id AS ifp_id

			FROM
				`tbs_input_forms_products` AS ifp

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = ifp.input_form_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pack
					ON
						pack.id = ifp.packaging_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ifp.flag_id

			INNER JOIN
				`tbs_warehouses` AS w
					ON
						w.form_id = ip.id
			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = w.product_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ifp.product_category_id

			WHERE
				ip.`id` = $form_id
				AND w.form_type = 1

			GROUP BY w.id
			ORDER BY th.id, ifp.id
		

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	get_in_virtual
 ---------------------------------------------------------------------*/
	public function get_in_virtual($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				f.id AS flag_id,
				w.id AS wid, w.*,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				th.id AS tariff_heading_id,
				th.physical_unit AS tariff_heading_unit,
				pc.name AS category,
				pack.name AS packing,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				pu.symbol AS unit_symbol,
				f.name AS flag,
				ifp.id AS ifp_id

			FROM
				`tbs_input_forms_products` AS ifp

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = ifp.input_form_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pack
					ON
						pack.id = ifp.packaging_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ifp.flag_id

			INNER JOIN
				`tbs_warehouses` AS w
					ON
						w.form_id = ip.id
			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = w.product_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ifp.product_category_id

			WHERE
				ip.`id` = $form_id
				AND w.form_type = 1 AND w.virtual > 0

			GROUP BY w.id
			ORDER BY th.id, ifp.id
		

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	get_in_locked
 ---------------------------------------------------------------------*/
	public function get_in_locked($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				f.id AS flag_id,
				w.id AS wid, w.*,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				th.id AS tariff_heading_id,
				th.physical_unit AS tariff_heading_unit,
				pc.name AS category,
				pack.name AS packing,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				pu.symbol AS unit_symbol,
				f.name AS flag,
				ifp.id AS ifp_id

			FROM
				`tbs_input_forms_products` AS ifp

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = ifp.input_form_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pack
					ON
						pack.id = ifp.packaging_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ifp.flag_id

			INNER JOIN
				`tbs_warehouses` AS w
					ON
						w.form_id = ip.id
			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = w.product_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ifp.product_category_id

			WHERE
				ip.`id` = $form_id
				AND w.form_type = 1 AND w.locked > 0

			GROUP BY w.id
			ORDER BY th.id, ifp.id
		

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "
			DELETE FROM
				`tbs_input_forms_products`
			WHERE
				`id` = $id
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	VERIFY
 ---------------------------------------------------------------------*/
	public function verify($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE
				`tbs_input_forms_products`

			SET
					is_verified  = 1

					WHERE `id` = $id;

		";
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit($params)
	{
		/*echo '<pre>'.print_r($params, TRUE).'</pre>';
		die();*/
		$params['quantity'] = str_replace(',', '.', $params['quantity']);
		$params['commercial_quantity'] = str_replace(',', '.', $params['commercial_quantity']);
		$params['unit_value'] = str_replace(',', '.', $params['unit_value']);
		$params['net_weight'] = str_replace(',', '.', $params['net_weight']);
		$params['fob_value'] = str_replace(',', '.', $params['fob_value']);
		$params['gross_weight'] = str_replace(',', '.', $params['gross_weight']);
		$params['freights'] = str_replace(',', '.', $params['freights']);
		$params['insurance'] = str_replace(',', '.', $params['insurance']);
		$params['other_expenses'] = str_replace(',', '.', $params['other_expenses']);

		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		$sql = "

			UPDATE
				`tbs_input_forms_products`
			SET
				`input_form_id` = '{$params['input_form_id']}',
				`product_id` = '{$params['product_id']}',
				`product_category_id` = '{$params['product_category_id']}',
				`quantity` = '{$params['quantity']}',
				`commercial_quantity` = '{$params['commercial_quantity']}',
				`unit_value` = '{$params['unit_value']}',
				`fob_value` = '{$params['fob_value']}',
				`net_weight` = '{$params['net_weight']}',
				`gross_weight` = '{$params['gross_weight']}',
				`freights` = '{$params['freights']}',
				`packaging_id` = '{$params['packaging_id']}',
				`insurance` = '{$params['insurance']}',
				`other_expenses` = '{$params['other_expenses']}',
				`flag_id` = '{$params['flag_id']}'
			WHERE
				`id` = '{$params['id']}';

		";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit_with_id($params, $id)
	{
		/*echo '<pre>'.print_r($params, TRUE).'</pre>';
		die();*/

		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		$sql = "

			UPDATE
				`tbs_input_forms_products`
			SET
				`input_form_id` = '{$params['input_form_id']}',
				`product_id` = '{$params['product_id']}',
				`product_category_id` = '{$params['product_category_id']}',
				`quantity` = '{$params['quantity']}',
				`commercial_quantity` = '{$params['commercial_quantity']}',
				`unit_value` = '{$params['unit_value']}',
				`fob_value` = '{$params['fob_value']}',
				`net_weight` = '{$params['net_weight']}',
				`gross_weight` = '{$params['gross_weight']}',
				`freights` = '{$params['freights']}',
				`packaging_id` = '{$params['packaging_id']}',
				`insurance` = '{$params['insurance']}',
				`other_expenses` = '{$params['other_expenses']}',
				`flag_id` = '{$params['flag_id']}'
			WHERE
				`id` = $id;

		";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	GET UNVERIFIED
 ---------------------------------------------------------------------*/
	public function get_unverified($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		/*echo '<pre>'.print_r($form_id, TRUE).'</pre>';
		die();*/
		return $this->db->query("

			SELECT
				ifp.*,
				p.*,
				ifp.id AS ifp_id,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading

			FROM
				`tbs_input_forms_products` AS ifp

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = ifp.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			WHERE
				ifp.input_form_id = $form_id
				AND
				ifp.is_verified = 0

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($input_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				ifp.*,
				p.*,
				ifp.id AS ifp_id,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading_code,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				th.id AS tariff_heading_id,
				th.physical_unit AS tariff_heading_unit,
				pc.name AS category,
				pack.name AS packing,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				pu.symbol AS unit_symbol,
				f.name AS flag,
				f.id AS flag_id

			FROM
				`tbs_input_forms_products` AS ifp

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = ifp.input_form_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = ifp.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ifp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pack
					ON
						pack.id = ifp.packaging_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ifp.flag_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			WHERE
				ip.`id` = $input_form_id

			ORDER BY th.id, ifp.id


		";


		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id_approved($input_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				
				ifp.*,
				p.*,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				th.id AS tariff_heading_id,
				th.physical_unit AS tariff_heading_unit,
				pc.name AS category,
				pack.name AS packing,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				pu.symbol AS unit_symbol,
				f.name AS flag,
				f.id AS flag_id,
				wh.id AS wid, wh.*

			FROM
				`tbs_input_forms` AS ip

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.form_id = ip.id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				`tbs_input_forms_products` AS ifp
					ON
						ifp.product_id= wh.product_id
						AND
						ip.id = ifp.input_form_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ifp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pack
					ON
						pack.id = ifp.packaging_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ifp.flag_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			WHERE
				ip.`id` = $input_form_id 
				AND wh.form_type = 1

			GROUP BY wh.id
		";


		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	SCRIPT
 ---------------------------------------------------------------------*/
	public function get_all_insumos()
	{

		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "
			SELECT
				ifp.*,
				p.*,
				ifp.id AS ifp_id,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				th.id AS tariff_heading_id,
				th.physical_unit AS tariff_heading_unit,
				pc.name AS category,
				pack.name AS packing,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				pu.symbol AS unit_symbol,
				f.name AS flag,
				f.id AS flag_id

			FROM
				`tbs_input_forms_products` AS ifp

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = ifp.input_form_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = ifp.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ifp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pack
					ON
						pack.id = ifp.packaging_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ifp.flag_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			WHERE
				ifp.product_category_id = 9 AND ip.form_state_id = 3

			ORDER BY th.id, ifp.id
		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id_single($input_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				ifp.*

			FROM
				`tbs_input_forms_products` AS ifp

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = ifp.input_form_id
			WHERE
				ip.`id` = $input_form_id

			ORDER BY ifp.id

			LIMIT 1

		";


		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	get_all_granel
 ---------------------------------------------------------------------*/
	public function get_all_granel()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				w.id AS wid,
				w.virtual AS virtual,
				w.form_id,
				ifp.*,
				p.*,
				ifp.id AS ifp_id,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				th.id AS tariff_heading_id,
				th.code AS tariff_heading_code,
				th.physical_unit AS tariff_heading_unit,
				pc.name AS category,
				pack.name AS packing,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				pu.symbol AS unit_symbol,
				f.name AS flag,
				f.id AS flag_id

			FROM
				`tbs_input_forms_products` AS ifp

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = ifp.input_form_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = ifp.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ifp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pack
					ON
						pack.id = ifp.packaging_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ifp.flag_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				`tbs_warehouses` AS w
					ON
						w.form_id = ip.id

			WHERE
				pack.id = 48 AND w.virtual>0

			ORDER BY th.id, ifp.id


		";


		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY PRODUCT ID
 ---------------------------------------------------------------------*/
	public function get_by_product_id($product_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				w.*,
				ifp.*

			FROM
				`tbs_warehouses` AS w

			INNER JOIN
				tbs_input_forms_products AS ifp
					ON
						ifp.product_id = w.product_id
						AND
						ifp.input_form_id = w.form_id
						AND
						w.form_type = 1

			WHERE
				w.id = $product_id

			LIMIT 1

		";

		return $this->db->query($sql)->fetchAll();
	}


}
