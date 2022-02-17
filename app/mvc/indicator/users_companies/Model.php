<?php

namespace indicator_users_companies;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT		uc.id,
						uc.user_id,
						u.username AS 'user',
						uc.company_id
			FROM		indicator_users_companies AS uc
			LEFT JOIN	admin_users AS u
						ON u.id = uc.user_id
			ORDER BY	uc.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_company_id($id)
	{
		return $this->db->query("

			SELECT		uc.id,
						uc.user_id,
						u.username AS 'user',
						uc.company_id,
						c.name AS 'company'
			FROM		indicator_users_companies AS uc
			INNER JOIN	admin_users AS u
						ON u.id = uc.user_id
			INNER JOIN	indicator_companies AS c
						ON c.id = uc.company_id
			WHERE		uc.company_id = '$id'
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	GET BY USER ID
------------------------------------------------------------------------------*/
	public function get_by_user_id($user_id)
	{
		return $this->db->query("

			SELECT		uc.id,
						uc.user_id,
						u.username AS 'user',
						uc.company_id,
						c.name AS 'company'
			FROM		indicator_users_companies AS uc
			INNER JOIN	admin_users AS u
						ON u.id = uc.user_id
			INNER JOIN	indicator_companies AS c
						ON c.id = uc.company_id
			WHERE		uc.user_id = '$user_id'

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		return $this->db->query("

			INSERT
			INTO		indicator_users_companies (`user_id`, `company_id`)
			VALUES		('{$params['user_id']}', '{$params['company_id']}')

		");
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		return $this->db->query("

			UPDATE		indicator_users_companies
			SET			`user_id` = '{$params['user_id']}',
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
			FROM		indicator_users_companies
			WHERE		id = '$id'

		");
	}
}