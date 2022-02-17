<?php

namespace tbs_transport_output_forms_verify;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_transport_output_forms_verify`

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_transport_output_forms_verify`
			WHERE id = $id
			LIMIT 1

		")->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_transport_output_forms_verify` AS tifv
			INNER JOIN tbs_transport_output_forms AS tif
			ON 			tif.id = tifv.form_id
			WHERE tifv.form_id = $id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($form_id, $field1, $field2, $field3)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			INSERT INTO `tbs_transport_output_forms_verify` (`form_id`, `field_type_id`, `field_type_group_id`, `field_name`, `state_id`)
			VALUES ('$form_id', ' $field1', '$field2', '$field3', '0');

		");
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "
			DELETE FROM tbs_transport_output_forms_verify WHERE form_id = $form_id
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}
}
