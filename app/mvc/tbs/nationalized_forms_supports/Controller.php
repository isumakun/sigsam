<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {


/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		$this->model('tbs/nationalized_forms_supports')->create($_POST['number'], $_POST['supp_date'], $_POST['form_id']);
	}

/*----------------------------------------------------------------------
	DELETE
----------------------------------------------------------------------*/
	public function delete()
	{
		$this->model('tbs/nationalized_forms_supports')->delete($_GET['id']);

		redirect_back();
	}

}
