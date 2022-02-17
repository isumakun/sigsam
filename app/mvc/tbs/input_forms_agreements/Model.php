<?php

namespace tbs_input_forms_agreements;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT *
			FROM tbs3.`tbs_input_forms_agreements`

		")->fetchAll();
	}
}
