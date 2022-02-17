<?php

namespace tbs_output_forms;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				`of`.*,
				`of`.id AS form_id,
				s.*,
				oft.*,
				tt.*,
				s.name AS supplier,
				CONCAT(oft.id, ' - ' , oft.name) AS transaction,
				oft.id AS transaction_code,
				tt.name AS transport,
				f1.name AS flag_1,
				f1.id AS flag_id_1,
				f2.name AS flag_2,
				f2.id AS flag_id_2,
				f3.name AS flag_3,
				f3.id AS flag_id_3,
				f4.name AS flag_4,
				f4.id AS flag_id_4,
				fs.name AS state

			FROM
				`tbs_output_forms` AS `of`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = of.supplier_id

			INNER JOIN
				tbs3.`tbs_output_forms_transactions` AS oft
					ON
						oft.id = of.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = of.transport_type_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = of.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = of.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = of.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = of.flag_id_4

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = of.form_state_id

			ORDER BY `of`.id DESC
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY DATE
 ---------------------------------------------------------------------*/
	public function get_by_date($month, $year)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
			c.name AS company,
				`of`.*,
				`of`.id AS form_id,
				s.*,
				oft.*,
				tt.*,
				s.name AS supplier,
				CONCAT(oft.id, ' - ' , oft.name) AS transaction,
				oft.id AS transaction_code,
				tt.name AS transport,
				f1.name AS flag_1,
				f1.id AS flag_id_1,
				f2.name AS flag_2,
				f2.id AS flag_id_2,
				f3.name AS flag_3,
				f3.id AS flag_id_3,
				f4.name AS flag_4,
				f4.id AS flag_id_4,
				fs.name AS state

			FROM
				tbs_company AS c, `tbs_output_forms` AS `of`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = of.supplier_id

			INNER JOIN
				tbs3.`tbs_output_forms_transactions` AS oft
					ON
						oft.id = of.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = of.transport_type_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = of.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = of.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = of.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = of.flag_id_4

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = of.form_state_id

			WHERE MONTH(of.approved_at) = $month
			AND YEAR(of.approved_at) = $year

			ORDER BY `of`.id DESC
		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL TEMPORARY
 ---------------------------------------------------------------------*/
	public function get_all_temporary()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT (SELECT MAX(form_state_id) FROM tbs_output_forms_logs WHERE form_id = `of`.id) AS LOL,
				`of`.*,
				`of`.id AS form_id,
				s.*,
				oft.*,
				tt.*,
				s.name AS supplier,
				CONCAT(oft.id, ' - ' , oft.name) AS transaction,
				oft.id AS transaction_code,
				tt.name AS transport,
				fs.name AS state

			FROM
				`tbs_output_forms` AS `of`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = of.supplier_id

			INNER JOIN
				tbs3.`tbs_output_forms_transactions` AS oft
					ON
						oft.id = of.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = of.transport_type_id

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = of.form_state_id

			WHERE (SELECT MAX(form_state_id) FROM tbs_output_forms_logs WHERE form_id = `of`.id) != 15 AND `of`.transaction_id = 409

			ORDER BY `of`.id DESC
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
				`of`.*,
				`of`.id AS form_id,
				s.*,
				oft.*,
				tt.*,
				s.name AS supplier,
				CONCAT(oft.id, ' - ' , oft.name) AS transaction,
				oft.id AS transaction_code,
				tt.name AS transport,
				f1.name AS flag_1,
				f1.id AS flag_id_1,
				f2.name AS flag_2,
				f2.id AS flag_id_2,
				f3.name AS flag_3,
				f3.id AS flag_id_3,
				f4.name AS flag_4,
				f4.id AS flag_id_4,
				fs.name AS state

			FROM
				tbs_company AS c, `tbs_output_forms` AS `of`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = of.supplier_id

			INNER JOIN
				tbs3.`tbs_output_forms_transactions` AS oft
					ON
						oft.id = of.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = of.transport_type_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = of.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = of.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = of.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = of.flag_id_4

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = of.form_state_id

			WHERE (`of`.form_state_id = 2 OR `of`.form_state_id = 10)
			ORDER BY `of`.id DESC
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
				`of`.*,
				`of`.id AS form_id,
				s.*,
				oft.*,
				tt.*,
				s.name AS supplier,
				oft.name AS transaction,
				oft.id AS transaction_code,
				tt.name AS transport,
				f1.name AS flag_1,
				f1.id AS flag_id_1,
				f2.name AS flag_2,
				f2.id AS flag_id_2,
				f3.name AS flag_3,
				f3.id AS flag_id_3,
				f4.name AS flag_4,
				f4.id AS flag_id_4,
				fs.name AS state

			FROM
				`tbs_output_forms` AS `of`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = of.supplier_id

			INNER JOIN
				tbs3.`tbs_output_forms_transactions` AS oft
					ON
						oft.id = of.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = of.transport_type_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = of.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = of.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = of.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = of.flag_id_4

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = of.form_state_id

			WHERE fs.id = 3
		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				`of`.*,
				`of`.id AS form_id,
				s.*,
				oft.*,
				tt.*,
				s.name AS supplier,
				s.nit AS supplier_nit,
				oft.name AS transaction,
				oft.id AS transaction_code,
				tt.name AS transport,
				f1.name AS flag_1,
				f1.id AS flag_id_1,
				f1.name AS flag_name_1,
				f2.name AS flag_2,
				f2.id AS flag_id_2,
				f2.name AS flag_name_2,
				f3.name AS flag_3,
				f3.id AS flag_id_3,
				f3.name AS flag_name_3,
				f4.name AS flag_4,
				f4.id AS flag_id_4,
				f4.name AS flag_name_4,
				fs.name AS state,
				u1.username AS created_by_user,
				u2.username AS approved_by_user,
				u3.username AS updated_by_user

			FROM
				`tbs_output_forms` AS `of`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = of.supplier_id

			INNER JOIN
				tbs3.`tbs_output_forms_transactions` AS oft
					ON
						oft.id = of.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = of.transport_type_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = of.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = of.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = of.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = of.flag_id_4

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = of.form_state_id

			LEFT JOIN 
				tbs3.`admin_users` AS u1
				ON 
					u1.id = of.created_by

			LEFT JOIN 
				tbs3.`admin_users` AS u2
				ON 
					u2.id = of.approved_by

			LEFT JOIN 
				tbs3.`admin_users` AS u3
				ON 
					u3.id = of.updated_by

			WHERE
				`of`.`id` = $id

			LIMIT 1

		";
		
		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$params['exchange_rate'] = str_replace(",", ".", $params['exchange_rate']);
		
		$sql = "

			INSERT INTO
				`tbs_output_forms` (
					`supplier_id`,
					`transaction_id`,
					`transport_type_id`,
					`exchange_rate`,
					`packages_quantity`,
					`refundable`,
					`flag_id_1`,
					`flag_id_2`,
					`flag_id_3`,
					`flag_id_4`,
					`observations`,
					`created_by`
				)

			VALUES (
				{$params['supplier_id']},
				{$params['transaction_id']},
				{$params['transport_type_id']},
				{$params['exchange_rate']},
				'{$params['packages_quantity']}',
				{$params['refundable']},
				{$params['flag_id_1']},
				{$params['flag_id_2']},
				{$params['flag_id_3']},
				{$params['flag_id_4']},
				'{$params['observations']}',
				'{$_SESSION['user']['id']}'
			);

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();
		
		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$params['exchange_rate'] = str_replace(",", ".", $params['exchange_rate']);
		
		/*echo '<pre>'.print_r($params, TRUE).'</pre>';
		die();*/
		return $this->db->query("

			UPDATE 
				`tbs_output_forms` 

			SET
					`supplier_id` = '{$params['supplier_id']}',
					`transaction_id` = '{$params['transaction_id']}',
					`transport_type_id` = '{$params['transport_type_id']}',
					`exchange_rate` = '{$params['exchange_rate']}',
					`packages_quantity` = '{$params['packages_quantity']}',
					`refundable` = '{$params['refundable']}',
					`flag_id_1` = '{$params['flag_id_1']}',
					`flag_id_2` = '{$params['flag_id_2']}',
					`flag_id_3` = '{$params['flag_id_3']}',
					`flag_id_4` = '{$params['flag_id_4']}',
					`observations` = '{$params['observations']}',
					`updated_by` = '{$_SESSION['user']['id']}',
					`updated_at` = now()
					
					WHERE `id` = {$params['output_form_id']};

		");
	}

/*----------------------------------------------------------------------
	APPROVE
 ---------------------------------------------------------------------*/
	public function approve($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_output_forms` 

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
	return_execute
 ---------------------------------------------------------------------*/
	public function return_execute($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_output_forms`

			SET
					`executed_by` = '',
					`executed_at` = '0000-00-00 00:00:00',
					form_state_id  = 3
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	APPROVE CHANGE TYPE
 ---------------------------------------------------------------------*/
	public function approve_change_type($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_output_forms` 

			SET
					form_state_id  = 11
					
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
				`tbs_output_forms` 

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
				`tbs_output_forms` 

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
	EXECUTE AT
 ---------------------------------------------------------------------*/
	public function execute_at($id, $executed_at, $executed_by)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_output_forms` 

			SET
					`executed_by` = '$executed_by',
					`executed_at` = '$executed_at',
					form_state_id  = 5
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	set_in_review
 ---------------------------------------------------------------------*/
	public function set_in_review($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_output_forms` 

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
	liberate
 ---------------------------------------------------------------------*/
	public function liberate($id, $state)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_output_forms` 

			SET
					`updated_by` = '{$_SESSION['user']['id']}',
					form_state_id  = $state
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	CHANGE TYPE
 ---------------------------------------------------------------------*/
	public function change_type($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_output_forms` 

			SET
					`presented_by` = '{$_SESSION['user']['id']}',
					`presented_at` = now(),
					form_state_id  = 10
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	ADD OBSERVATION
 ---------------------------------------------------------------------*/
	public function add_observation($id, $observations)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_output_forms` 

			SET
					`observations` = '$observations'
					
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
				`tbs_output_forms` 

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

/*----------------------------------------------------------------------
	RECOVER
 ---------------------------------------------------------------------*/
	public function recover($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		$sql = "

			UPDATE 
				`tbs_output_forms` 

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


}
