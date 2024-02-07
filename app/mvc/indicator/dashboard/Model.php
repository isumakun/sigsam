<?php

namespace tbs_dashboard;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	get_dashboard_count
 ---------------------------------------------------------------------*/
	public function get_dashboard_count($table)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			(SELECT
				'open', COUNT(ip.id) AS count

			FROM
				`tbs_$table` AS `ip`

			WHERE DATE(ip.presented_at) = CURDATE() AND (ip.form_state_id != 3 OR ip.form_state_id != 5))
			UNION
			(SELECT
				'approved', COUNT(ip.id) AS count

			FROM
				`tbs_$table` AS `ip`

			WHERE DATE(ip.approved_at) = CURDATE())

		";

		return $this->db->query($sql)->fetchAll();
	}
}