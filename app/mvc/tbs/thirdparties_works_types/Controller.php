<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['thirdparties_works_types'] = $this->model('tbs/thirdparties_works_types')->get_all();

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	VIEW
------------------------------------------------------------------------------*/
	public function view()
	{
		if (!$data['thirdparty_work_type'] = $this->model('tbs/thirdparties_works_types')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_works_types");
		}
		

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($this->model('tbs/thirdparties_works_types')->create($_POST))
				{
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("tbs/thirdparties_works_types");
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['thirdparty_work_type'] = $this->model('tbs/thirdparties_works_types')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_works_types");
		}

		if ($_POST)
		{
			
				if ($this->model('tbs/thirdparties_works_types')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("tbs/thirdparties_works_types");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/thirdparties_works_types')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("tbs/thirdparties_works_types");
	}
}