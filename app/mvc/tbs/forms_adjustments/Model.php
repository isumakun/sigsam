<?php

namespace tbs_forms_adjustments;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		return $this->db->query("

			SELECT *
			FROM `tbs_forms_adjustments`

		")->fetchAll();
	}


/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT a.*
			FROM `tbs_forms_adjustments` AS a
			WHERE a.id = $id
			LIMIT 1
		")->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($form_id, $form_type)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT a.*, u.username AS 'created_by'
			FROM `tbs_forms_adjustments` AS a
			INNER JOIN tbs3.admin_users AS u
			ON u.id = a.created_by
			WHERE a.form_id = $form_id AND a.form_type = $form_type
			ORDER BY a.id DESC

		";

		return $this->db->query($sql)->fetchAll();
	}


/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO `tbs_forms_adjustments` (`form_type`, `form_id`, `field_type`, `field_id`, `field_name`, `old_value`, `new_value`, `created_by`, `created_at`)
			VALUES ('{$params['form_type']}', '{$params['form_id']}', '{$params['field_type']}', '{$params['field_id']}', '{$params['field_name']}', '{$params['old_value']}', '{$params['new_value']}', '{$_SESSION['user']['id']}', now())

		";

		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create_tbs($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO `tbs_forms_adjustments` (`form_type`, `form_id`, `field_type`, `field_id`, `field_name`, `old_value`, `new_value`, `created_by`, `created_at`)
			VALUES ('{$params['form_type']}', '{$params['form_id']}', '{$params['field_type']}', '{$params['field_id']}', '{$params['field_name']}', '{$params['old_value']}', '{$params['new_value']}', 333, now())

		";

		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_forms_adjustments` 
			SET
				`id` = '{$params['id']}',
				`form_type` = '{$params['form_type']}',
				`form_id` = '{$params['form_id']}',
				`field_type` = '{$params['field_type']}',
				`field_id` = '{$params['field_id']}',
				`old_value` = '{$params['old_value']}',
				`new_value` = '{$params['new_value']}'
			WHERE 
				`id` = '{$params['id']}';

		";
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "
			DELETE FROM 
				`tbs_forms_adjustments`
			WHERE 
				`id` = $id 
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}
}
