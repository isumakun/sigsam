<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['transport_input_forms_products'] = $this->model('tbs/transport_input_forms_products')->get_all();

		$this->view('', $data);
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	/* Esto no se usa
	public function create()
	{
		if ($_POST)
		{			
			$product = $this->model('tbs/input_forms_products')->get_by_id($_POST['input_forms_product_id']);
			
			if ($product['virtual']>=$_POST['quantity']) {
				if ($this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $_POST['input_forms_product_id'], $_POST['quantity'])) 
				{
					redirect("tbs/transport_input_forms/details?id={$_GET['form_id']}");
				}
				else
				{
					set_notification('Ocurrió un error', 'error');
				}
			}else{
				set_notification('La cantidad que requiere es mayor a la que está en inventario', 'error');
			}
		}
		$data['products'] = $this->model('tbs/products')->get_all_in_virtual();
		$this->view('create', $data);
	}*/

/*----------------------------------------------------------------------
	SET EXCECUTABLE
----------------------------------------------------------------------*/
	public function set_execute_form(){
		
		if ($this->model('tbs/transport_input_forms_products')->set_execute_form($_GET['product_id'], $_GET['value'])) {
			redirect_back();
		}else{
			redirect_back('Ocurrió un error', 'error');
		}
	}


/*----------------------------------------------------------------------
	CREATE MASSIVELY
----------------------------------------------------------------------*/
	public function create_massively()
	{
		$product_real_id = 0;
		$count = 0;
		$insert = TRUE;

		$transport_form = $this->model('tbs/transport_input_forms')->get_by_id($_POST['form_id']);
		//echo '<pre>'.print_r($transport_form, TRUE).'</pre>';
		//die();

		foreach ($_POST['products_id'] as $wid) {
			$product = $this->model('tbs/input_forms_products')->get_in_warehouse($wid);

			if($count==0){
				$product_real_id = $product['product_id'];
			}

			if ($product['packaging_id']==48) {
				if ($transport_form['quantity_manifested']==0 OR $transport_form['quantity_manifested']=='') {
					set_notification('Antes de añadir productos debe colocar la cantidad manifestada', 'error');
					$insert = FALSE;
					break;
				}
			}

			if ($product['product_id']!=$product_real_id) {
				if ($product['packaging_id']==48) {
					set_notification('Para Granel Líquido debe seleccionar productos de referencias iguales', 'error');
					$insert = FALSE;
					break;
				}
			}

			$count++;

		}

		$count = 0;
		if ($insert) {
			$scale =  str_replace(',', '.', $transport_form['quantity_manifested']);

			foreach ($_POST['products_id'] as $wid) {
				$product = $this->model('tbs/input_forms_products')->get_in_warehouse($wid);
				$virtual =$product['virtual'];

					if ($product['packaging_id']==48) {
						if($virtual>=$scale){
							if ($virtual==$scale) {
								$this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $wid, $scale, 1);
							}else{
								$this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $wid, $scale);
							}

							$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($wid, $scale);
						}else{
							$qman = $scale;
							$scale = $scale - $virtual;

							if ($scale>=0) {
								if ($product['virtual']<=$qman) {
									$this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $wid, $virtual, 1);
								}else{
									$this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $wid, $virtual);
								}
								$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($wid, $virtual);
							}else{
								if ($product['virtual']==$qman) {
									$this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $wid, $scale, 1);
								}else{
									$this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $wid, $scale);
								}

								$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($wid, $scale);
							}
						}
					}else{
						$this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $wid, $virtual);
						$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($wid, $virtual);
					}
			}
		}
		
	}

	//ADD ALL PRODUCTS FROM AN INPUT FORM
	public function add_products_by_form(){

		$form = $this->model('tbs/input_forms')->get_by_id($_POST['input_form_id']);
		$transport_input_forms_products = $this->model('tbs/transport_input_forms_products')->get_by_form_id($_POST['form_id']);

		if (count($form)!=0) {
				$products = $this->model('tbs/input_forms_products')->get_with_warehouse_id($_POST['input_form_id']);

				if (count($products)!=0) {
					foreach ($products as $product) {
						$insert = TRUE;

						foreach ($transport_input_forms_products as $tproduct) {
							if ($tproduct['wid']==$product['wid']) {
								$insert = FALSE;
							}
						}

						if ($insert) {
							$this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $product['wid'], $product['virtual']);

							$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($product['wid'], $product['virtual']);
						}
					}
				}

				set_notification('Productos añadidos');
		}else{
			set_notification('Este formulario no existe', 'error');
		}

		redirect_back();
		
	}

	//ADD ALL PRODUCTS FROM AN INPUT FORM AND PASS TO 
	public function add_products_by_form_MAGIC(){
		//error_reporting(E_ALL);
		$form = $this->model('tbs/input_forms')->get_by_id($_POST['input_form_id']);

		$to_insert = $this->model('tbs/input_forms_products')->get_in_virtual($_POST['input_form_id']);
	
		foreach ($to_insert as $product) {
			$this->model('tbs/transport_input_forms_products')->create($_POST['form_id'], $product['wid'], $product['virtual']);

			$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($product['wid'], $product['virtual']);
			$this->model('tbs/warehouses')->from_virtual_reserved_to_locked($product['wid'], $product['virtual']);
		}

		$count = count($to_insert);
		set_notification($count.' Productos añadidos');

		redirect_back();
		
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['transport_input_form_product'] = $this->model('tbs/transport_input_forms_products')->get_by_id($_GET['id']);
		
		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			$_POST['output_form_id'] = $_GET['form_id'];

			$pp = $this->model('tbs/input_forms_products')->get_in_warehouse($_POST['warehouse_id']);
			
			$product = $data['transport_input_form_product'];

			$granel = FALSE;

			if ($product['packaging_id']==48) {
				$granel = TRUE;
			}

			if ($_POST['old_quantity']<=$_POST['quantity']) {

				if (!$granel) {
					$virtual = $pp['virtual'] + $_POST['old_quantity'];
				}else{
					$virtual = $pp['virtual'];
				}

				if ($virtual>=$_POST['quantity']) {
					if ($this->model('tbs/transport_input_forms_products')->edit($_POST))
					{
						if ($product['packaging_id']!=48) {
							$this->model('tbs/warehouses')->from_virtual_reserved_to_virtual($product['warehouse_id'], $_POST['old_quantity']);
							$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($product['warehouse_id'], $_POST['quantity']);
						}

						if (count($data['transport_input_forms_verify'])!=0) {
							for ($i=0; $i < count($_POST['field_names']); $i++) {
								$this->model('tbs/transport_input_forms_verify')->create($_GET['form_id'], 2, $_GET['id'], $_POST['field_names']);
							}
						}

						redirect("tbs/transport_input_forms/details?id={$_GET['form_id']}");
					}
					else
					{
						set_notification('Ocurrió un error', 'error');
					}
				}else{
					set_notification('La cantidad que ingresó es mayor al saldo disponible', 'error');
				}
			}else{

				if ($this->model('tbs/transport_input_forms_products')->edit($_POST)) 
				{
					$product = $data['transport_input_form_product'];

					$this->model('tbs/warehouses')->from_virtual_reserved_to_virtual($product['warehouse_id'], $_POST['old_quantity']);
					$this->model('tbs/warehouses')->from_virtual_to_virtual_reserved($product['warehouse_id'], $_POST['quantity']);

					if (count($data['transport_input_forms_verify'])!=0) {
						for ($i=0; $i < count($_POST['field_names']); $i++) {
							$this->model('tbs/transport_input_forms_verify')->create($_GET['form_id'], 2, $_GET['id'], $_POST['field_names']);
						}
					}

					redirect("tbs/transport_input_forms/details?id={$_GET['form_id']}");
				}
				else
				{
					set_notification('Ocurrió un error', 'error');
				}
			}
		}

		$data['products'] = $this->model('tbs/products')->get_all_in_virtual();

		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	DELETE
----------------------------------------------------------------------*/
	public function delete()
	{
		$product = $this->model('tbs/transport_input_forms_products')->get_by_id($_GET['id']);
		
		if ($this->model('tbs/transport_input_forms_products')->delete($_GET['id'])) {
			$this->model('tbs/warehouses')->from_virtual_reserved_to_virtual($product['warehouse_id'], $product['quantity']);
			redirect_back('');
		}else{
			redirect_back('No se pudo eliminar', 'error');
		}
	}

}
