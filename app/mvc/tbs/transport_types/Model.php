<?php

namespace tbs_transport_types;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		return $this->db->query("

			SELECT *
			FROM tbs3.`tbs_transport_types`

		")->fetchAll();
	}
}
