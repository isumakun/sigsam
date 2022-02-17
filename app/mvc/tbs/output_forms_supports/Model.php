<?php

namespace tbs_output_forms_supports;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			INSERT INTO
				`tbs_output_forms_supports` (
					`output_form_id`, 
					`details`,
					`file_extension`,
					`output_form_support_type_id`, 
					`created_at`
					)

			VALUES (
				{$params['output_form_id']},
				'{$params['details']}',
				'{$params['file_extension']}',
				{$params['output_form_support_type_id']},
				'{$params['created_at']}'
			);

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		$this->db->query($sql);
		return  $this->db->lastInsertId();
	}

/*----------------------------------------------------------------------
	EDIT
 ---------------------------------------------------------------------*/
	public function edit($params)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			UPDATE 
				`tbs_output_forms_supports` 
			SET
				`output_form_id` = '{$params['output_form_id']}',
				`details` = '{$params['details']}',
				`file_extension` = '{$params['file_extension']}',
				`output_form_support_type_id` = '{$params['output_form_support_type_id']}',
				`created_at` = '{$params['created_at']}'
			WHERE `id` = '{$params['id']}';

		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "
			DELETE FROM 
				`tbs_output_forms_supports`
			WHERE 
				`id` = $id 
			LIMIT 1;
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/

		return $this->db->query($sql);
	}

/*----------------------------------------------------------------------
	GET BY FORM ID
 ---------------------------------------------------------------------*/
	public function get_by_form_id($output_form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				ifs.*,
				ifst.name AS support_type,
				ifs.id AS supp_id
				
			FROM
				`tbs_output_forms_supports` AS ifs

			INNER JOIN
				tbs3.`tbs_output_forms_supports_types` AS ifst
					ON
						ifst.id = ifs.output_form_support_type_id

			WHERE
				`output_form_id` = $output_form_id

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	GET BY ID
 ---------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT
				ifs.*,
				ifst.name AS support_type
				
			FROM
				`tbs_output_forms_supports` AS ifs

			INNER JOIN
				tbs3.`tbs_output_forms_supports_types` AS ifst
					ON
						ifst.id = ifs.output_form_support_type_id

			WHERE
				ifs.id = $id

			LIMIT 1

		")->fetchAll()[0];
	}


/*----------------------------------------------------------------------
	GET BY DETAIL
 ---------------------------------------------------------------------*/
	public function get_by_detail($detail)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");
		
		return $this->db->query("

			SELECT
				ifs.*, ifs.output_form_id AS form_id, fs.name AS state
				
			FROM
				`tbs_output_forms_supports` AS ifs

			INNER JOIN
				tbs_output_forms AS op
				ON
					op.id = ifs.output_form_id

			INNER JOIN
				tbs3.tbs_forms_states AS fs
				ON
					op.form_state_id = fs.id

			WHERE
				ifs.details LIKE '%$detail%'

		")->fetchAll();
	}
}
