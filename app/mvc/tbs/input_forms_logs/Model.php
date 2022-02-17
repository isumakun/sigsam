<?php

namespace tbs_input_forms_logs;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_input_forms_logs`

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT l.form_id, l.form_state_id, l.created_at, u.username AS created_by, f.id AS form_id, fs.name AS state
			
			FROM `tbs_input_forms_logs` AS l

			INNER JOIN
				tbs3.`tbs_forms_states` AS fs
				ON
					l.form_state_id = fs.id

			INNER JOIN
				`tbs_input_forms` AS f
				ON
					l.form_id = f.id

			INNER JOIN
				tbs3.`admin_users` AS u
				ON
					l.created_by = u.id

			WHERE 
				f.id = $id
			ORDER BY l.id DESC
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($form_id, $form_state_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO 
				`tbs_input_forms_logs` 
				(
					`form_id`, 
					`form_state_id`, 
					`created_by`, 
					`created_at`
				)

			VALUES (
				$form_id,
				$form_state_id,
				{$_SESSION['user']['id']},
				now()
			);

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create_at($form_id, $form_state_id, $created_at, $created_by)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO 
				`tbs_input_forms_logs` 
				(
					`form_id`, 
					`form_state_id`, 
					`created_by`, 
					`created_at`
				)

			VALUES (
				$form_id,
				$form_state_id,
				'$created_by',
				'$created_at'
			);

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}



/*----------------------------------------------------------------------
	GET LAST
 ---------------------------------------------------------------------*/
	public function get_last($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				l.*, fs.name AS state

			FROM
				`tbs_input_forms_logs` AS l

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = l.form_state_id

			WHERE 
				form_id = $form_id

			ORDER BY l.id DESC 

			LIMIT 1
		";

		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET 
 ---------------------------------------------------------------------*/
	public function get_last_by_state($form_id, $state_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				l.*, fs.name AS state

			FROM
				`tbs_input_forms_logs` AS l

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = l.form_state_id

			WHERE 
				form_id = $form_id
				AND 
				form_state_id = $state_id

			ORDER BY l.id DESC 

			LIMIT 1
		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET 
 ---------------------------------------------------------------------*/
	public function get_last_states($form_id, $state_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			SELECT
				l.*, fs.name AS state

			FROM
				`tbs_input_forms_logs` AS l

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = l.form_state_id
			
			WHERE 
				form_id = $form_id
				AND 
				form_state_id = $state_id

			ORDER BY l.id DESC
		";

		return $this->db->query($sql)->fetchAll();
	}
}
