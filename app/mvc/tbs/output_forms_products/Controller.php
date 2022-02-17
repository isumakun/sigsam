<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	CREATE
	----------------------------------------------------------------------*/
	public function create()
	{
		
		if ($_POST)
		{
			$_POST['output_form_id'] = $_GET['form_id'];

			if (isset($_GET['transformed'])) {
				$product = $this->model('tbs/transformation_forms_products')->get_by_warehouse($_POST['warehouse_id']);
			}else{
				$product = $this->model('tbs/input_forms_products')->get_in_warehouse($_POST['warehouse_id']);
			}

			$set_th = $this->model('tbs/tariff_headings')->get_by_id($_POST['tariff_heading_id']);

			if (isset($_GET['transformed'])) {
				if ($product['stock']>= $_POST['quantity']) {
					if ($id = $this->model('tbs/output_forms_products')->create($_POST)) 
					{
						$this->model('tbs/warehouses')->from_stock_to_reserved($product['wid'], $_POST['quantity']);
						redirect("tbs/output_forms/details?id={$_GET['form_id']}",'Producto Agregado');
					}
					else
					{
						set_notification('Ocurrió un error', 'error');
					}
				}else{
					set_notification('La cantidad que requiere es mayor a la que está en inventario', 'error');
				}
				
			}else{
				if ($product['tariff_heading_unit']==$set_th['physical_unit']) {
					if ($product['stock']>=$_POST['quantity']) {
						if ($id = $this->model('tbs/output_forms_products')->create($_POST)) 
						{
							$this->model('tbs/warehouses')->from_stock_to_reserved($product['wid'], $_POST['quantity']);
							redirect("tbs/output_forms/details?id={$_GET['form_id']}",'Producto Agregado');
						}
						else
						{
							set_notification('Ocurrió un error', 'error');
						}
					}else{
						set_notification('La cantidad que requiere es mayor a la que está en inventario', 'error');
					}
				}else{
					set_notification('La unidad de la nueva subpartida no coincide con la de la anterior', 'error');
				}
			}
			
		}

		$data['output_form'] = $this->model('tbs/output_forms')->get_by_id($_GET['form_id']);
		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();
		$data['transport_types'] = $this->model('tbs/transport_types')->get_all();
		$data['packaging'] = $this->model('tbs/packaging')->get_all();
		$data['flags'] = $this->model('tbs/flags')->get_all();
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		if (isset($_GET['transformed'])) {
			$data['products'] = $this->model('tbs/products')->get_all_in_stock_transformed();
		}else{
			$data['products'] = $this->model('tbs/products')->get_all_in_stock();
		}

		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	CREATE MASSIVELY
	----------------------------------------------------------------------*/
	public function create_massively()
	{
		foreach ($_POST['products_id'] as $data) {
			$data = explode('-', $data);
			$wid = $data[0];
			$form_id = $data[1];

			$wh = $this->model('tbs/warehouses')->get_by_id($wid);
			
			if ($wh['form_type']==1) {
				$product = $this->model('tbs/input_forms_products')->get_in_warehouse($wid);
			}elseif ($wh['form_type']==4) {
				$product = $this->model('tbs/output_forms_products')->get_in_warehouse($wid, $form_id);
			}

				if (!empty($product)) {
					if ($product['stock']>=$_POST['quantity']) {
						$this->model('tbs/warehouses')->from_stock_to_reserved($wid, $product['stock']);
						if ($this->model('tbs/output_forms_products')->create_massively($_POST['form_id'], $product)) {
							
							set_notification('Producto #'.$wid.' Añadidos');
							
						}else{
							//print_r($product);
							set_notification('Ocurrió con el producto #'.$wid, 'error');
						}
					}else{
						set_notification('La cantidad que requiere del product '.$product['product'].' es mayor a la que hay en stock', 'error');
					}
					
				}else{
					set_notification('Ocurrió un error', 'error');
				}			
		}
	}

/*----------------------------------------------------------------------
	EDIT
	----------------------------------------------------------------------*/
	public function edit()
	{
		$data['output_form_product'] = $this->model('tbs/output_forms_products')->get_by_id($_GET['id']);
		$data['output_forms_verify'] = $this->model('tbs/output_forms_verify')->get_by_form_id($_GET['form_id']);
		
		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			$_POST['output_form_id'] = $_GET['form_id'];

			$product = $this->model('tbs/output_forms_products')->get_by_id($_GET['id']);

			$set_th = $this->model('tbs/tariff_headings')->get_by_id($_POST['tariff_heading_id']);

			if ($product['tariff_heading_unit']==$set_th['physical_unit']) {
				$this->model('tbs/warehouses')->from_reserved_to_stock($product['warehouse_id'], $product['quantity']);
				$this->model('tbs/warehouses')->from_stock_to_reserved($product['warehouse_id'], $_POST['quantity']);

				$product = $this->model('tbs/input_forms_products')->get_in_warehouse($_POST['warehouse_id']);
				
				if (empty($product)) {
					$product = $this->model('tbs/transformation_forms_products')->get_in_warehouse($_POST['warehouse_id']);
				}

				$checkQuantity = TRUE;

				if (!$form['form_state_id']==3 OR !$form['form_state_id']==5) {
					if ($product['reserved']<$_POST['quantity']) {
						$checkQuantity = FALSE;
					}
				}				

				if ($checkQuantity) {

					if ($this->model('tbs/output_forms_products')->edit($_POST))
					{
						$form = $this->model('tbs/output_forms')->get_by_id($_GET['form_id']);
						$form_id = $_GET['form_id'];

						$old_product = $data['output_form_product'];
						$new_product = $this->model('tbs/output_forms_products')->get_by_id($_GET['id']);

						if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
							if ($_SESSION['master_mode']==0) {
								foreach ($new_product as $key => $value) {
									foreach ($old_product as $key2 => $value2) {
										if ($key==$key2) {
											if ($value!=$value2) {

												$adjustment = array();
												$adjustment['form_type'] = 2; //Salida
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
							if (count($data['output_forms_verify'])!=0) {
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
					}

					redirect("tbs/output_forms/details?id={$_GET['form_id']}");
				}else{
					set_notification('La cantidad que requiere es mayor a la que está en inventario', 'error');
				}

				
			}
			else
			{
				set_notification('La unidad de las subpartidas no coincide', 'error');
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
		$data['products'] = $this->model('tbs/products')->get_all_in_stock();

		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	VERIFY
	----------------------------------------------------------------------*/
	public function verify()
	{
		$form_id = $_GET['form_id'];
		$product_id = $_GET['id'];

		if ($this->model('tbs/output_forms_products')->verify($product_id)) {
			$this->model('tbs/warehouses')->from_stock_to_reserved($product_id, $form_id, 2);
			
			$unverified = $this->model('tbs/output_forms_products')->get_unverified($form_id);
			
			if (count($unverified)!=0) 
			{
				redirect_back('');
			}
			else if (count($unverified) == 0)
			{
				$this->model('tbs/output_forms')->execute($form_id);
				redirect("tbs/output_forms/inspection");
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
		$product = $this->model('tbs/output_forms_products')->get_by_id($_GET['id']);

		$this->model('tbs/warehouses')->from_reserved_to_stock($product['warehouse_id'], $product['quantity']);

		if ($this->model('tbs/output_forms_products')->delete($_GET['id'])) {
			
			
			redirect_back();
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
