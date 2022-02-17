<?php

namespace tbs_output_forms_inspections_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($warehouse_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			INSERT INTO
				`tbs_output_forms_inspections_products` (
					`warehouse_id`,
					`inspected_by`,
					`inspected_at`
					)

			VALUES (
				$warehouse_id,
				'{$_SESSION['user']['id']}',
				now()
			);

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

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
				`tbs_output_forms_inspections_products`

			SET
					warehouse_id  = $new_wid

					WHERE `warehouse_id` = $old_wid;

		";
		return $this->db->query($sql);
	}
}
