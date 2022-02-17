<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['services_products'] = $this->model('tbs/services_products')->get_all();

		$this->view('Inicio', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			$_POST['service_id'] = $_GET['form_id'];

			if ($id = $this->model('tbs/services_products')->create($_POST))
			{
				redirect("tbs/services/details?id=".$_GET['form_id']);
			}
			else
			{
				set_notification('No pudo crearse el formulario.', 'error');
			}
		}

		$data['products'] = $this->model('tbs/products')->get_all();
		$data['concepts'] = $this->model('tbs/concepts')->get_all();
		$this->view('Inicio', $data);
	}

/*----------------------------------------------------------------------
	CREATE MASSIVE
----------------------------------------------------------------------*/
	public function create_massively()
	{
			$_POST['service_id'] = $_POST['form_id'];

			foreach ($_POST['products_id'] as $product) {

				$_POST['product_id'] = $product;

				if ($id = $this->model('tbs/services_products')->create($_POST))
				{
					
				}
				else
				{
					set_notification('No se pudo crear el producto '.$product, 'error');
				}
			}
	}

/*----------------------------------------------------------------------
	DETAILS
----------------------------------------------------------------------*/
	public function details()
	{
		$data['service_product'] = $this->model('tbs/services_products')->get_by_id($_GET['id']);
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();
		$data['concepts'] = $this->model('tbs/concepts')->get_all();

		$this->view('Detalles', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['service_product'] = $this->model('tbs/services_products')->get_by_id($_GET['id']);

		if ($_POST)
		{
			$_POST['service_id'] = $_GET['form_id'];
			if ($this->model('tbs/services')->edit($_POST))
			{
				set_notification('Guardado');
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
			}

			redirect_back();
		}

		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	DELETE
----------------------------------------------------------------------*/
	public function delete()
	{	
		if ($this->model('tbs/services_products')->delete($_GET['id'])) {
			
			redirect_back('');
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
