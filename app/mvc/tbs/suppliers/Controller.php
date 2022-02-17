<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['suppliers'] = $this->model('tbs/suppliers')->get_all();

		$this->view('Inicio', $data);
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		error_reporting(E_ALL);
		if ($_POST)
		{
			if ($id = $this->model('tbs/suppliers')->create($_POST))
			{
				$supplier = $this->model('tbs/suppliers')->get_by_id($id);
				set_message([$supplier['id'], $supplier['name']], 'supplier');
				set_notification('Concepto creado');
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
			}

			redirect_back();
		}

		$this->view('Inicio', $data);
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['supplier'] = $this->model('tbs/suppliers')->get_by_id($_GET['id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			if ($this->model('tbs/suppliers')->edit($_POST))
			{
				set_notification('Se editó bien.');
			}
			else
			{
				set_notification('Se editó mal.', 'error');
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
		if ($this->model('tbs/suppliers')->delete($_GET['id'])) {
			
			redirect_back();
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
