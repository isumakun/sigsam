<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['thirdparties_workers'] = $this->model('tbs/thirdparties_workers')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			$worker = $this->model('tbs/thirdparties_workers')->get_by_employee_id($_POST['employee_id']);
			$request = $this->model('tbs/thirdparties_requests')->get_by_id($_POST['request_id']);

			$insert = FALSE;
			if (!empty($worker)) {
				$date1 = new DateTime($worker['limit_date']);
				$date2 = new DateTime($request['schedule_to']);

				if ($date1>=$date2) {
					$insert = TRUE;
				}
			}

			if ($insert) {
				if ($this->model('tbs/thirdparties_workers')->create_with_limit_date($_POST, $worker['limit_date']))
				{
					set_notification("Trabajador registrado correctamente", 'success', TRUE);
					redirect("tbs/thirdparties_requests/details?id=".$_POST['request_id']);
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
			}else{
				if ($this->model('tbs/thirdparties_workers')->create($_POST))
				{
					set_notification("Trabajador registrado correctamente", 'success', TRUE);
					redirect("tbs/thirdparties_requests/details?id=".$_POST['request_id']);
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
			}
				
		}
		//error_reporting(E_ALL);
		$data['thirdparties_employees'] = $this->model('tbs/thirdparties_employees')->get_all();
		$data['thirdparties_workers_categories'] = $this->model('tbs/thirdparties_workers_categories')->get_all();
		$data['thirdparties_works_types'] = $this->model('tbs/thirdparties_works_types')->get_all();
		$data['thirdparties_requests'] = $this->model('tbs/thirdparties_requests')->get_all();

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	UPDATE LIMIT DATE
------------------------------------------------------------------------------*/
	public function update_limit_date()
	{
		if ($data['thirdparty_worker'] = $this->model('tbs/thirdparties_workers')->update_limit_date($_POST['worker_id'], $_POST['limit_date']))
		{
			redirect_back();
		}
	}


/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['thirdparty_worker'] = $this->model('tbs/thirdparties_workers')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_workers");
		}

		if ($_POST)
		{
			
				if ($this->model('tbs/thirdparties_workers')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("tbs/thirdparties_requests/details?id=".$_POST['request_id']);
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		
		$data['thirdparties_employees'] = $this->model('tbs/thirdparties_employees')->get_all();
		$data['thirdparties_workers_categories'] = $this->model('tbs/thirdparties_workers_categories')->get_all();
		$data['thirdparties_works_types'] = $this->model('tbs/thirdparties_works_types')->get_all();
		$data['thirdparties_requests'] = $this->model('tbs/thirdparties_requests')->get_all();

		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/thirdparties_workers')->delete_by_id($_GET['id']))
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