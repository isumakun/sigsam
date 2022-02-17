<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['companies'] = $this->model('indicator/companies')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($this->model('indicator/companies')->create($_POST))
				{
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("indicator/companies");
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['company'] = $this->model('indicator/companies')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("indicator/companies");
		}

		if ($_POST)
		{
			
				if ($this->model('indicator/companies')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("indicator/companies");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('indicator/companies')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("indicator/companies");
	}
}