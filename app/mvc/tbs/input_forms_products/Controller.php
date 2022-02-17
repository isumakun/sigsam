<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			$_POST['input_form_id'] = $_GET['form_id'];
			
			if ($this->model('tbs/input_forms_products')->create($_POST)) 
			{
				redirect("tbs/input_forms/details?id={$_GET['form_id']}");
			}
			else
			{
				set_notification('No se pudo añadir el producto', 'error');
			}
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['packaging'] = $this->model('tbs/packaging')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();

		$this->view('create', $data);
	}
/*----------------------------------------------------------------------
	CREATE MASSIVELY
----------------------------------------------------------------------*/
	public function create_massively()
	{
		if ($_POST)
		{
			$products_success = 0;
			$products_errors = 0;
			//error_reporting(E_ALL);

			$_POST['input_form_id'] = $_GET['form_id'];

			if ($_POST['products_from_excel'])
			{
				$products = preg_split('/\n/', $_POST['products_from_excel']);
			}

			$inserted_products_ids = array();

			$sql = 'INSERT INTO 
					`tbs_input_forms_products` (`input_form_id`, `product_id`, `product_category_id`, `quantity`, `commercial_quantity`,  `unit_value`,  `fob_value`, `net_weight`, `gross_weight`, `freights`, `packaging_id`, `insurance`, `other_expenses`, `flag_id`) VALUES';

			foreach ($products AS $product)
			{
				$tabs = preg_split('/\t/', $product);

				for ($i=0; $i <count($tabs) ; $i++) {
					if ($tabs[$i]=='' OR $tabs[$i]==' ') {
						redirect_back('Hay celdas en blanco, por favor revise el archivo masivo', 'error');
						break;
					}
					if ($tabs[2] == 0 OR $tabs[2]== '') {
						break;
						set_notification('La categoria del producto '.$tabs[0].' no puede ser 0 o estar vacia');
						redirect("tbs/input_forms/details?id={$_GET['form_id']}");
					}

					if ($tabs[3] == 0 OR $tabs[3] == '') {
						break;
						set_notification('La el tipo del producto '.$tabs[0].' no puede ser 0 o estar vacia');
						redirect("tbs/input_forms/details?id={$_GET['form_id']}");
					}

					if ($tabs[16] == 0 OR $tabs[16] == '') {
						break;
						set_notification('El embalaje del producto '.$tabs[0].' no puede ser 0 o estar vacio');
						redirect("tbs/input_forms/details?id={$_GET['form_id']}");
					}

					if (strlen($tabs[4])>10) {
						$tabs[4] = substr($tabs[4], 0, 10);
					}
					$tariff_heading = $this->model('tbs/tariff_headings')->get_by_code($tabs[4]);
					//echo '<pre>'.print_r($tabs[4], TRUE).'</pre>';
					if ($tariff_heading['id']=='' OR empty($tariff_heading)) {
						set_notification('La subpartida '.$tabs[4].' no existe en el sistema');
						redirect("tbs/input_forms/details?id={$_GET['form_id']}");
					 	break;
					}
				}
			}
			
			foreach ($products AS $product)
			{
				$tabs = preg_split('/\t/', $product);
				
				$product_name = str_replace(',', '.', $tabs[0]);
				$interface_code = $tabs[1];
				$product_type_id = $tabs[2];
				$product_category_id = $tabs[3];
				$tariff_heading = $this->model('tbs/tariff_headings')->get_by_code($tabs[4]);
				$tariff_heading_id = $tariff_heading['id'];
				$commercial_quantity = str_replace(',', '.', $tabs[5]);
				$quantity = str_replace(',', '.', $tabs[6]);
				$physical_unit_id = $tabs[7];
				$net_weight = str_replace(',', '.', $tabs[8]);
				$gross_weight = str_replace(',', '.', $tabs[9]);
				$unit_value = str_replace(',', '.', $tabs[10]);
				$fob_value = str_replace(',', '.', $tabs[11]);
				$freights = str_replace(',', '.', $tabs[12]);
				$insurance = str_replace(',', '.', $tabs[13]);
				$other_expenses = str_replace(',', '.', $tabs[14]);
				$packaging_id = $tabs[15];
				$flag_id = $tabs[16];

				if (!empty($tariff_heading)) {
					if ($product_name!='') {
						if ($id = $this->model('tbs/products')->create_massively($product_name, $interface_code, $product_type_id, $tariff_heading_id, $physical_unit_id))
							{
								$_POST['product_id'] = $id;

								$sql .= "({$_GET['form_id']},	$id, $product_category_id, $quantity,	$commercial_quantity, $unit_value, $fob_value,	$net_weight,	$gross_weight,	$freights, $packaging_id,	
									$insurance,	$other_expenses, $flag_id),";
									
							}
							else
							{
								//$products_errors++;
							}
					}else{
						echo "LOL";
					}
				}else{
					set_notification('El producto '.$product_name.' no tiene una subpartida registrada en el sistema: '.$tabs[4], 'error');
				}
			}

			$sql = rtrim($sql,',');

			//echo '<pre>'.print_r($sql, TRUE).'</pre>';
			//die();
			if ($this->model('tbs/input_forms_products')->create_all_in_one($sql)) {
				set_notification('Productos ingresados y añadidos al formulario');
			}else{
				set_notification('Ocurrió un error', 'error');
			}

			redirect("tbs/input_forms/details?id={$_GET['form_id']}");
			if ($products_errors>0) {
				set_notification('Error al agregar '.$products_errors.' productos en el formulario.', 'error');
			}
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['packaging'] = $this->model('tbs/packaging')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();

		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['input_form_product'] = $this->model('tbs/input_forms_products')->get_by_id($_GET['id']);
		$data['input_forms_verify'] = $this->model('tbs/input_forms_verify')->get_by_form_id($_GET['form_id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			$_POST['input_form_id'] = $_GET['form_id'];
			
			if ($this->model('tbs/input_forms_products')->edit($_POST)) 
			{
				$form = $this->model('tbs/input_forms')->get_by_id($_GET['form_id']);
				$form_id = $_GET['form_id'];

				$old_product = $data['input_form_product'];
				$new_product = $this->model('tbs/input_forms_products')->get_by_id($_GET['id']);

				if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
					if ($_SESSION['master_mode']==0) {
						foreach ($new_product as $key => $value) {
							foreach ($old_product as $key2 => $value2) {
								if ($key==$key2) {
									if ($value!=$value2) {

										$adjustment = array();
										$adjustment['form_type'] = 1; //Ingreso
										$adjustment['form_id'] = $form_id;
										$adjustment['field_type'] = 1; //Productos
										$adjustment['field_name'] = $key; 
										$adjustment['field_id'] = $_GET['id'];
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

					if (count($data['input_forms_verify'])!=0) {
						for ($i=0; $i < count($_POST['field_names']); $i++) {
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

				redirect("tbs/input_forms/details?id={$_GET['form_id']}");
			}
			else
			{
				redirect('', 'Ocurrió un error', 'error');
			}
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['packaging'] = $this->model('tbs/packaging')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();

		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	VERIFY
----------------------------------------------------------------------*/
	public function verify()
	{
		$form_id = $_GET['form_id'];
		$product_id = $_GET['id'];

		if ($this->model('tbs/input_forms_products')->verify($product_id)) {
			
			$unverified = $this->model('tbs/input_forms_products')->get_unverified($form_id);
			
			if (count($unverified)!=0) 
			{
				redirect_back('');
			}
			else if (count($unverified) == 0)
			{
				$this->model('tbs/input_forms')->execute($form_id);
				redirect("tbs/input_forms/inspection");
			}
			
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}

/*----------------------------------------------------------------------
	DELETE
----------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/input_forms_products')->delete($_GET['id'])) {
			redirect_back('');
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
