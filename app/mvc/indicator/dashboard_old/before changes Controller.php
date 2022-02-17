<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$this->view('Inicio', $data, 'fullwidth');
	}


/*----------------------------------------------------------------------
	CHANGE COMPANY
----------------------------------------------------------------------*/
	public function change_company()
	{
		$company = $this->model('indicator/companies')->get_by_id($_POST['company']);

		/*Y aquí la cambias :D*/

		redirect('tbs/dashboard', 'Empresa cambiada a: '.$company['name']);
	}
}
