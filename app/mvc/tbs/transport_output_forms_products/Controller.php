<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['transport_output_forms_products'] = $this->model('tbs/transport_output_forms_products')->get_all();

		$this->view('', $data);
	}

/*----------------------------------------------------------------------
	CREATE MASSIVELY
----------------------------------------------------------------------*/
	public function create_massively()
	{

		foreach ($_POST['products_id'] as $exp) {

			$exp = explode('-', $exp);
			$wid = $exp[0];
			$output_form_id = $exp[1];

			$product = $this->model('tbs/output_forms_products')->get_in_warehouse($wid, $output_form_id);

			if ($product['inspected_to_output']>=$product['quantity']) {
				$this->model('tbs/transport_output_forms_products')->create($_POST['form_id'], $wid, $product['inspected_to_output'], $output_form_id);

				$this->model('tbs/warehouses')->from_inspected_to_output_to_reserved_to_output($wid, $product['inspected_to_output']);
			}else{
				$this->model('tbs/transport_output_forms_products')->create($_POST['form_id'], $wid, $product['inspected_to_output'], $output_form_id);

				$this->model('tbs/warehouses')->from_inspected_to_output_to_reserved_to_output($wid, $product['inspected_to_output']);
				
				set_notification('Se añadió TODO el saldo en inspeccionado para salida del producto: '.$product['product'], 'info');
			}
		}
	}

/*----------------------------------------------------------------------
	CREATE MASSIVELY
----------------------------------------------------------------------*/
	public function create_massively_transformated()
	{
		foreach ($_POST['products_id'] as $exp) {
			$exp = explode('-', $exp);
			$wid = $exp[0];
			$output_form_id = $exp[1];

			$product = $this->model('tbs/transformation_forms_products')->get_in_warehouse($wid, $output_form_id);

			$this->model('tbs/transport_output_forms_products')->create($_POST['form_id'], $wid, $product['quantity'], $output_form_id);

			$this->model('tbs/warehouses')->from_inspected_to_output_to_reserved_to_output($wid, $product['quantity']);
		}
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['transport_output_form_product'] = $this->model('tbs/transport_output_forms_products')->get_by_id($_GET['id']);
		
		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			$_POST['output_form_id'] = $_GET['form_id'];
			
			if ($this->model('tbs/transport_output_forms_products')->edit($_POST)) 
			{
				$product = $data['transport_output_form_product'];

				$this->model('tbs/warehouses')->from_reserved_to_output_to_inspected_to_output($product['wid'], $_POST['old_quantity']);
				$this->model('tbs/warehouses')->from_inspected_to_output_to_reserved_to_output($product['wid'], $_POST['quantity']);

				if (count($data['transport_output_forms_verify'])!=0) {
					for ($i=0; $i < count($_POST['field_names']); $i++) {
						$this->model('tbs/transport_output_forms_verify')->create($_GET['form_id'], 2, $_GET['id'], $_POST['field_names']);
					}
				}

				redirect("tbs/transport_output_forms/details?id={$_GET['form_id']}");
			}
			else
			{
				redirect('Ocurrió un error', 'error');
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
		$product = $this->model('tbs/transport_output_forms_products')->get_by_id($_GET['id']);
		
		if ($this->model('tbs/transport_output_forms_products')->delete($_GET['id'])) {

			$this->model('tbs/warehouses')->from_reserved_to_output_to_inspected_to_output($product['wid'], $product['quantity']);
			redirect_back("Producto removido");
		}else{
			redirect_back('No se pudo eliminar', 'error');
		}
	}

}
