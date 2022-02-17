<?php

namespace tbs_input_forms;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				`if`.*,
				`if`.id AS form_id,
				s.*,
				fs.id AS 'state_id',
				ift.*,
				tt.*,
				s.name AS supplier,
				s.nit AS supplier_nit,
				CONCAT(ift.id, ' - ' , ift.name) AS transaction,
				tt.name AS transport,
				a.name AS agreement,
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
				`tbs_input_forms` AS `if`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = if.supplier_id

			INNER JOIN
				tbs3.`tbs_input_forms_transactions` AS ift
					ON
						ift.id = if.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = if.transport_type_id

			LEFT JOIN
				tbs3.`tbs_input_forms_agreements` AS a
					ON
						a.id = if.agreement_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = if.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = if.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = if.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = if.flag_id_4

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = if.form_state_id

			ORDER BY `if`.id DESC
		";

		return $this->db->query($sql)->fetchAll();
	}


/*----------------------------------------------------------------------
	GET BY DATE
 ---------------------------------------------------------------------*/
	public function get_by_date($month, $year, $transaction_id=0)
	{
		if ($transaction_id!=0) {
			$and = " AND transaction_id regexp '^[$transaction_id]+'" ;
		}
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
			c.name AS company,
				`if`.*,
				`if`.id AS form_id,
				s.*,
				fs.id AS 'state_id',
				ift.*,
				tt.*,
				s.name AS supplier,
				s.nit AS supplier_nit,
				CONCAT(ift.id, ' - ' , ift.name) AS transaction,
				tt.name AS transport,
				a.name AS agreement,
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
				tbs_company AS c, `tbs_input_forms` AS `if`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = if.supplier_id

			INNER JOIN
				tbs3.`tbs_input_forms_transactions` AS ift
					ON
						ift.id = if.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = if.transport_type_id

			LEFT JOIN
				tbs3.`tbs_input_forms_agreements` AS a
					ON
						a.id = if.agreement_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = if.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = if.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = if.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = if.flag_id_4

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = if.form_state_id

			WHERE MONTH(`if`.approved_at) = $month
			AND YEAR(`if`.approved_at) = $year
			$and
			ORDER BY `if`.id DESC
		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_presented()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
			c.name AS company,
			c.id AS company_id,
				`if`.*,
				`if`.id AS form_id,
				s.*,
				fs.id AS 'state_id',
				ift.*,
				tt.*,
				s.name AS supplier,
				s.nit AS supplier_nit,
				CONCAT(ift.id, ' - ' , ift.name) AS transaction,
				tt.name AS transport,
				a.name AS agreement,
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
				tbs_company AS c, `tbs_input_forms` AS `if`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = if.supplier_id

			INNER JOIN
				tbs3.`tbs_input_forms_transactions` AS ift
					ON
						ift.id = if.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = if.transport_type_id

			LEFT JOIN
				tbs3.`tbs_input_forms_agreements` AS a
					ON
						a.id = if.agreement_id

			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = if.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = if.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = if.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = if.flag_id_4

			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
				ON 
					fs.id = if.form_state_id

			WHERE `if`.form_state_id = 2
			ORDER BY `if`.id DESC
		";

		return $this->db->query($sql)->fetchAll();
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
				s.*,
				ift.*,
				tt.*,
				s.name AS supplier,
				a.name AS agreement,
				ift.name AS transaction,
				ift.id AS transaction_code,
				tt.name AS transport,
				f1.name AS flag_1,
				f2.name AS flag_2,
				f3.name AS flag_3,
				f4.name AS flag_4,
				fs.name AS state

			FROM
				`tbs_input_forms` AS `if`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = if.supplier_id

			INNER JOIN
				tbs3.`tbs_input_forms_transactions` AS ift
					ON
						ift.id = if.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = if.transport_type_id

			LEFT JOIN
				tbs3.`tbs_input_forms_agreements` AS a
					ON
						a.id = if.agreement_id
						
			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = if.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = if.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = if.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = if.flag_id_4

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

		$sql = "

			SELECT
				`if`.*,
				`if`.id AS form_id,
				s.*,
				ift.*,
				tt.*,
				s.name AS supplier,
				s.nit AS supplier_nit,
				ift.name AS transaction,
				ift.id AS transaction_code,
				tt.name AS transport,
				a.name AS agreement,
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
				u3.username AS updated_by_user,
				tif.starting_weight_value,
				tif.ending_weight_value

			FROM
				`tbs_input_forms` AS `if`

			INNER JOIN
				`tbs_suppliers` AS s
					ON
						s.id = if.supplier_id

			INNER JOIN
				tbs3.`tbs_input_forms_transactions` AS ift
					ON
						ift.id = if.transaction_id

			INNER JOIN
				tbs3.`tbs_transport_types` AS tt
					ON
						tt.id = if.transport_type_id

			LEFT JOIN
				tbs3.`tbs_input_forms_agreements` AS a
					ON
						a.id = if.agreement_id
						
			INNER JOIN
				tbs3.`tbs_flags` AS f1
					ON
						f1.id = if.flag_id_1

			INNER JOIN
				tbs3.`tbs_flags` AS f2
					ON
						f2.id = if.flag_id_2

			INNER JOIN
				tbs3.`tbs_flags` AS f3
					ON
						f3.id = if.flag_id_3

			INNER JOIN
				tbs3.`tbs_flags` AS f4
					ON
						f4.id = if.flag_id_4

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
					u3.id = if.updated_by

			LEFT JOIN 
				`tbs_warehouses` AS w
				ON 
					w.form_id = if.id

			LEFT JOIN 
				`tbs_transport_input_forms_products` AS tifp
				ON 
					tifp.warehouse_id = w.id

			LEFT JOIN 
				`tbs_transport_input_forms` AS tif
				ON 
					tifp.form_id = tif.id

			WHERE
				`if`.`id` = $id

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
				`tbs_input_forms` (
					`supplier_id`,
					`transaction_id`,
					`transport_type_id`,
					`exchange_rate`,
					`refundable`,
					`agreement_id`,
					`packages_quantity`,
					`flag_id_1`,
					`flag_id_2`,
					`flag_id_3`,
					`flag_id_4`,
					`created_by`
				)

			VALUES (
				{$params['supplier_id']},
				{$params['transaction_id']},
				{$params['transport_type_id']},
				{$params['exchange_rate']},
				'{$params['refundable']}',
				'{$params['agreement_id']}',
				'{$params['packages_quantity']}',
				{$params['flag_id_1']},
				{$params['flag_id_2']},
				{$params['flag_id_3']},
				{$params['flag_id_4']},
				'{$_SESSION['user']['id']}'
			);

		";
		
			/*echo "ESTAMOS ARREGLANDO ALGO, POR FAVOR ESPERE :)";
			echo '<pre>'.print_r($sql, TRUE).'</pre>';
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

		$params['exchange_rate'] = str_replace(",", ".", $params['exchange_rate']);
		
		$sql = "

			UPDATE 
				`tbs_input_forms` 

			SET
					`supplier_id` = '{$params['supplier_id']}',
					`transaction_id` = '{$params['transaction_id']}',
					`transport_type_id` = '{$params['transport_type_id']}',
					`exchange_rate` = '{$params['exchange_rate']}',
					`refundable` = '{$params['refundable']}',
					`agreement_id` = '{$params['agreement_id']}',
					`packages_quantity` = '{$params['packages_quantity']}',
					`flag_id_1` = '{$params['flag_id_1']}',
					`flag_id_2` = '{$params['flag_id_2']}',
					`flag_id_3` = '{$params['flag_id_3']}',
					`flag_id_4` = '{$params['flag_id_4']}',
					`observations` = '{$params['observations']}',
					`updated_by` = '{$_SESSION['user']['id']}',
					`updated_at` = now()
					
					WHERE `id` = {$params['input_form_id']};

		";

		//echo '<pre>'.print_r($sql, TRUE).'</pre>';
		//die();

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
				`tbs_input_forms` 

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
				`tbs_input_forms` 

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
				`tbs_input_forms` 

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
				`tbs_input_forms` 

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
	EXECUTE AT
 ---------------------------------------------------------------------*/
	public function execute_at($id, $executed_at, $executed_by)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_input_forms` 

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
				`tbs_input_forms` 

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
				`tbs_input_forms` 

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
	RECOVER
 ---------------------------------------------------------------------*/
	public function recover($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_input_forms` 

			SET
					`presented_by` = '',
					`presented_at` = '0000-00-00 00:00:00',
					form_state_id  = 1
					
					WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	CANCEL
 ---------------------------------------------------------------------*/
	public function cancel($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_input_forms` 

			SET
				form_state_id  = 13
					
				WHERE `id` = $id;

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql);
	}
}
