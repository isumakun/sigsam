<?php

namespace tbs_output_forms_inspections_requests;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($warehouse_id, $place)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			INSERT INTO
				`tbs_output_forms_inspections_requests` (
					`warehouse_id`,
					`place`,
					`created_by`,
					`created_at`
					)

			VALUES (
				$warehouse_id,
				'$place',
				'{$_SESSION['user']['id']}',
				now()
			);

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		$this->db->query($sql);

		return $this->db->lastInsertId();
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
				`tbs_output_forms_inspections_requests` (
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

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete_by_warehouse_id($wid)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "
			DELETE FROM 
				`tbs_output_forms_inspections_requests`
			WHERE 
				`warehouse_id` = $wid
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}
}
