<?php

namespace tbs_flags;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT *
			FROM `tbs_flags`

		")->fetchAll();
	}
}
