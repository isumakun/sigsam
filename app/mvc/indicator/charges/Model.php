<?php

namespace indicator_charges;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all($id)
	{
		return $this->db->query("

			SELECT		c.id,
						c.user_id,
						u.username AS 'user',
						u.last_name,
						u.first_name,
						c.job_position,
						c.company_id,
						c1.name AS 'company'
			FROM		indicator_charges AS c
			INNER JOIN	admin_users AS u
						ON u.id = c.user_id
			INNER JOIN	indicator_companies AS c1
						ON c1.id = c.company_id
				WHERE   c.company_id = $id 
				AND u.is_active = 1
			ORDER BY	c.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		return $this->db->query("

			SELECT		c.id,
						c.user_id,
						u.username AS 'user',
						c.job_position,
						c.company_id,
						c1.name AS 'company'
			FROM		indicator_charges AS c
			INNER JOIN	admin_users AS u
						ON u.id = c.user_id
			INNER JOIN	indicator_companies AS c1
						ON c1.id = c.company_id
			WHERE		c.id = '$id'
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		return $this->db->query("

			INSERT
			INTO		indicator_charges (`user_id`, `job_position`, `company_id`)
			VALUES		('{$params['user_id']}', '{$params['job_position']}', '{$params['company_id']}')

		");
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		return $this->db->query("

			UPDATE		indicator_charges
			SET			`user_id` = '{$params['user_id']}',
						`job_position` = '{$params['job_position']}',
						`company_id` = '{$params['company_id']}'
			WHERE		id = '$id'

		");
	}

/*------------------------------------------------------------------------------
	DELETE BY ID
------------------------------------------------------------------------------*/
	public function delete_by_id($id)
	{
		return $this->db->query("

			DELETE
			FROM		indicator_charges
			WHERE		id = '$id'

		");
	}
}