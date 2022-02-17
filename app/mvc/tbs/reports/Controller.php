<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		render('fullwidth');
	}


/*----------------------------------------------------------------------
	FOB REPORT
----------------------------------------------------------------------*/
	public function fob_value()
	{
		if ($_POST)
		{
			$companies = $this->model('tbs/companies')->get_all();

			$current_schema = $_SESSION['user']['company_schema'];

			$input_data = array();

			$month = date("n");
			$year = date("Y");

			$max = 12;

			if ($year==$_POST['year']) {
				$max = $month;
			}

			$input_transactions = [1, 3, 5];

			foreach ($companies as $company) {
				$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];

				foreach ($input_transactions as $it) {
					for ($i=1; $i <=$max ; $i++) { 
						$result = $this->model('tbs/reports')->get_input_fob($i, $_POST['year'], $it);
						array_push($input_data, $result);
					}
				}
			}

			$_SESSION['user']['company_schema'] = $current_schema;

			data('input_data', $input_data);
		}

		render();
	}

/*----------------------------------------------------------------------
	APPROBATION DATETIME
----------------------------------------------------------------------*/
	public function approbation_datetime()
	{
		//error_reporting(E_ALL);
		if ($_POST)
		{
			
			$companies = $this->model('tbs/companies')->get_all();

			$current_schema = $_SESSION['user']['company_schema'];

			$data = array();

			$month = date("n");
			$year = date("Y");

			$max = 12;

			if ($year==$_POST['year']) {
				$max = $month;
			}

			foreach ($companies as $company) {
				$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];

				if ($_POST['type']==1) {
					$result = $this->model('tbs/input_forms')->get_by_date($_POST['month'], $_POST['year']);
					array_push($data, $result);
				}else if ($_POST['type']==2) {
					$result = $this->model('tbs/output_forms')->get_by_date($_POST['month'], $_POST['year']);
					array_push($data, $result);
				}else if ($_POST['type']==3) {
					$ips = $this->model('tbs/input_forms')->get_by_date($_POST['month'], $_POST['year'], 1);
					foreach ($ips as $ip) {
						$result = $this->model('tbs/transport_input_forms_products')->get_last_transport($ip['form_id']);
						array_push($data, $result);
					}
						
				}
				
			}

			$_SESSION['user']['company_schema'] = $current_schema;

			data('type', $_POST['type']);
			data('data', $data);
		}

		render();
	}


/*----------------------------------------------------------------------
	TRACE
----------------------------------------------------------------------*/
	public function trace()
	{	
		if ($_POST['report_type'] == 1)
		{
			$product_id = $_POST['product_id'];

			data('input', $this->model('tbs/input_forms_products')->get_by_product_id($product_id));
			data('transport_input', $this->model('tbs/transport_input_forms_products')->get_by_product_id($product_id));
			data('output', $this->model('tbs/output_forms_products')->get_by_product_id($product_id));
			data('transport_output', $this->model('tbs/transport_output_forms_products')->get_by_product_id($product_id));
			data('nationalized', $this->model('tbs/nationalized_forms_products')->get_by_product_id($product_id));
			data('transformation', $this->model('tbs/transformation_forms_consumables')->get_by_product_id($product_id));

			data('result', ':)');
		}

		render();
	}

/*----------------------------------------------------------------------
	thirdparties_validity
----------------------------------------------------------------------*/
	public function thirdparties_validity()
	{
		//error_reporting(E_ALL);
		$companies = $this->model('tbs/companies')->get_all();

		$current_schema = $_SESSION['user']['company_schema'];

		$data['results'] = array();

		foreach ($companies as $company) {
			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];
			$result = $this->model('tbs/reports')->thirdparties_validity();
			
			array_push($data['results'], $result);
		}

		$_SESSION['user']['company_schema'] = $current_schema;

		$this->view('', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	RE_ENTRY
----------------------------------------------------------------------*/
	public function re_entry()
	{
		if ($_POST)
		{			
			data('products', $this->model('tbs/output_forms_products')->get_by_form_id($_POST['form_id']));
		}

		render('fullwidth');
	}

/*----------------------------------------------------------------------
	TRANSPORTS BY FORM
----------------------------------------------------------------------*/
	public function transports_by_form()
	{
		if ($_POST)
		{			
			if ($_POST['type']==1) {
				data('forms', $this->model('tbs/reports')->get_transports_by_form($_POST['form_id'], 1));
				data('type', 1);
			}else{
				data('forms', $this->model('tbs/reports')->get_transports_by_form($_POST['form_id'], 2));
				data('type', 2);
			}
		}

		render('fullwidth');
	}

/*----------------------------------------------------------------------
	TRANSFORMATIONS PRODUCT
----------------------------------------------------------------------*/
	public function transformations_products()
	{
		if ($_POST)
		{			
			//error_reporting(E_ALL);
			data('products', $this->model('tbs/reports')->get_transformations($_POST['warehouse_id']));
		}

		render();
	}


/*----------------------------------------------------------------------
	MASTER
----------------------------------------------------------------------*/
	public function master()
	{
		if ($_POST)
		{
			set_flash('data', $_POST);
			redirect('tbs/reports/master_csv');
		}

		render();
	}

/*----------------------------------------------------------------------
	MASTER
----------------------------------------------------------------------*/
	public function master_csv()
	{
		data('results', $this->model('tbs/reports')->get_master($data));
		render('flat');
	}


/*----------------------------------------------------------------------
	MASTER
----------------------------------------------------------------------*/
	public function dane_menu()
	{
		render();
	}

/*----------------------------------------------------------------------
	DANE
----------------------------------------------------------------------*/
	public function dane()
	{
		//error_reporting(E_ALL);

		$init_date = $_POST['report_date'].'-01';
		$end_date = $_POST['report_date'].'-31';

		$companies = $this->model('tbs/companies')->get_all();

		$data['inputs'] = array();
		$data['outputs'] = array();

		$current_schema = $_SESSION['user']['company_schema'];

		foreach ($companies as $company) {
			if ($company['id']!='900162578') {
				$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];

				$results_in = $this->model('tbs/reports')->get_dane_inputs($init_date, $end_date);
				array_push($data['inputs'], $results_in);

				$results_out = $this->model('tbs/reports')->get_dane_outputs($init_date, $end_date);
				array_push($data['outputs'], $results_out);
			}
		}

		$_SESSION['user']['company_schema'] = $current_schema;
		$this->view('DANE', $data, 'flat');
	}

/*----------------------------------------------------------------------
	WAREHOUSE
----------------------------------------------------------------------*/
	public function warehouse()
	{
		data('results', $this->model('tbs/reports')->get_balances());
		data('categories', $this->model('tbs/reports')->get_categories_by_warehouses());
		data('bls', $this->model('tbs/reports')->get_bls());
		render('fullwidth');
	}
}
