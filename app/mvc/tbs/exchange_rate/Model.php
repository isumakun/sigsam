<?php

namespace tbs_exchange_rate;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET
 ---------------------------------------------------------------------*/
	public function get()
	{
		return $this->db->query("

			SELECT exchange_rate
			FROM tbs3.`tbs_exchange_rate`
			LIMIT 1
		")->fetchAll()[0];
	}

/*----------------------------------------------------------------------
	SET
 ---------------------------------------------------------------------*/
	public function set($exchange_rate)
	{
		$sql = "

			UPDATE 
				tbs3.`tbs_exchange_rate` 
			SET
				`exchange_rate` = $exchange_rate

			WHERE id = 1
		";

		return $this->db->query($sql);
	}
}
