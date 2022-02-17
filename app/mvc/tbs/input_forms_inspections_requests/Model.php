<?php

namespace tbs_input_forms_inspections_requests;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($warehouse_id, $observations)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			INSERT INTO
				`tbs_input_forms_inspections_requests` (
					`warehouse_id`,
					`created_by`,
					`created_at`
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
	CREATE2
 ---------------------------------------------------------------------*/
	public function create_manual($warehouse_id, $created_at=0, $created_by=0)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		if ($created_at==0) {
			$created_at = 'now()';
		}
		if ($created_by==0) {
			$created_by = $_SESSION['user']['id'];
		}

		$sql = "

			INSERT INTO
				`tbs_input_forms_inspections_requests` (
					`warehouse_id`,
					`created_at`,
					`created_by`
					)

			VALUES (
				$warehouse_id,
				$created_at,
				$created_by
			);

		";

		return $this->db->query($sql);
	}
}
