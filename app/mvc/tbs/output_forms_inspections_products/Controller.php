<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['products'] = $this->model('tbs/products')->get_all_in_virtual_reserved();

		$this->view('', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	CREATE MASSIVELY
----------------------------------------------------------------------*/
	public function create_massively()
	{
		$ok = array();

		foreach ($_POST['warehouses_id'] as $wid) {

			$wid = explode('-', $wid);
			$warehous_id = $wid[0];
			$output_form_id = $wid[1];

			if (!in_array($warehous_id, $ok)) {
				$product = $this->model('tbs/output_forms_products')->get_in_warehouse($warehous_id, $output_form_id);

				$this->model('tbs/output_forms_inspections_products')->create($warehous_id);

				$this->model('tbs/warehouses')->from_approved_to_inspected_to_output($warehous_id, $product['quantity']);

				array_push($ok, $warehous_id);
			}
		}

		set_notification('Se inspeccionaron los productos correctamente');
	}

/*----------------------------------------------------------------------
	RECOVER
----------------------------------------------------------------------*/
	public function recover()
	{
		$products_list = '';
		foreach ($_POST['warehouses_id'] as $warehouses_id) {
			$wid = explode('-', $warehouses_id);
			$warehous_id = $wid[0];
			$output_form_id = $wid[1];
			$product = $this->model('tbs/input_forms_products')->get_in_warehouse($warehous_id);

			$products_list .= $product['product'].', ';
			$this->model('tbs/output_forms_inspections_requests')->delete_by_warehouse_id($warehous_id);
		}

		//Crear notificación
		$noti_body = 'Se devolvió la inspección de los siguientes productos: <b>'.$products_list.'</b> por la siguiente razón: '.$_POST['observations'];
		$this->model('tbs/notifications')->create('cancel', $noti_body, 1);
	}

}
