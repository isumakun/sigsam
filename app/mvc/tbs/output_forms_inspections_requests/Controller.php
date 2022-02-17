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
		foreach ($_POST['warehouses_id'] as $wid) {

			$this->model('tbs/output_forms_inspections_requests')->create($wid, $_POST['observations']);

			set_notification('Se ha solicitado la inspección');
		}

		//Crear notificación
		$noti_body = 'Tiene una nueva solicitud de inspección hecha por @'.$_SESSION['user']['username'];
		$this->model('tbs/notifications')->create('file-text', $noti_body);
	}

/*----------------------------------------------------------------------
	INSPECT_ALL
----------------------------------------------------------------------*/
	/*public function inspect_all()
	{
		$count = 0;
		$products = $this->model('tbs/products')->get_all_in_locked_by_input_form($_POST['input_form_id']);
		$inserted = array();

		if (!count($products)==0) {
			foreach ($products as $product) {
				$this->model('tbs/output_forms_inspections_requests')->create($product['wid']);
			}

			set_notification(count($products).' Solicitados para inspección');
		}else{
			set_notification('Este formulario no tiene productos para inspección', 'error');
		}

		redirect_back();
	}*/

}
