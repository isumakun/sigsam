<?php

namespace indicator_values;

Class Model extends \ModelBase {

/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_all()
	{
		$sql = "

			SELECT		v.id,
						v.indicator_id,
						i.name AS 'indicator',
						i.unit,
						v.value,
						v.created_by,
						u.username AS 'created_by',
						v.created_at,
						v.support,
						p.frequency_id
			FROM		indicator_informs AS v
			INNER JOIN	indicator_indicators AS i
						ON i.id = v.indicator_id
			INNER JOIN	indicator_periods AS p
						ON p.id = v.period_id
			INNER JOIN	admin_users AS u
						ON u.id = v.created_by
			AND i.visibility = 1
			ORDER BY	v.created_at DESC

		";
		return $this->db->query($sql)->fetchAll();
	}
/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
public function get_all_edit($id)
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
					v.age_id,
					v.period_id,
					v.value,
					v.support,
					v.support1,
					v.inform,
					v.inform_type_id,
					v.inform_class_id,
					c.user_id AS 'chager',
					p.name AS 'process',
					p.company_id,
					tp.name AS 'type_process',
					i.unit
		FROM		indicator_informs AS v
		INNER JOIN  indicator_indicators i
					ON v.indicator_id = i.id
		LEFT JOIN   indicator_user_indicator AS ii 
					ON ii.indicator_id = i.id 
		LEFT JOIN   indicator_charges AS c
					ON ii.user_id = c.id
		LEFT JOIN	indicator_types AS t
					ON t.id = i.type_id
		INNER JOIN	indicator_processes AS p
					ON p.id = i.process_id
		LEFT JOIN	indicator_type_processes AS tp
					ON tp.id = p.type_process_id
		INNER JOIN	indicator_frequencies AS f
					ON f.id = i.frequency_id
		
			WHERE   p.company_id = ".$_SESSION['user']['company_id']." AND v.id =$id
		AND i.visibility = 1
		ORDER BY	i.id ASC
		LIMIT 1
	   
	";
	
	return $this->db->query($sql)->fetchAll()[0];
}
/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
public function get_age_id($id)
{
	return $this->db->query("

		SELECT		a.name, a.id
		FROM		indicator_informs AS v
		INNER JOIN	indicator_ages a
		ON			a.id = v. age_id
		WHERE		v.indicator_id = '$id'
		GROUP BY a.id
	")->fetchAll();
}
/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
public function get_test($ind_id, $year)
{

	$sql = "
		SELECT
		    v.id,
		    v.indicator_id,
		    v.inform,
		    v.age_id,
		    ia.name,
		    i.name AS 'indicator',
		    v.value,
		    p.name AS 'period',
		    v.created_by,
		    u.username AS 'created_by',
		    v.created_at,
		    v.support,
		    v.support1,
		    i.frequency_id
		FROM
		    indicator_informs AS v
		INNER JOIN indicator_indicators AS i
		ON
		    i.id = v.indicator_id
		    LEFT JOIN indicator_ages AS ia
		ON
		    v.age_id = ia.id
		LEFT JOIN indicator_periods AS p
		ON
		    p.id = v.period_id
		INNER JOIN admin_users AS u
		ON
		    u.id = v.created_by

		WHERE
		    IFNULL(
		        ia.name = COALESCE(
		            (
		            SELECT
		                iaa.name
		            FROM
		                indicator_informs AS ii
		            INNER JOIN indicator_ages AS iaa
		            ON
		                ii.age_id = iaa.id
		            WHERE
		                iaa.name = YEAR('$year')
		            AND  ii.indicator_id = $ind_id
		            LIMIT 1
		        ),
		        (
		        SELECT
		            iaa.name
		        FROM
		            indicator_informs AS ii
		        INNER JOIN indicator_ages AS iaa
		        ON
		            ii.age_id = iaa.id
		        WHERE
		            iaa.name = YEAR(DATE_SUB('$year', INTERVAL 1 YEAR))
		            AND  ii.indicator_id = $ind_id
		        LIMIT 1
		    )
		        ),
		        ia.name
		    ) AND v.indicator_id = $ind_id AND i.visibility = 1
		ORDER BY
		    p.id ASC";

	return $this->db->query($sql)->fetchAll();
}
/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_filter($id, $age_id){
		return $this->db->query("

			SELECT		v.id,
						v.indicator_id,
						v.analysis,
						v.analysis_end,
						i.name AS 'indicator',
						v.value,
						p.name AS 'period',
						v.created_by,
						u.username AS 'created_by',
						v.created_at,
						v.support,
						i.frequency_id
			FROM		indicator_informs AS v
			INNER JOIN	indicator_indicators AS i
						ON i.id = v.indicator_id
			INNER JOIN	indicator_periods AS p
						ON p.id = v.period_id
						INNER JOIN	indicator_ages AS a
						ON a.id = v.age_id
			INNER JOIN	admin_users AS u
						ON u.id = v.created_by
			WHERE      v.indicator_id = $id AND v.age_id = $age_id
			AND i.visibility = 1
			ORDER BY	v.id ASC

		")->fetchAll();
	}
/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_graph($ind_id, $year){
		$sql = "
		SELECT
			GROUP_CONCAT(v.value ORDER BY p.id) AS 'value',
			GROUP_CONCAT(CONCAT('',ia.name,'') ORDER BY ia.id ) AS 'period'
			FROM
		    indicator_informs AS v
		INNER JOIN indicator_indicators AS i
		ON
		    i.id = v.indicator_id
		    LEFT JOIN indicator_ages AS ia
		ON
		    v.age_id = ia.id
		LEFT JOIN indicator_periods AS p
		ON
		    p.id = v.period_id
		INNER JOIN admin_users AS u
		ON
		    u.id = v.created_by

		WHERE
		    IFNULL(
		        ia.name = COALESCE(
		            (
		            SELECT
		                iaa.name
		            FROM
		                indicator_informs AS ii
		            INNER JOIN indicator_ages AS iaa
		            ON
		                ii.age_id = iaa.id
		            WHERE
		                iaa.name = YEAR('$year')
		                AND  ii.indicator_id = $ind_id
		            LIMIT 1
		        ),
		        (
		        SELECT
		            iaa.name
		        FROM
		            indicator_informs AS ii
		        INNER JOIN indicator_ages AS iaa
		        ON
		            ii.age_id = iaa.id
		        WHERE
		            iaa.name = YEAR(DATE_SUB('$year', INTERVAL 1 YEAR))
		            AND  ii.indicator_id = $ind_id
		        LIMIT 1
		    )
		        ),
		        ia.name
		    ) AND v.indicator_id = $ind_id AND i.visibility = 1
		    ORDER BY p.name,v.value
			";


		return $this->db->query($sql)->fetchAll();
	}
/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
public function get_graph_filter($ind_id, $year)
{
	return $this->db->query("

		SELECT
			GROUP_CONCAT(v.value ORDER BY p.id) AS 'value',
			GROUP_CONCAT(CONCAT('',p.name,'') ORDER BY p.id ) AS 'period'
			FROM
		    indicator_informs AS v
		INNER JOIN indicator_indicators AS i
		ON
		    i.id = v.indicator_id
		    LEFT JOIN indicator_ages AS ia
		ON
		    v.age_id = ia.id
		LEFT JOIN indicator_periods AS p
		ON
		    p.id = v.period_id
		INNER JOIN admin_users AS u
		ON
		    u.id = v.created_by

		WHERE
		    IFNULL(
		        ia.name = COALESCE(
		            (
		            SELECT
		                iaa.name
		            FROM
		                indicator_informs AS ii
		            INNER JOIN indicator_ages AS iaa
		            ON
		                ii.age_id = iaa.id
		            WHERE
		                iaa.name = YEAR('$year')
		                AND  ii.indicator_id = $ind_id
		            LIMIT 1
		        ),
		        (
		        SELECT
		            iaa.name
		        FROM
		            indicator_informs AS ii
		        INNER JOIN indicator_ages AS iaa
		        ON
		            ii.age_id = iaa.id
		        WHERE
		            iaa.name = YEAR(DATE_SUB('$year', INTERVAL 1 YEAR))
		            AND  ii.indicator_id = $ind_id
		        LIMIT 1
		    )
		        ),
		        ia.name
		    ) AND v.indicator_id = $ind_id AND i.visibility = 1
		    ORDER BY p.name,v.value
			

	")->fetchAll();
}
/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
public function get_analysis($variable)
{
	return $this->db->query("

		SELECT	
					i.name AS 'ind',
					v.analysis_end
		FROM		indicator_informs AS v
		INNER JOIN	indicator_indicators AS i
					ON i.id = v.indicator_id
		INNER JOIN	indicator_periods AS p
					ON p.id = v.period_id
		INNER JOIN	admin_users AS u
					ON u.id = v.created_by
		WHERE      v.indicator_id = $variable AND v.analysis_end != ''
		AND i.visibility = 1
		ORDER BY	v.id ASC
		LIMIT		1

	")->fetchAll();
}
/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
	public function get_value_period()
	{
		return $this->db->query("

			SELECT		v.id,
						v.indicator_id,
						i.name AS 'indicator',
						v.value,
						v.inform,
						a.name AS age,
						p.name AS period,
						p.frequency_id
			FROM		indicator_informs AS v
			INNER JOIN	indicator_indicators AS i
						ON i.id = v.indicator_id
			INNER JOIN	indicator_periods AS p
						ON p.id = v.period_id
			LEFT JOIN	indicator_ages AS a
						ON a.id = v.age_id
			AND i.visibility = 1
			ORDER BY	p.id ASC

		")->fetchAll();
	}
/*------------------------------------------------------------------------------
	get_value_period by id
------------------------------------------------------------------------------*/
	public function get_value_period_by_id($id)
	{
		$sql = "

			SELECT		v.id,
						v.indicator_id,
						i.name AS 'indicator',
						v.value,
						v.inform,
						a.name AS age,
						p.name AS period,
						p.frequency_id
			FROM		indicator_informs AS v
			INNER JOIN	indicator_indicators AS i
						ON i.id = v.indicator_id
			INNER JOIN	indicator_periods AS p
						ON p.id = v.period_id
			LEFT JOIN	indicator_ages AS a
						ON a.id = v.age_id
			WHERE 		v.indicator_id = $id
			AND i.visibility = 1
			ORDER BY	p.id ASC

		";
		
		return $this->db->query($sql)->fetchAll();
	}

/*------------------------------------------------------------------------------
	get_inform_class
------------------------------------------------------------------------------*/

	public function get_inform_class(){

		$sql = "
			SELECT  ic.id,
					ic.name,
					ic.description
			FROM 	indicator_inform_class as ic
		";
		return $this->db->query($sql)->fetchAll();
	}
/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
public function get_value_result($indicator_id, $age)
{
$stamentc="";
if($age != ""){
	if ($stamentc=="") {
		$stamentc="a.name = '$age'";
	}else{
		$stamentc .=" AND a.name = '$age'";
	}
}
	$sql ="

		SELECT		v.id,
					v.indicator_id,
					v.period_id,
					i.name AS 'indicator',
					v.value,
					p.name AS period,
					p.frequency_id
		FROM		indicator_informs AS v
		INNER JOIN	indicator_indicators AS i
					ON i.id = v.indicator_id
		INNER JOIN	indicator_periods AS p
					ON p.id = v.period_id
		LEFT JOIN	indicator_ages AS a
					ON a.id = v.age_id
		WHERE      v.indicator_id = $indicator_id AND ($stamentc OR p.name=$age)
		AND i.visibility = 1
		ORDER BY	v.id ASC

	";

	return $this->db->query($sql)->fetchAll();
}
/*------------------------------------------------------------------------------
	GET PERIOD
------------------------------------------------------------------------------*/
	public function get_period()
	{
		return $this->db->query("

			SELECT		p.id,
						p.name,
						p.frequency_id,
						i.id AS indicator_id
			FROM		indicator_periods AS p
			INNER JOIN  indicator_frequencies AS f
					ON  f.id = p.frequency_id
			INNER JOIN  indicator_indicators i
			    USING (frequency_id)
			    WHERE i.visibility = 1
			ORDER BY	p.id ASC

		")->fetchAll();
	}
/*------------------------------------------------------------------------------
	get_period_by_indicator
------------------------------------------------------------------------------*/
	public function get_period_by_indicator($id)
	{
		return $this->db->query("

			SELECT		p.id,
						p.name,
						p.frequency_id,
						i.id AS indicator_id
			FROM		indicator_periods AS p
			INNER JOIN  indicator_frequencies AS f
					ON  f.id = p.frequency_id
			INNER JOIN  indicator_indicators i
			    USING (frequency_id)
			WHERE i.id = $id
			AND i.visibility = 1
			ORDER BY	p.id ASC

		")->fetchAll();
	}
/*------------------------------------------------------------------------------
	GET AGE
------------------------------------------------------------------------------*/
	public function get_age()
	{
		return $this->db->query("

			SELECT		a.id,
						a.name AS age
			FROM		indicator_ages AS a
			ORDER BY	a.id ASC

		")->fetchAll();
	}

/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_id($id)
	{
		return $this->db->query("

			SELECT		v.id,
						v.indicator_id,
						i.name AS 'indicator',
						v.value,
						v.created_by,
						u.first_name,
						u.last_name,
						u.username AS 'created_by',
						v.created_at,
						v.support
			FROM		indicator_informs AS v
			INNER JOIN	indicator_indicators AS i
						ON i.id = v.indicator_id
			INNER JOIN	admin_users AS u
						ON u.id = v.created_by
			WHERE		v.id = '$id'
			AND i.visibility = 1
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	
------------------------------------------------------------------------------*/

	public function get_supports_inform_by_id($inform_id){
		$sql ="
			SELECT
						v.support,
						v.support1
			FROM		indicator_informs AS v
			INNER JOIN	indicator_indicators AS i
						ON i.id = v.indicator_id
			WHERE		v.id = $inform_id
			AND i.visibility = 1
			LIMIT		1
		";
		return $this->db->query($sql)->fetchAll()[0];

	}
/*------------------------------------------------------------------------------
	GET BY ID
------------------------------------------------------------------------------*/
	public function get_by_frequency($id)
	{
		return $this->db->query("

			SELECT	    i.frequency_id
			FROM		indicator_indicators AS i
			WHERE		i.id = '$id'
			AND i.visibility = 1
			LIMIT		1

		")->fetchAll()[0];
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create($params)
	{
		// $params['value'] = str_replace(',','.',$params['value']);
	if ($params['age_id']) {
		$sql = "

			INSERT
			INTO		indicator_informs (`indicator_id`,`period_id`,`age_id`,`inform`,`value`, `created_by`,`support1`,`created_at`,`inform_type_id`, `inform_class_id`, `support`)
			VALUES		('{$params['indicator_id']}'
						 ,COALESCE(NULLIF('{$params['period_id']}', ''), NULL)
						 ,'{$params['age_id']}'
						 ,'{$params['inform']}'
						 ,'{$params['value']}'
						 ,'{$params['created_by']}'
						 ,'{$params['support1']}'
						 , now()
						 ,'{$params['inform_type']}'
						 ,'{$params['inform_class']}'
						 ,'{$params['support']}')

		";
	} else{ 
		$sql = "

			INSERT
			INTO		indicator_informs (`indicator_id`,`period_id`,`inform`,`value`, `created_by`,`support1`,`created_at`,`inform_type_id`, `inform_class_id`, `support`)
			VALUES		('{$params['indicator_id']}'
						 ,'{$params['period_id']}'
						 ,'{$params['inform']}'
						 ,'{$params['value']}'
						 ,'{$params['created_by']}'
						 ,'{$params['support1']}'
						 , now()
						 ,'{$params['inform_type']}'
						 ,'{$params['inform_class']}'
						 ,'{$params['support']}')

		";
	} 
		$this->db->query($sql);
		return $this->db->lastInsertId();
	}
/*------------------------------------------------------------------------------
	create_final_report
------------------------------------------------------------------------------*/
	public function create_final_report($params)
	{
		// $params['value'] = str_replace(',','.',$params['value']);
	if ($params['age_id']) {
		$sql = "

			INSERT
			INTO		indicator_informs (`indicator_id`,`period_id`,`age_id`,`inform`,`value`, `created_by`,`support1`,`created_at`,`inform_type_id`, `inform_class_id`, `support`)
			VALUES		('{$params['indicator_id']}'
						 ,'{$params['period_id']}'
						 ,'{$params['age_id']}'
						 ,'{$params['final_inform']}'
						 ,'{$params['value']}'
						 ,'{$params['created_by']}'
						 ,'{$params['support1']}'
						 , now()
						 ,'{$params['inform_type']}'
						 , 3
						 ,'{$params['support']}')

		";
	} else{ 
		$sql = "

			INSERT
			INTO		indicator_informs (`indicator_id`,`period_id`,`inform`,`value`, `created_by`,`support1`,`created_at`,`inform_type_id`, `inform_class_id`, `support`)
			VALUES		('{$params['indicator_id']}'
						 ,'{$params['period_id']}'
						 ,'{$params['final_inform']}'
						 ,'{$params['value']}'
						 ,'{$params['created_by']}'
						 ,'{$params['support1']}'
						 , now()
						 ,'{$params['inform_type']}'
						 , 3
						 ,'{$params['support']}')

		";
	} 
	

		
		return $this->db->query($sql);
	}
/*------------------------------------------------------------------------------
	GET ALL
------------------------------------------------------------------------------*/
public function get_name($variable)
{
	return $this->db->query("

		SELECT	
					i.name 'ind',
					i.unit,
				    i.upper_limit,
				    i.lower_limit,
				    i.goal
		FROM		indicator_indicators AS i
		WHERE      i.id = $variable 
		AND i.visibility = 1
		LIMIT		1

	")->fetchAll();
}
/*------------------------------------------------------------------------------
	UPDATE BY ID
------------------------------------------------------------------------------*/
public function update_by_id($id, $params)
{
	// $params['value'] = str_replace(',','.',$params['value']);
	// $params['analysis'] = str_replace(',','.',$params['analysis']);
	// $params['analysis_end'] = str_replace(',','.',$params['analysis_end']);

	$sql = "

		UPDATE		indicator_informs
		SET			`value` =  COALESCE(NULLIF('{$params['value']}', ''), `value`),
					`period_id` = '{$params['period_id']}',
					`inform` =  COALESCE(NULLIF('{$params['inform']}', ''), `inform`),
					`support` = COALESCE(NULLIF('{$params['support']}', ''), `support`),
					`support1` = COALESCE(NULLIF('{$params['support1']}', ''), `support1`),
					`inform_type_id` = '{$params['inform_type']}',
					`inform_class_id` = COALESCE(NULLIF('{$params['inform_class']}', ''), `inform_class_id`),
					`age_id` = COALESCE(NULLIF('{$params['age_id']}', ''), null)
		WHERE		id = '$id'

	";

	return $this->db->query($sql);
}

/*------------------------------------------------------------------------------
	DELETE BY ID
------------------------------------------------------------------------------*/
	public function delete_by_id($id){
		return $this->db->query("

			DELETE
			FROM		indicator_informs
			WHERE		id = '$id'

		");
	}
/*------------------------------------------------------------------------------
	obtain_row
------------------------------------------------------------------------------*/
	public function obtain_row($id){
		$sql = "
			SELECT ifm.id,
					ifm.indicator_id,
					ifm.period_id,
					ifm.value,
					ifm.inform,
					ifm.created_by,
					ifm.created_at,
					ifm.support,
					ifm.support1,
					ifm.age_id,
					ifm.inform_type_id,
					ifm.inform_class_id
			FROM 	indicator_informs AS ifm
			WHERE ifm.id = $id
		";

		return $this->db->query($sql)->fetchAll();

	}
}