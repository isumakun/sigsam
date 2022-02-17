<?php

namespace tbs_reports;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				*

			FROM
				tbs3_900324176.`tbs_suppliers`

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_count()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT transaction_id, COUNT(transaction_id) AS recuento FROM tbs_input_forms
			WHERE MONTH(approved_at) = 4
   			AND YEAR(approved_at) = 2018
			GROUP BY transaction_id

			UNION

			SELECT transaction_id, COUNT(transaction_id) AS recuento FROM tbs_output_forms
			WHERE MONTH(approved_at) = 4
   			AND YEAR(approved_at) = 2018
			GROUP BY transaction_id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET INPUT FOB
 ---------------------------------------------------------------------*/
	public function get_input_fob($month, $year, $transaction)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT SUM(ifp.fob_value) AS sum, c.name AS company, MONTH(executed_at) AS month, $transaction AS transaction
			FROM tbs_company AS c, tbs_input_forms_products AS ifp
			INNER JOIN tbs_input_forms AS ip
			ON ifp.input_form_id = ip.id
			WHERE ip.form_state_id = 5 
			AND ip.transaction_id regexp '^[$transaction]+'
			AND MONTH(executed_at) = $month
			AND YEAR(executed_at) = $year

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
	No debería estar acá, sino en su respectivo modelo
 ---------------------------------------------------------------------*/
	public function get_transports_by_form($form_id, $type)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		if ($type==1) {
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
				tw.`form_id` = $form_id

			GROUP BY ttif.id 

		";
		}else{
			$sql = "

			SELECT
				tw.*,
				ttifp.output_form_id AS iid,
				ttifp.*,
				ttif.*,
				ttif.approved_at AS approved,
				ttif.id AS tid,
				fs.name AS 'state', 
				GROUP_CONCAT(p.name SEPARATOR ' - ') AS products


			FROM
				`tbs_warehouses` tw

			INNER JOIN
				tbs_transport_output_forms_products AS ttifp
					ON
						ttifp.warehouse_id = tw.id

			INNER JOIN
				tbs_transport_output_forms AS ttif
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
				ttifp.`output_form_id` = $form_id

			GROUP BY ttif.id 

		";
		}
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
	No debería estar acá, sino en su respectivo modelo
 ---------------------------------------------------------------------*/
	public function get_transformations($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT * 
			FROM tbs_transformation_forms_consumables AS tfc
			WHERE tfc.warehouse_id = $id

		";
		
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	thirdparties_validity
 ---------------------------------------------------------------------*/
	public function thirdparties_validity()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT e.name, w.limit_date, CONCAT(u.first_name, ' ', u.last_name) AS verified_by, r.verified_at,
			CONCAT(u2.first_name, ' ', u2.last_name) AS approved_by, r.approved_at, r.id FROM tbs_thirdparties_workers AS w
			INNER JOIN tbs_thirdparties_employees AS e
			ON w.employee_id = e.id
			INNER JOIN tbs_thirdparties_requests AS r
			ON w.request_id = r.id
			LEFT JOIN tbs3.admin_users AS u
			ON r.verified_by = u.id
			LEFT JOIN tbs3.admin_users AS u2
			ON r.approved_by = u2.id
			WHERE w.limit_date >= CURDATE() AND (r.form_state_id = 5 OR r.form_state_id = 12)
			GROUP BY w.employee_id
			ORDER BY e.name ASC

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_master($starting_date=0, $ending_date=0)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				tw.id AS warehouse_id,
				tw.*,
				tif.*,
				tp.*,
				tp.name AS product,
				tpt.name AS product_type,
				tpu.symbol AS physical_unit,
				tifp.*,
				tpc.name AS product_category

			FROM
				`tbs_warehouses` AS tw

			INNER JOIN
				`tbs_input_forms` tif
					ON
						tif.id = tw.form_id

			INNER JOIN
				`tbs_products` tp
					ON
						tp.id = tw.product_id

			INNER JOIN
				tbs3.tbs_products_types AS tpt
					ON
						tpt.id = tp.product_type_id

			INNER JOIN
				tbs3.tbs_physical_units AS tpu
					ON
						tpu.id = tp.physical_unit_id

			INNER JOIN
				tbs_input_forms_products AS tifp
					ON
						tifp.input_form_id = tif.id

			INNER JOIN
				tbs3.tbs_products_categories AS tpc
					ON
						tpc.id = tifp.product_category_id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	get_dane_inputs
 ---------------------------------------------------------------------*/
	public function get_dane_inputs($init_date, $end_date)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT tif.id, tif.*, 
				tp.product_type_id, 
				c.id AS nit, 
				f1.id AS pais_compra,
				f2.id AS pais_destino,
				f3.id AS pais_proce,
				f4.id AS bandera,
				f5.id AS pais_origen, 
				tth.code AS tariff_heading_code, 
				tth.physical_unit AS tariff_heading_unit, 
				tp.physical_unit_id, 
				tifp.*, 
				c.name AS company_name
			FROM
				`tbs_company` c, `tbs_input_forms` tif

			INNER JOIN
				tbs_input_forms_products AS tifp
					ON
						tifp.input_form_id = tif.id

			INNER JOIN
				`tbs_products` tp
					ON
						tp.id = tifp.product_id

			INNER JOIN
				`tbs_suppliers` s
					ON
						s.id = tif.supplier_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = tif.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = tif.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = tif.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = tif.flag_id_4

			INNER JOIN
				tbs3.`tbs_flags` AS f5
					ON
						f5.id = tifp.flag_id

			INNER JOIN
				tbs3.tbs_products_types AS tpt
					ON
						tpt.id = tp.product_type_id

			INNER JOIN
				tbs3.tbs_physical_units AS tpu
					ON
						tpu.id = tp.physical_unit_id

			INNER JOIN
				tbs3.tbs_products_categories AS tpc
					ON
						tpc.id = tifp.product_category_id

			INNER JOIN
				tbs3.tbs_transport_types AS ttt
					ON
						ttt.id = tif.transport_type_id

			INNER JOIN
				tbs3.tbs_tariff_headings AS tth
					ON
						tth.id = tp.tariff_heading_id

			WHERE tif.approved_at BETWEEN '$init_date' AND '$end_date'

			GROUP BY tifp.id

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	get_dane_outputs
 ---------------------------------------------------------------------*/
	public function get_dane_outputs($init_date, $end_date)
	{

		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT tof.id, tof.*, 
				tp.product_type_id, 
				c.id AS nit, 
				f1.id AS pais_compra,
				f2.id AS pais_destino,
				f3.id AS pais_proce,
				f4.id AS bandera,
				f5.id AS pais_origen, 
				tth.code AS tariff_heading_code, 
				tth.physical_unit AS tariff_heading_unit, 
				tp.physical_unit_id, 
				tofp.*, 
				c.name AS company_name
			FROM
				`tbs_company` c, `tbs_input_forms` tif

			INNER JOIN
				tbs_warehouses AS tw
					ON
						tw.form_id = tif.id

			INNER JOIN
				tbs_output_forms_products AS tofp
					ON
						tofp.warehouse_id = tw.id

			INNER JOIN
				tbs_output_forms AS tof
					ON
						tofp.output_form_id = tof.id

			INNER JOIN
				`tbs_products` tp
					ON
						tp.id = tw.product_id

			INNER JOIN
				`tbs_suppliers` s
					ON
						s.id = tif.supplier_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = tof.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = tof.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = tof.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = tof.flag_id_4

			INNER JOIN
				tbs3.`tbs_flags` AS f5
					ON
						f5.id = tofp.flag_id

			INNER JOIN
				tbs3.tbs_products_types AS tpt
					ON
						tpt.id = tp.product_type_id

			INNER JOIN
				tbs3.tbs_physical_units AS tpu
					ON
						tpu.id = tp.physical_unit_id

			INNER JOIN
				tbs3.tbs_products_categories AS tpc
					ON
						tpc.id = tofp.product_category_id

			INNER JOIN
				tbs3.tbs_transport_types AS ttt
					ON
						ttt.id = tof.transport_type_id

			INNER JOIN
				tbs3.tbs_tariff_headings AS tth
					ON
						tth.id = tp.tariff_heading_id

			WHERE tof.approved_at BETWEEN '$init_date' AND '$end_date'

			GROUP BY tofp.id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_balances()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			(SELECT p.name AS product, p.interface_code, th.code AS tariff_heading, pt.name AS type, pu.symbol AS unit,  SUM(w.locked +w.stock+ w.reserved+ w.approved+ w.inspected_to_output+ reserved_to_output) AS quantity, p.product_type_id, ifp.product_category_id, ifp.unit_value
			FROM tbs_warehouses AS w
			INNER JOIN tbs_products AS p
			ON p.id = w.product_id
			INNER JOIN tbs_input_forms_products AS ifp
			ON ifp.input_form_id = w.form_id AND ifp.product_id = p.id
			INNER JOIN tbs3.tbs_tariff_headings AS th
			ON p.tariff_heading_id = th.id
			INNER JOIN tbs3.tbs_products_types AS pt
			ON p.product_type_id = pt.id
			INNER JOIN tbs3.tbs_physical_units AS pu
			ON p.physical_unit_id = pu.id
			GROUP BY p.name, pt.id
			HAVING SUM(w.locked +w.stock+ w.reserved+ w.approved+ w.inspected_to_output+ reserved_to_output) > 0
			ORDER BY pt.name)
			UNION
			(SELECT p.name AS product, p.interface_code, th.code AS tariff_heading, pt.name AS type, pu.symbol AS unit,  SUM(w.locked +w.stock+ w.reserved+ w.approved+ w.inspected_to_output+ reserved_to_output) AS quantity, 
			p.product_type_id, ofp.product_category_id, ofp.fob_value AS unit_value
			FROM tbs_warehouses AS w
			INNER JOIN tbs_products AS p
			ON p.id = w.product_id
			INNER JOIN tbs_output_forms_products AS ofp
			ON ofp.warehouse_id = w.id AND w.form_type = 4
			INNER JOIN tbs3.tbs_tariff_headings AS th
			ON p.tariff_heading_id = th.id
			INNER JOIN tbs3.tbs_products_types AS pt
			ON p.product_type_id = pt.id
			INNER JOIN tbs3.tbs_physical_units AS pu
			ON p.physical_unit_id = pu.id
			GROUP BY p.name, pt.id
			HAVING SUM(w.locked +w.stock+ w.reserved+ w.approved+ w.inspected_to_output+ reserved_to_output) > 0
			ORDER BY pt.name)
			UNION
			(SELECT p.name AS product, p.interface_code, th.code AS tariff_heading, pt.name AS type, pu.symbol AS unit,  SUM(w.locked +w.stock+ w.reserved+ w.approved+ w.inspected_to_output+ reserved_to_output) AS quantity, 
			p.product_type_id, tfp.product_category_id, tfp.fob_value AS unit_value
			FROM tbs_warehouses AS w
			INNER JOIN tbs_products AS p
			ON p.id = w.product_id
			INNER JOIN tbs_transformation_forms_products AS tfp
			ON tfp.warehouse_id = w.id AND w.form_type = 2
			INNER JOIN tbs3.tbs_tariff_headings AS th
			ON p.tariff_heading_id = th.id
			INNER JOIN tbs3.tbs_products_types AS pt
			ON p.product_type_id = pt.id
			INNER JOIN tbs3.tbs_physical_units AS pu
			ON p.physical_unit_id = pu.id
			GROUP BY p.name, pt.id
			HAVING SUM(w.locked +w.stock+ w.reserved+ w.approved+ w.inspected_to_output+ reserved_to_output) > 0
			ORDER BY pt.name)

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_types_by_warehouses()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT pt.*
			FROM tbs3.`tbs_products_types` AS pt
			INNER JOIN tbs_products AS p
			ON p.product_type_id = pt.id
			INNER JOIN tbs_warehouses AS w
			ON w.product_id = p.id
			GROUP BY pt.name
			HAVING SUM(w.locked +w.stock+ w.reserved+ w.approved+ w.inspected_to_output+ reserved_to_output) > 0


		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_categories_by_warehouses()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT pc.*
			FROM tbs3.`tbs_products_categories` AS pc
			LEFT JOIN tbs_input_forms_products AS ifp
			ON ifp.product_category_id = pc.id
			INNER JOIN tbs_warehouses AS w
			ON w.form_id = ifp.input_form_id		
			GROUP BY pc.name
			HAVING SUM(w.locked +w.stock+ w.reserved+ w.approved+ w.inspected_to_output+ reserved_to_output) > 0
			ORDER BY pc.id


		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_bls()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT p.name AS product, ifs.details AS detail FROM tbs_input_forms_products AS ifp
			INNER JOIN tbs_products AS p
			ON p.id = ifp.product_id
			INNER JOIN tbs_input_forms_supports AS ifs
			ON ifs.input_form_id = ifp.input_form_id
			WHERE ifs.input_form_support_type_id = 3 AND (p.product_type_id = 1 OR p.product_type_id = 4)


		")->fetchAll();
	}
}
