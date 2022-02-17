<?php

namespace tbs_transformation_forms_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO
				`tbs_transformation_forms_products` (
					`warehouse_id`,
					`product_category_id`,
					`quantity`,
					`fob_value`,
					`form_id`,
					`is_principal`
					)

			VALUES (
				{$params['warehouse_id']},
				'7',
				{$params['quantity']},
				{$params['fob_value']},
				{$params['transformation_form_id']},
				{$params['is_principal']}
			);

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();

		$this->db->query($sql);
		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				tfp.*,
				p.*,
				p.id AS product_id,
				tfp.id AS tfp_id,
				p.name AS product,
				pt.name AS product_type,
				wh.*, wh.id AS wid

			FROM
				`tbs_transformation_forms_products` AS tfp

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = tfp.warehouse_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id
			WHERE
				tfp.id = $id

			LIMIT 1

		")->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET IN WAREHOUSE
 ---------------------------------------------------------------------*/
	public function get_by_warehouse($warehouse_id)
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
				wh.form_id AS tform_id

			FROM
				`tbs_warehouses` AS wh

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
				wh.form_id AS tform_id,
				ofp.quantity

			FROM
				`tbs_warehouses` AS wh

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

			INNER JOIN
				`tbs_output_forms_products` AS ofp
					ON
						ofp.warehouse_id = wh.id

			WHERE
				wh.id = $warehouse_id AND ofp.output_form_id = $output_form_id

			LIMIT 1

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "
			DELETE FROM
				`tbs_transformation_forms_products`
			WHERE
				`id` = $id
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

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
				`tbs_transformation_forms_products`
			SET
				`form_id` = '{$params['transformation_form_id']}',
				`warehouse_id` = '{$params['warehouse_id']}',
				`product_category_id` = '7',
				`quantity` = '{$params['quantity']}',
				`fob_value` = '{$params['fob_value']}',
				`is_principal` = '{$params['is_principal']}'
			WHERE
				`id` = '{$params['id']}';

		");
	}

/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				tfp.*,
				p.*,
				p.id AS product_id,
				tfp.id AS tfp_id,
				p.name AS product,
				pt.name AS product_type,
				th.code,
				pu.symbol,
				wh.*, wh.id AS wid

			FROM
				`tbs_transformation_forms_products` AS tfp

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = tfp.warehouse_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			WHERE
				tfp.`form_id` = $form_id

		")->fetchAll();
	}
}
