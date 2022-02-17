<?php

namespace indicator_type_processes;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT		tp.id,
						tp.name
			FROM		indicator_type_processes AS tp
			ORDER BY	tp.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		return $this->db->query("

			SELECT		tp.id,
						tp.name
			FROM		indicator_type_processes AS tp
			WHERE		tp.id = '$id'
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
			INTO		indicator_type_processes (`name`)
			VALUES		('{$params['name']}')

		");
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		return $this->db->query("

			UPDATE		indicator_type_processes
			SET			`name` = '{$params['name']}'
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
			FROM		indicator_type_processes
			WHERE		id = '$id'

		");
	}
}