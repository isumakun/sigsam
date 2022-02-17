<?php

namespace tbs_companies;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT *
			FROM tbs3.`tbs_companies`
			WHERE id > 12345

		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET BY USER
 ---------------------------------------------------------------------*/
	public function get_by_user($user_id)
	{
		return $this->db->query("

			SELECT c.*
			FROM `tbs_companies` AS c
			INNER JOIN tbs3.tbs_employees AS e
			ON e.company_id = c.id
			WHERE e.user_id = $user_id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$sql = "

			SELECT c.*
			FROM tbs3.`tbs_companies` AS c
			WHERE c.id = $id
			LIMIT 1
		";

		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET COMPANY
 ---------------------------------------------------------------------*/
	public function get_company($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT *
			FROM `tbs_company`
			WHERE id = $id
			LIMIT 1
		";

		return $this->db->query($sql)->fetchAll()[0];
	}
}
