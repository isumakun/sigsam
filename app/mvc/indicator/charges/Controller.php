<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['charges'] = $this->model('indicator/charges')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($this->model('indicator/charges')->create($_POST))
				{
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("indicator/charges");
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		
		$data['users'] = $this->model('admin/users')->get_all();
		$data['companies'] = $this->model('indicator/companies')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['charge'] = $this->model('indicator/charges')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("indicator/charges");
		}

		if ($_POST)
		{
			
				if ($this->model('indicator/charges')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("indicator/charges");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		
		$data['users'] = $this->model('indicator/users')->get_all();
		$data['companies'] = $this->model('indicator/companies')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('indicator/charges')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("indicator/charges");
	}
}