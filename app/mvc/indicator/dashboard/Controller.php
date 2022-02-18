<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		// $this->view('Inicio', $data, 'fullwidth');
		$data['indicators'] = $this->model('indicator/indicators')->get_all($_SESSION['user']['company_id']);
		// if(has_role(2)|| has_role(3)){
		// 	$data['indicators'] = $this->model('indicator/indicators')->getall_by_rol($_SESSION['user']['company_id']);
		// }else{
		// 	$data['indicators'] = $this->model('indicator/indicators')->get_all($_SESSION['user']['company_id']);
		// }
		
		$data['page_title'] = 'Indicadores';
		$this->view('', $data, 'fullwidth');
	}


/*----------------------------------------------------------------------
	CHANGE COMPANY
----------------------------------------------------------------------*/
	public function change_company()
	{
		$company = $this->model('indicator/companies')->get_by_id($_POST['company']);

		/*Y aquí la cambias :D*/

		redirect('indicator/dashboard', 'Empresa cambiada a: '.$company['name']);
	}
}
