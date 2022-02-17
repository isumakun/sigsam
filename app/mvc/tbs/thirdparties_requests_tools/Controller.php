<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['thirdparties_requests_tools'] = $this->model('tbs/thirdparties_requests_tools')->get_all();

		$this->view('', $data, 'fullwidth');
	}


/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($this->model('tbs/thirdparties_requests_tools')->create($_POST))
				{
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("tbs/thirdparties_requests/details?id=".$_POST['request_id']);
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		
		
		$data['tools'] = $this->model('tbs/thirdparties_tools')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	check_entry
------------------------------------------------------------------------------*/
	public function check_entry()
	{
		$current_schema = $_SESSION['user']['company_schema'];
		$count = 0;

		foreach ($_POST['tools_ids'] as $tool) {
			$tool = explode("-", $tool);
			$nit = $tool[0];
			$tool_id = $tool[1];

			$_SESSION['user']['company_schema'] = 'tbs3_'.$nit;

			if ($_GET['type']==1) {
				$this->model('tbs/thirdparties_requests_tools')->check_entry($tool_id, $_POST['observations'][$count]);
			}else{
				$this->model('tbs/thirdparties_requests_tools')->no_enter($tool_id, $_POST['observations'][$count]);
			}
			

			$count++;
		}

		$_SESSION['user']['company_schema'] = $current_schema;

		set_notification('Inspeccionado');
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['thirdparty_request_tool'] = $this->model('tbs/thirdparties_requests_tools')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_requests_tools");
		}

		if ($_POST)
		{
			
				if ($this->model('tbs/thirdparties_requests_tools')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect_back();
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		
		$data['thirdparties_requests'] = $this->model('tbs/thirdparties_requests')->get_all();
		$data['tools'] = $this->model('tbs/thirdparties_tools')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/thirdparties_requests_tools')->delete_by_id($_GET['id']))
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