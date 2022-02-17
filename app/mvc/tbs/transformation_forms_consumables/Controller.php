<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			$_POST['transformation_form_id'] = $_GET['form_id'];
			
			$product = $this->model('tbs/input_forms_products')->get_in_warehouse($_POST['warehouse_id']);

			if ($product['stock']>=$_POST['quantity']) {
				if ($id = $this->model('tbs/transformation_forms_consumables')->create($_POST)) 
				{
					$this->model('tbs/warehouses')->from_stock_to_reserved($_POST['warehouse_id'], $_POST['quantity']);

					redirect("tbs/transformation_forms/details?id={$_GET['form_id']}");
				}
				else
				{
					set_notification('Ocurrió un error', 'error');
				}
			}else{
				set_notification('La cantidad solicitada es mayor al saldo', 'error');
			}
		}

		$data['products'] = $this->model('tbs/products')->get_all_in_stock();

		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['transformation_form_consumable'] = $this->model('tbs/transformation_forms_consumables')->get_by_id($_GET['id']);
		$data['transformation_forms_verify'] = $this->model('tbs/transformation_forms_verify')->get_by_form_id($_GET['form_id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			$_POST['transformation_form_id'] = $_GET['form_id'];
			
			$product = $this->model('tbs/transformation_forms_consumables')->get_by_id($_GET['id']);

			$consumable = $data['transformation_form_consumable'];

			$this->model('tbs/warehouses')->from_reserved_to_stock($consumable['warehouse_id'], $consumable['quantity']);
			$this->model('tbs/warehouses')->from_stock_to_reserved($consumable['warehouse_id'], $_POST['quantity']);

			if ($this->model('tbs/transformation_forms_consumables')->edit($_POST)) 
			{
				if (count($data['transformation_forms_verify'])!=0) {
					$this->model('tbs/transformation_forms_verify')->create($_GET['form_id'], 2, $_GET['id'], $_POST['field_names']);
				}
				
				redirect("tbs/transformation_forms/details?id={$_GET['form_id']}");
			}
			else
			{
				redirect('', 'Ocurrió un error', 'error');
			}
		}
		
		$data['products'] = $this->model('tbs/products')->get_all();

		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	DELETE
----------------------------------------------------------------------*/
	public function delete()
	{
		$product = $this->model('tbs/transformation_forms_consumables')->get_by_id($_GET['id']);
		
		if ($this->model('tbs/transformation_forms_consumables')->delete($_GET['id'])) {

			$this->model('tbs/warehouses')->from_reserved_to_stock($product['warehouse_id'], $product['quantity']);

			redirect_back('');
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
