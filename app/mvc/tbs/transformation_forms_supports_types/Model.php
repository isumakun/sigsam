<?php

namespace tbs_transformation_forms_supports_types;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT *
			FROM tbs3.`tbs_transformation_forms_supports_types`

		")->fetchAll();
	}
}
