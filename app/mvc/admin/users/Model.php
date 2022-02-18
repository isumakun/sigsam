<?php

namespace admin_users;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	VALIDATE USER
----------------------------------------------------------------------*/
	public function validate_user($username, $password)
	{
		$password = sha1($password);

		$sql = "

			SELECT
				users.id,
				users.username,
				users.first_name,
				users.last_name,
				users.email,
				roles.main_page

			FROM
				admin_users AS users

			LEFT JOIN
				admin_users_roles AS users_roles
					ON
						users_roles.user_id = users.id
						AND users_roles.is_active >= 1

			LEFT JOIN
				admin_roles AS roles ON
					roles.id = users_roles.role_id

			WHERE
				users.username = '{$username}'
				AND users.password = '{$password}'

				AND users.is_deleted = 0
				AND users.is_active > 0

			LIMIT
				1

		";

		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET BY USERNAME
----------------------------------------------------------------------*/
	public function get_by_username($username)
	{
		
		$sql = "

			SELECT
				u.*, ur.role_id,
				roles.main_page

			FROM
				`admin_users` AS u

			INNER JOIN admin_users_roles AS ur
				ON
					ur.user_id = u.id

			INNER JOIN admin_roles AS r
				ON
					r.id = ur.role_id

			LEFT JOIN indicator_users_companies AS uc
				ON
					uc.user_id = u.id

			LEFT JOIN indicator_companies AS c
				ON
					c.id = uc.company_id

			LEFT JOIN
				admin_roles AS roles ON
					roles.id = ur.role_id

			WHERE 	u.username = '$username'
			AND u.is_deleted = 0
			AND u.is_active > 0

			GROUP BY u.id

			LIMIT 1
		";

		return $this->db->query($sql)->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	GET ROLES
----------------------------------------------------------------------*/
	public function get_roles($user_id)
	{
		return $this->db->query("

			SELECT
				*

			FROM
				`admin_users_roles`

			WHERE
				`user_id` = $user_id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL ROLES
----------------------------------------------------------------------*/
	public function get_all_roles()
	{
		return $this->db->query("

			SELECT
				*

			FROM
				`admin_roles`


		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
----------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT
				u.id,
				CONCAT(u.first_name, ' ', u.last_name) AS name,
				u.username,
				u.email,
				IF(uc.company_id = 0, 'Todas', GROUP_CONCAT(c.name SEPARATOR ',')) AS companies,
				r.name AS rol,
				IF(u.is_active=1, 'Activo', 'Desactivado') AS state

			FROM
				`admin_users` AS u
			INNER JOIN admin_users_roles AS ur
				ON
					ur.user_id = u.id

			INNER JOIN admin_roles AS r
				ON
					r.id = ur.role_id

			LEFT JOIN indicator_users_companies AS uc
				ON
					uc.user_id = u.id

			LEFT JOIN indicator_companies AS c
				ON
					c.id = uc.company_id

			WHERE u.id !=1
			GROUP BY u.id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY ID
----------------------------------------------------------------------*/
	public function get_by_id($user_id)
	{
		$sql = "

			SELECT
				u.*, ur.role_id

			FROM
				`admin_users` AS u
			INNER JOIN admin_users_roles AS ur
				ON
					ur.user_id = u.id

			INNER JOIN admin_roles AS r
				ON
					r.id = ur.role_id

			LEFT JOIN indicator_users_companies AS uc
				ON
					uc.user_id = u.id

			LEFT JOIN indicator_companies AS c
				ON
					c.id = uc.company_id

			WHERE 	u.id = $user_id

			GROUP BY u.id

			LIMIT 1
		";

		return $this->db->query($sql)->fetchAll()[0];
	}


/*----------------------------------------------------------------------
	GET USERS BY COMPANY
----------------------------------------------------------------------*/
	public function get_users_by_company($company_id)
	{
		$sql = "

			SELECT
				u.*
			FROM
				`admin_users` AS u

			INNER JOIN admin_users_roles AS ur
				ON ur.user_id = u.id

			INNER JOIN indicator_users_companies AS iuc
				ON iuc.user_id = u.id

			WHERE ur.role_id = 4
				AND iuc.company_id = $company_id

		";

		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET PRIVILEGES
 ---------------------------------------------------------------------*/
	public function get_privileges($user_id)
	{
		return $this->db->query("
(
			SELECT
				ar.prefix,
				ar.controller,
				ar.method

			FROM
				`admin_users_roles` AS ur

			INNER JOIN
				admin_roles_routes AS rr ON rr.role_id = ur.role_id

			INNER JOIN
				admin_routes AS ar ON ar.id = rr.route_id

			WHERE
				ur.`user_id` = '{$user_id}'
				AND ur.is_active = 1
				AND rr.is_active = 1
				AND ar.is_active = 1
			)
			UNION
			(
			SELECT
				ar.prefix,
				ar.controller,
				ar.method

			FROM
				`admin_routes` AS ar

			WHERE
				ar.is_active = 1
				AND
				(
					ar.is_public = 1
					OR ar.is_for_all_users = 1
				)
)

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	CHANGE PASSWORD
 ---------------------------------------------------------------------*/
	public function change_password($user_id, $password)
	{
		return $this->db->query("

			UPDATE
				admin_users

			SET
				password = sha1('{$password}')

			WHERE
				id = '{$user_id}'

		");
	}

/*----------------------------------------------------------------------
	CREATE
	* Tengo que revisarlo pra que se cree en la tabla ADMIN_USERS
 ---------------------------------------------------------------------*/
	public function create()
	{
		$password = sha1($_POST['password']);

		$query = $this->db->query("

			INSERT
			INTO		admin_users (`username`, `first_name`, `last_name`, `email`, `password`, `created_at`)
			VALUES		('{$_POST['username']}', '{$_POST['first_name']}', '{$_POST['last_name']}', '{$_POST['email']}', '$password', now())
		");

		$id = $this->db->lastInsertId();

		$sql = "

			INSERT INTO `admin_users_roles` (`user_id`, `role_id`, `is_active`)
			VALUES ('$id', '{$_POST['role_id']}', '1');

		";

		$query = $this->db->exec($sql);

		foreach ($_POST['companies'] as $company) {
			$query = $this->db->exec("

				INSERT INTO `indicator_users_companies` (`user_id`, `company_id`)
				VALUES ('$id', '$company');

			");
		}

		return TRUE;
	}


/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		$this->db->query("

			UPDATE		admin_users
			SET			`username` = '{$params['username']}',
						`first_name` = '{$params['first_name']}',
						`last_name` = '{$params['last_name']}',
						`email` = '{$params['email']}',
						`password` = '{$params['password']}'
			WHERE		id = '$id'

		");

		$this->db->query("

			DELETE FROM `indicator_users_companies`
			WHERE (`user_id` = '$id');

		");

		foreach ($params['companies'] as $company) {
			$query = $this->db->exec("

				INSERT INTO `indicator_users_companies` (`user_id`, `company_id`)
				VALUES ('$id', '$company');

			");
		}

		return TRUE;
	}


}
