<?php

namespace tbs_notifications;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_users()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		$sql = "
			SELECT *
			FROM `tbs_notifications`
			WHERE for_users = 1
			ORDER BY id DESC
			LIMIT 32
		";
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all_operators()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		$sql = "
			SELECT *
			FROM `tbs_notifications`
			WHERE for_operators = 1
			ORDER BY id DESC
			LIMIT 64
		";

		return $this->db->query($sql)->fetchAll();
	}


/*----------------------------------------------------------------------
	GET PENDING
 ---------------------------------------------------------------------*/
	public function get_pending_operators()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		$sql = "

			SELECT *
			FROM `tbs_notifications`
			WHERE for_operators = 1
			AND was_readed = 0
			ORDER BY id DESC
		";
		
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	get_last_3
 ---------------------------------------------------------------------*/
	public function get_last_10()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		if (has_role(3)) {
			$sql = "

				SELECT *
				FROM `tbs_notifications`
				WHERE for_users = 1
				ORDER BY id DESC
				LIMIT 10
			";
		}elseif (has_role(4)) {
			$sql = "

				SELECT *
				FROM `tbs_notifications`
				WHERE for_operators = 1
				ORDER BY id DESC
				LIMIT 10
			";
		}
		
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	GET PENDING
 ---------------------------------------------------------------------*/
	public function get_pending_users()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		$sql = "

			SELECT *
			FROM `tbs_notifications`
			WHERE for_users = 1
			AND was_readed = 0
			ORDER BY id DESC
		";
		
		return $this->db->query($sql)->fetchAll();
	}


/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($icon, $description, $users=0)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		if ($users==0) {
			$sql = "

			INSERT INTO `tbs_notifications` (`description`, `icon`, `for_operators`, `created_at`)
			VALUES ('$description', '$icon', 1, now());

			";
		}else{
			$sql = "

			INSERT INTO `tbs_notifications` (`description`, `icon`, `for_users`, `created_at`)
			VALUES ('$description', '$icon', 1, now());

			";
		}

		$this->db->query($sql);

		return TRUE;
	}

/*----------------------------------------------------------------------
	READED
 ---------------------------------------------------------------------*/
	public function readed($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_notifications` 
			SET
				`was_readed` = '1',
				`readed_at` = now()
			WHERE 
				`id` = '$id'

		";
		
		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	SENDED
 ---------------------------------------------------------------------*/
	public function sent($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_notifications` 
			SET
				`was_sent` = '1'
			WHERE 
				`id` = '$id'

		";
		
		return $this->db->query($sql);
	}
}
