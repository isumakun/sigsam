<?php

namespace indicator_processes;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all(){
		return $this->db->query("
			SELECT		p.id,
						p.name,
						p.type_process_id,
						p.company_id,
						tp.name AS 'type_process'
			FROM		indicator_processes AS p
			LEFT JOIN	indicator_type_processes AS tp
						ON tp.id = p.type_process_id
			INNER JOIN	indicator_companies AS cs
						ON cs.id = p.company_id
		    WHERE p.company_id = {$_SESSION['user']['company_id']}
			AND p.is_deleted = 0
			ORDER BY	p.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		return $this->db->query("

			SELECT		p.id,
						p.name,
						p.type_process_id,
						tp.name AS 'type_process'
			FROM		indicator_processes AS p
			LEFT JOIN	indicator_type_processes AS tp
						ON tp.id = p.type_process_id
			WHERE		p.id = '$id'
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
			INTO		indicator_processes (`name`, `type_process_id`, `company_id`)
			VALUES		('{$params['name']}', '{$params['type_process_id']}', '{$_SESSION['user']['company_id']}')

		");
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		return $this->db->query("

			UPDATE		indicator_processes
			SET			`name` = '{$params['name']}',
						`type_process_id` = '{$params['type_process_id']}'
			WHERE		id = '$id'

		");
	}

/*------------------------------------------------------------------------------
	DELETE BY ID
------------------------------------------------------------------------------*/
	public function delete_by_id($id)
	{
		return $this->db->query("

			UPDATE `indicator_processes`
			SET `is_deleted` = '1'		
			WHERE		id = '$id'

		");
	}
}