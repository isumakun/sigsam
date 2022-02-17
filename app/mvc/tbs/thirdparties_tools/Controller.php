<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['thirdparties_tools'] = $this->model('tbs/thirdparties_tools')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($id = $this->model('tbs/thirdparties_tools')->create($_POST))
				{
					$tool = $this->model('tbs/thirdparties_tools')->get_by_id($id);
					set_message([$tool['id'], $tool['name']], 'tool');
					set_notification('Registro creado');
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}

			redirect_back();
		}
		

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['thirdparty_tool'] = $this->model('tbs/thirdparties_tools')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_tools");
		}

		if ($_POST)
		{
			
				if ($this->model('tbs/thirdparties_tools')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("tbs/thirdparties_tools");
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
		if ($this->model('tbs/thirdparties_tools')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("tbs/thirdparties_tools");
	}
}