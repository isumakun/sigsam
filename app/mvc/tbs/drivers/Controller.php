<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['drivers'] = $this->model('tbs/drivers')->get_all();

		$this->view('Inicio', $data);
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			if ($id = $this->model('tbs/drivers')->create($_POST))
			{
				$driver = $this->model('tbs/drivers')->get_by_id($id);
				set_message([$driver['id'], $driver['name']], 'driver');
				//set_notification('Se creó bien.');
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
		$data['driver'] = $this->model('tbs/drivers')->get_by_id($_GET['id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			if ($this->model('tbs/drivers')->edit($_POST))
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
		if ($this->model('tbs/drivers')->delete($_GET['id'])) {
			
			redirect_back('');
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
