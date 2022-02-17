<?php

namespace tbs_transformation_forms;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				`if`.*,
				`if`.id AS form_id,
				fs.name AS state

			FROM
				`tbs_transformation_forms` AS `if`
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = if.form_state_id

			ORDER BY `if`.id DESC
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_presented()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				c.name AS company,
				c.id AS company_id,
				`if`.*,
				`if`.id AS form_id,
				fs.name AS state

			FROM
				`tbs_company` AS c, `tbs_transformation_forms` AS `if`
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = if.form_state_id

			WHERE `if`.form_state_id = 2
			ORDER BY `if`.id DESC
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	get_for_inspection
 ---------------------------------------------------------------------*/
	public function get_for_inspection()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				`if`.*,
				`if`.id AS form_id,
				fs.name AS state

			FROM
				`tbs_transformation_forms` AS `if`

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = if.form_state_id

			WHERE fs.id = 3
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				`if`.*,
				`if`.id AS form_id,
				fs.name AS state,
				u1.username AS created_by_user,
				u2.username AS approved_by_user,
				u3.username AS updated_by_user

			FROM
				`tbs_transformation_forms` AS `if`

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = if.form_state_id

			LEFT JOIN 
				tbs3.`admin_users` AS u1
				ON 
					u1.id = if.created_by

			LEFT JOIN 
				tbs3.`admin_users` AS u2
				ON 
					u2.id = if.approved_by

			LEFT JOIN 
				tbs3.`admin_users` AS u3
				ON 
					u3.id = if.approved_by

			WHERE
				`if`.`id` = $id

			LIMIT 1

		")->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($man_power, $utility, $direct_cost)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO
				`tbs_transformation_forms` (
					`man_power`,
					`utility`,
					`direct_cost`,
					`created_by`,
					`created_at`
				)

			VALUES (
				'$man_power',
				'$utility',
				'$direct_cost',
				'{$_SESSION['user']['id']}',
				now()
			);

		";
		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		
		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		/*echo '<pre>'.print_r($params, TRUE).'</pre>';
		die();*/
		return $this->db->query("

			UPDATE 
				`tbs_transformation_forms` 

			SET
					`man_power` = '{$params['man_power']}',
					`utility` = '{$params['utility']}',
					`direct_cost` = '{$params['direct_cost']}',
					`observations` = '{$params['observations']}',
					`updated_by` = '{$_SESSION['user']['id']}',
					`updated_at` = now()
					
					WHERE `id` = {$params['transformation_form_id']};

		");
	}

/*----------------------------------------------------------------------
	set_in_review
 ---------------------------------------------------------------------*/
	public function set_in_review($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transformation_forms` 

			SET
					`updated_by` = '{$_SESSION['user']['id']}',
					form_state_id  = 14
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}
	
/*----------------------------------------------------------------------
	APPROVE
 ---------------------------------------------------------------------*/
	public function approve($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transformation_forms` 

			SET
					`approved_by` = '{$_SESSION['user']['id']}',
					`approved_at` = now(),
					form_state_id  = 3
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	PRESENT
 ---------------------------------------------------------------------*/
	public function present($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transformation_forms` 

			SET
					`presented_by` = '{$_SESSION['user']['id']}',
					`presented_at` = now(),
					form_state_id  = 2
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	EXECUTE
 ---------------------------------------------------------------------*/
	public function execute($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_transformation_forms` 

			SET
					`executed_by` = '{$_SESSION['user']['id']}',
					`executed_at` = now(),
					form_state_id  = 5
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	RETURN PRESENTED
 ---------------------------------------------------------------------*/
	public function return_presented($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			UPDATE 
				`tbs_transformation_forms` 

			SET
					`presented_by` = '',
					`presented_at` = '0000-00-00 00:00:00',
					form_state_id 	   = 1
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	REJECT
 ---------------------------------------------------------------------*/
	public function reject($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			UPDATE 
				`tbs_transformation_forms` 

			SET
					`presented_by` = '',
					`presented_at` = '0000-00-00 00:00:00',
					form_state_id 	   = 4
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}
}
