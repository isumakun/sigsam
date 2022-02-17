<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['thirdparties_companies'] = $this->model('tbs/thirdparties_companies')->get_all();

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($id = $this->model('tbs/thirdparties_companies')->create($_POST))
				{
					$company = $this->model('tbs/thirdparties_companies')->get_by_id($id);
					$name = $company['nit'].' - '.$company['name'];
					set_message([$company['id'], $name], 'company');
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
		if (!$data['thirdparty_company'] = $this->model('tbs/thirdparties_companies')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_companies");
		}

		if ($_POST)
		{
			
				if ($this->model('tbs/thirdparties_companies')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect_back();
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
		if ($this->model('tbs/thirdparties_companies')->delete_by_id($_GET['id']))
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