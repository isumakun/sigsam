<?php

namespace tbs_output_forms_verify;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_output_forms_verify`

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT v.*
			FROM 
				`tbs_output_forms_verify` AS v
				
			INNER JOIN
				`tbs_output_forms` AS f
				ON
					v.form_id = f.id

			WHERE 
				f.id = $id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	UPDATE STATE BY TYPE
 ---------------------------------------------------------------------*/
	public function update_state($form_id, $field_type_id, $field_type_group_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE `tbs_output_forms_verify` SET
			`state_id` = '2'
			WHERE 
				form_id = $form_id 
				AND field_type_id = $field_type_id
				AND field_type_group_id = $field_type_group_id

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "
			DELETE FROM tbs_output_forms_verify WHERE form_id = $form_id
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($form_id, $field_type_id, $field_type_group_id, $field_name)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
			$sql = "

				INSERT INTO 
					`tbs_output_forms_verify` 
					(
					`form_id`, 
					`field_type_id`, 
					`field_type_group_id`, 
					`field_name`,
					`state_id`
					)

				VALUES (
					$form_id,
					$field_type_id,
					$field_type_group_id, 
					'$field_name',
					2
				)
				ON DUPLICATE KEY UPDATE
					form_id     			= $form_id,
					field_type_id 			= $field_type_id,
					field_type_group_id     = $field_type_group_id,
					field_name     			= '$field_name',
					state_id				= 2;

			";
		return $this->db->query($sql);
	}
}
