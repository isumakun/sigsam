<?php

namespace tbs_thirdparties_requests;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tr.id,
						tr.company_id,
						tc.name AS 'company',
						tr.person_in_charge,
						tr.schedule_from,
						tr.schedule_to,
						tr.contact_phone,
						tr.access, tr.working_hours,
						tr.created_at,
						u1.username AS created_by,
						tr.presented_at,
						u2.username AS presented_by,
						tr.approved_at,
						u3.username AS approved_by,
						tr.rejected_at,
						u4.username AS rejected_by,
						tr.form_state_id,
						fs.name AS form_state
			FROM		tbs_thirdparties_requests AS tr
			INNER JOIN	
				tbs_thirdparties_companies AS tc
					ON tc.id = tr.company_id
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
					ON fs.id = tr.form_state_id
			LEFT JOIN 
				tbs3.`admin_users` AS u1
					ON u1.id = tr.created_by
			LEFT JOIN 
				tbs3.`admin_users` AS u2
					ON u2.id = tr.presented_by
			LEFT JOIN 
				tbs3.`admin_users` AS u3
					ON u3.id = tr.approved_by
			LEFT JOIN 
				tbs3.`admin_users` AS u4
					ON u4.id = tr.rejected_by
			ORDER BY tr.id DESC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	get_all_presented
------------------------------------------------------------------------------*/
	public function get_all_presented()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		com.name AS request_company,
						com.id AS nit,
						tr.id,
						tr.company_id,
						tc.name AS 'company',
						tr.person_in_charge,
						tr.schedule_from,
						tr.schedule_to,
						tr.contact_phone,
						tr.access, tr.working_hours,
						tr.work_types,
						tr.observations,
						tr.created_at,
						u1.username AS created_by,
						tr.presented_at,
						u2.username AS presented_by,
						tr.form_state_id,
						fs.name AS form_state
			FROM		tbs_company AS com, tbs_thirdparties_requests AS tr
			INNER JOIN	
				tbs_thirdparties_companies AS tc
					ON tc.id = tr.company_id
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
					ON fs.id = tr.form_state_id
			INNER JOIN 
				tbs3.`admin_users` AS u1
					ON u1.id = tr.created_by
			INNER JOIN 
				tbs3.`admin_users` AS u2
					ON u2.id = tr.presented_by
			WHERE tr.form_state_id = 2
			ORDER BY	tr.id DESC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	get_all_verified
------------------------------------------------------------------------------*/
	public function get_all_verified()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		com.name AS request_company,
						com.id AS nit,
						tr.id,
						tr.company_id,
						tc.name AS 'company',
						tr.person_in_charge,
						tr.schedule_from,
						tr.schedule_to,
						tr.contact_phone,
						tr.access, tr.working_hours,
						tr.work_types,
						tr.observations,
						tr.created_at,
						u1.username AS created_by,
						tr.presented_at,
						u2.username AS presented_by,
						tr.approved_at,
						u3.username AS approved_by,
						tr.rejected_at,
						u4.username AS rejected_by,
						tr.form_state_id,
						fs.name AS form_state
			FROM		tbs_company AS com, tbs_thirdparties_requests AS tr
			INNER JOIN	
				tbs_thirdparties_companies AS tc
					ON tc.id = tr.company_id
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
					ON fs.id = tr.form_state_id
			LEFT JOIN 
				tbs3.`admin_users` AS u1
					ON u1.id = tr.created_by
			LEFT JOIN 
				tbs3.`admin_users` AS u2
					ON u2.id = tr.presented_by
			LEFT JOIN 
				tbs3.`admin_users` AS u3
					ON u3.id = tr.approved_by
			LEFT JOIN 
				tbs3.`admin_users` AS u4
					ON u4.id = tr.rejected_by
			WHERE tr.form_state_id = 12
			ORDER BY	tr.id DESC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET ALL APPROVED
------------------------------------------------------------------------------*/
	public function get_all_approved()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tr.id,
						tr.company_id,
						tc.name AS 'company',
						tr.person_in_charge,
						tr.schedule_from,
						tr.schedule_to,
						tr.contact_phone,
						tr.access, tr.working_hours,
						tr.work_types,
						tr.observations,
						tr.created_at,
						u1.username AS created_by,
						tr.presented_at,
						u2.username AS presented_by,
						tr.approved_at,
						u3.username AS approved_by,
						tr.rejected_at,
						u4.username AS rejected_by,
						tr.form_state_id,
						fs.name AS form_state
			FROM		tbs_thirdparties_requests AS tr
			INNER JOIN	
				tbs_thirdparties_companies AS tc
					ON tc.id = tr.company_id
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
					ON fs.id = tr.form_state_id
			LEFT JOIN 
				tbs3.`admin_users` AS u1
					ON u1.id = tr.created_by
			LEFT JOIN 
				tbs3.`admin_users` AS u2
					ON u2.id = tr.presented_by
			LEFT JOIN 
				tbs3.`admin_users` AS u3
					ON u3.id = tr.approved_by
			LEFT JOIN 
				tbs3.`admin_users` AS u4
					ON u4.id = tr.rejected_by
			WHERE (tr.form_state_id = 3 OR tr.form_state_id = 5)
			ORDER BY	tr.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		tr.id,
						tr.company_id,
						tc.name AS 'company',
						tr.person_in_charge,
						tr.schedule_from,
						tr.schedule_to,
						tr.contact_phone,
						tr.access, tr.working_hours,
						tr.work_types,
						tr.observations,
						tr.created_at,
						u1.username AS created_by,
						tr.presented_at,
						u2.username AS presented_by,
						tr.approved_at,
						u3.username AS approved_by,
						tr.rejected_at,
						u4.username AS rejected_by,
						tr.form_state_id,
						fs.name AS form_state
			FROM		tbs_thirdparties_requests AS tr
			INNER JOIN	
				tbs_thirdparties_companies AS tc
					ON tc.id = tr.company_id
			INNER JOIN 
				tbs3.`tbs_forms_states` AS fs
					ON fs.id = tr.form_state_id
			LEFT JOIN 
				tbs3.`admin_users` AS u1
					ON u1.id = tr.created_by
			LEFT JOIN 
				tbs3.`admin_users` AS u2
					ON u2.id = tr.presented_by
			LEFT JOIN 
				tbs3.`admin_users` AS u3
					ON u3.id = tr.approved_by
			LEFT JOIN 
				tbs3.`admin_users` AS u4
					ON u4.id = tr.rejected_by
			WHERE		tr.id = '$id'
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$work_types = '';
		foreach ($params['work_types'] as $wt) {
			$work_types .= $wt.', ';
		}
		
		$sql = "

			INSERT INTO		tbs_thirdparties_requests (`company_id`, `person_in_charge`, `work_types`, `observations`, `schedule_from`, `schedule_to`, `contact_phone`, `access`, `working_hours`, `created_at`, `created_by`)
			VALUES		('{$params['company_id']}', '{$params['person_in_charge']}', '$work_types', '{$params['observations']}', '{$params['schedule_from']}', '{$params['schedule_to']}', '{$params['contact_phone']}', '{$params['access']}', '{$params['working_hours']}', now(), '{$_SESSION['user']['id']}')

		";

		$this->db->query($sql);

		return $this->db->lastInsertId();
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$work_types = '';
		foreach ($params['work_types'] as $wt) {
			$work_types .= $wt.', ';
		}

		$sql = "

			UPDATE		tbs_thirdparties_requests
			SET			`company_id` = '{$params['company_id']}',
						`person_in_charge` = '{$params['person_in_charge']}',
						`work_types` = '{$params['work_types']}',
						`observations` = '{$params['observations']}',
						`schedule_from` = '{$params['schedule_from']}',
						`schedule_to` = '{$params['schedule_to']}',
						`contact_phone` = '{$params['contact_phone']}',
						`access` = '{$params['access']}',
						`working_hours` = '{$params['working_hours']}'
			WHERE		id = '$id'

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	PRESENT
------------------------------------------------------------------------------*/
	public function present($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE		tbs_thirdparties_requests
			SET			`presented_by` = '{$_SESSION['user']['id']}',
						`presented_at` = now(),
						`form_state_id` = 2
			WHERE		id = '$id'

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	REJECT
------------------------------------------------------------------------------*/
	public function reject($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE		tbs_thirdparties_requests
			SET			`presented_by` = '',
						`presented_at` = '0000-00-00 00:00:00',
						`rejected_by` = '{$_SESSION['user']['id']}',
						`rejected_at` = now(),
						`form_state_id` = 4
			WHERE		id = '$id'

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	APPROVE
------------------------------------------------------------------------------*/
	public function approve($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE		tbs_thirdparties_requests
			SET			`approved_by` = '{$_SESSION['user']['id']}',
						`approved_at` = now(),
						`form_state_id` = 3
			WHERE		id = '$id'

		";

		return $this->db->query($sql);
	}


/*------------------------------------------------------------------------------
	verify_auto
------------------------------------------------------------------------------*/
	public function verify_auto($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE		tbs_thirdparties_requests
			SET			`verified_by` = 333,
						`verified_at` =  now(),
						`form_state_id` = 12
			WHERE		id = '$id'

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	VERIFY
------------------------------------------------------------------------------*/
	public function verify($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE		tbs_thirdparties_requests
			SET			`verified_by` = '{$_SESSION['user']['id']}',
						`verified_at` =  now(),
						`form_state_id` = 12
			WHERE		id = '$id'

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	DELETE BY ID
------------------------------------------------------------------------------*/
	public function delete_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			DELETE
			FROM		tbs_thirdparties_requests
			WHERE		id = '$id'

		");
	}
}