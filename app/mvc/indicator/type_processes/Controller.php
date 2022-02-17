<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['processes'] = $this->model('indicator/processes')->get_all();
		$data['types'] = $this->model('indicator/types')->get_all();

		$this->view('', $data, 'fullwidth');
	}

	public function indicator_process(){
		echo json_encode('asdasdasd');
	}

/*------------------------------------------------------------------------------
	Json Data
------------------------------------------------------------------------------*/
	public function json_data()
	{
		if($_POST){
			$josnuser = $this->model('indicator/type_processes')->get_all();

			echo json_encode($josnuser,1);
		}
		
	}
/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($this->model('indicator/type_processes')->create($_POST))
				{
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("indicator/type_processes");
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
		if (!$data['type_process'] = $this->model('indicator/type_processes')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("indicator/type_processes");
		}

		if ($_POST)
		{
			
				if ($this->model('indicator/type_processes')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("indicator/type_processes");
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
		if ($this->model('indicator/type_processes')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("indicator/type_processes");
	}
}