<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		//$data['output_forms'] = $this->model('tbs/output_forms')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	TEMPORARY OUTPUTS
----------------------------------------------------------------------*/
	public function temporary()
	{
		$data['temporary_forms'] = $this->model('tbs/output_forms')->get_all_temporary();

		$this->view('', $data);
	}

/*----------------------------------------------------------------------
	TEMPORARY RETURNS
----------------------------------------------------------------------*/
	public function re_enter()
	{
		error_reporting(E_ALL);

		$output_forms_products = $this->model('tbs/output_forms_products')->get_by_form_id($_POST['form_id']);

		foreach ($output_forms_products as $product) {
			$this->model('tbs/warehouses')->from_dispatched_to_stock($product['warehouse_id'], $product['quantity']);
		}

		$output_form = $this->model('tbs/output_forms')->get_by_id($_POST['form_id']);

		$new_obs = $output_form['observations'];
		$new_obs = $new_obs.'\n\n REINGRESO:\n\n '.$_POST['observations'];

		$this->model('tbs/output_forms')->add_observation($_POST['form_id'], $new_obs);
		$this->model('tbs/output_forms_logs')->create($_POST['form_id'], 15);

		redirect("tbs/output_forms/temporary", 'Productos Reingresados');

		$this->view('', $data);
	}

/*----------------------------------------------------------------------
	RECUPERAR
----------------------------------------------------------------------*/

	public function recover(){
		if ($this->model('tbs/output_forms')->recover($_GET['id'])) {
			redirect("tbs/output_forms/details?id=".$_GET['id'], 'Formulario Recuperado');
		}else{
			set_notification('No se pudo recuperar el formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	CAMBIAR TIPO
----------------------------------------------------------------------*/

	public function change_type(){
		if ($this->model('tbs/output_forms')->change_type($_GET['id'])) {

			//Crear notificación
			$form = $this->model('tbs/output_forms')->get_by_id($_GET['id']);
			$noti_body = 'El usuario @'.$form['created_by_user'].' solicitó un cambio de tipo para el formulario de salida <b>#'.$_GET['id'].'</b> ';
			$this->model('tbs/notifications')->create('loop4', $noti_body, 1);

			$this->model('tbs/output_forms_logs')->create($_GET['id'], 10);
			redirect("tbs/output_forms/details?id={$_GET['id']}", 'Formulario Presentado');

			redirect("tbs/output_forms/details?id=".$_GET['id'], 'Solicitud Enviada');
		}else{
			set_notification('Error', 'error');
		}
	}

/*----------------------------------------------------------------------
	RECHAZAR
----------------------------------------------------------------------*/

	public function reject(){
		if ($this->model('tbs/input_forms')->return_presented($_GET['id'])) {
			redirect("tbs/input_forms/details?id=".$_GET['id']);
		}else{
			set_notification('No se pudo rechazar el formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['output_forms_transactions'] = $this->model('tbs/output_forms_transactions')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['exchange_rate'] = $this->model('tbs/exchange_rate')->get();

		if ($_POST)
		{
			if ($last_id = $this->model('tbs/output_forms')->create($_POST)) 
			{
				$this->model('tbs/output_forms_logs')->create($last_id, 1);
				redirect("tbs/output_forms/details?id=$last_id");
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
		if ($this->model('tbs/output_forms')->present($_GET['id'])) 
		{
			//Crear notificación
			$form = $this->model('tbs/output_forms')->get_by_id($_GET['id']);
			$noti_body = 'El formulario de salida <b>#'.$_GET['id'].'</b> fue presentado por @'.$form['created_by_user'];
			$this->model('tbs/notifications')->create('file-text', $noti_body);

			$this->model('tbs/output_forms_logs')->create($_GET['id'], 2);
			redirect("tbs/output_forms/details?id={$_GET['id']}", 'Formulario Presentado');
		}
		else
		{
			redirect("tbs/output_forms/details?id={$_GET['id']}", 'No se pudo presentar el Formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['output_form'] = $this->model('tbs/output_forms')->get_by_id($_GET['id']);

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['packaging'] = $this->model('tbs/packaging')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['output_forms_transactions'] = $this->model('tbs/output_forms_transactions')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all_in_stock();
		$data['output_forms_supports'] = $this->model('tbs/output_forms_supports')->get_by_form_id($_GET['id']);
		$data['output_forms_products'] = $this->model('tbs/output_forms_products')->get_by_form_id($_GET['id']);
		$data['output_forms_verify'] = $this->model('tbs/output_forms_verify')->get_by_form_id($_GET['id']);

		if ($_POST)
		{
			$_POST['output_form_id'] = $_GET['id'];

			if ($this->model('tbs/output_forms')->edit($_POST)) 
			{
				$form = $data['output_form'];
				$form_id = $_GET['id'];
				if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
					if ($_SESSION['master_mode']==0) {
						foreach ($_POST as $key => $value) {
							foreach ($form as $key2 => $value2) {
								if ($key==$key2) {
									if ($value!=$value2) {

										$adjustment = array();
										$adjustment['form_type'] = 2; //Salida
										$adjustment['form_id'] = $form_id;
										$adjustment['field_type'] = 0; //Info general
										$adjustment['field_name'] = $key; 
										$adjustment['field_id'] = 0;
										$adjustment['old_value'] = $value2;
										$adjustment['new_value'] = $value;

										//Guardo un ajuste de lo que se hizo
										$this->model('tbs/forms_adjustments')->create($adjustment);
									}
								}
							}
						}
					}
				}else{

					if (count($data['output_forms_verify'])!=0) {

						$verify = $this->model('tbs/output_forms_verify')->get_top($_GET['id'], 1, 0, $_POST['field_names'][$i]);

							if (count($verify)>0) {
								if ($verify['field_value_new']!='') {
									$this->model('tbs/output_forms_verify')->update_all_values($verify['id'], $_POST['field_values'][$i]);
								}else{
									$this->model('tbs/output_forms_verify')->update_value($verify['id'], $_POST['field_values'][$i]);
								}
							}else{
								$this->model('tbs/output_forms_verify')->create($_GET['id'], 1, 0, $_POST['field_names'][$i], $_POST['field_values'][$i]);
							}
							
					}
				}
				
				//Crear LOG de modificado
				//$this->model('tbs/output_forms_logs')->create($_GET['id'], 6);
				redirect("tbs/output_forms/details?id=".$_GET['id']);
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
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
		$data['output_forms_transactions'] = $this->model('tbs/output_forms_transactions')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();
		$data['output_forms_supports'] = $this->model('tbs/output_forms_supports')->get_by_form_id($_GET['id']);
		$data['output_forms_products'] = $this->model('tbs/output_forms_products')->get_by_form_id($_GET['id']);
		$data['output_forms_verify'] = $this->model('tbs/output_forms_verify')->get_by_form_id($_GET['id']);
		$data['logs'] = $this->model('tbs/output_forms_logs')->get_by_form_id($_GET['id']);
		
		$errors = count($data['output_forms_verify']);
		if ($errors>0) {
			set_notification('Se encontraron campos por revisar en el formulario.', 'info');
		}

		$data['output_form'] = $this->model('tbs/output_forms')->get_by_id($_GET['id']);

		$this->view('details', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	VERIFY
----------------------------------------------------------------------*/
	public function verify()
	{
		$data['output_form'] = $this->model('tbs/output_forms')->get_by_id($_GET['id']);

		if ($data['output_form']['form_state_id']==14) {
			if ($_SESSION['user']['id']!=$data['output_form']['updated_by']) {
				set_notification('Este formulario está siendo revisado', 'info');
				redirect('tbs/output_forms/');
			}
		}else if ($data['output_form']['form_state_id']==3 OR $data['output_form']['form_state_id']==5) {
				set_notification('Este formulario ya fue aprobado y/o ejecutado', 'info');
				redirect("tbs/output_forms/");
		}else{
			$this->model('tbs/output_forms')->set_in_review($_GET['id']);
		}
		
		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['packaging'] = $this->model('tbs/packaging')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['output_forms_transactions'] = $this->model('tbs/output_forms_transactions')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();
		$data['output_forms_supports'] = $this->model('tbs/output_forms_supports')->get_by_form_id($_GET['id']);
		$data['output_forms_products'] = $this->model('tbs/output_forms_products')->get_by_form_id($_GET['id']);
		$data['output_forms_verify'] = $this->model('tbs/output_forms_verify')->get_by_form_id($_GET['id']);
		$log = $this->model('tbs/output_forms_logs')->get_last($_GET['id']);

		if ($_POST)
		{
			$of = $this->model('tbs/output_forms')->get_by_id($_GET['id']);
			
			if ($of['form_state_id']==3 OR $of['form_state_id']==5) {
				set_notification('Este formulario ya fue aprobado y/o ejecutado', 'info');
				redirect("tbs/output_forms/");
			}
				$form_id = $_POST['form_id'];
				$bad_fields = $_POST['bad_fields'];

				if ($_POST['comment']!='') {
					$this->model('tbs/output_forms_logs')->create($form_id, 4);
					$this->model('tbs/output_forms')->return_presented($form_id);

					//Crear notificación
					$form = $this->model('tbs/output_forms')->get_by_id($form_id);
					$noti_body = 'El formulario de salida <b>#'.$form_id.'</b> fue Rechazado por la siguiente razón: '.$_POST['comment'];
					$this->model('tbs/notifications')->create('cancel', $noti_body, 1);
				}else{
					if (count($bad_fields)!=0) {

						//$this->model('tbs/output_forms_verify')->delete($form_id);

						foreach ($bad_fields as $bf) {
							$fields = explode("#/", $bf);

							$this->model('tbs/output_forms_verify')->create($form_id, $fields[0], $fields[1], $fields[2], $fields[3]);
							
						}

						$this->model('tbs/output_forms_logs')->create($form_id, 4);
						$this->model('tbs/output_forms')->return_presented($form_id);

						//Crear notificación
						$form = $this->model('tbs/output_forms')->get_by_id($form_id);
						$noti_body = 'El formulario de salida <b>#'.$form_id.'</b> fue rechazado por @'.$_SESSION['user']['username'];
						$this->model('tbs/notifications')->create('cancel', $noti_body, 1);
					}else{
						//$this->model('tbs/output_forms_verify')->delete($form_id);
						$output_form = $data['output_form'];
						if ($log['form_state_id']!=10) {
							//Aprueba
							$this->model('tbs/output_forms_logs')->create($form_id, 3);
							$this->model('tbs/output_forms')->approve($form_id);
							
							$to_dispatched = FALSE;

							if ($data['output_form']['transport_type_id']==7) {
								$to_dispatched = TRUE;
							}

							if ($data['output_form']['transaction_code']==426) {
								$to_dispatched = TRUE;
							}

							if ($to_dispatched) {
								foreach ($data['output_forms_products'] as $product) {
									$this->model('tbs/warehouses')->from_reserved_to_dispatched($product['warehouse_id'], $product['quantity']);
								}

								//Ejecuta
								$this->model('tbs/output_forms_logs')->create($form_id, 5);
								$this->model('tbs/output_forms')->execute($form_id);

							}else{
								foreach ($data['output_forms_products'] as $product) {
									$to_inspected = FALSE;

									if ($data['output_form']['transport_type_id']==3) {
										if ($product['packaging_id']==48) {
											$to_inspected = TRUE;
										}
									}
									
									if ($to_inspected) {
										$this->model('tbs/warehouses')->from_reserved_to_inspected_to_output($product['warehouse_id'], $product['quantity']);
									}else{
										$double_check =  $this->model('tbs/output_forms_products')->get_by_id($product['ofp_id']);

										if ($double_check['reserved']>0) {
											$this->model('tbs/warehouses')->from_reserved_to_approved($product['warehouse_id'], $product['quantity']);
										}
									}
								}
							}

							//Crear notificación
							$form = $this->model('tbs/output_forms')->get_by_id($form_id);
							$noti_body = 'El formulario de salida <b>#'.$form_id.'</b> fue aprobado por @'.$_SESSION['user']['username'];
							$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);
						}else{
							//Cambia Tipo
							foreach ($data['output_forms_products'] as $product) {
								
								if($_SESSION['user']['company_id']=='900162578'){

									//Mover Saldo a Nacionaliado
									$this->model('tbs/warehouses')->from_reserved_to_nationalized($product['warehouse_id'], $product['quantity']);

									//Crear producto nuevo con tipo nacionalizado
									$new_product_id = $this->model('tbs/products')->create_from_nationalized($product['product'], $product['interface_code'], 4 , $product['tariff_heading_id'], $product['physical_unit_id']);

									//Crea registro en nationalized_forms_products
									$this->model('tbs/nationalized_forms_products')->create($form_id, $product['warehouse_id'], $product['quantity']);

									if ($_POST['only_change_type']==1) {
										//Crea producto en almacen y pone saldo en reservado
										$new_warehouse_id = $this->model('tbs/warehouses')->create_stock($new_product_id, 4, $form_id, $product['reserved']);
									}else{
										//Crea producto en almacen y pone saldo en reservado
										$new_warehouse_id = $this->model('tbs/warehouses')->create_reserved($new_product_id, 4, $form_id, $product['reserved']);
									}

									//Eliminar producto viejo del formulario de salida
									$this->model('tbs/output_forms_products')->delete($product['ofp_id']);

									$nop = array();
									$nop['output_form_id'] = $product['output_form_id'];
									$nop['warehouse_id'] = $new_warehouse_id;
									$nop['tariff_heading_id'] = $product['tariff_heading_id'];
									$nop['product_category_id'] = $product['product_category_id'];
									$nop['quantity'] = str_replace(',', '.', $product['quantity']);
									$nop['commercial_quantity'] = str_replace(',', '.', $product['commercial_quantity']);
									$nop['packages_quantity'] = $product['packages_quantity'];
									$nop['fob_value'] = str_replace(',', '.', $product['fob_value']);
									$nop['net_weight'] = str_replace(',', '.', $product['net_weight']);
									$nop['gross_weight'] = str_replace(',', '.', $product['gross_weight']);
									$nop['freights'] = str_replace(',', '.', $product['freights']);
									$nop['packaging_id'] = $product['packaging_id'];
									$nop['insurance'] = str_replace(',', '.', $product['insurance']);
									$nop['other_expenses'] =str_replace(',', '.', $product['other_expenses']);
									$nop['flag_id'] = $product['flag_id'];

									//print_r($nop);

									//Agregar producto nuevo al formulario de salida
									$this->model('tbs/output_forms_products')->create($nop);
								}
							}

							if ($_POST['only_change_type']==0) {
								$this->model('tbs/output_forms_logs')->create($form_id, 11);
								$this->model('tbs/output_forms')->approve_change_type($form_id);

								//Crear notificación
								$form = $this->model('tbs/output_forms')->get_by_id($form_id);
								$noti_body = 'El cambio de tipo del formulario de salida <b>#'.$form_id.'</b> fue aprobado por @'.$_SESSION['user']['username'];
								$this->model('tbs/notifications')->create('loop4', $noti_body, 1);
							}else{
								$this->model('tbs/output_forms_logs')->create($form_id, 3);
								$this->model('tbs/output_forms')->approve($form_id);
								$this->model('tbs/output_forms_logs')->create($form_id, 5);
								$this->model('tbs/output_forms')->execute($form_id);

								//Crear notificación
								$form = $this->model('tbs/output_forms')->get_by_id($form_id);
								$noti_body = 'El cambio de tipo INTERNO del formulario de salida <b>#'.$form_id.'</b> fue aprobado y ejecutado por @'.$_SESSION['user']['username'];
								$this->model('tbs/notifications')->create('loop4', $noti_body, 1);
							}
						}
					}
				}

			redirect("tbs/output_forms/");
		}

		$this->view('verify', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	liberate
----------------------------------------------------------------------*/

	public function liberate(){

		$last_state = $this->model('tbs/output_forms_logs')->get_last($_GET['id']);

		if ($this->model('tbs/output_forms')->liberate($_GET['id'], $last_state['form_state_id'])) {
			
			set_notification('Formulario Liberado');
		}else{
			set_notification('No se pudo regresar el formulario', 'error');
		}

		redirect("tbs/output_forms/details?id=".$_GET['id']);
	}

/*----------------------------------------------------------------------
	PRINTOUT
----------------------------------------------------------------------*/
	public function printout()
	{
		data('output_forms_supports', $this->model('tbs/output_forms_supports')->get_by_form_id($_GET['id']));
		data('output_forms_products', $this->model('tbs/output_forms_products')->get_by_form_id($_GET['id']));
		data('forms_adjustments', $this->model('tbs/forms_adjustments')->get_by_form_id($_GET['id'], 2));
		data('output_form', $this->model('tbs/output_forms')->get_by_id($_GET['id']));
		
		render('flat');
	}

}
