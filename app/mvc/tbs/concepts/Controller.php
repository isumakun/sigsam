<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['concepts'] = $this->model('tbs/concepts')->get_all();

		$this->view('Inicio', $data);
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			if ($id = $this->model('tbs/concepts')->create($_POST))
			{
				$concept = $this->model('tbs/concepts')->get_by_id($id);
				set_message([$concept['id'], $concept['name']], 'concept');
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
		$data['concept'] = $this->model('tbs/concepts')->get_by_id($_GET['id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			if ($this->model('tbs/concepts')->edit($_POST))
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
		if ($this->model('tbs/concepts')->delete($_GET['id'])) {
			
			redirect_back();
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
