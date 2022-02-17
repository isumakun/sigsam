<?php

namespace tbs_nationalized_forms_products;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		return $this->db->query("

			SELECT *
			FROM `tbs_nationalized_forms_products`

		")->fetchAll();
	}

/*----------------------------------------------------------------------
	DELETE
 ---------------------------------------------------------------------*/
	public function delete($form_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "
			DELETE FROM tbs_nationalized_forms_products WHERE form_id = $form_id
		";

		/*echo '<pre>'.print_r($sql, TRUE).'</pre>';
		die();*/
		return $this->db->query($sql)->fetchAll();
	}

/*----------------------------------------------------------------------
	CREATE
 ---------------------------------------------------------------------*/
	public function create($output_form_id, $warehouse_id, $quantity)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

			$sql = "

				INSERT INTO
					`tbs_nationalized_forms_products`
					(
					`output_form_id`,
					`warehouse_id`,
					`quantity`,
					`created_at`,
					`created_by`
					)

				VALUES (
					$output_form_id,
					$warehouse_id,
					$quantity,
					now(),
					'{$_SESSION['user']['id']}'
				)

			";

			if($_SESSION['user']['company_id']=='900162578'){
				//echo '<pre>'.print_r($sql, TRUE).'</pre>';
				//die();
			}
		return $this->db->query($sql);
	}


/*----------------------------------------------------------------------
	GET BY PRODUCT ID
 ---------------------------------------------------------------------*/
	public function get_by_product_id($product_id)
	{
		$this->db->exec("USE {$_SESSION['user']['company_schema']}");

		$sql = "

			SELECT
				*

			FROM
				`tbs_nationalized_forms_products`

			WHERE
				`warehouse_id` = $product_id

		";

		return $this->db->query($sql)->fetchAll();
	}
}
