<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['transport_output_forms'] = $this->model('tbs/transport_output_forms')->get_all();
		
		$this->view('', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	RECUPERAR
----------------------------------------------------------------------*/

	public function recover(){
		if ($this->model('tbs/transport_output_forms')->recover($_GET['id'])) {
			$this->model('tbs/transport_output_forms_logs')->create($_GET['id'], 8);
			redirect("tbs/transport_output_forms/details?id=".$_GET['id']);
		}else{
			set_notification('No se pudo recuperar el formulario', 'error');
		}
	}


/*----------------------------------------------------------------------
	EDIT CHARGE INFO
----------------------------------------------------------------------*/
	public function edit_charge_info()
	{
		$data['tif'] = $this->model('tbs/transport_output_forms')->get_by_id($_GET['id']);

		if ($_POST)
		{
			if ($this->model('tbs/transport_output_forms')->edit_charge_info($_POST, $_GET['id'])) 
			{

				redirect("tbs/transport_output_forms/details?id={$_GET['id']}");
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
			}
		}

		$this->view('', $data);
	}

/*----------------------------------------------------------------------
	VERIFIED
----------------------------------------------------------------------*/

	public function verified(){
		if ($this->model('tbs/transport_output_forms_logs')->create($_GET['id'], 12)) {
			redirect("tbs/transport_output_forms/details?id=".$_GET['id']);
		}else{
			set_notification('No se pudo verificar el formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	PRESENT
----------------------------------------------------------------------*/
	public function present()
	{
		if ($this->model('tbs/transport_output_forms')->present($_GET['id'])) 
		{
			//Crear notificación
			$form = $this->model('tbs/transport_output_forms')->get_by_id($_GET['id']);
			$noti_body = 'El pase de salida <b>#'.$_GET['id'].'</b> fue presentado por @'.$form['created_by_user'];
			$this->model('tbs/notifications')->create('file-text', $noti_body);

			$this->model('tbs/transport_output_forms_logs')->create($_GET['id'], 2);
			redirect("tbs/transport_output_forms/details?id={$_GET['id']}", 'Formulario Presentado');
		}
		else
		{
			redirect("tbs/output_forms/details?id={$_GET['id']}", 'No se pudo presentar el Formulario', 'error');
		}
	}

	//SET WEIGHT
	public function set_weight(){
		if ($_POST['type']==1) {
			
			if ($this->model('tbs/transport_output_forms')->set_starting_weight($_POST['weight'], $_POST['form_id'])) {

				redirect_back('Peso de entrada registrado');
			}else{
				redirect_back('Ocurrió un error', 'error');
			}
		}else{
			if ($this->model('tbs/transport_output_forms')->set_ending_weight($_POST['weight'], $_POST['form_id'])) {

				redirect_back('Peso de sálida registrado');
			}else{
				redirect_back('Ocurrió un error', 'error');
			}
		}
	}

	//SET CHARGE NUMBER
	public function set_charge_number(){

		if ($this->model('tbs/transport_output_forms')->set_charge_unit_number($_POST['charge_number'], $_POST['form_id'])) {

			redirect_back('Número de unidad de carga registrado');
		}else{
			redirect_back('Ocurrió un error', 'error');
		}
	}

/*----------------------------------------------------------------------
	DETAILS
----------------------------------------------------------------------*/
	public function details()
	{
		$data['transport_output_forms_products'] = $this->model('tbs/transport_output_forms_products')->get_by_form_id($_GET['id']);
		$data['tbs_transport_output_forms_verify'] = $this->model('tbs/transport_output_forms_verify')->get_by_form_id($_GET['id']);
		$data['transport_output_forms_supports'] = $this->model('tbs/transport_output_forms_supports')->get_by_form_id($_GET['id']);
		$data['logs'] = $this->model('tbs/transport_output_forms_logs')->get_by_form_id($_GET['id']);
		$data['drivers'] = $this->model('tbs/drivers')->get_all();

		$data['transport_output_form'] = $this->model('tbs/transport_output_forms')->get_by_id($_GET['id']);

		$errors = count($data['tbs_transport_output_forms_verify']);
		if ($errors>0) {
			set_notification('Se encontraron campos por revisar en el formulario.', 'info');
		}
		
		$this->view('details', $data, 'fullwidth');
	}
	
/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			if ($last_id = $this->model('tbs/transport_output_forms')->create($_POST)) 
			{
				$this->model('tbs/transport_output_forms_logs')->create($last_id, 1);

				redirect("tbs/transport_output_forms/details?id=$last_id");
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
			}
		}
		$data['drivers'] = $this->model('tbs/drivers')->get_all();
		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	VERIFY
----------------------------------------------------------------------*/
	public function verify()
	{
		
		$data['transport_output_forms_products'] = $this->model('tbs/transport_output_forms_products')->get_by_form_id($_GET['id']);
		$data['transport_output_forms_supports'] = $this->model('tbs/transport_output_forms_supports')->get_by_form_id($_GET['id']);
		$data['transport_output_forms_verify'] = $this->model('tbs/transport_output_forms_verify')->get_by_form_id($_GET['id']);

		$data['transport_output_form'] = $this->model('tbs/transport_output_forms')->get_by_id($_GET['id']);

		if ($data['transport_output_form']['form_state_id']==14) {
			if ($_SESSION['user']['id']!=$data['transport_output_form']['updated_by']) {
				set_notification('Este formulario está siendo revisado', 'info');
				redirect("tbs/transport_output_forms/");
			}
		}else if ($data['transport_output_form']['form_state_id']==3) {
				set_notification('Este pase ya fue aprobado', 'info');
				redirect("tbs/transport_output_forms/");
		}

		if ($_POST)
		{
			$form = $this->model('tbs/transport_output_forms')->get_by_id($_GET['id']);

			if ($form['form_state_id']==3) {
				set_notification('Este pase ya fue aprobado');
				redirect("tbs/transport_output_forms/");
			}

			$form_id = $_POST['form_id'];
			$bad_fields = $_POST['bad_fields'];

			if (count($bad_fields)!=0) {

				$this->model('tbs/transport_output_forms_verify')->delete($form_id);

				foreach ($bad_fields as $bf) {
					$fields = explode("-", $bf);

					$this->model('tbs/transport_output_forms_verify')->create($form_id, $fields[0], $fields[1], $fields[2]);
					
				}

				$this->model('tbs/transport_output_forms_logs')->create($form_id, 4);
				$this->model('tbs/transport_output_forms')->return_presented($form_id);

				//Crear notificación
				$form = $this->model('tbs/transport_output_forms')->get_by_id($form_id);
				$noti_body = 'El pase de salida <b>#'.$form_id.'</b> fue rechazado por @'.$_SESSION['user']['username'];
				$this->model('tbs/notifications')->create('cancel', $noti_body, 1);
			}else{
				//$this->model('tbs/transport_output_forms_verify')->delete($form_id);
				//error_reporting(E_ALL);

				$this->model('tbs/transport_output_forms_logs')->create($form_id, 3);
				$this->model('tbs/transport_output_forms')->approve($form_id);

				foreach ($data['transport_output_forms_products'] as $product) {
					$this->model('tbs/warehouses')->from_reserved_to_output_to_dispatched($product['warehouse_id'], $product['quantity']);
				}

				$output_forms = $this->model('tbs/warehouses')->get_forms_from_transport_out($_GET['id']);				

				foreach ($output_forms as $output) {
					$out_products = $this->model('tbs/output_forms_products')->get_by_form_id($output['output_form_id']);

					if (count($out_products)==1) {
						//Si no es transformación
						if ($out_products[0]['form_type']!=2) {
								$sum = $this->model('tbs/transport_output_forms_products')->get_sum_transports($output['output_form_id']);

								if ($sum['sum']==$out_products[0]['quantity']) {
									$this->model('tbs/output_forms')->execute($output['output_form_id']);
									$this->model('tbs/output_forms_logs')->create($output['output_form_id'], 5);

									//Crear notificación
									$noti_body = 'El formulario de salida <b>#'.$output['output_form_id'].'</b> fue ejecutado por @'.$_SESSION['user']['username'];
									$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);
								}
						}else{
							//Si es transformación
							foreach ($data['transport_output_forms_products'] as $product) {
								if ($product['quantity']<=$out_products['quantity']) {
									$this->model('tbs/output_forms')->execute($output['output_form_id']);
									$this->model('tbs/output_forms_logs')->create($output['output_form_id'], 5);

									//Crear notificación
									$noti_body = 'El formulario de salida <b>#'.$output['output_form_id'].'</b> fue ejecutado por @'.$_SESSION['user']['username'];
									$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);
								}else{
									$sum = $this->model('tbs/output_forms_products')->get_sum_warehouses($output['output_form_id']);
					
									if ($sum['sum_warehouses']==0) {
										$this->model('tbs/output_forms')->execute($output['output_form_id']);
										$this->model('tbs/output_forms_logs')->create($output['output_form_id'], 5);

										//Crear notificación
										$noti_body = 'El formulario de salida <b>#'.$output['output_form_id'].'</b> fue ejecutado por @'.$_SESSION['user']['username'];
										$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);
									}
								}
							}
						}
					}else{
						$sum = $this->model('tbs/output_forms_products')->get_sum_warehouses($output['output_form_id']);
					
							if ($sum['sum_warehouses']==0) {
								$this->model('tbs/output_forms')->execute($output['output_form_id']);
								$this->model('tbs/output_forms_logs')->create($output['output_form_id'], 5);

								//Crear notificación
								$noti_body = 'El formulario de salida <b>#'.$output['output_form_id'].'</b> fue ejecutado por @'.$_SESSION['user']['username'];
								$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);
							}
					}
				}

				//Crear notificación
				$form = $this->model('tbs/transport_output_forms')->get_by_id($form_id);
				$noti_body = 'El pase de salida <b>#'.$form_id.'</b> fue aprobado por @'.$_SESSION['user']['username'];
				$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);


				//Ejecutar todos los formularios que están en 0
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
			}

			redirect("tbs/transport_output_forms/");
		}
		$data['drivers'] = $this->model('tbs/drivers')->get_all();
		$this->view('verify', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['tof'] = $this->model('tbs/transport_output_forms')->get_by_id($_GET['id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];

			if ($last_id = $this->model('tbs/transport_output_forms')->edit($_POST)) 
			{
				//$this->model('tbs/transport_output_forms_logs')->create($last_id, 1);

				redirect_back();
			}
			else
			{
				redirect_back('Ocurrió un error', 'error');
			}
		}
		$data['drivers'] = $this->model('tbs/drivers')->get_all();
		$this->view('create', $data);
	}

}
