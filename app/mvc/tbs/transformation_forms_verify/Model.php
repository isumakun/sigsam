<?php

namespace tbs_transformation_forms_verify;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_transformation_forms_verify`

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
				`tbs_transformation_forms_verify` AS v
				
			INNER JOIN
				`tbs_input_forms` AS f
				ON
					v.form_id = f.id

			WHERE 
				f.id = $id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET TOP
 ---------------------------------------------------------------------*/
	public function get_top($form_id, $field_type_id, $field_type_group_id, $field_name)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT v.*
			FROM 
				`tbs_transformation_forms_verify` AS v

			WHERE 
				form_id = $form_id 
				AND field_type_id = $field_type_id
				AND field_type_group_id = $field_type_group_id
				AND field_name = '$field_name'

			ORDER BY v.id DESC
			LIMIT 1
		";

		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	UPDATE VALUE
 ---------------------------------------------------------------------*/
	public function update_value($verify_id, $new_value)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE `tbs_transformation_forms_verify` 
				SET
				`field_value_new` = '$new_value'

			WHERE 
				id = $verify_id

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	UPDATE ALL VALUES
 ---------------------------------------------------------------------*/
	public function update_all_values($verify_id, $new_value)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE `tbs_transformation_forms_verify` 
				SET
				`field_value_original` = `field_value_new`,
				`field_value_new` = '$new_value'

			WHERE 
				id = $verify_id

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
			DELETE FROM tbs_transformation_forms_verify WHERE form_id = $form_id
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($form_id, $field_type_id, $field_type_group_id, $field_name, $field_value_original)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
			$sql = "

				INSERT INTO 
					`tbs_transformation_forms_verify` 
					(
					`form_id`, 
					`field_type_id`, 
					`field_type_group_id`, 
					`field_name`,
					`field_value_original`,
					`state_id`
					)

				VALUES (
					$form_id,
					$field_type_id,
					$field_type_group_id,
					'$field_name',
					'$field_value_original',
					2
				)

			";
		return $this->db->query($sql);
	}
}
