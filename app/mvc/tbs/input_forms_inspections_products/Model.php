<?php

namespace tbs_input_forms_inspections_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($warehouse_id, $observations)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			INSERT INTO
				`tbs_input_forms_inspections_products` (
					`warehouse_id`,
					`observations`,
					`inspected_by`,
					`inspected_at`
					)

			VALUES (
				$warehouse_id,
				'$observations',
				'{$_SESSION['user']['id']}',
				now()
			);

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	CREATE2
 ---------------------------------------------------------------------*/
	public function create_manual($warehouse_id, $observations, $inpected_by=0, $inspected_at=0)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		if ($inspected_at==0) {
			$inspected_at = 'now()';
		}
		if ($inspected_by==0) {
			$inspected_by = $_SESSION['user']['id'];
		}

		$sql = "

			INSERT INTO
				`tbs_input_forms_inspections_products` (
					`warehouse_id`,
					`observations`,
					`inspected_by`,
					`inspected_at`
					)

			VALUES (
				$warehouse_id,
				'$observations',
				$inpected_by,
				$inspected_at
			);

		";

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				ifip.observations,
				p.name AS product,
				ifip.inspected_at

			FROM
				tbs_input_forms_inspections_products AS ifip
			INNER JOIN
				tbs_warehouses AS w
					ON
						ifip.warehouse_id = w.id

			INNER JOIN
				tbs_input_forms AS ip
					ON
						ip.id = w.form_id

			INNER JOIN
				tbs_products AS p
					ON
						p.id = w.product_id

			WHERE
				w.form_id = $id

			GROUP BY p.name

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll();
	}
}
