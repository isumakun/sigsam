<?php

namespace tbs_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				p.*,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' [', th.physical_unit, '] - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit


			FROM 
				`tbs_products` AS p

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

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL NOT VEHICLES
 ---------------------------------------------------------------------*/
 //ESTO HAY QUE REVISARLO
	public function get_all_not_vehicles()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				p.*,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' [', th.physical_unit, '] - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit


			FROM 
				`tbs_products` AS p

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

			WHERE p.id IN ( SELECT w.product_id
								FROM tbs_warehouses AS w
								INNER JOIN tbs_products AS p
								ON w.product_id = p.id
								INNER JOIN tbs_input_forms AS ip
								ON w.form_id = ip.id
								INNER JOIN tbs_input_forms_products AS ifp
								ON ifp.input_form_id = ip.id
								WHERE w.form_type = 1 
								AND ifp.product_category_id != 2
								AND (ip.form_state_id = 3 OR ip.form_state_id = 5)
								)

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	get_transformed
 ---------------------------------------------------------------------*/
	public function get_transformed()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
			
				p.*,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' [', th.physical_unit, '] - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid

			FROM 
				`tbs_products` AS p

			LEFT JOIN
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id

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

			WHERE p.is_transformed = 1

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL IN VIRTUAL
 ---------------------------------------------------------------------*/
	public function get_all_in_virtual()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT wh.id AS wid,
				p.*,
				p.id AS product_id,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_id,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, sp.name AS supplier


			FROM 
				`tbs_products` AS p

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
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						wh.form_id = ip.id

			INNER JOIN
				`tbs_suppliers` AS sp
					ON
						ip.supplier_id = sp.id

			WHERE wh.virtual > 0

			GROUP BY wh.id, p.id
			
		";
		$result = $this->db->query($sql)->fetchAll();
		return $result;
	}

/*----------------------------------------------------------------------
	GET ALL IN VIRTUAL RESERVED
 ---------------------------------------------------------------------*/
	public function get_all_in_virtual_reserved()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT 
				p.*,
				p.id AS product_id,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.id AS input_forms_product_id,
				ifp.input_form_id AS form_id

			FROM 
				`tbs_products` AS p

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
				`tbs_input_forms_products` AS ifp
					ON
						ifp.product_id = p.id

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id

			WHERE wh.virtual_reserved > 0

			GROUP BY wh.id
			
		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL IN LOCKED
 ---------------------------------------------------------------------*/
	public function get_all_in_locked()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT 
				p.*,
				p.id AS product_id,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.id AS input_forms_product_id,
				ifp.input_form_id AS form_id

			FROM 
				`tbs_products` AS p

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
				`tbs_input_forms_products` AS ifp
					ON
						ifp.product_id = p.id

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ifp.input_form_id = ip.id
						
			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id

			WHERE wh.locked > 0 AND ifp.packaging_id != 48 AND ip.form_state_id != 5
		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL IN LOCKED
 ---------------------------------------------------------------------*/
	public function get_all_for_input_inspection()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT 
				p.*,
				p.id AS product_id,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.id AS input_forms_product_id,
				ifp.input_form_id AS form_id,
				r.created_at AS requested_at

			FROM 
				`tbs_products` AS p

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
				`tbs_input_forms_products` AS ifp
					ON
						ifp.product_id = p.id

			INNER JOIN
				`tbs_input_forms` AS ip
					ON
						ifp.input_form_id = ip.id
						
			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id

			INNER JOIN
				`tbs_input_forms_inspections_requests` AS r
					ON
						r.warehouse_id = wh.id

			WHERE wh.locked > 0 AND ifp.packaging_id != 48 AND ip.form_state_id != 5
		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL IN LOCKED
 ---------------------------------------------------------------------*/
	public function get_all_in_locked_by_input_form($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT 
				p.*,
				p.id AS product_id,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.id AS input_forms_product_id,
				ifp.input_form_id AS form_id

			FROM 
				`tbs_products` AS p

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
				`tbs_input_forms_products` AS ifp
					ON
						ifp.product_id = p.id

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id

			WHERE wh.locked > 0 
			AND ifp.packaging_id != 48 
			AND ifp.input_form_id = $form_id
			AND wh.form_type = 1
			
		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_in_stock()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			(SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				th.id AS tariff_heading_id,
				pa.name AS packaging,
				CONCAT(fl.id, ' - ', fl.code_name) AS flag,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading_long,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.*,
				ifp.id AS input_forms_product_id,
				ifp.input_form_id AS form_id

			FROM 
				`tbs_warehouses` AS wh

			INNER JOIN tbs_products AS p
			ON p.id= wh.product_id

			INNER JOIN tbs_input_forms_products AS ifp
			ON ifp.input_form_id = wh.form_id AND ifp.product_id = p.id

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

			LEFT JOIN
				tbs3.`tbs_flags` AS fl
					ON
						fl.id = ifp.flag_id

			LEFT JOIN
				tbs3.`tbs_packaging` AS pa
					ON
						pa.id = ifp.packaging_id

			WHERE wh.stock > 0
			
			AND wh.id NOT IN (SELECT id FROM tbs_warehouses WHERE form_type = 2)

			GROUP BY wh.id)
			UNION
			(SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				th.id AS tariff_heading_id,
				pa.name AS packaging,
				CONCAT(fl.id, ' - ', fl.code_name) AS flag,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading_long,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.*,
				ifp.id AS output_forms_product_id,
				ifp.output_form_id AS form_id

			FROM 
				`tbs_warehouses` AS wh

			INNER JOIN tbs_output_forms AS ip
			ON wh.form_id = ip.id

			INNER JOIN tbs_output_forms_products AS ifp
			ON ifp.output_form_id = ip.id

			INNER JOIN tbs_products AS p
			ON p.id= wh.product_id

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

			LEFT JOIN
				tbs3.`tbs_flags` AS fl
					ON
						fl.id = ifp.flag_id

			LEFT JOIN
				tbs3.`tbs_packaging` AS pa
					ON
						pa.id = ifp.packaging_id

			WHERE wh.stock > 0
			
			AND wh.id NOT IN (SELECT id FROM tbs_warehouses WHERE form_type = 1)
			GROUP BY wh.id)
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_in_stock_nationalized()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				th.id AS tariff_heading_id,
				pa.name AS packaging,
				CONCAT(fl.id, ' - ', fl.code_name) AS flag,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading_long,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.*,
				ifp.id AS output_forms_product_id,
				ifp.output_form_id AS form_id

			FROM 
				`tbs_warehouses` AS wh

			INNER JOIN tbs_output_forms AS ip
			ON wh.form_id = ip.id

			INNER JOIN tbs_output_forms_products AS ifp
			ON ifp.output_form_id = ip.id

			INNER JOIN tbs_products AS p
			ON p.id= wh.product_id

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

			LEFT JOIN
				tbs3.`tbs_flags` AS fl
					ON
						fl.id = ifp.flag_id

			LEFT JOIN
				tbs3.`tbs_packaging` AS pa
					ON
						pa.id = ifp.packaging_id

			WHERE wh.stock > 0
			
			AND wh.id NOT IN (SELECT id FROM warehouse_id WHERE form_type = 1)
			GROUP BY wh.id
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_in_stock_transformed()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				th.id AS tariff_heading_id,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading_long,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid

			FROM 
				`tbs_products` AS p

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
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id

			WHERE wh.stock > 0 AND form_type = 2 
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_nationalized()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				th.id AS tariff_heading_id,
				pa.name AS packaging,
				CONCAT(fl.id, ' - ', fl.code_name) AS flag,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading_long,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.*,
				ifp.id AS input_forms_product_id,
				ifp.input_form_id AS form_id

			FROM 
				`tbs_products` AS p

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
				`tbs_input_forms_products` AS ifp
					ON
						ifp.product_id = p.id

			INNER JOIN
				tbs3.`tbs_flags` AS fl
					ON
						fl.id = ifp.flag_id

			INNER JOIN
				tbs3.`tbs_packaging` AS pa
					ON
						pa.id = ifp.packaging_id

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id

			WHERE wh.stock > 0

			GROUP BY p.id
		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_for_outputs()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.id AS input_forms_product_id,
				ifp.input_form_id AS form_id

			FROM 
				`tbs_products` AS p

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
				`tbs_input_forms_products` AS ifp
					ON
						ifp.product_id = p.id

			INNER JOIN
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id

			WHERE wh.stock > 0

			AND (pt.id != 1 OR pt.id != 6)

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_approved()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ofp.output_form_id, ofp.quantity

			FROM 
				`tbs_warehouses` AS wh

			INNER JOIN 
				`tbs_products` AS p
					ON
						wh.product_id = p.id

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
				tbs_output_forms_products AS ofp
					ON ofp.warehouse_id = wh.id

			INNER JOIN
				tbs_output_forms AS op
					ON ofp.output_form_id = op.id

			WHERE wh.approved > 0 AND wh.nationalized = 0
			AND wh.id NOT IN (SELECT warehouse_id FROM tbs_output_forms_inspections_requests)
			AND op.form_state_id != 5
			GROUP BY form_id, wh.id
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_for_output_inspection()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				c.name AS company,
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ofp.output_form_id,
				r.created_at AS requested_at,
				r.place

			FROM 
				tbs_company AS c, `tbs_warehouses` AS wh

			INNER JOIN 
				`tbs_products` AS p
					ON
						wh.product_id = p.id

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
				tbs_output_forms_products AS ofp
					ON ofp.warehouse_id = wh.id

			INNER JOIN
				tbs_output_forms_inspections_requests AS r
					ON r.warehouse_id = wh.id

			WHERE wh.approved > 0 AND wh.nationalized = 0

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_for_output_inspection_group()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				GROUP_CONCAT(p.name) AS vins,
				c.name AS company,
				c.id AS company_id,
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ofp.output_form_id,
				r.created_at AS requested_at,
				r.place

			FROM 
				tbs_company AS c, `tbs_warehouses` AS wh

			INNER JOIN 
				`tbs_products` AS p
					ON
						wh.product_id = p.id

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
				tbs_output_forms_products AS ofp
					ON ofp.warehouse_id = wh.id

			INNER JOIN
				tbs_output_forms_inspections_requests AS r
					ON r.warehouse_id = wh.id

			WHERE wh.approved > 0 AND wh.nationalized = 0

			GROUP BY r.created_at
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_inspected_to_output()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid, ofp.*

			FROM 
				`tbs_warehouses` AS wh

			INNER JOIN 
				`tbs_products` AS p
					ON
						wh.product_id = p.id

			INNER JOIN
				tbs3.`tbs_products_types` AS pt
					ON
						pt.id = p.product_type_id

			INNER JOIN
				`tbs_output_forms_products` AS ofp
					ON
						ofp.warehouse_id = wh.id

			INNER JOIN
				tbs3.`tbs_tariff_headings` AS th
					ON
						th.id = p.tariff_heading_id

			INNER JOIN
				tbs3.`tbs_physical_units` AS pu
					ON
						pu.id = p.physical_unit_id

			WHERE wh.inspected_to_output > 0 AND (wh.form_type = 1 OR wh.form_type = 4)

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_inspected_to_output_transformated()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				th.code AS tariff_heading,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid, ofp.*

			FROM 
				`tbs_warehouses` AS wh

			INNER JOIN 
				`tbs_products` AS p
					ON
						wh.product_id = p.id

			INNER JOIN
				`tbs_output_forms_products` AS ofp
					ON
						ofp.warehouse_id = wh.id

INNER JOIN
				`tbs_output_forms` AS of
					ON
						ofp.output_form_id = of.id

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

			WHERE wh.inspected_to_output > 0 AND wh.form_type = 2 AND of.form_state_id != 5

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
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid,
				ifp.id AS input_forms_product_id,
				ifp.input_form_id AS form_id

			FROM 
				`tbs_products` AS p

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

			LEFT JOIN
				`tbs_input_forms_products` AS ifp
					ON
						ifp.product_id = p.id

			LEFT JOIN
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id
			WHERE
				p.`id` = $id

			LIMIT 1

		";
		
		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET BY NAME
 ---------------------------------------------------------------------*/
	public function get_by_name($name)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT 
				p.*,
				p.id AS pid,
				p.name AS product,
				pt.name AS product_type,
				CONCAT(th.code, ' - ', th.description) AS tariff_heading,
				pu.symbol,
				CONCAT(pu.symbol, ' - ', pu.unit) AS physical_unit,
				wh.*, wh.id AS wid

			FROM 
				`tbs_products` AS p

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
				`tbs_warehouses` AS wh
					ON
						wh.product_id = p.id
			WHERE
				p.`name` LIKE '%$name%'

			LIMIT 1

		";
		
		return $this->db->query($sql)->fetchAll()[0];
	}


/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$this->db->query("

			INSERT INTO
				`tbs_products` (
					`name`,
					`interface_code`,
					`product_type_id`,
					`tariff_heading_id`,
					`physical_unit_id`
				)

			VALUES (
				'{$params['name']}',
				'{$params['interface_code']}',
				'{$params['product_type_id']}',
				'{$params['tariff_heading_id']}',
				'{$params['physical_unit_id']}'
			);

		");

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create_transformed($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$this->db->query("

			INSERT INTO
				`tbs_products` (
					`name`,
					`interface_code`,
					`product_type_id`,
					`tariff_heading_id`,
					`physical_unit_id`,
					`is_transformed`
				)

			VALUES (
				'{$params['name']}',
				'{$params['interface_code']}',
				'{$params['product_type_id']}',
				'{$params['tariff_heading_id']}',
				'{$params['physical_unit_id']}',
				1
			);

		");

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create_from_nationalized($name, $interface_code, $product_type_id, $tariff_heading_id, $physical_unit_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO
				`tbs_products` (
					`name`,
					`interface_code`,
					`product_type_id`,
					`tariff_heading_id`,
					`physical_unit_id`
				)

			VALUES (
				'$name',
				'$interface_code',
				'$product_type_id',
				'$tariff_heading_id',
				'$physical_unit_id'
			);

		";

		
		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	CREATE_MASSIVE
 ---------------------------------------------------------------------*/
	public function create_massively($name, $interface_code, $product_type_id, $tariff_heading_id, $physical_unit_id)
	{ 
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "INSERT INTO `tbs_products` (`name`, `interface_code`, `product_type_id`, `tariff_heading_id`, `physical_unit_id`)
			VALUES ('$name', '$interface_code', '$product_type_id', '$tariff_heading_id', '$physical_unit_id')";
			
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
				`tbs_products` 
			SET
					`name` = '{$params['name']}',
					`interface_code` = '{$params['interface_code']}',
					`product_type_id` = {$params['product_type_id']},
					`tariff_heading_id` = {$params['tariff_heading_id']},
					`physical_unit_id` = {$params['physical_unit_id']}
			WHERE 
				`id` = {$params['product_id']};

		";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	CHANGE TYPE
 ---------------------------------------------------------------------*/
	public function change_type($id, $type)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		$sql = "

			UPDATE 
				`tbs_products` 
			SET
					`product_type_id` = $type
			WHERE 
				`id` = $id

		";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	CHANGE CODE
 ---------------------------------------------------------------------*/
	public function change_code($id, $code)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		$sql = "

			UPDATE 
				`tbs_products` 
			SET
					`interface_code` = $code
			WHERE 
				`id` = $id

		";

		return $this->db->query($sql);
	}
}
