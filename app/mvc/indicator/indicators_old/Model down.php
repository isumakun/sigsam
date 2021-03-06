<?php

namespace indicator_indicators;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
public function get_by_id($id)
{
	$sql = "

		SELECT		i.id,
					i.name,
					i.formula,
					i.upper_limit,
					i.lower_limit,
					i.type_id,
					i.goal,
					i.category_id,
					i.frequency_id,
					i.process_id,
					f.name AS 'frequency',
					t.name AS 'type',
					GROUP_CONCAT(c.id SEPARATOR ', ') AS 'charge_id',
    				GROUP_CONCAT(c.job_position SEPARATOR ',') AS 'job_position',
					c.user_id AS 'chager',
					p.name AS 'process',
					p.company_id,
					tp.name AS 'type_process',
					i.unit
		FROM		indicator_indicators AS i
		LEFT JOIN  indicator_user_indicator AS ii 
					ON ii.indicator_id = i.id 
		LEFT JOIN  indicator_charges AS c
					ON ii.user_id = c.id
		LEFT JOIN	indicator_types AS t
					ON t.id = i.type_id
		INNER JOIN	indicator_processes AS p
					ON p.id = i.process_id
		LEFT JOIN	indicator_type_processes AS tp
					ON tp.id = p.type_process_id
		INNER JOIN	indicator_frequencies AS f
					ON f.id = i.frequency_id
			WHERE   p.company_id = ".$_SESSION['user']['company_id']."
			AND i.id = $id
			AND i.visibility = 1
		GROUP BY i.id
		ORDER BY	i.id ASC
	   
	";

	return $this->db->query($sql)->fetchAll();
}

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
public function get_all()
{
	$sql = "

		SELECT		i.id,
					i.name,
					i.formula,
					i.upper_limit,
					i.lower_limit,
					i.type_id,
					i.goal,
					i.category_id,
					i.frequency_id,
					i.process_id,
					f.name AS 'frequency',
					t.name AS 'type',
					GROUP_CONCAT(c.id SEPARATOR ', ') AS 'charge_id',
    				GROUP_CONCAT(c.job_position SEPARATOR ',') AS 'job_position',
					c.user_id AS 'chager',
					p.name AS 'process',
					p.company_id,
					tp.name AS 'type_process',
					i.unit
		FROM		indicator_indicators AS i
		LEFT JOIN  indicator_user_indicator AS ii 
					ON ii.indicator_id = i.id 
		LEFT JOIN  indicator_charges AS c
					ON ii.user_id = c.id
		LEFT JOIN	indicator_types AS t
					ON t.id = i.type_id
		INNER JOIN	indicator_processes AS p
					ON p.id = i.process_id
		LEFT JOIN	indicator_type_processes AS tp
					ON tp.id = p.type_process_id
		INNER JOIN	indicator_frequencies AS f
					ON f.id = i.frequency_id
			WHERE   p.company_id = ".$_SESSION['user']['company_id']."
			AND i.visibility = 1
		GROUP BY i.id
		ORDER BY	i.id ASC
	   
	";
	
	return $this->db->query($sql)->fetchAll();
}


public function get_supports($id)
{
	return $this->db->query("

		SELECT		i.id,
					v.support,
					v.support1
		FROM		indicator_informs AS v
		INNER JOIN	indicator_indicators AS i
					ON i.id = v.indicator_id
		INNER JOIN	indicator_periods AS p
					ON p.id = v.period_id
		INNER JOIN	admin_users AS u
					ON u.id = v.created_by
		WHERE i.id = $id
		AND i.visibility = 1
		ORDER BY	v.id ASC

	")->fetchAll();
}
	public function get_name($id){
		$sql = "

			SELECT		i.name,
						i.unit
			FROM		indicator_indicators AS i
			WHERE i.id = $id
			AND i.visibility = 1
			LIMIT 1

		";
		
		return $this->db->query($sql)->fetchAll()[0];
	}
/*------------------------------------------------------------------------------
	GET CATEGORY
------------------------------------------------------------------------------*/
	public function get_category()
	{
		return $this->db->query("

			SELECT		c.id,
						c.name
			FROM		indicator_categories AS c
			ORDER BY	c.id DESC

		")->fetchAll();
	}
/*------------------------------------------------------------------------------
	get_search_category
------------------------------------------------------------------------------*/
public function get_search_category($category,$process,$indicator){
	
	$where_category= "";
	$where_process = "";
	$where_indicator = "";

	if($category != ""){
		$where_category= " AND c.name = '$category'";
	}
	if($process != ""){
		$where_process = " AND p.name = '$process'";
	}
	if($indicator != ""){
		$where_indicator = " AND i.name = '$indicator'";
	}
	$sql = "
		SELECT	i.id,
				i.name AS 'indicator',
				i.formula,
				i.upper_limit,
				i.lower_limit,
				i.type_id,
				i.goal,
				i.category_id,
				i.frequency_id,
				f.name AS 'frequency',
				t.name AS 'type',
				GROUP_CONCAT(ch.id SEPARATOR ', ') AS 'charge_id',
				GROUP_CONCAT(ch.job_position SEPARATOR ',') AS 'job_position',
				ch.user_id AS 'chager',
				p.name AS 'process',
				p.company_id,
				tp.name AS 'type_process',
				i.unit
		FROM		indicator_indicators AS i
		LEFT JOIN	indicator_types AS t		
		ON   		t.id = i.type_id
		LEFT JOIN  indicator_user_indicator AS ii 
					ON ii.indicator_id = i.id 
		LEFT JOIN  indicator_charges AS ch
					ON ii.user_id = ch.id
		INNER JOIN	indicator_processes AS p
		ON   		p.id = i.process_id
		LEFT JOIN	indicator_type_processes AS tp
		ON   		tp.id = p.type_process_id
		INNER JOIN	indicator_frequencies AS f
		ON   		f.id = i.frequency_id
		INNER JOIN	indicator_categories AS c
		ON   		c.id = i.category_id
		WHERE p.company_id = ".$_SESSION['user']['company_id']."
		AND i.visibility = 1
		$where_category
		$where_process
		$where_indicator
		GROUP BY i.id";

		
	return $this->db->query($sql)->fetchAll();
}
/*------------------------------------------------------------------------------
	GET FREQUENCY
------------------------------------------------------------------------------*/
	public function get_frequency()
	{
		return $this->db->query("

			SELECT		f.id,
						f.name
			FROM		indicator_frequencies AS f
			ORDER BY	f.id DESC

		")->fetchAll();
	}
/*------------------------------------------------------------------------------
	get_charges_user
------------------------------------------------------------------------------*/
	public function get_charges_user($indicator_id){

		$sql = "
		SELECT
		    ui.user_id
		FROM
		    `indicator_user_indicator` AS ui
		WHERE
		    ui.indicator_id = $indicator_id
		";

		return $this->db->query($sql)->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
// 	public function get_by_id($id)
// 	{
// 		return $this->db->query("

// 		SELECT		i.id,
// 		i.name,
// 		i.formula,
// 		i.upper_limit,
// 		i.lower_limit,
// 		i.type_id,
// 		i.goal,
// 		i.category_id,
// 		i.process_id,
// 		i.frequency_id,
// 		f.name AS 'frequency',
// 		t.name AS 'type',
// 		i.charge_id,
// 		c.job_position,
// 		c.user_id AS 'chager',
// 		p.name AS 'process',
// 		tp.name AS 'type_process',
// 		i.unit
// FROM		indicator_indicators AS i
// LEFT JOIN	indicator_types AS t
// 		ON t.id = i.type_id
// INNER JOIN	indicator_processes AS p
// 		ON p.id = i.process_id
// LEFT JOIN	indicator_type_processes AS tp
// 		ON tp.id = p.type_process_id
// INNER JOIN	indicator_charges AS c
// 		ON c.id = i.charge_id
// INNER JOIN	indicator_frequencies AS f
// 		ON f.id = i.frequency_id
// 			WHERE		i.id = '$id'
// 			LIMIT		1

// 		")->fetchAll()[0];
// 	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		if ($params['category_id']!=1) {
	
			$sql = "

			INSERT
			INTO		indicator_indicators (`name`, `formula`,`goal`, `upper_limit`, `lower_limit`, `type_id`, `process_id`, `frequency_id`, `unit`,`category_id`)
			VALUES		('{$params['name']}',
			             '{$params['formula']}',
			             '{$params['goal']}',
						 '{$params['upper_limit']}', 
						 '{$params['lower_limit']}', 
						 '{$params['type_id']}', 
						 '{$params['process_id']}',
						 '{$params['frequency_id']}',
						 '{$params['unit']}',
						 '{$params['category_id']}')

		";
		} else{
			$sql = "

			INSERT
			INTO		indicator_indicators (`name`, `formula`, `process_id`, `frequency_id`, `unit`,`category_id`)
			VALUES		('{$params['name']}',
			             '{$params['formula']}',
						 '{$params['process_id']}',
						 '{$params['frequency_id']}',
						 '{$params['unit']}',
						 '{$params['category_id']}')

		";
			
		}


		$this->db->query($sql);
		return $this->db->lastInsertId();
	}


/*------------------------------------------------------------------------------
	insert in charge of the indicators
------------------------------------------------------------------------------*/
	public function insert_in_charge_indicator($id,$charges){
		$values_charge = '';
		
		$temp =0;
		if(!empty($charges)){
			foreach ($charges as $key) {
				if($temp == 0){
					$values_rol .= 'VALUES ('.$id.', '.$key.')';
					$temp = 1;
				}else{
					$values_rol .= ', ('.$id.', '.$key.')';
				}
			}			
		}

		$sql = "

			INSERT IGNORE INTO 
				indicator_user_indicator (`indicator_id`, `user_id`) 
			$values_rol
		";

		return $this->db->query($sql);
	}
/*------------------------------------------------------------------------------
	delete_in_charge_indicator
------------------------------------------------------------------------------*/

	public function delete_in_charge_indicator($id, $charges){
		$sql = '';

		if(!empty($charges)){
			
					$sql .= "DELETE
				FROM
				    `indicator_user_indicator`
				WHERE
				    `indicator_user_indicator`.`indicator_id` = $id";
					
		}

		
		return $this->db->query($sql);
	}

/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
	public function update_by_id($id, $params)
	{	
		$sql = "

			UPDATE		indicator_indicators
			SET			`name` = '{$params['name']}',
						`formula` = '{$params['formula']}',
						`goal` = '{$params['goal']}',
						`upper_limit` = '{$params['upper_limit']}',
						`lower_limit` = '{$params['lower_limit']}',
						`type_id` = COALESCE(NULLIF('{$params['type_id']}', ''), null),
						`process_id` = COALESCE(NULLIF('{$params['process_id']}', ''), `process_id`),
						`frequency_id` = COALESCE(NULLIF('{$params['frequency_id']}', ''), `frequency_id`),
						`unit` = '{$params['unit']}'
			WHERE		id = '$id'

		";
		return $this->db->query($sql);
	}
/*------------------------------------------------------------------------------
	get_inform_class
------------------------------------------------------------------------------*/
	public function get_inform_class()
	{
		$sql = "
			SELECT
			    ic.id,
			    ic.name,
			    ic.description
			FROM
			    `indicator_inform_class` AS ic
		";
		return $this->db->query($sql)->fetchAll();
	}
/*------------------------------------------------------------------------------
	DELETE BY ID
------------------------------------------------------------------------------*/
	public function delete_by_id($id){
		return $this->db->query("

			DELETE
			FROM		indicator_indicators
			WHERE		id = '$id'

		");
	}

/*------------------------------------------------------------------------------
	turn_off_visibility = instead of deleting the indicator and all its registers, we change visibility to 0
------------------------------------------------------------------------------*/

	public function turn_off_visibility($id){
		$sql = "
			UPDATE
			    `indicator_indicators`
			SET
			    `visibility` = '0'
			WHERE
			    `indicator_indicators`.`id` = $id";

		return $this->db->query($sql);
	}


}