<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['thirdparties_outputs_tools'] = $this->model('tbs/thirdparties_outputs_tools')->get_all();

		$this->view('', $data, 'fullwidth');
	}


/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($this->model('tbs/thirdparties_outputs_tools')->create($_POST))
				{
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("tbs/thirdparties_outputs_tools");
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		
		$data['thirdparties_outputs'] = $this->model('tbs/thirdparties_outputs')->get_all();
		$data['thirdparties_requests_tools'] = $this->model('tbs/thirdparties_requests_tools')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['thirdparty_output_tool'] = $this->model('tbs/thirdparties_outputs_tools')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_outputs_tools");
		}

		if ($_POST)
		{
			
				if ($this->model('tbs/thirdparties_outputs_tools')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("tbs/thirdparties_outputs/details?id=".$_POST['output_id']);
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		
		$data['thirdparties_outputs'] = $this->model('tbs/thirdparties_outputs')->get_all();
		$data['thirdparties_requests_tools'] = $this->model('tbs/thirdparties_requests_tools')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/thirdparties_outputs_tools')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("tbs/thirdparties_outputs_tools");
	}
}