<?php

namespace tbs_output_forms_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO
				`tbs_output_forms_products` (
					`output_form_id`,
					`warehouse_id`,
					`tariff_heading_id`,
					`product_category_id`,
					`quantity`,
					`commercial_quantity`,
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
				{$params['output_form_id']},
				{$params['warehouse_id']},
				{$params['tariff_heading_id']},
				{$params['product_category_id']},
				'{$params['quantity']}',
				'{$params['commercial_quantity']}',
				'{$params['fob_value']}',
				'{$params['net_weight']}',
				'{$params['gross_weight']}',
				'{$params['freights']}',
				'{$params['packaging_id']}',
				'{$params['insurance']}',
				'{$params['other_expenses']}',
				{$params['flag_id']}
			);

		";
		$this->db->query($sql);
		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	CREATE MASSIVELY
 ---------------------------------------------------------------------*/
	public function create_massively($form_id, $params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$params['fob_value'] = str_replace(',', '.', $params['fob_value']);
		$params['net_weight'] = str_replace(',', '.', $params['net_weight']);
		$params['gross_weight'] = str_replace(',', '.', $params['gross_weight']);
		$params['freights'] = str_replace(',', '.', $params['freights']);
		$params['insurance'] = str_replace(',', '.', $params['insurance']);
		$params['other_expenses'] = str_replace(',', '.', $params['other_expenses']);

		$sql = "

			INSERT INTO
				`tbs_output_forms_products` (
					`output_form_id`,
					`warehouse_id`,
					`tariff_heading_id`,
					`product_category_id`,
					`quantity`,
					`commercial_quantity`,
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
				$form_id,
				'{$params['wid']}',
				'{$params['tariff_heading_id']}',
				'{$params['product_category_id']}',
				'{$params['stock']}',
				'{$params['commercial_quantity']}',
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

		/*if($_SESSION['user']['company_id']=='900162578'){
			echo '<pre>'.print_r($sql, TRUE).'</pre>';
			die();
		}*/

		$this->db->query($sql);
		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	GET IN WAREHOUSE
 ---------------------------------------------------------------------*/
	public function get_in_warehouse($warehouse_id, $output_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

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
				ofp.*,
				ofp.output_form_id

			FROM
				`tbs_warehouses` AS wh

			INNER JOIN
				`tbs_output_forms_products` AS ofp
					ON
						ofp.warehouse_id = wh.id

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
				wh.id = $warehouse_id AND ofp.output_form_id = $output_form_id

			LIMIT 1

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll()[0];
	}


/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				ofp.*,
				p.*,
				ofp.id AS ofp_id,
				p.name AS product,
				p.id AS product_id,
				wh.form_id,
				pt.name AS product_type,
				pc.name AS category,
				pk.name AS packing,
				f.code_name AS flag,
				th.id AS tariff_heading_id,
				th.physical_unit AS tariff_heading_unit,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*

			FROM
				`tbs_output_forms_products` AS ofp

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = ofp.warehouse_id

			LEFT JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = wh.form_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ofp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pk
					ON
						pk.id = ofp.packaging_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = ofp.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ofp.flag_id


			WHERE
				ofp.id = $id

			LIMIT 1

		";


		return $this->db->query($sql)->fetchAll()[0];
	}


/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_name($name)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				ofp.*,
				p.*,
				ofp.id AS ofp_id,
				p.name AS product,
				p.id AS product_id,
				wh.form_id,
				pt.name AS product_type,
				pc.name AS category,
				pk.name AS packing,
				f.code_name AS flag,
				th.id AS tariff_heading_id,
				th.physical_unit AS tariff_heading_unit,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*

			FROM
				`tbs_output_forms_products` AS ofp

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = ofp.warehouse_id

			LEFT JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = wh.form_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ofp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pk
					ON
						pk.id = ofp.packaging_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = ofp.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ofp.flag_id


			WHERE
				p.name = '$name'

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
				`tbs_output_forms_products`
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
				`tbs_output_forms_products`

			SET
					is_verified  = 1

					WHERE `id` = $id;

		";
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	change_ext_to_nac
 ---------------------------------------------------------------------*/
	public function change_ext_to_nac($old_wid, $new_wid)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE
				`tbs_output_forms_products`

			SET
					warehouse_id  = $new_wid

					WHERE `warehouse_id` = $old_wid;

		";
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		/*echo '<pre>'.print_r($params, TRUE).'</pre>';
		die();*/
		return $this->db->query("

			UPDATE
				`tbs_output_forms_products`
			SET
				`output_form_id` = '{$params['output_form_id']}',
				`warehouse_id` = '{$params['warehouse_id']}',
				`tariff_heading_id` = '{$params['tariff_heading_id']}',
				`product_category_id` = '{$params['product_category_id']}',
				`quantity` = '{$params['quantity']}',
				`commercial_quantity` = '{$params['commercial_quantity']}',
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

		");
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
				ofp.*,
				p.*,
				ofp.id AS ofp_id,
				p.name AS product,
				p.id AS product_id,
				wh.form_id,
				pt.name AS product_type,
				pc.name AS category,
				pk.name AS packing,
				f.code_name AS flag,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*

			FROM
				`tbs_output_forms_products` AS ofp

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = ofp.warehouse_id

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = wh.form_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ofp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pk
					ON
						pk.id = ofp.packaging_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = ofp.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ofp.flag_id


			WHERE
				ofp.output_form_id = $form_id
				AND
				ofp.is_verified = 0

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET SUM WAREHOUSE
 ---------------------------------------------------------------------*/
	public function get_sum_warehouses($output_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT SUM(w.virtual + w.virtual_reserved + w.locked + w.stock + w.inspected_to_input + w.reserved + w.approved + w.reserved_to_output+ w.inspected_to_output) AS sum_warehouses

			FROM
				`tbs_output_forms_products` AS ofp

			INNER JOIN
				`tbs_warehouses` AS w
					ON
						w.id = ofp.warehouse_id

			WHERE
				ofp.`output_form_id` = $output_form_id

		";
		
		return $this->db->query($sql)->fetchAll()[0];
	}


/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($output_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				ofp.*,
				p.*,
				ofp.id AS ofp_id,
				p.name AS product,
				p.id AS product_id,
				wh.form_id,
				pt.name AS product_type,
				pc.name AS category,
				pk.name AS packing,
				pu.symbol AS unit_symbol,
				f.name AS flag,
				f.id AS flag_id,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				th.code AS tariff_heading_code,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				th.id AS tariff_heading_id,
				wh.*, wh.id AS wid

			FROM
				`tbs_output_forms_products` AS ofp

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = ofp.warehouse_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ofp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pk
					ON
						pk.id = ofp.packaging_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = ofp.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ofp.flag_id

			WHERE
				`output_form_id` = $output_form_id

		";
		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll();
	}


/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function script_all_ext($output_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				ofp.*,
				p.*,
				ofp.id AS ofp_id,
				p.name AS product,
				p.id AS product_id,
				wh.form_id,
				pt.name AS product_type,
				pc.name AS category,
				pk.name AS packing,
				pu.symbol AS unit_symbol,
				f.name AS flag,
				f.id AS flag_id,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				th.id AS tariff_heading_id,
				wh.*, wh.id AS wid

			FROM
				`tbs_output_forms_products` AS ofp

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = ofp.warehouse_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ofp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pk
					ON
						pk.id = ofp.packaging_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = ofp.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ofp.flag_id

			WHERE
				`output_form_id` = $output_form_id AND p.product_type_id = 1

		";
		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll();
	}


/*----------------------------------------------------------------------
	GET FOR OUTPUT
 ---------------------------------------------------------------------*/
	public function get_for_output()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				ofp.*,
				p.*,
				ofp.id AS ofp_id,
				p.name AS product,
				p.id AS product_id,
				wh.form_id,
				pt.name AS product_type,
				pc.name AS category,
				pk.name AS packing,
				f.code_name AS flag,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*

			FROM
				`tbs_output_forms_products` AS ofp

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = ofp.warehouse_id

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ip.id = wh.form_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_products_categories` AS pc
					ON
						pc.id = ofp.product_category_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pk
					ON
						pk.id = ofp.packaging_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = ofp.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_flags` AS f
					ON
						f.id = ofp.flag_id


			WHERE
				`output_form_id` = $output_form_id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY PRODUCT ID
 ---------------------------------------------------------------------*/
	public function get_by_product_id($product_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT *, output_form_id AS form_id
				

			FROM
				`tbs_output_forms_products`

			WHERE
				`warehouse_id` = $product_id

		";

		return $this->db->query($sql)->fetchAll();
	}

}
