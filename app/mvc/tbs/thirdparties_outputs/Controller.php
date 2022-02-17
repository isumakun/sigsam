<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		//error_reporting(E_ALL);
		$data['thirdparties_outputs'] = $this->model('tbs/thirdparties_outputs')->get_all();

		$this->view('', $data, 'fullwidth');
	}


/*------------------------------------------------------------------------------
	DETAILS
------------------------------------------------------------------------------*/
	public function details()
	{
		//error_reporting(E_ALL);
		$data['output'] = $this->model('tbs/thirdparties_outputs')->get_by_id($_GET['id']);
		$data['tools'] = $this->model('tbs/thirdparties_outputs_tools')->get_by_output_id($_GET['id']);

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($id = $this->model('tbs/thirdparties_outputs')->create($_POST))
				{
					$tools = $this->model('tbs/thirdparties_requests_tools')->get_by_request_id($_POST['request_id']);

					foreach ($tools as $tool) {
						$tool['output_id'] = $id;
						$this->model('tbs/thirdparties_outputs_tools')->create($tool);
					}

					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("tbs/thirdparties_outputs/details?id=$id");
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		
		$data['thirdparties_requests'] = $this->model('tbs/thirdparties_requests')->get_all_approved();
		$data['thirdparties_companies'] = $this->model('tbs/thirdparties_companies')->get_all();
		$data['thirdparties_employees'] = $this->model('tbs/thirdparties_employees')->get_all();

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['thirdparty_output'] = $this->model('tbs/thirdparties_outputs')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_outputs");
		}

		if ($_POST)
		{
			
				if ($this->model('tbs/thirdparties_outputs')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("tbs/thirdparties_outputs");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		
		$data['thirdparties_requests'] = $this->model('tbs/thirdparties_requests')->get_all();
		$data['thirdparties_companies'] = $this->model('tbs/thirdparties_companies')->get_all();
		$data['thirdparties_employees'] = $this->model('tbs/thirdparties_employees')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/thirdparties_outputs')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("tbs/thirdparties_outputs");
	}

/*----------------------------------------------------------------------
	PRINTOUT
----------------------------------------------------------------------*/
	public function printout()
	{
		//error_reporting(E_ALL);
		$output = $this->model('tbs/thirdparties_outputs')->get_by_id($_GET['id']);

		data('workers', $this->model('tbs/thirdparties_workers')->get_by_request_id($output['request_id']));
		data('supports', $this->model('tbs/thirdparties_supports')->get_by_request_id($output['request_id']));
		data('tools', $this->model('tbs/thirdparties_outputs_tools')->get_by_output_id($_GET['id']));
		data('thirdparties_works_types', $this->model('tbs/thirdparties_works_types')->get_all());

		data('output', $this->model('tbs/thirdparties_outputs')->get_by_id($_GET['id']));
		render('flat');
	}
}