<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['products'] = $this->model('tbs/products')->get_all_in_virtual_reserved();

		render('fullwidth', $data);
	}

/*----------------------------------------------------------------------
	CREATE MASSIVELY
----------------------------------------------------------------------*/
	public function create_massively()
	{
		$count = 0;
		
		foreach ($_POST['warehouses_id'] as $wid) {
			$product = $this->model('tbs/input_forms_products')->get_in_warehouse($wid);

			$this->model('tbs/input_forms_inspections_products')->create($wid, $_POST['observations'][$count]);

			$this->model('tbs/warehouses')->from_locked_to_inspected_to_input($wid, $product['locked']);

			$form_products = $this->model('tbs/warehouses')->get_products_form($product['form_id']);

			$sum_locked = 0;
			foreach ($form_products as $form_product) {
				$sum_locked += $form_product['virtual'] + $form_product['virtual_reserved'] + $form_product['locked'];
			}
			

			if ($sum_locked==0) {
				foreach ($form_products as $form_product) {
					$this->model('tbs/warehouses')->from_inspected_to_input_to_stock($form_product['wid'], $form_product['inspected_to_input']);
				}

				$this->model('tbs/input_forms')->execute($product['form_id']);

				set_notification('Se inspeccionaron todos los productos del formulario '.$product['form_id'].' y se ejecutó', 'info');
			}else{
				set_notification('Se inspeccionaron los productos correctamente');
			}

			$count++;
		}
	}

/*----------------------------------------------------------------------
	INSPECT_ALL
----------------------------------------------------------------------*/
	public function inspect_all()
	{
		$count = 0;
		$products = $this->model('tbs/products')->get_all_in_locked_by_input_form($_POST['input_form_id']);
		$inserted = array();

		foreach ($products as $product) {

			$this->model('tbs/warehouses')->from_locked_to_inspected_to_input($product['wid'], $product['locked']);
			$this->model('tbs/warehouses')->from_inspected_to_input_to_stock($product['wid'], $product['locked']);
			array_push($inserted, $product['wid']);
			$this->model('tbs/input_forms_inspections_products')->create_manual($product['wid'], $_POST['observation'], $_POST['inspected_by'], $_POST['inspected_at']);

		}
		set_notification(count($products).' Productos pasados a stock');
		redirect_back();
	}

}
