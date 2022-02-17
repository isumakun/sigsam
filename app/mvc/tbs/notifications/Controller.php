<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		//error_reporting(E_ALL);
		if (has_role(3) OR has_role(7)) {
			$data['notifications'] = $this->model('tbs/notifications')->get_all_operators();
		}else if (has_role(4)){
			$data['notifications'] = $this->model('tbs/notifications')->get_all_users();
		}

		foreach ($data['notifications'] as $notification) {
			$this->model('tbs/notifications')->readed($notification['id']);
		}
		
		$this->view('Inicio', $data);
	}

/*----------------------------------------------------------------------
	CHANGE MODE
----------------------------------------------------------------------*/
	public function change_mode()
	{
		if ($_SESSION['master_mode']==1) {
			$_SESSION['master_mode']=0;
			set_notification('Modo maestro desactivado', 'error');
			redirect_back();
		}else{
			$_SESSION['master_mode']=1;
			set_notification('Modo maestro activado');
			redirect_back();
		}
	}

/*----------------------------------------------------------------------
	change_from_nationalized_to_foreigner
----------------------------------------------------------------------*/
	public function script_data()
	{
		if ($_POST) {

			if ($_POST['data'])
			{
				$datas = preg_split('/\n/', $_POST['data']);
			}

			$count = 0;
			$nope = array();
			foreach ($datas as $data) {

				$data = preg_replace( "/\r|\n/", "", $data);

				$product = $this->model('tbs/products')->get_by_name($data);

				if ($this->model('tbs/products')->change_type($product['pid'], 1)) {
					$count++;
				}else{
					array_push($nope, $data);
				}
			}

			set_notification($count.' registros cambiados');

			if (count($nope)>0) {
				echo "Esto no se pudo cambiar:";
				echo '<pre>'.print_r($nope, TRUE).'</pre>';
				die();
			}

			redirect("tbs/notifications/script_data");
		}

		$this->view('', $data);
	}

/*----------------------------------------------------------------------
	from_nationalized_to_foreigner
----------------------------------------------------------------------*/
	public function from_nationalized_to_foreigner()
	{
		if ($_POST) {

			if ($_POST['data'])
			{
				$datas = preg_split('/\n/', $_POST['data']);
			}

			$count = 0;
			$nope = array();
			foreach ($datas as $data) {

				$data = preg_replace( "/\r|\n/", "", $data);

				$product = $this->model('tbs/products')->get_by_name($data);

				if ($this->model('tbs/products')->change_type($product['pid'], 1)) {
					$count++;
				}else{
					array_push($nope, $data);
				}
			}

			set_notification($count.' registros cambiados');

			if (count($nope)>0) {
				echo "Esto no se pudo cambiar:";
				echo '<pre>'.print_r($nope, TRUE).'</pre>';
				die();
			}

			redirect("tbs/notifications/script_data");
		}

		$this->view('', $data);
	}


/*----------------------------------------------------------------------
	count
----------------------------------------------------------------------*/
	public function count_mane()
	{
		//error_reporting(E_ALL);
		$companies = $this->model('tbs/companies')->get_all();

		$current_schema = $_SESSION['user']['company_schema'];
		//error_reporting(E_ALL);

		foreach ($companies as $company) {
			echo $company['name'].'<br><br>';

			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];

			$result = $this->model('tbs/reports')->get_count();

			foreach ($result as $res) {
				echo "<b>Transacción: ".$res['transaction_id']."</b> = ".$res['recuento'];
				echo "<br>";
			}
			echo "<hr>";
		}

		$_SESSION['user']['company_schema'] = $current_schema;
	}

/*----------------------------------------------------------------------
	get_notifications
----------------------------------------------------------------------*/
	public function get_pending_notifications()
	{
		if (has_role(3) OR has_role(7)) {
			$notifications = $this->model('tbs/notifications')->get_pending_operators();
		}else{
			$notifications = $this->model('tbs/notifications')->get_pending_users();
		}

		foreach ($notifications as $notification) {
			$this->model('tbs/notifications')->readed($notification['id']);
		}
		
		if (!$notifications) {
			return FALSE;
		}
		
		echo json_encode($notifications);
	}

/*----------------------------------------------------------------------
	script
----------------------------------------------------------------------*/
	public function script()
	{
		//error_reporting(E_ALL);
		//Todos los carros extranjeros de un formulario
		$all_ext = $this->model('tbs/output_forms_products')->script_all_ext($_GET['id']);

		foreach ($all_ext as $ext) {
			$product_name = $ext['product'];

			//Cojo el nombre y busco su parte nacionalizada
			$nac = $this->model('tbs/products')->get_by_name($product_name);

			//Cambio el extranjero por el nacionalizado en el formulario de salida
			$this->model('tbs/output_forms_products')->change_ext_to_nac($ext['wid'], $nac['wid']);

			//Cambio el extranjero por el nacionalizado en la inspección
			$this->model('tbs/output_forms_inspections_products')->change_ext_to_nac($ext['wid'], $nac['wid']);

			//Cambio el extranjero por el nacionalizado en el transporte de salida
			$this->model('tbs/transport_output_forms_products')->change_ext_to_nac($ext['wid'], $nac['wid']);

			//Si el extranjero fue despachado
			if ($ext['reserved']<0) {
				//Lo paso a 0
				$this->model('tbs/warehouses')->reserved_to_0($ext['wid']);
				$this->model('tbs/warehouses')->stock_to_0($nac['wid']);
			}

			//Paso los saldos de approved, inspected_to_output, reserved_to_output y dispatched al producto nacionalizado
			$wh = $this->model('tbs/warehouses')->get_by_id($ext['wid']);

			//Paso los saldos del extranjero al nacionalizado
			$this->model('tbs/warehouses')->update_nac($nac['wid'], $wh['approved'], $wh['inspected_to_output'], $wh['reserved_to_output'], $wh['dispatched']);

			//Paso los saldos del extranjero a 0 y solo dejo 1 en nacionalizado
			$this->model('tbs/warehouses')->update_nac($ext['wid'], 0, 0, 0, 0);
			
		}
	}

/*----------------------------------------------------------------------
	remove_execute
----------------------------------------------------------------------*/
	public function remove_execute()
	{
		error_reporting(E_ALL);

		$all_output = $this->model('tbs/output_forms')->get_all();

		foreach ($all_output as $output) { 
			if ($output['form_state_id']==5) {
				$sum = $this->model('tbs/output_forms_products')->get_sum_warehouses($output['form_id']);
				
				if ($sum['sum_warehouses']!=0) {
					$this->model('tbs/output_forms')->return_execute($output['form_id']);
					$this->model('tbs/output_forms_logs')->return_execute($output['form_id']);
				}
			}
			
		}

	}

/*----------------------------------------------------------------------
	execute_all
----------------------------------------------------------------------*/
	public function execute_all()
	{
		//error_reporting(E_ALL);

		$all_output = $this->model('tbs/output_forms')->get_all();

		foreach ($all_output as $output) { 
			if ($output['form_state_id']==3) {
				$sum = $this->model('tbs/output_forms_products')->get_sum_warehouses($output['form_id']);
				
				if ($sum['sum_warehouses']==0) {
					$transport = $this->model('tbs/transport_output_forms_products')->get_last_transport($output['form_id']);

					//echo '<pre>'.print_r('Formulario #'.$output['form_id'].', ejecutado el día '.$transport['approved_at'], TRUE).'</pre>';
					if ($transport['approved_at']!='') {
						$this->model('tbs/output_forms')->execute_at($output['form_id'], $transport['approved_at'], $transport['approved_by']);
						$this->model('tbs/output_forms_logs')->create_at($output['form_id'], 5, $transport['approved_at'], $transport['approved_by']);
					}
				}
			}
		}

		redirect_back();

	}

/*----------------------------------------------------------------------
	execute_defined
----------------------------------------------------------------------*/
	public function execute_defined()
	{
		error_reporting(E_ALL);

		$all_output = [2, 8, 39, 40, 44, 47, 50, 50, 51, 52, 54, 56, 58, 59, 60, 68, 69, 70, 71, 72, 74, 84, 106, 107, 108, 151, 152, 175, 180, 191, 192, 206, 212, 214, 218, 221, 222, 226, 250];


		foreach ($all_output as $output) {
			$this->model('tbs/output_forms')->return_execute($output);
			$this->model('tbs/output_forms_logs')->return_execute($output);
		}

	}

/*----------------------------------------------------------------------
	LOL
----------------------------------------------------------------------*/
	public function lol()
	{
		error_reporting(E_ALL);

		$products = $this->model('tbs/input_forms_products')->get_by_form_id(3);
		
		foreach ($products as $product) {
			$this->model('tbs/warehouses')->insert_lol($product['input_form_id'], $product['product_id'], $product['quantity']);
		}

	}
}
