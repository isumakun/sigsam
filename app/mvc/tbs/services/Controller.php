<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['services'] = $this->model('tbs/services')->get_all();
		$data['services_concepts'] = $this->model('tbs/services_concepts')->get_all();

		$this->view('Inicio', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			if ($id = $this->model('tbs/services')->create($_POST))
			{
				foreach ($_POST['concepts'] as $concept) {
					$this->model('tbs/services_concepts')->create($concept, $id);
				}
				redirect("tbs/services/details?id=$id");
			}
			else
			{
				set_notification('No pudo crearse el formulario.', 'error');
			}
		}

		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['concepts'] = $this->model('tbs/concepts')->get_all();
		$this->view('Inicio', $data);
	}

/*----------------------------------------------------------------------
	DETAILS
----------------------------------------------------------------------*/
	public function details()
	{
		$data['service'] = $this->model('tbs/services')->get_by_id($_GET['id']);
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['concepts'] = $this->model('tbs/concepts')->get_all();
		$data['services_products'] = $this->model('tbs/services_products')->get_by_form_id($_GET['id']);
		$data['services_concepts'] = $this->model('tbs/services_concepts')->get_by_service_id($_GET['id']);

		$this->view('Detalles', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['service'] = $this->model('tbs/services')->get_by_id($_GET['id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			if ($this->model('tbs/services')->edit($_POST))
			{
				$this->model('tbs/services_concepts')->delete_by_service_id($_GET['id']);
				foreach ($_POST['concepts'] as $concept) {
					$this->model('tbs/services_concepts')->create($concept, $_GET['id']);
				}
				set_notification('Guardado');
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
			}

			redirect_back();
		}

		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['concepts'] = $this->model('tbs/concepts')->get_all();
		$data['services_concepts'] = $this->model('tbs/services_concepts')->get_by_service_id($_GET['id']);
		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	DELETE
----------------------------------------------------------------------*/
	public function delete()
	{	
		if ($this->model('tbs/services')->delete($_GET['id'])) {
			
			redirect_back('');
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
