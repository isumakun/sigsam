<?php

namespace indicator_companies;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		return $this->db->query("

			SELECT		c.id,
						c.name
			FROM		indicator_companies AS c
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
						c.name
			FROM		indicator_companies AS c
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
			INTO		indicator_companies (`name`)
			VALUES		('{$params['name']}')

		");
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{
		return $this->db->query("

			UPDATE		indicator_companies
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
			FROM		indicator_companies
			WHERE		id = '$id'

		");
	}
}