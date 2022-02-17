<?php

namespace tbs_products_types;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT *
			FROM tbs3.`tbs_products_types`

		")->fetchAll();
	}
}
