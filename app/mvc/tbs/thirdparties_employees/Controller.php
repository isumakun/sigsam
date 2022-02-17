<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['thirdparties_employees'] = $this->model('tbs/thirdparties_employees')->get_all();

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($id = $this->model('tbs/thirdparties_employees')->create($_POST))
				{
					$employee = $this->model('tbs/thirdparties_employees')->get_by_id($id);
					$name = $employee['citizen_id'].' - '.$employee['name'];
					set_message([$employee['id'], $name], 'employee');
					set_notification('Registro creado');
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}

				redirect_back();
		}

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['thirdparty_employee'] = $this->model('tbs/thirdparties_employees')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_employees");
		}

		if ($_POST)
		{
				if ($this->model('tbs/thirdparties_employees')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					//redirect("tbs/thirdparties_employees");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}

				redirect_back();
		}
		

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/thirdparties_employees')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect_back();
	}
}