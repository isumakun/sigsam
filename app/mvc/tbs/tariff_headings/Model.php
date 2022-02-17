<?php

namespace tbs_tariff_headings;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT *
			FROM tbs3.`tbs_tariff_headings`

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	get_by_code
 ---------------------------------------------------------------------*/
	public function get_by_code($code)
	{
		$sql = "

			SELECT id
			FROM tbs3.`tbs_tariff_headings`
			WHERE code = '$code'
			LIMIT 1
		";
		
		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	get_by_id
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$sql = "

			SELECT *
			FROM tbs3.`tbs_tariff_headings`
			WHERE id = $id

		";
		return $this->db->query($sql)->fetchAll()[0];
	}
}
