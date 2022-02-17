<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
	----------------------------------------------------------------------*/
	public function index()
	{
		$this->view('', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	PRESENT
	----------------------------------------------------------------------*/
	public function present()
	{
		$products = $this->model('tbs/transport_input_forms_products')->get_by_form_id($_GET['id']);

		foreach ($products as $product) {
			if ($product['quantity']<=0) {
				set_notification('Hay productos con cantidad en 0', 'error');
				redirect("tbs/transport_input_forms/details?id={$_GET['id']}");
			}
		}

		if ($this->model('tbs/transport_input_forms')->present($_GET['id'])) 
		{
			//Crear notificación
			$form = $this->model('tbs/transport_input_forms')->get_by_id($_GET['id']);
			$noti_body = 'El pase de ingreso <b>#'.$_GET['id'].'</b> fue presentado por @'.$form['created_by_user'];
			$this->model('tbs/notifications')->create('file-text', $noti_body);

			$this->model('tbs/transport_input_forms_logs')->create($_GET['id'], 2);
			redirect("tbs/transport_input_forms/details?id={$_GET['id']}", 'Formulario Presentado');
		}
		else
		{
			redirect("tbs/input_forms/details?id={$_GET['id']}", 'No se pudo presentar el Formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	SET WEIGHT
----------------------------------------------------------------------*/
	public function set_weight(){
		if ($_POST['type']==1) {
			
			if ($this->model('tbs/transport_input_forms')->set_starting_weight($_POST['weight'], $_POST['form_id'])) {

				redirect_back('Peso de entrada registrado');
			}else{
				redirect_back('Ocurrió un error', 'error');
			}
		}else{
			if ($this->model('tbs/transport_input_forms')->set_ending_weight($_POST['weight'], $_POST['form_id'])) {

				redirect_back('Peso de sálida registrado');
			}else{
				redirect_back('Ocurrió un error', 'error');
			}
		}

		redirect("tbs/input_forms/details?id={$_GET['id']}", 'No se pudo presentar el Formulario', 'error');
	}

/*----------------------------------------------------------------------
	SET LAST TRUCK
	----------------------------------------------------------------------*/
	public function set_last_truck(){
		
		if ($this->model('tbs/transport_input_forms')->set_is_last_truck($_GET['form_id'], $_GET['value'])) {

			redirect_back();
		}else{
			redirect_back('Ocurrió un error', 'error');
		}
	}

	public function set_quantity(){
		if ($this->model('tbs/transport_input_forms')->set_quantity_manifested($_POST['quantity'], $_POST['form_id'])) {

			redirect_back('Cantidad registrada');
		}else{
			redirect_back('Ocurrió un error', 'error');
		}
	}

/*----------------------------------------------------------------------
	DETAILS
----------------------------------------------------------------------*/
	public function details()
	{
		$data['transport_input_forms_products'] = $this->model('tbs/transport_input_forms_products')->get_by_form_id($_GET['id']);
		$data['transport_input_forms_verify'] = $this->model('tbs/transport_input_forms_verify')->get_by_form_id($_GET['id']);
		$data['transport_input_forms_supports'] = $this->model('tbs/transport_input_forms_supports')->get_by_form_id($_GET['id']);
		$data['logs'] = $this->model('tbs/transport_input_forms_logs')->get_by_form_id($_GET['id']);
		$data['products'] = $this->model('tbs/products')->get_all_in_virtual();
		$data['drivers'] = $this->model('tbs/drivers')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();

		$data['transport_input_form'] = $this->model('tbs/transport_input_forms')->get_by_id($_GET['id']);

		$errors = count($data['transport_input_forms_verify']);
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
			if ($last_id = $this->model('tbs/transport_input_forms')->create($_POST)) 
			{
				$this->model('tbs/transport_input_forms_logs')->create($last_id, 1);

				redirect("tbs/transport_input_forms/details?id=$last_id");
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
			}
		}
		
		$data['drivers'] = $this->model('tbs/drivers')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();

		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	VERIFY
	----------------------------------------------------------------------*/
	public function verify()
	{
		
		$data['transport_input_forms_products'] = $this->model('tbs/transport_input_forms_products')->get_by_form_id($_GET['id']);
		$data['transport_input_forms_verify'] = $this->model('tbs/transport_input_forms_verify')->get_by_form_id($_GET['id']);
		$data['transport_input_forms_supports'] = $this->model('tbs/transport_input_forms_supports')->get_by_form_id($_GET['id']);
		$data['drivers'] = $this->model('tbs/drivers')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();

		$data['transport_input_form'] = $this->model('tbs/transport_input_forms')->get_by_id($_GET['id']);

		if ($data['transport_input_form']['form_state_id']==14) {
			if ($_SESSION['user']['id']!=$data['transport_input_form']['updated_by']) {
				set_notification('Este formulario está siendo revisado', 'info');
				redirect("tbs/transport_output_forms/");
			}
		}else if ($data['transport_input_form']['form_state_id']==3) {
				set_notification('Este pase ya fue aprobado', 'info');
				redirect("tbs/transport_input_forms/");
		}

		//error_reporting(E_ALL);
		//ini_set('display_errors', 'On');
		
		if ($_POST)
		{
			$form = $this->model('tbs/transport_input_forms')->get_by_id($_GET['id']);

			if ($form['form_state_id']==3) {
				set_notification('Este pase ya fue aprobado');
				redirect("tbs/transport_input_forms/");
			}

			$form_id = $_POST['form_id'];
			$bad_fields = $_POST['bad_fields'];

			if (count($bad_fields)!=0) {

				//$this->model('tbs/transport_input_forms_verify')->delete($form_id);

				foreach ($bad_fields as $bf) {
					$fields = explode("-", $bf);
					
					$this->model('tbs/transport_input_forms_verify')->create($form_id, $fields[0], $fields[1], $fields[2]);
					
				}

				$this->model('tbs/transport_input_forms_logs')->create($form_id, 4);
				$this->model('tbs/transport_input_forms')->return_presented($form_id);

				//Crear notificación
				$form = $this->model('tbs/transport_input_forms')->get_by_id($form_id);
				$noti_body = 'El pase de ingreso <b>#'.$form_id.'</b> fue rechazado por @'.$_SESSION['user']['username'];
				$this->model('tbs/notifications')->create('cancel', $noti_body, 1);
			}else{
				$tifps = $data['transport_input_forms_products'];
				
				$scale_difference = $data['transport_input_form']['starting_weight_value'] - $data['transport_input_form']['ending_weight_value'];

				$granel = FALSE;
				$opt2 = FALSE;

				$input_form = $this->model('tbs/input_forms')->get_by_id($tifps[0]['form_id']);

				if ($tifps[0]['physical_unit_id']==1) {
					if ($tifps[0]['packaging_id']==35) {
						if ($input_form['transaction_id']!=312) {
							$opt2 = TRUE;
						}
					}
				}

				if ($tifps[0]['packaging_id']==48) {
					if ($input_form['transaction_id']!=327) {
						$granel = TRUE;
					}
				}

				if ($opt2) {
					foreach ($tifps as $product) {
						$input_form_product = $this->model('tbs/input_forms_products')->get_by_id($product['id']);

						$input_form_product['gross_weight'] = $scale_difference;

						//Actualizo las cantidades
						$this->model('tbs/input_forms_products')->edit($input_form_product);
					}
				}

				if ($granel)
				{
					if (count($tifps)==1)
					{
						//Si la cantidad reservada del único producto es mayor o = que la diferencia en báscula
						if ($tifps[0]['quantity'] >= $scale_difference) {
							//mueve la diferencia de báscula de virtual_reserved a locked
							$this->model('tbs/warehouses')->from_virtual_reserved_to_locked($tifps[0]['wid'], $scale_difference);

							//Si sobra algo en virtual reserved, lo devuelvo a virtual
							$vr_remain = $tifps[0]['quantity'] - $scale_difference;

							if ($vr_remain>0) {
								$this->model('tbs/warehouses')->from_virtual_reserved_to_virtual($tifps[0]['wid'], $vr_remain);
							}

							//Consulto nuevamente los saldos en el almacen
							$pw1 = $this->model('tbs/warehouses')->get_by_id($tifps[0]['wid']);

							$virtual = $pw1['virtual'] + $pw1['virtual_reserved'];
							
							if ($virtual==0) {
								//Si no hay nada en virtual o virtual reserved  procedo a ejecutar el formulario

								/*echo '<pre>'.print_r($vr_remain, TRUE).'</pre>';
								echo '<pre>'.print_r($pw1, TRUE).'</pre>';
								echo '<pre>'.print_r($virtual, TRUE).'</pre>';
								echo '<pre>'.print_r('Nada en virtual, ejecuta', TRUE).'</pre>';*/

								//mueve todo lo de bloqueado a stock
								$this->model('tbs/warehouses')->move_all_from_locked_to_stock($tifps[0]['wid']);

								//ejecuta el formulario

								$form_id = $tifps[0]['form_id'];

								$this->model('tbs/input_forms')->execute($form_id);
								$this->model('tbs/input_forms_logs')->create($form_id, 5);

								//Crear notificación
								$noti_body = 'El formulario de ingreso <b>#'.$form_id.'</b> fue ejecutado por @'.$_SESSION['user']['username'];
								$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);
							}

							//Si el usuario pidió que se ejecutara
							if ($tifps[0]['execute']==1) {

								//Tomo el producto del formulario de entrada asociado (que siempre será 1 porque es granel).
								$input_form_product = $this->model('tbs/input_forms_products')->get_by_form_id_single($tifps[0]['form_id']);

								$old_value = $input_form_product['quantity'];
								$new_value = str_replace(',', '.', $input_form_product['quantity'] ) - ($tifps[0]['virtual']+$vr_remain);
								$freights =  str_replace(',', '.', $input_form_product['freights']);
								$insurance =  str_replace(',', '.', $input_form_product['insurance']);
								$oexpenses =  str_replace(',', '.', $input_form_product['other_expenses']);

								//Modifico el producto principal en el formulario de ingreso

								if ($freights!=0) {
									$freights_unit_value = $freights/$old_value;
									$freights = $freights_unit_value*$new_value;
									$input_form_product['freights'] = $freights;
								}

								if ($insurance!=0) {
									$insurance_unit_value = $insurance/$old_value;
									$insurance = $insurance_unit_value*$new_value;
									$input_form_product['insurance'] = $insurance;
								}

								if ($oexpenses!=0) {
									$oexpenses_unit_value = $oexpenses/$old_value;
									$oexpenses = $oexpenses_unit_value*$new_value;
									$input_form_product['other_expenses'] = $oexpenses;
								}
								
								$input_form_product['quantity'] = $new_value;
								$input_form_product['commercial_quantity'] = $new_value;
								$input_form_product['net_weight'] = $new_value;
								$input_form_product['gross_weight'] = $new_value;
								$input_form_product['fob_value'] = str_replace(',', '.', $input_form_product['unit_value'] ) * $new_value;

								//Actualizo las cantidades
								$this->model('tbs/input_forms_products')->edit($input_form_product);

								//Guardo registro del ajuste
								$adjustment = array();
								$adjustment['form_type'] = 1; //Ingreso
								$adjustment['form_id'] = $tifps[0]['form_id'];
								$adjustment['field_type'] = 2; //Producto
								$adjustment['field_id'] = $input_form_product['id'];
								$adjustment['field_name'] = 'quantity';
								$adjustment['old_value'] = $old_value ;
								$adjustment['new_value'] = $new_value;

								//Guardo un ajuste de lo que se hizo
								$this->model('tbs/forms_adjustments')->create_tbs($adjustment);

								//mover todo lo de virtual del producto n a diferencia de báscula
								$this->model('tbs/warehouses')->move_all_from_virtual_to_scale_difference($tifps[0]['wid']);

								//mover todo lo de virtual_reserved del producto n a bloqueado
								$this->model('tbs/warehouses')->move_all_from_virtual_reserved_to_locked($tifps[0]['wid']);

								//mueve todo lo de bloqueado a stock
								$this->model('tbs/warehouses')->move_all_from_locked_to_stock($tifps[0]['wid']);

								//ejecuta el formulario
								$this->model('tbs/input_forms')->execute($tifps[0]['form_id']);
							}

						// Si la cantidad reservada es menor a la de báscula
						}else if ($tifps[0]['quantity'] < $scale_difference) {

							//Traigo los saldos de almacen del producto
							$pw1 = $this->model('tbs/warehouses')->get_by_id($tifps[0]['wid']);

							//Se mira si se puede reservar más de ese producto
							$new_reserved = $tifps[0]['quantity'] + $pw1['virtual'];
							
							/*echo '<pre>'.print_r('quantity '.$tifps[0]['quantity'], TRUE).'</pre>';
							echo '<pre>'.print_r('scale_difference '.$scale_difference, TRUE).'</pre>';
							echo '<pre>'.print_r('new_reserved '.$new_reserved, TRUE).'</pre>';*/
							//Si hay más que reservar en virtual
							if ($scale_difference<=$new_reserved) {
								//Se calcula lo que hace falta para llenar la demanda
								$left_to_reserve = $scale_difference - $tifps[0]['quantity'];

								$tifps[0]['quantity'] += $left_to_reserve;

								//echo '<pre>'.print_r('left_to_reserve '.$left_to_reserve, TRUE).'</pre>';

								//Se actualiza la cantidad que se habia reservado
								//$this->model('tbs/transport_input_forms_products')->edit($tifps[0]);

								//Se reserva lo que hace falta
								$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($tifps[0]['wid'], $left_to_reserve);

								//Si el usuario pidió que se ejecutara
								if ($tifps[0]['execute']==1) {

									//mover todo lo de virtual_reserved del producto n a bloqueado
									$this->model('tbs/warehouses')->move_all_from_virtual_reserved_to_locked($tifps[0]['wid']);

									//mover todo lo de virtual del producto n a diferencia de báscula
									$this->model('tbs/warehouses')->move_all_from_virtual_to_scale_difference($tifps[0]['wid']);

									//mueve todo lo de bloqueado a stock
									$this->model('tbs/warehouses')->move_all_from_locked_to_stock($tifps[0]['wid']);

									$input_form_product = $this->model('tbs/input_forms_products')->get_by_form_id_single($tifps[0]['form_id']);

									$pw1 = $this->model('tbs/warehouses')->get_by_id($tifps[0]['wid']);

									$old_value = $input_form_product['quantity'];
									$aux = $new_reserved - $left_to_reserve;
									$new_value = str_replace(',', '.', $pw1['stock']);
									$freights =  str_replace(',', '.', $input_form_product['freights']);
									$insurance =  str_replace(',', '.', $input_form_product['insurance']);
									$oexpenses =  str_replace(',', '.', $input_form_product['other_expenses']);

									//Modifico el producto principal en el formulario de ingreso

									if ($freights!=0) {
										$freights_unit_value = $freights/$old_value;
										$freights = $freights_unit_value*$new_value;
										$input_form_product['freights'] = $freights;
									}

									if ($insurance!=0) {
										$insurance_unit_value = $insurance/$old_value;
										$insurance = $insurance_unit_value*$new_value;
										$input_form_product['insurance'] = $insurance;
									}

									if ($oexpenses!=0) {
										$oexpenses_unit_value = $oexpenses/$old_value;
										$oexpenses = $oexpenses_unit_value*$new_value;
										$input_form_product['other_expenses'] = $oexpenses;
									}
									
									//Le sumo la diferencia en báscula a cantidad, cantidad comercial, peso neto, peso bruto
									$input_form_product['quantity'] = $new_value;
									$input_form_product['commercial_quantity'] = $new_value;
									$input_form_product['net_weight'] = $new_value;
									$input_form_product['gross_weight'] = $new_value;
									$input_form_product['fob_value'] = str_replace(',', '.', $input_form_product['unit_value'] ) * $new_value;

									//Actualizo las cantidades
									$this->model('tbs/input_forms_products')->edit($input_form_product);

									//Guardo registro del ajuste
									$adjustment = array();
									$adjustment['form_type'] = 1; //Ingreso
									$adjustment['form_id'] = $tifps[0]['form_id'];
									$adjustment['field_type'] = 2; //Producto
									$adjustment['field_id'] = $input_form_product['id'];
									$adjustment['field_name'] = 'quantity';
									$adjustment['old_value'] = $old_value ;
									$adjustment['new_value'] = $new_value;

									//Guardo un ajuste de lo que se hizo
									$this->model('tbs/forms_adjustments')->create_tbs($adjustment);

									//ejecuta el formulario
									$form_id = $tifps[0]['form_id'];

									$this->model('tbs/input_forms')->execute($form_id);
									$this->model('tbs/input_forms_logs')->create($form_id, 5);

									//Crear notificación
									$noti_body = 'El formulario de ingreso <b>#'.$form_id.'</b> fue ejecutado por @'.$_SESSION['user']['username'];
									$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);
								}else{
									//Si no pidió que se ejecutara

									//Se pasa la cantidad de virtual_reserved a bloqueado
									$this->model('tbs/warehouses')->from_virtual_reserved_to_locked($tifps[0]['wid'], $tifps[0]['quantity']);
								}
							}else{
								
								//Tomo el producto del formulario de entrada asociado (que siempre será 1 porque es granel).
								$input_form_product = $this->model('tbs/input_forms_products')->get_by_form_id_single($tifps[0]['form_id']);

								//Se resta la cantidad reservada
								//$this->model('tbs/warehouses')->from_virtual_reserved_to_locked($tifps[0]['wid'], $tifps[0]['quantity']);

								$scale_difference -= $tifps[0]['quantity'];

								//Se suma la cantidad que llegó en realidad
								$this->model('tbs/warehouses')->add_to_locked($tifps[0]['wid'], $scale_difference);

								$old_value = str_replace(',', '.', $input_form_product['quantity']);
								$new_value = str_replace(',', '.', $input_form_product['quantity']) + $scale_difference;
								$freights =  str_replace(',', '.', $input_form_product['freights']);
								$insurance =  str_replace(',', '.', $input_form_product['insurance']);
								$oexpenses =  str_replace(',', '.', $input_form_product['other_expenses']);

								//Modifico el producto principal en el formulario de ingreso

								if ($freights!=0) {
									$freights_unit_value = $freights/$old_value;
									$freights = $freights_unit_value*$new_value;
									$input_form_product['freights'] = $freights;
								}

								if ($insurance!=0) {
									$insurance_unit_value = $insurance/$old_value;
									$insurance = $insurance_unit_value*$new_value;
									$input_form_product['insurance'] = $insurance;
								}

								if ($oexpenses!=0) {
									$oexpenses_unit_value = $oexpenses/$old_value;
									$oexpenses = $oexpenses_unit_value*$new_value;
									$input_form_product['other_expenses'] = $oexpenses;
								}

								$input_form_product['quantity'] = $new_value;
								$input_form_product['commercial_quantity'] = $new_value;
								$input_form_product['net_weight'] = $new_value;
								$input_form_product['gross_weight'] = $new_value;
								$input_form_product['unit_value'] = str_replace(',', '.', $input_form_product['unit_value']);
								$input_form_product['fob_value'] = str_replace(',', '.', $input_form_product['unit_value'] ) * $new_value;


								//Actualizo las cantidades
								$this->model('tbs/input_forms_products')->edit($input_form_product);

								//Guardo registro del ajuste
								$adjustment = array();
								$adjustment['form_type'] = 1; //Ingreso
								$adjustment['form_id'] = $tifps[0]['form_id'];
								$adjustment['field_type'] = 2; //Producto
								$adjustment['field_id'] = $input_form_product['id'];
								$adjustment['field_name'] = 'quantity';
								$adjustment['old_value'] = $old_value ;
								$adjustment['new_value'] = $new_value;

								//Guardo un ajuste de lo que se hizo
								$this->model('tbs/forms_adjustments')->create_tbs($adjustment);

								//Si el usuario pidió que se ejecutara
								if ($tifps[0]['execute']==1) {

									//mueve todo lo de virtual_reserved a bloqueado
									$this->model('tbs/warehouses')->move_all_from_virtual_reserved_to_locked($tifps[0]['wid']);

									//mueve todo lo de bloqueado a stock
									$this->model('tbs/warehouses')->move_all_from_locked_to_stock($tifps[0]['wid']);

									//ejecuta el formulario
									$input_form = $this->model('tbs/input_forms')->get_by_id($tifps[0]['form_id']);
									$this->model('tbs/input_forms')->execute($input_form['id']);

									set_notification('El formulario de ingreso #'.$tifps[0]['form_id'].' fue ajustado', 'info');
								}
							}
						}
					}
					else
					{
						//Si el usuario añade varios productos
						$count = 0;
						$scale_difference = $data['transport_input_form']['starting_weight_value'] - $data['transport_input_form']['ending_weight_value'];

						foreach ($tifps as $product) {

							//Si es el primer producto
							if ($count==0) {
								//se calcula lo que sobra de báscula luego de restarle lo del producto 1
								$scale_difference -= $product['quantity'];

								//Busco la información del producto en el almacen
								$input_form_product = $this->model('tbs/input_forms_products')->get_by_form_id_single($product['form_id']);

								$old_value = $input_form_product['quantity'];
								$new_value = str_replace(',', '.', $input_form_product['quantity'] ) - ($product['virtual']);
								$freights =  str_replace(',', '.', $input_form_product['freights']);
								$insurance =  str_replace(',', '.', $input_form_product['insurance']);
								$oexpenses =  str_replace(',', '.', $input_form_product['other_expenses']);

								//Modifico el producto principal en el formulario de ingreso

								if ($freights!=0) {
									$freights_unit_value = $freights/$old_value;
									$freights = $freights_unit_value*$new_value;
									$input_form_product['freights'] = $freights;
								}

								if ($insurance!=0) {
									$insurance_unit_value = $insurance/$old_value;
									$insurance = $insurance_unit_value*$new_value;
									$input_form_product['insurance'] = $insurance;
								}

								if ($oexpenses!=0) {
									$oexpenses_unit_value = $oexpenses/$old_value;
									$oexpenses = $oexpenses_unit_value*$new_value;
									$input_form_product['other_expenses'] = $oexpenses;
								}

								//Le sumo la diferencia en báscula a cantidad, cantidad comercial, peso neto, peso bruto
								$input_form_product['quantity'] = $new_value;
								$input_form_product['commercial_quantity'] = $new_value;
								$input_form_product['net_weight'] = $new_value;
								$input_form_product['gross_weight'] = $new_value;
								$input_form_product['fob_value'] = str_replace(',', '.', $input_form_product['unit_value'] ) * $new_value;

								//Actualizo las cantidades
								$this->model('tbs/input_forms_products')->edit($input_form_product);

								//Guardo registro del ajuste
								$adjustment = array();
								$adjustment['form_type'] = 1; //Ingreso
								$adjustment['form_id'] = $product['form_id'];
								$adjustment['field_type'] = 2; //Producto
								$adjustment['field_id'] = $input_form_product['id'];
								$adjustment['field_name'] = 'quantity';
								$adjustment['old_value'] = $old_value ;
								$adjustment['new_value'] = $new_value;

								//Guardo un ajuste de lo que se hizo
								$this->model('tbs/forms_adjustments')->create_tbs($adjustment);

								//mover todo lo de virtual_reserved del producto 1 a bloqueado
								$this->model('tbs/warehouses')->move_all_from_virtual_reserved_to_locked($product['wid']);

								//mover todo lo demás a diferencia en báscula
								$this->model('tbs/warehouses')->move_all_from_virtual_to_scale_difference($product['wid']);

								//mueve todo lo de bloqueado a stock
								$this->model('tbs/warehouses')->move_all_from_locked_to_stock($product['wid']);

								//ejecuta el formulario
								$input_form = $this->model('tbs/input_forms')->get_by_id($product['input_form_id']);
								$this->model('tbs/input_forms')->execute($input_form['id']);
							}else{
								//Para el resto de productos se reparte lo que sobre en báscula

								//si la diferencia es mayor que la cantidad del producto
								if ($scale_difference> $product['quantity']) {
									//Traigo los saldos de almacen del producto
									$pw1 = $this->model('tbs/warehouses')->get_by_id($product['wid']);

									//Se mira si se puede reservar más de ese producto
									$new_reserved = $product['quantity'] + $pw1['virtual'];

									//Si hay más que reservar en virtual
									if ($new_reserved>=$scale_difference) {

										//Se calcula lo que hace falta para llenar la demanda
										$left_to_reserve = $scale_difference - $product['quantity'];

										//Se actualiza la cantidad que se habia reservado
										//$this->model('tbs/transport_input_forms_products')->edit($product);

										//Se reserva lo que hace falta
										$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($product['wid'], $left_to_reserve);

										//Si el usuario pidió que se ejecutara
										if ($product['execute']==1) {
											
											$input_form_product = $this->model('tbs/input_forms_products')->get_by_form_id_single($product['form_id']);

											$old_value = str_replace(',', '.', $input_form_product['quantity']);
											$new_value = str_replace(',', '.', $input_form_product['quantity']) - ($product['virtual']);
											$freights =  str_replace(',', '.', $input_form_product['freights']);
											$insurance =  str_replace(',', '.', $input_form_product['insurance']);
											$oexpenses =  str_replace(',', '.', $input_form_product['other_expenses']);

											//Modifico el producto principal en el formulario de ingreso

											if ($freights!=0) {
												$freights_unit_value = $freights/$old_value;
												$freights = $freights_unit_value*$new_value;
												$input_form_product['freights'] = $freights;
											}

											if ($insurance!=0) {
												$insurance_unit_value = $insurance/$old_value;
												$insurance = $insurance_unit_value*$new_value;
												$input_form_product['insurance'] = $insurance;
											}

											if ($oexpenses!=0) {
												$oexpenses_unit_value = $oexpenses/$old_value;
												$oexpenses = $oexpenses_unit_value*$new_value;
												$input_form_product['other_expenses'] = $oexpenses;
											}


											//Le sumo la diferencia en báscula a cantidad, cantidad comercial, peso neto, peso bruto
											$input_form_product['quantity'] = $new_value;
											$input_form_product['commercial_quantity'] = $new_value;
											$input_form_product['net_weight'] = $new_value;
											$input_form_product['gross_weight'] = $new_value;
											$input_form_product['fob_value'] = str_replace(',', '.', $input_form_product['unit_value'] ) * $new_value;

											//Actualizo las cantidades
											$this->model('tbs/input_forms_products')->edit($input_form_product);

											//Guardo registro del ajuste
											$adjustment = array();
											$adjustment['form_type'] = 1; //Ingreso
											$adjustment['form_id'] = $product['form_id'];
											$adjustment['field_type'] = 2; //Producto
											$adjustment['field_id'] = $input_form_product['id'];
											$adjustment['field_name'] = 'quantity';
											$adjustment['old_value'] = $old_value ;
											$adjustment['new_value'] = $new_value;

											//Guardo un ajuste de lo que se hizo
											$this->model('tbs/forms_adjustments')->create_tbs($adjustment);

											//mover todo lo de virtual_reserved del producto n a bloqueado
											$this->model('tbs/warehouses')->move_all_from_virtual_reserved_to_locked($product['wid']);

											//mover todo lo de virtual del producto n a diferencia de báscula
											$this->model('tbs/warehouses')->move_all_from_virtual_to_scale_difference($product['wid']);

											//mueve todo lo de bloqueado a stock
											$this->model('tbs/warehouses')->move_all_from_locked_to_stock($product['wid']);

											//ejecuta el formulario
											$input_form = $this->model('tbs/input_forms')->get_by_id($product['form_id']);

											$this->model('tbs/input_forms')->execute($input_form['id']);
										}else{
											//Si no pidió que se ejecutara

											//Se pasa la cantidad de virtual_reserved a bloqueado
											$this->model('tbs/warehouses')->from_virtual_reserved_to_locked($product['wid'], $scale_difference);
										}

									}else{
										//Tomo el producto del formulario de entrada asociado (que siempre será 1 porque es granel).
										
										$input_form_product = $this->model('tbs/input_forms_products')->get_by_form_id_single($product['form_id']);
										
										$old_value = $input_form_product['quantity'];
										$new_value = $scale_difference;
										$freights =  str_replace(',', '.', $input_form_product['freights']);
										$insurance =  str_replace(',', '.', $input_form_product['insurance']);
										$oexpenses =  str_replace(',', '.', $input_form_product['other_expenses']);

										//Modifico el producto principal en el formulario de ingreso

										if ($freights!=0) {
											$freights_unit_value = $freights/$old_value;
											$freights = $freights_unit_value*$new_value;
											$input_form_product['freights'] = $freights;
										}

										if ($insurance!=0) {
											$insurance_unit_value = $insurance/$old_value;
											$insurance = $insurance_unit_value*$new_value;
											$input_form_product['insurance'] = $insurance;
										}

										if ($oexpenses!=0) {
											$oexpenses_unit_value = $oexpenses/$old_value;
											$oexpenses = $oexpenses_unit_value*$new_value;
											$input_form_product['other_expenses'] = $oexpenses;
										}

										//Le sumo la diferencia en báscula a cantidad, cantidad comercial, peso neto, peso bruto
										$input_form_product['quantity'] = $new_value;
										$input_form_product['commercial_quantity'] = $new_value;
										$input_form_product['net_weight'] = $new_value;
										$input_form_product['gross_weight'] = $new_value;
										$input_form_product['unit_value'] = str_replace(',', '.', $input_form_product['unit_value']);
										$input_form_product['fob_value'] = str_replace(',', '.', $input_form_product['unit_value'] ) * $new_value;


										//Guardo registro del ajuste
										$adjustment = array();
										$adjustment['form_type'] = 1; //Ingreso
										$adjustment['form_id'] = $product['form_id'];
										$adjustment['field_type'] = 2; //Producto
										$adjustment['field_id'] = $input_form_product['id'];
										$adjustment['field_name'] = 'quantity';
										$adjustment['new_value'] = $new_value;
										$adjustment['old_value'] = $old_value;

										//Guardo un ajuste de lo que se hizo
										$this->model('tbs/forms_adjustments')->create_tbs($adjustment);

										//Actualizo las cantidades
										$this->model('tbs/input_forms_products')->edit($input_form_product);

										$scale_difference -= $product['virtual_reserved'];

										//añado lo sobrante de la báscula a bloqueado
										$this->model('tbs/warehouses')->add_to_locked($product['wid'], $scale_difference);

										//mueve todo lo de virtual_reserved a bloqueado
										$this->model('tbs/warehouses')->move_all_from_virtual_reserved_to_locked($product['wid']);

										//mueve todo lo de bloqueado a stock
										$this->model('tbs/warehouses')->move_all_from_locked_to_stock($product['wid']);

										//ejecuta el formulario
										$input_form = $this->model('tbs/input_forms')->get_by_id($product['form_id']);
										$this->model('tbs/input_forms')->execute($input_form['id']);
									}
								}else if ($scale_difference < $product['quantity']) {
									//Si la diferencia es menor que la cantidad del producto

									$return = $product['quantity'] - $scale_difference;

									//Regreso a virtual lo que sobra
									$this->model('tbs/warehouses')->from_virtual_reserved_to_virtual($product['wid'], $return);

									$this->model('tbs/warehouses')->from_virtual_reserved_to_locked($product['wid'], $scale_difference);

									if ($product['execute']==1) {
										//mover todo lo de virtual del producto n a diferencia de báscula
										$this->model('tbs/warehouses')->move_all_from_virtual_to_scale_difference($product['wid']);

										//mover todo lo de virtual_reserved del producto n a bloqueado
										$this->model('tbs/warehouses')->move_all_from_virtual_reserved_to_locked($product['wid']);

										//mueve todo lo de bloqueado a stock
										$this->model('tbs/warehouses')->move_all_from_locked_to_stock($product['wid']);

										//ejecuta el formulario
										$input_form = $this->model('tbs/input_forms')->get_by_id($product['form_id']);
										$this->model('tbs/input_forms')->execute($input_form['id']);
									}

								}

							}

							$count++;
						}
					}
					
				}else{
					foreach ($tifps as $product) {
						$this->model('tbs/warehouses')->from_virtual_reserved_to_locked($product['wid'], $product['quantity']);

						$input_form_product = $this->model('tbs/input_forms_products')->get_by_id($product['ifp_id']);

						if ($product['execute']==1) {

							//mover todo lo de virtual del producto n a diferencia de báscula
							$this->model('tbs/warehouses')->move_all_from_virtual_to_scale_difference($product['wid']);

							//mover todo lo de virtual_reserved del producto n a bloqueado
							$this->model('tbs/warehouses')->move_all_from_virtual_reserved_to_locked($product['wid']);

							$old_value = str_replace(',', '.', $input_form_product['quantity']);
							$new_value = str_replace(',', '.', $input_form_product['quantity']) - $product['virtual'];
							$freights =  str_replace(',', '.', $input_form_product['freights']);
							$insurance =  str_replace(',', '.', $input_form_product['insurance']);
							$oexpenses =  str_replace(',', '.', $input_form_product['other_expenses']);

							//Modifico el producto principal en el formulario de ingreso

							if ($freights!=0) {
								$freights_unit_value = $freights/$old_value;
								$freights = $freights_unit_value*$new_value;
								$input_form_product['freights'] = $freights;
							}

							if ($insurance!=0) {
								$insurance_unit_value = $insurance/$old_value;
								$insurance = $insurance_unit_value*$new_value;
								$input_form_product['insurance'] = $insurance;
							}

							if ($oexpenses!=0) {
								$oexpenses_unit_value = $oexpenses/$old_value;
								$oexpenses = $oexpenses_unit_value*$new_value;
								$input_form_product['other_expenses'] = $oexpenses;
							}

							//Ajusto el formulario
							$input_form_product['quantity'] =  $new_value;
							$input_form_product['quantity'] =  $new_value;
							$input_form_product['commercial_quantity'] = $new_value;
							$input_form_product['unit_value'] = str_replace(',', '.', $input_form_product['unit_value']);
							$input_form_product['fob_value'] = str_replace(',', '.', $input_form_product['unit_value']) * $new_value;

							//Actualizo las cantidades
							$this->model('tbs/input_forms_products')->edit_with_id($input_form_product, $product['ifp_id']);

							//Guardo registro del ajuste
							$adjustment = array();
							$adjustment['form_type'] = 1; //Ingreso
							$adjustment['form_id'] = $tifps[0]['form_id'];
							$adjustment['field_type'] = 2; //Producto
							$adjustment['field_id'] = $input_form_product['id'];
							$adjustment['field_name'] = 'quantity';
							$adjustment['new_value'] = $new_value;
							$adjustment['old_value'] = $old_value;

							//Guardo un ajuste de lo que se hizo
							$this->model('tbs/forms_adjustments')->create_tbs($adjustment);

							set_notification('Se ajustó el formulario #'.$tifps[0]['form_id']);
						}
					}
				}

				$this->model('tbs/transport_input_forms_logs')->create($form_id, 3);
				$this->model('tbs/transport_input_forms')->approve($form_id);

				$input_forms = $this->model('tbs/warehouses')->get_forms_from_transport($form_id);

				foreach ($input_forms as $input) {
					$sum = $this->model('tbs/warehouses')->get_sum_virtual($input['id']);
					if ($sum==0) {
						$this->model('tbs/input_forms')->execute($input['id']);
						$this->model('tbs/input_forms_logs')->create($input['id'], 5);
					}
				}

				//Crear notificación
				$form = $this->model('tbs/transport_input_forms')->get_by_id($form_id);
				$noti_body = 'El pase de ingreso <b>#'.$form_id.'</b> fue aprobado por @'.$_SESSION['user']['username'];
				$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);

			}

			redirect("tbs/transport_input_forms/", '');
		}

		$this->view('verify', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	RECUPERAR
	----------------------------------------------------------------------*/

	public function recover(){
		if ($this->model('tbs/transport_input_forms')->recover($_GET['id'])) {
			$this->model('tbs/transport_input_forms_logs')->create($_GET['id'], 8);
			redirect("tbs/transport_input_forms/details?id=".$_GET['id']);
		}else{
			set_notification('No se pudo recuperar el formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	EDIT
	----------------------------------------------------------------------*/
	public function edit()
	{
		$data['tif'] = $this->model('tbs/transport_input_forms')->get_by_id($_GET['id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			if ($this->model('tbs/transport_input_forms')->edit($_POST)) 
			{
				$this->model('tbs/transport_input_forms_logs')->create($_GET['id'], 1);

				redirect("tbs/transport_input_forms/details?id=".$_GET['id']);
			}
			else
			{
				redirect('', 'Ocurrió un error', 'error');
			}
		}
		$data['drivers'] = $this->model('tbs/drivers')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();

		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	EDIT CHARGE INFO
	----------------------------------------------------------------------*/
	public function edit_charge_info()
	{
		$data['tif'] = $this->model('tbs/transport_input_forms')->get_by_id($_GET['id']);

		if ($_POST)
		{
			if ($this->model('tbs/transport_input_forms')->edit_charge_info($_POST, $_GET['id'])) 
			{

				redirect("tbs/transport_input_forms/details?id={$_GET['id']}");
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
			}
		}

		$this->view('', $data);
	}

}
