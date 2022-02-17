<?php

namespace tbs_products_categories;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT *
			FROM tbs3.`tbs_products_categories`

		")->fetchAll();
	}
}
