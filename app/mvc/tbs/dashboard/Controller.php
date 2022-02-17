<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['notifications'] = $this->model('tbs/notifications')->get_last_10();
		$_SESSION['panel_notifications'] = $data['notifications'];

		$data['input_forms'] = $this->model('tbs/dashboard')->get_dashboard_count('input_forms');
		$data['transport_input_forms'] = $this->model('tbs/dashboard')->get_dashboard_count('transport_input_forms');
		$data['output_forms'] = $this->model('tbs/dashboard')->get_dashboard_count('output_forms');
		$data['transport_output_forms'] = $this->model('tbs/dashboard')->get_dashboard_count('transport_output_forms');

		$_SESSION['exchange_rate'] = $this->model('tbs/exchange_rate')->get();
		$this->view('Inicio', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	SEGURIDAD
----------------------------------------------------------------------*/
	public function security()
	{
		$this->view('Inicio', $data);
	}

/*------------------------------------------------------------------------------
	REDIRECT
------------------------------------------------------------------------------*/
	public function redirect()
	{
		//error_reporting(E_ALL);
		$current_schema = $_SESSION['user']['company_schema'];
		$new_schema = 'tbs3_'.$_GET['company_id'];

		if ($current_schema!=$new_schema) {
			$company = $this->model('tbs/companies')->get_by_id($_GET['company_id']);

			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];
			$_SESSION['user']['company_name'] = $company['name'];
			$_SESSION['user']['company_alias'] = $company['alias'];
			
			set_notification('Se ha cambiado de empresa a: '.$company['name']);
		}

		if ($_GET['type']==1) {
			redirect('tbs/input_forms/details?id='.$_GET['id']);
		}elseif ($_GET['type']==2) {
			redirect('tbs/transport_input_forms/details?id='.$_GET['id']);
		}elseif ($_GET['type']==3) {
			redirect('tbs/output_forms/details?id='.$_GET['id']);
		}elseif ($_GET['type']==4) {
			redirect('tbs/transport_output_forms/details?id='.$_GET['id']);
		}elseif ($_GET['type']==5) {
			redirect('tbs/transformation_forms/details?id='.$_GET['id']);
		}elseif ($_GET['type']==6) {
			redirect('tbs/thirdparties_requests/details?id='.$_GET['id']);
		}elseif ($_GET['type']==7) {
			redirect('tbs/output_forms_inspections_products/');
		}

		$this->view('', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	TURNOS INSPECCIÓN DE SALIDA
----------------------------------------------------------------------*/
	public function turns()
	{
		$companies = $this->model('tbs/companies')->get_all();

		$current_schema = $_SESSION['user']['company_schema'];

		$data['output_inspections'] = array();

		foreach ($companies as $company) {
			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];
			//echo 'tbs3_'.$company['id'].'<br>';
			
			$oi = $this->model('tbs/products')->get_all_for_output_inspection_group();
			array_push($data['output_inspections'], $oi);
		}

		$_SESSION['user']['company_schema'] = $current_schema;

		$this->view('', $data, 'fullwidth');
	}


/*----------------------------------------------------------------------
	REVISIÓN
----------------------------------------------------------------------*/
	public function review()
	{
		//error_reporting(E_ALL);
		$companies = $this->model('tbs/companies')->get_all();

		$current_schema = $_SESSION['user']['company_schema'];
		//error_reporting(E_ALL);

		$data['inputs'] = array();
		$data['outputs'] = array();
		$data['transport_inputs'] = array();
		$data['transport_outputs'] = array();
		$data['transformations'] = array();
		$data['thirdparty'] = array();
		$data['output_inspections'] = array();

		foreach ($companies as $company) {
			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];
			//echo 'tbs3_'.$company['id'].'<br>';
			$results_in = $this->model('tbs/input_forms')->get_all_presented();
			array_push($data['inputs'], $results_in);

			$results_out = $this->model('tbs/output_forms')->get_all_presented();
			array_push($data['outputs'], $results_out);

			$results_in = $this->model('tbs/transport_input_forms')->get_all_presented();
			array_push($data['transport_inputs'], $results_in);

			$results_out = $this->model('tbs/transport_output_forms')->get_all_presented();
			array_push($data['transport_outputs'], $results_out);

			$trans = $this->model('tbs/transformation_forms')->get_all_presented();
			array_push($data['transformations'], $trans);

			$tp = $this->model('tbs/thirdparties_requests')->get_all_verified();
			array_push($data['thirdparty'], $tp);

			$oi = $this->model('tbs/products')->get_all_for_output_inspection_group();
			array_push($data['output_inspections'], $oi);
		}

		$_SESSION['user']['company_schema'] = $current_schema;

		$this->view('security', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	VEHICULOS
----------------------------------------------------------------------*/
	public function vehicles()
	{
		$companies = $this->model('tbs/companies')->get_all();

		$current_schema = $_SESSION['user']['company_schema'];
		//error_reporting(E_ALL);

		$data['inputs'] = array();
		$data['outputs'] = array();
		$data['outputs_created'] = array();
		$data['approved'] = array();

		foreach ($companies as $company) {
			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];

			$results_in = $this->model('tbs/transport_input_forms')->get_all_presented();
			array_push($data['inputs'], $results_in);

			$results_out = $this->model('tbs/transport_output_forms')->get_all_presented();
			array_push($data['outputs'], $results_out);

			$aux = array();
			$results_out_created = $this->model('tbs/transport_output_forms')->get_all_created();
			if (count($results_out_created)>0) {
				foreach ($results_out_created as $rr) {
					if ($rr['id']!=0) {
						array_push($aux, $rr);
					}
				}
			}

			if (count($aux)>0) {
				array_push($data['outputs_created'], $aux);
			}

			$results_approved = $this->model('tbs/transport_output_forms')->get_approved();
			array_push($data['approved'], $results_approved);
		}

		$_SESSION['user']['company_schema'] = $current_schema;
		//error_reporting(E_ALL);
		//$data['init_notifications'] = $this->model('tbs/notifications')->get_pending();

		$this->view('security', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	TERCEROS
----------------------------------------------------------------------*/
	public function thirdparties()
	{
		$companies = $this->model('tbs/companies')->get_all();

		$current_schema = $_SESSION['user']['company_schema'];

		$data['workers'] = array();

		foreach ($companies as $company) {
			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];

			$workers = $this->model('tbs/thirdparties_workers')->get_all_allowed();
			array_push($data['workers'], $workers);
		}

		$_SESSION['user']['company_schema'] = $current_schema;
		//error_reporting(E_ALL);

		$this->view('', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	MATERIALES, HERRAMIENTAS Y EQUIPOS
----------------------------------------------------------------------*/
	public function tools()
	{

		$companies = $this->model('tbs/companies')->get_all();

		$current_schema = $_SESSION['user']['company_schema'];

		$data['tools'] = array();

		foreach ($companies as $company) {
			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];

			$tools = $this->model('tbs/thirdparties_requests_tools')->get_all_allowed();
			array_push($data['tools'], $tools);
		}

		$_SESSION['user']['company_schema'] = $current_schema;

		$this->view('', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	CHANGE COMPANY
----------------------------------------------------------------------*/
	public function change_company()
	{
		$company = $this->model('tbs/companies')->get_by_id($_POST['company']);

		$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];
		$_SESSION['user']['company_name'] = $company['name'];
		$_SESSION['user']['company_alias'] = $company['alias'];
		$_SESSION['company_users'] = $this->model('admin/users')->get_users_by_company($company['id']);

		redirect('tbs/dashboard', 'Empresa cambiada a: '.$company['name']);
	}

/*----------------------------------------------------------------------
	SET EXCHANGE RATE
----------------------------------------------------------------------*/
	public function set_exchange_rate()
	{
		$this->model('tbs/exchange_rate')->set($_POST['exchange_rate']);

		$_SESSION['exchange_rate'] = $_POST['exchange_rate'];

		redirect_back('TRM cambiada a: $'.$_POST['exchange_rate']);
	}
}
