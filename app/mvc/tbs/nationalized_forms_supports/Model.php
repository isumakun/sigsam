<?php

namespace tbs_nationalized_forms_supports;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_nationalized_forms_supports`

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY FORM
 ---------------------------------------------------------------------*/
	public function get_by_form($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_nationalized_forms_supports`
			WHERE output_form_id = $form_id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "
			DELETE FROM tbs_nationalized_forms_supports WHERE id = $id
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($number, $supp_date, $form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
			$sql = "

				INSERT INTO 
					`tbs_nationalized_forms_supports` 
					(
					`number`, 
					`supp_date`,
					`output_form_id`
					)

				VALUES (
					'$number',
					'$supp_date',
					$form_id
				)

			";
		return $this->db->query($sql);
	}
}
