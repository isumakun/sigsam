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
	INSPECTION
	----------------------------------------------------------------------*/
	public function inspection()
	{
		$data['input_forms'] = $this->model('tbs/input_forms')->get_for_inspection();

		$this->view('', $data);
	}

/*----------------------------------------------------------------------
	CREATE
	----------------------------------------------------------------------*/
	public function create()
	{
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['agreements'] = $this->model('tbs/input_forms_agreements')->get_all();
		$data['input_forms_transactions'] = $this->model('tbs/input_forms_transactions')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['exchange_rate'] = $this->model('tbs/exchange_rate')->get();

		if ($_POST)
		{
			if ($last_id = $this->model('tbs/input_forms')->create($_POST)) 
			{
				$this->model('tbs/input_forms_logs')->create($last_id, 1);
				redirect("tbs/input_forms/details?id=$last_id");
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
			}
		}
		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	PRESENT
----------------------------------------------------------------------*/
	public function present()
	{
		if ($this->model('tbs/input_forms')->present($_GET['id'])) 
		{
			$this->model('tbs/input_forms_logs')->create($_GET['id'], 2);

			//Crear notificación
			$form = $this->model('tbs/input_forms')->get_by_id($_GET['id']);
			$noti_body = 'El formulario de ingreso <b>#'.$_GET['id'].'</b> fue presentado por @'.$form['created_by_user'];
			$this->model('tbs/notifications')->create('file-text', $noti_body);

			redirect("tbs/input_forms/details?id={$_GET['id']}", 'Formulario Presentado');
		}
		else
		{
			redirect("tbs/input_forms/details?id={$_GET['id']}", 'No se pudo presentar el Formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	EDIT
	----------------------------------------------------------------------*/
	public function edit()
	{
		$data['input_form'] = $this->model('tbs/input_forms')->get_by_id($_GET['id']);

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['packaging'] = $this->model('tbs/packaging')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['agreements'] = $this->model('tbs/input_forms_agreements')->get_all();
		$data['input_forms_transactions'] = $this->model('tbs/input_forms_transactions')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();
		$data['input_forms_supports'] = $this->model('tbs/input_forms_supports')->get_by_form_id($_GET['id']);
		$data['input_forms_products'] = $this->model('tbs/input_forms_products')->get_by_form_id($_GET['id']);
		$data['input_forms_verify'] = $this->model('tbs/input_forms_verify')->get_by_form_id($_GET['id']);

		if ($_POST)
		{
			$_POST['input_form_id'] = $_GET['id'];
			$form_id = $_GET['id'];

			if ($this->model('tbs/input_forms')->edit($_POST)) 
			{
				$form = $data['input_form'];
				if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
					if ($_SESSION['master_mode']==0) {
						foreach ($_POST as $key => $value) {
							foreach ($form as $key2 => $value2) {
								if ($key==$key2) {
									if ($value!=$value2) {

										$adjustment = array();
										$adjustment['form_type'] = 1; //Ingreso
										$adjustment['form_id'] = $form_id;
										$adjustment['field_type'] = 0; //Info general
										$adjustment['field_name'] = $key; 
										$adjustment['field_id'] = 0;
										$adjustment['old_value'] = $value2;
										$adjustment['new_value'] = $value;

										error_reporting(E_ALL);

										//Guardo un ajuste de lo que se hizo
										$this->model('tbs/forms_adjustments')->create($adjustment);
									}
								}
							}
						}
					}
				}else{
					if (count($data['input_forms_verify'])!=0) {
						for($i=0; $i < count($_POST['field_names']); $i++){

							$verify = $this->model('tbs/input_forms_verify')->get_top($_GET['id'], 1, 0, $_POST['field_names'][$i]);

							if (count($verify)>0) {
								if ($verify['field_value_new']!='') {
									$this->model('tbs/input_forms_verify')->update_all_values($verify['id'], $_POST['field_values'][$i]);
								}else{
									$this->model('tbs/input_forms_verify')->update_value($verify['id'], $_POST['field_values'][$i]);
								}
							}else{
								$this->model('tbs/input_forms_verify')->create($_GET['id'], 1, 0, $_POST['field_names'][$i], $_POST['field_values'][$i]);
							}
							
						}
					}
				}

				redirect("tbs/input_forms/details?id={$_GET['id']}");
			}
			else
			{
				redirect("tbs/input_forms/edit?id={$_GET['id']}", 'Ocurrió un error', 'error');
			}
		}

		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	DETAILS
	----------------------------------------------------------------------*/
	public function details()
	{
		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['packaging'] = $this->model('tbs/packaging')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['agreements'] = $this->model('tbs/input_forms_agreements')->get_all();
		$data['input_forms_transactions'] = $this->model('tbs/input_forms_transactions')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();
		$data['input_forms_supports'] = $this->model('tbs/input_forms_supports')->get_by_form_id($_GET['id']);
		$data['input_forms_products'] = $this->model('tbs/input_forms_products')->get_by_form_id($_GET['id']);
		$data['inspections'] = $this->model('tbs/input_forms_inspections_products')->get_by_form_id($_GET['id']);
		$data['input_forms_verify'] = $this->model('tbs/input_forms_verify')->get_by_form_id($_GET['id']);
		$data['logs'] = $this->model('tbs/input_forms_logs')->get_by_form_id($_GET['id']);

		$errors = count($data['input_forms_verify']);
		if ($errors>0) {
			set_notification('Se encontraron campos por revisar en el formulario.', 'info');
		}

		$data['input_form'] = $this->model('tbs/input_forms')->get_by_id($_GET['id']);

		$this->view('details', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	VERIFY
----------------------------------------------------------------------*/
	public function verify()
	{
		$data['input_form'] = $this->model('tbs/input_forms')->get_by_id($_GET['id']);

		if ($data['input_form']['form_state_id']==14) {
			if ($_SESSION['user']['id']!=$data['input_form']['updated_by']) {
				set_notification('Este formulario está siendo revisado', 'info');
				redirect("tbs/transport_output_forms/");
			}
		}else if ($data['input_form']['form_state_id']==3 OR $data['input_form']['form_state_id']==5) {
				set_notification('Este formulario ya fue aprobado y/o ejecutado', 'info');
				redirect("tbs/input_forms/");
		}else{
			$this->model('tbs/input_forms')->set_in_review($_GET['id']);
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['packaging'] = $this->model('tbs/packaging')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['agreements'] = $this->model('tbs/input_forms_agreements')->get_all();
		$data['input_forms_transactions'] = $this->model('tbs/input_forms_transactions')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();
		$data['input_forms_supports'] = $this->model('tbs/input_forms_supports')->get_by_form_id($_GET['id']);
		$data['input_forms_products'] = $this->model('tbs/input_forms_products')->get_by_form_id($_GET['id']);
		$data['input_forms_verify'] = $this->model('tbs/input_forms_verify')->get_by_form_id($_GET['id']);

		if ($_POST)
		{
			$form = $this->model('tbs/input_forms')->get_by_id($_GET['id']);

			if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
				set_notification('Este formulario ya fue aprobado y/o ejecutado');
				redirect("tbs/input_forms/");
			}

			$form_id = $_POST['form_id'];
			$bad_fields = $_POST['bad_fields'];

			if ($_POST['comment']!='') {
				$this->model('tbs/input_forms_logs')->create($form_id, 4);
				$this->model('tbs/input_forms')->return_presented($form_id);

				//Crear notificación
				$form = $this->model('tbs/input_forms')->get_by_id($form_id);
				$noti_body = 'El formulario de ingreso <b>#'.$form_id.'</b> fue Rechazado por la siguiente razón: '.$_POST['comment'];
				$this->model('tbs/notifications')->create('cancel', $noti_body, 1);
			}else{
				if (count($bad_fields)!=0) {
					//$this->model('tbs/input_forms_verify')->delete($form_id);

					foreach ($bad_fields as $bf) {
						$fields = explode("#/", $bf);
						$this->model('tbs/input_forms_verify')->create($form_id, $fields[0], $fields[1], $fields[2], $fields[3]);
					}

					$this->model('tbs/input_forms_logs')->create($form_id, 4);
					$this->model('tbs/input_forms')->return_presented($form_id);

					//Crear notificación
					$form = $this->model('tbs/input_forms')->get_by_id($form_id);
					$noti_body = 'El formulario de ingreso <b>#'.$form_id.'</b> fue Rechazado por @'.$_SESSION['user']['username'];
					$this->model('tbs/notifications')->create('cancel', $noti_body, 1);

				}else{
					//$this->model('tbs/input_forms_verify')->delete($form_id);
					$this->model('tbs/input_forms_logs')->create($form_id, 3);
					$this->model('tbs/input_forms')->approve($form_id);
					if ($data['input_form']['transport_type_id']==7) {
						foreach ($data['input_forms_products'] as $product) {
							$this->model('tbs/warehouses')->create_stock($product['product_id'], 1, $form_id, $product['quantity']);
						}
						$this->model('tbs/input_forms')->execute($form_id);
						$this->model('tbs/input_forms_logs')->create($form_id, 5);
					}else{
						foreach ($data['input_forms_products'] as $product) {
							$this->model('tbs/warehouses')->create($product, 1);
						}
					}

					//Crear notificación
					$form = $this->model('tbs/input_forms')->get_by_id($form_id);
					$noti_body = 'El formulario de ingreso <b>#'.$form_id.'</b> fue aprobado por @'.$_SESSION['user']['username'];
					$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);

				}
			}
			
			redirect("tbs/input_forms/");
		}

		$this->view('verify', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	RECUPERAR
----------------------------------------------------------------------*/

	public function recover(){
		if ($this->model('tbs/input_forms')->recover($_GET['id'])) {
			$this->model('tbs/input_forms_logs')->create($_GET['id'], 8);
			redirect("tbs/input_forms/details?id=".$_GET['id']);
		}else{
			set_notification('No se pudo regresar el formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	CANCEL
----------------------------------------------------------------------*/

	public function cancel(){

		if ($this->model('tbs/input_forms')->cancel($_GET['id'])) {
			$this->model('tbs/input_forms_logs')->create($_GET['id'], 13);

			$products = $this->model('tbs/input_forms_products')->get_with_warehouse_id($_GET['id']);
			
			foreach ($products as $product) {
				$this->model('tbs/warehouses')->from_virtual_to_scale_difference($product['wid'], $product['virtual']);	
			}

			redirect("tbs/input_forms/details?id=".$_GET['id']);
		}else{
			set_notification('No se pudo regresar el formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	liberate
----------------------------------------------------------------------*/

	public function liberate(){

		$last_state = $this->model('tbs/input_forms_logs')->get_last($_GET['id']);

		if ($this->model('tbs/input_forms')->liberate($_GET['id'], $last_state['form_state_id'])) {
			
			set_notification('Formulario Liberado');
		}else{
			set_notification('No se pudo regresar el formulario', 'error');
		}

		redirect("tbs/input_forms/details?id=".$_GET['id']);
	}

/*----------------------------------------------------------------------
	Trick#1: Pasa a virtual productos que aún no lo están
----------------------------------------------------------------------*/
	public function trick_1(){
		$data['input_forms_products'] = $this->model('tbs/input_forms_products')->get_by_form_id($_GET['id']);
		$inserted = $this->model('tbs/input_forms_products')->get_with_warehouse_id($_GET['id']);

		$to_insert = array();
		foreach ($data['input_forms_products'] as $product) {
			$insert = TRUE;
			foreach ($inserted as $pi) {
				if ($pi['product_id']==$product['product_id']) {
					$insert = FALSE;
				}
			}

			if ($insert) {
				array_push($to_insert, $product);
			}
		}

		foreach ($to_insert as $product) {
			$this->model('tbs/warehouses')->create($product, 1);
		}

		$count = count($to_insert);
		set_notification('Done! '.$count.' products created in warehouse');
		redirect("tbs/input_forms/details?id=".$_GET['id']);
	}

/*----------------------------------------------------------------------
	EXECUTE
----------------------------------------------------------------------*/
	public function execute()
	{
		error_reporting(E_ALL);
		$input_form = $this->model('tbs/input_forms')->get_by_id($_GET['id']);

		$products = $this->model('tbs/input_forms_products')->get_by_form_id_approved($_GET['id']);

		$products_in_transit = 0;

		foreach ($products as $product) {
			if ($product['packaging_id']==48) {
				$products_in_transit += $product['virtual_reserved'];
			}else{
				$products_in_transit += $product['virtual_reserved']+$product['locked'];
			}
		}

		if ($products_in_transit>0) {
			set_notification('Aún hay productos en virtual_reserved o bloqueado', 'error');
			redirect("tbs/input_forms/details?id=".$_GET['id']);
		}else{
			foreach ($products as $product) {
				if ($product['packaging_id']==48) {
					if ($product['locked']>0) {
						$this->model('tbs/warehouses')->move_all_from_locked_to_stock($product['wid']);
						set_notification($product['locked'].' pasó a stock', 'info');

						$this->model('tbs/warehouses')->move_all_to_scale_difference($product['wid']);
						set_notification($product['virtual'].' pasó a diferencia en báscula', 'info');
					}else{
						$this->model('tbs/warehouses')->move_all_to_scale_difference($product['wid']);
						set_notification($product['virtual'].' pasó a diferencia en báscula', 'info');
					}
				}else{
					if ($product['inspected_to_input']>0) {
						$this->model('tbs/warehouses')->from_inspected_to_input_to_stock($product['wid'], $product['quantity']);
						set_notification($product['inspected_to_input'].' pasó a stock', 'info');
					
						$this->model('tbs/warehouses')->move_all_to_scale_difference($product['wid']);
						set_notification($product['virtual'].' pasó a diferencia en báscula', 'info');
					}else{
						$this->model('tbs/warehouses')->move_all_to_scale_difference($product['wid']);
						set_notification($product['virtual'].' pasó a diferencia en báscula', 'info');
					}
				}
			}

			$transport = $this->model('tbs/transport_input_forms_products')->get_last_transport($_GET['id']);

			$this->model('tbs/input_forms')->execute_at($_GET['id'], $transport['approved_at'], $_SESSION['user']['user_id']);
			$this->model('tbs/input_forms_logs')->create_at($_GET['id'], 5, $transport['approved_at'], $_SESSION['user']['user_id']);

			set_notification('Se ejecutó el formulario correctamente');
			redirect("tbs/input_forms/details?id=".$_GET['id']);
		}

		//$this->view('', $data);
	}


/*----------------------------------------------------------------------
	PRINTOUT
----------------------------------------------------------------------*/
	public function printout()
	{
		$input_form = $this->model('tbs/input_forms')->get_by_id($_GET['id']);

		data('input_forms_supports', $this->model('tbs/input_forms_supports')->get_by_form_id($_GET['id']));
		data('transports', $this->model('tbs/transport_input_forms')->get_transports_by_form_approved($_GET['id']));
		data('forms_adjustments', $this->model('tbs/forms_adjustments')->get_by_form_id($_GET['id'], 1));
		if ($input_form['form_state_id']==5) {
			data('input_forms_products', $this->model('tbs/input_forms_products')->get_by_form_id_approved($_GET['id']));
		}else{
			data('input_forms_products', $this->model('tbs/input_forms_products')->get_by_form_id($_GET['id']));
		}

		data('input_form', $this->model('tbs/input_forms')->get_by_id($_GET['id']));
		render('flat');
	}

}
