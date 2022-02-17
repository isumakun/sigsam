<?php

namespace tbs_services_concepts;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		return $this->db->query("

			SELECT		sc.id,
						sc.concept_id,
						c.name AS 'concept',
						sc.service_id,
						s.service_type AS 'service'
			FROM		tbs_services_concepts AS sc
			INNER JOIN	tbs_concepts AS c
						ON c.id = sc.concept_id
			INNER JOIN	tbs_services AS s
						ON s.id = sc.service_id
			ORDER BY	sc.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT		sc.id,
						sc.concept_id,
						c.name AS 'concept',
						sc.service_id,
						s.service_type AS 'service'
			FROM		tbs_services_concepts AS sc
			INNER JOIN	tbs_concepts AS c
						ON c.id = sc.concept_id
			INNER JOIN	tbs_services AS s
						ON s.id = sc.service_id
			WHERE		sc.id = '$id'
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	GET BY SERVICE ID
------------------------------------------------------------------------------*/
	public function get_by_service_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT		sc.id,
						sc.concept_id,
						c.name AS 'concept',
						sc.service_id,
						s.service_type AS 'service'
			FROM		tbs_services_concepts AS sc
			INNER JOIN	tbs_concepts AS c
						ON c.id = sc.concept_id
			INNER JOIN	tbs_services AS s
						ON s.id = sc.service_id
			WHERE		sc.service_id = '$id'

		";

		return $this->db->query($sql)->fetchAll();
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($concept, $service_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT
			INTO		tbs_services_concepts (`concept_id`, `service_id`)
			VALUES		('$concept', '$service_id')

		";

		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $concept, $service_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			UPDATE		tbs_services_concepts
			SET			`concept_id` = '$concept',
						`service_id` = '$service_id'
			WHERE		id = '$id'

		");
	}

/*------------------------------------------------------------------------------
	DELETE BY ID
------------------------------------------------------------------------------*/
	public function delete_by_service_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			DELETE
			FROM		tbs_services_concepts
			WHERE		service_id = '$id'

		");
	}
}