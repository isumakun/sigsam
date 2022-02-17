<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['users_companies'] = $this->model('indicator/users_companies')->get_all();

		$this->view('', $data, 'fullwidth');
	}


/*------------------------------------------------------------------------------
	change_company
------------------------------------------------------------------------------*/
	public function change_company()
	{
		ini_set('display_errors', true);
		//error_reporting(E_ALL);

		$company = $this->model('indicator/users_companies')->get_by_company_id($_POST['company']);
		
		$_SESSION['user']['company_id'] = $company['company_id'];
		$_SESSION['user']['company_name'] = $company['company'];
		$_SESSION['company_users'] = $this->model('admin/users')->get_users_by_company($company['id']);

		set_notification('Empresa cambiada a: '.$company['company'], 'success', TRUE);
		redirect("./");
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($this->model('indicator/users_companies')->create($_POST))
				{
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("indicator/users_companies");
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		
		$data['users'] = $this->model('indicator/users')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['user_company'] = $this->model('indicator/users_companies')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("indicator/users_companies");
		}

		if ($_POST)
		{
			
				if ($this->model('indicator/users_companies')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("indicator/users_companies");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		
		$data['users'] = $this->model('indicator/users')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('indicator/users_companies')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("indicator/users_companies");
	}
}