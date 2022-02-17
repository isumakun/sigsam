<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['processes'] = $this->model('indicator/processes')->get_all();

		$this->view('', $data, 'fullwidth');
	}


/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($this->model('indicator/processes')->create($_POST))
				{
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("indicator/processes");
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		
		$data['type_processes'] = $this->model('indicator/type_processes')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['process'] = $this->model('indicator/processes')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("indicator/processes");
		}

		if ($_POST)
		{
			
				if ($this->model('indicator/processes')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("indicator/processes");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		
		$data['type_processes'] = $this->model('indicator/type_processes')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('indicator/processes')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("indicator/processes");
	}
}