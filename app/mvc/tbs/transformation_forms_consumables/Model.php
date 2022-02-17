<?php

namespace tbs_transformation_forms_consumables;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO
				`tbs_transformation_forms_consumables` (
					`warehouse_id`,
					`quantity`,
					`waste`,
					`form_id`
					)

			VALUES (
				{$params['warehouse_id']},
				{$params['quantity']},
				{$params['waste']},
				{$params['transformation_form_id']}
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
				tfc.*,
				p.*,
				tfc.id AS tfc_id,
				p.name AS consumable,
				p.id AS product_id,
				wh.id AS wid, wh.*

			FROM
				`tbs_transformation_forms_consumables` AS tfc

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = tfc.warehouse_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id
			WHERE
				tfc.id = $id

			LIMIT 1

		")->fetchAll()[0];
	}



/*----------------------------------------------------------------------
	GET PRODUCT ID
 ---------------------------------------------------------------------*/
	public function get_by_product_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *

			FROM `tbs_transformation_forms_consumables` AS tfc

			WHERE tfc.warehouse_id = $id

		")->fetchAll();
	}


/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "
			DELETE FROM
				`tbs_transformation_forms_consumables`
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
				`tbs_transformation_forms_consumables`
			SET
				`form_id` = '{$params['transformation_form_id']}',
				`warehouse_id` = '{$params['warehouse_id']}',
				`quantity` = '{$params['quantity']}',
				`waste` = '{$params['waste']}'
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

		$sql = "

			SELECT
				tfc.*,
				p.*,
				p.id AS product_id,
				tfc.id AS tfc_id,
				p.name AS consumable,
				tfc.waste AS product_waste,
				p.id AS product_id,
				pt.name AS product_type,
				wh.id AS wid,
				tifp.unit_value,
				tth.code,
				tpu.symbol,
				wh.*

			FROM
				`tbs_transformation_forms_consumables` AS tfc

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.id = tfc.warehouse_id

			INNER JOIN
				`tbs_products` AS p
					ON
						p.id = wh.product_id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			LEFT JOIN
				tbs_input_forms_products AS tifp
					ON
						tifp.product_id = wh.product_id
						AND
						tifp.input_form_id = wh.form_id

			INNER JOIN
				tbs3.tbs_tariff_headings AS tth
					ON
						tth.id = p.tariff_heading_id

			INNER JOIN
				tbs3.tbs_physical_units AS tpu
					ON
						tpu.id = p.physical_unit_id

			WHERE
				tfc.`form_id` = $form_id

			GROUP BY tfc.id

		";

		return $this->db->query($sql)->fetchAll();
	}

}
