<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['warehouses_tools'] = $this->model('tbs/warehouses_tools')->get_all();

		$this->view('Inicio', $data);
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			if ($id = $this->model('tbs/warehouses_tools')->create($_POST))
			{
				$tool = $this->model('tbs/warehouses_tools')->get_by_id($id);
				set_message([$tool['id'], $tool['name']], 'tool');
				set_notification('Creado');
			}
			else
			{
				set_notification('Se creó mal.', 'error');
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
		$data['tool'] = $this->model('tbs/warehouses_tools')->get_by_id($_GET['id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			if ($this->model('tbs/warehouses_tools')->edit($_POST))
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
		if ($this->model('tbs/warehouses_tools')->delete($_GET['id'])) {
			
			redirect_back();
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
