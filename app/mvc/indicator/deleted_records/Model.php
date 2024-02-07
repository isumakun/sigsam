<?php

namespace indicator_deleted_records;

Class Model extends \ModelBase {


	/*------------------------------------------------------------------------------
		GET ALL
	------------------------------------------------------------------------------*/
	public function get_all(){
		$sql = "

				SELECT
				i.id,
				i.name,
				i.formula,
				indg.upper_limit,
				indg.lower_limit,
				i.type_id,
				indg.goal,
				i.category_id,
				i.frequency_id,
				i.process_id,
				f.name AS 'frequency',
				t.name AS 'type',
				GROUP_CONCAT(DISTINCT c.id SEPARATOR ', ') AS 'charge_id',
				GROUP_CONCAT(
					DISTINCT c.job_position SEPARATOR ','
				) AS 'job_position',
				c.user_id AS 'chager',
				p.name AS 'process',
				p.company_id,
				tp.name AS 'type_process',
				i.unit
			FROM
				indicator_indicators AS i
			LEFT JOIN(
				SELECT
					igg.indicator_id,
					igg.goal,
					igg.upper_limit,
					igg.lower_limit
				FROM
					indicator_goals AS igg
				WHERE
					igg.visibility = 1
				GROUP BY
					igg.indicator_id
				ORDER BY
					igg.indicator_id
				DESC
			) indg
			ON
				indg.indicator_id = i.id
			LEFT JOIN indicator_user_indicator AS ii
			ON
				ii.indicator_id = i.id
			LEFT JOIN indicator_charges AS c
			ON
				ii.user_id = c.id
			LEFT JOIN indicator_types AS t
			ON
				t.id = i.type_id
			
			LEFT JOIN indicator_processes AS p
			ON
				p.id = i.process_id
			LEFT JOIN indicator_type_processes AS tp
			ON
				tp.id = p.type_process_id
			INNER JOIN indicator_frequencies AS f
			ON
				f.id = i.frequency_id
			WHERE
				p.company_id = {$_SESSION['user']['company_id']} AND i.visibility = 0
			GROUP BY
				i.id
			ORDER BY
				i.id ASC
		   
		";
				
		return $this->db->query($sql)->fetchAll();
	}


}