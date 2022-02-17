<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['transformation_forms'] = $this->model('tbs/transformation_forms')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	RETURN
----------------------------------------------------------------------*/
	public function recover()
	{
		if ($this->model('tbs/transformation_forms')->return_presented($_GET['id'])) {
			redirect("tbs/transformation_forms/details?id=".$_GET['id']);
		}else{
			set_notification('No se pudo recuperar el formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST) {
			$man_power = $_POST['man_power'];
			$utility = $_POST['utility'];
			$direct_cost = $_POST['direct_cost'];

			if ($last_id = $this->model('tbs/transformation_forms')->create($man_power, $utility, $direct_cost))
			{
				//echo '<pre>'.print_r($last_id, TRUE).'</pre>';
				//die();
				$this->model('tbs/transformation_forms_logs')->create($last_id, 1);
				redirect("tbs/transformation_forms/details?id=$last_id");
			}
			else
			{
				redirect('', 'Ocurrió un error', 'error');
			}
		}

		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	PRESENT
----------------------------------------------------------------------*/
	public function present()
	{
		if ($this->model('tbs/transformation_forms')->present($_GET['id']))
		{
			//Crear notificación
			$form = $this->model('tbs/transformation_forms')->get_by_id($_GET['id']);
			$noti_body = 'El formulario de transformación <b>#'.$_GET['id'].'</b> fue presentado por @'.$form['created_by_user'];
			$this->model('tbs/notifications')->create('file-text', $noti_body);

			$this->model('tbs/transformation_forms_logs')->create($_GET['id'], 2);
			redirect("tbs/transformation_forms/details?id={$_GET['id']}", 'Formulario Presentado');
		}
		else
		{
			redirect("tbs/transformation_forms/details?id={$_GET['id']}", 'No se pudo presentar el Formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['transformation_form'] = $this->model('tbs/transformation_forms')->get_by_id($_GET['id']);

		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();
		$data['transformation_forms_products'] = $this->model('tbs/transformation_forms_products')->get_by_form_id($_GET['id']);
		$data['transformation_forms_verify'] = $this->model('tbs/transformation_forms_verify')->get_by_form_id($_GET['id']);

		if ($_POST)
		{
			$_POST['transformation_form_id'] = $_GET['id'];

			if ($this->model('tbs/transformation_forms')->edit($_POST))
			{
				$form = $this->model('tbs/transformation_forms')->get_by_id($_GET['form_id']);
				$form_id = $_GET['form_id'];
				if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
							if ($_SESSION['master_mode']==0) {
								foreach ($_POST as $key => $value) {
									foreach ($form as $key2 => $value2) {
										if ($key==$key2) {
											if ($value!=$value2) {

												$adjustment = array();
												$adjustment['form_type'] = 3; //Salida
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
					if (count($data['transformation_forms_verify'])!=0) {
						for($i=0; $i < count($_POST['field_names']); $i++){

							$verify = $this->model('tbs/transformation_forms_verify')->get_top($_GET['id'], 1, 0, $_POST['field_names'][$i]);

							if (count($verify)>0) {
								if ($verify['field_value_new']!='') {
									$this->model('tbs/transformation_forms_verify')->update_all_values($verify['id'], $_POST['field_values'][$i]);
								}else{
									$this->model('tbs/transformation_forms_verify')->update_value($verify['id'], $_POST['field_values'][$i]);
								}
							}else{
								$this->model('tbs/transformation_forms_verify')->create($_GET['id'], 1, 0, $_POST['field_names'][$i], $_POST['field_values'][$i]);
							}

						}
					}
				}

				//Crear LOG de modificado
				$this->model('tbs/transformation_forms_logs')->create($_GET['id'], 6);
				redirect("tbs/transformation_forms/details?id={$_GET['id']}", 'Editado Correctamente');
			}
			else
			{
				redirect("tbs/transformation_forms/edit?id={$_GET['id']}", 'Ocurrió un Error al editar', 'error');
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
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();
		$data['transformation_forms_products'] = $this->model('tbs/transformation_forms_products')->get_by_form_id($_GET['id']);
		$data['transformation_forms_consumables'] = $this->model('tbs/transformation_forms_consumables')->get_by_form_id($_GET['id']);
		$data['transformation_forms_supports'] = $this->model('tbs/transformation_forms_supports')->get_by_form_id($_GET['id']);
		$data['logs'] = $this->model('tbs/transformation_forms_logs')->get_by_form_id($_GET['id']);
		$data['transformation_forms_verify'] = $this->model('tbs/transformation_forms_verify')->get_by_form_id($_GET['id']);

		$errors = count($data['transformation_forms_verify']);
		if ($errors>0) {
			set_notification('Se encontraron campos por revisar en el formulario.', 'info');
		}

		$data['transformation_form'] = $this->model('tbs/transformation_forms')->get_by_id($_GET['id']);

		$this->view('details', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	VERIFY
----------------------------------------------------------------------*/
	public function verify()
	{
		$data['transformation_form'] = $this->model('tbs/transformation_forms')->get_by_id($_GET['id']);

		if ($data['transformation_form']['form_state_id']==14) {
			if ($_SESSION['user']['id']!=$data['transformation_form']['updated_by']) {
				set_notification('Este formulario está siendo revisado', 'info');
			}
		}else if ($data['transformation_form']['form_state_id']==3 OR $data['transformation_form']['form_state_id']==5) {
				set_notification('Este formulario ya fue aprobado y/o ejecutado', 'info');
				redirect("tbs/transformation_forms/");
		}else{
			$this->model('tbs/transformation_forms')->set_in_review($_GET['id']);
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();
		$data['transformation_forms_products'] = $this->model('tbs/transformation_forms_products')->get_by_form_id($_GET['id']);
		$data['transformation_forms_consumables'] = $this->model('tbs/transformation_forms_consumables')->get_by_form_id($_GET['id']);
		$data['transformation_forms_supports'] = $this->model('tbs/transformation_forms_supports')->get_by_form_id($_GET['id']);
		$data['logs'] = $this->model('tbs/transformation_forms_logs')->get_by_form_id($_GET['id']);
		$data['transformation_forms_verify'] = $this->model('tbs/transformation_forms_verify')->get_by_form_id($_GET['id']);		

		if ($_POST)
		{
			$form = $this->model('tbs/transformation_forms')->get_by_id($_GET['id']);

			if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
				set_notification('Este formulario ya fue aprobado y/o ejecutado');
				redirect("tbs/transformation_forms/");
			}
			
				$form_id = $_POST['form_id'];
				$bad_fields = $_POST['bad_fields'];

				if ($_POST['comment']!='') {
					$this->model('tbs/transformation_forms_logs')->create($form_id, 4);
					$this->model('tbs/transformation_forms')->return_presented($form_id);

					//Crear notificación
					$form = $this->model('tbs/output_forms')->get_by_id($form_id);
					$noti_body = 'El formulario de salida <b>#'.$form_id.'</b> fue Rechazado por la siguiente razón: '.$_POST['comment'];
					$this->model('tbs/notifications')->create('cancel', $noti_body, 1);
				}else{
					if (count($bad_fields)!=0) {

						//$this->model('tbs/transformation_forms_verify')->delete($form_id);

						foreach ($bad_fields as $bf) {
							$fields = explode("#/", $bf);

							$this->model('tbs/transformation_forms_verify')->create($form_id, $fields[0], $fields[1], $fields[2], $fields[3]);

						}

						$this->model('tbs/transformation_forms_logs')->create($form_id, 4);
						$this->model('tbs/transformation_forms')->reject($form_id);

						//Crear notificación
						$form = $this->model('tbs/transformation_forms')->get_by_id($form_id);
						$noti_body = 'El formulario de transformación <b>#'.$form_id.'</b> fue rechazado por @'.$form['created_by'];
						$this->model('tbs/notifications')->create('cancel', $noti_body, $form['created_by']);

					}else{
						//$this->model('tbs/transformation_forms_verify')->delete($form_id);

						foreach ($data['transformation_forms_products'] as $product) {
							$ware = $this->model('tbs/warehouses')->get_by_id($product['warehouse_id']);

							$this->model('tbs/warehouses')->create_stock($ware['product_id'], 2, $form_id, $product['quantity']);
						}

						foreach ($data['transformation_forms_consumables'] as $consumable)
						{
							$quantity = str_replace(',', '.', $consumable['quantity']);
							$waste = str_replace(',', '.', $consumable['waste']);

							$this->model('tbs/warehouses')->from_reserved_to_dispatched($consumable['warehouse_id'], $quantity, $waste);
						}


						$this->model('tbs/transformation_forms_logs')->create($form_id, 3);
						$this->model('tbs/transformation_forms')->approve($form_id);

						//Crear notificación
						$form = $this->model('tbs/transformation_forms')->get_by_id($form_id);
						$noti_body = 'El formulario de transformación <b>#'.$form_id.'</b> fue aprobado por @'.$form['created_by'];
						$this->model('tbs/notifications')->create('checkmark', $noti_body, $form['created_by']);
					}
				}

			redirect("tbs/transformation_forms/");
		}

		$this->view('verify', $data, 'fullwidth');
	}


/*----------------------------------------------------------------------
	liberate
----------------------------------------------------------------------*/

	public function liberate(){

		$last_state = $this->model('tbs/transformation_forms_logs')->get_last($_GET['id']);

		if ($this->model('tbs/transformation_forms')->liberate($_GET['id'], $last_state['form_state_id'])) {
			
			set_notification('Formulario Liberado');
		}else{
			set_notification('No se pudo regresar el formulario', 'error');
		}

		redirect("tbs/transformation_forms/details?id=".$_GET['id']);
	}


/*----------------------------------------------------------------------
	PRINTOUT
----------------------------------------------------------------------*/
	public function printout()
	{
		data('transformation_forms_supports', $this->model('tbs/transformation_forms_supports')->get_by_form_id($_GET['id']));
		data('transformation_forms_products', $this->model('tbs/transformation_forms_products')->get_by_form_id($_GET['id']));
		data('transformation_forms_consumables', $this->model('tbs/transformation_forms_consumables')->get_by_form_id($_GET['id']));
		data('forms_adjustments', $this->model('tbs/forms_adjustments')->get_by_form_id($_GET['id'], 3));
		data('transformation_form', $this->model('tbs/transformation_forms')->get_by_id($_GET['id']));

		render('flat');
	}

}
