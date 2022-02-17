<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['requests'] = $this->model('tbs/thirdparties_requests')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	REDIRECT
------------------------------------------------------------------------------*/
	public function redirect()
	{
		$current_schema = $_SESSION['user']['company_schema'];
		$new_schema = 'tbs3_'.$_GET['nit'];

		if ($current_schema!=$new_schema) {
			$company = $this->model('tbs/companies')->get_by_id($_GET['nit']);

			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];
			$_SESSION['user']['company_name'] = $company['name'];
			$_SESSION['user']['company_alias'] = $company['alias'];
			
			set_notification('Se ha cambiado de empresa a: '.$company['name']);
		}

		redirect('tbs/thirdparties_requests/details?id='.$_GET['id']);

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	GLOBAL VIEW
------------------------------------------------------------------------------*/
	public function global_view()
	{
		//error_reporting(E_ALL);
		$companies = $this->model('tbs/companies')->get_all();

		$current_schema = $_SESSION['user']['company_schema'];

		$data['requests'] = array();

		foreach ($companies as $company) {
			$_SESSION['user']['company_schema'] = 'tbs3_'.$company['id'];

			if (has_role(1)) {
				$requests = $this->model('tbs/thirdparties_requests')->get_all_presented();
				$requests = $this->model('tbs/thirdparties_requests')->get_all_verified();
			}else if (has_role(7)) {
				$requests = $this->model('tbs/thirdparties_requests')->get_all_presented();
			}elseif (has_role(3)) {
				$requests = $this->model('tbs/thirdparties_requests')->get_all_verified();
			}
			array_push($data['requests'], $requests);
		}

		$_SESSION['user']['company_schema'] = $current_schema;

		$this->view('', $data, 'fullwidth');
	}


/*------------------------------------------------------------------------------
	HOME
------------------------------------------------------------------------------*/
	public function home()
	{
		$data['thirdparties_requests'] = $this->model('tbs/thirdparties_requests')->get_all();

		$this->view('', $data);
	}

/*----------------------------------------------------------------------
	PRESENT
----------------------------------------------------------------------*/
	public function present()
	{
		$request = $this->model('tbs/thirdparties_requests')->get_by_id($_GET['id']);
		$workers = $this->model('tbs/thirdparties_workers')->get_by_request_id($_GET['id']);

		$all_allowed = TRUE;

		foreach ($workers as $worker) {
			if ($worker['is_employee']==0) {
				if ($worker['category_id']!=1) {
					$all_allowed = FALSE;
				}
			}

			if ($worker['category_id']!=1) {
				if ($worker['limit_date']=='0000-00-00') {
					$all_allowed = FALSE;
				}else{
					$request_limit_date = strtotime($request['schedule_to']);
					$worker_limit_date = strtotime($worker['limit_date']);
					if ($worker_limit_date<$request_limit_date) {
						$all_allowed = FALSE;
					}
				}
			}
		}

		if ($this->model('tbs/thirdparties_requests')->present($_GET['id'])) 
		{
			if ($all_allowed) {
				$this->model('tbs/thirdparties_requests')->verify_auto($_GET['id']);
				
				//Crear notificación
				$noti_body = 'La solicitud de terceros <b>#'.$_GET['id'].'</b> verificó automaticamente y necesita aprobación';
				$this->model('tbs/notifications')->create('checkmark', $noti_body);

				redirect("tbs/thirdparties_requests/details?id={$_GET['id']}", 'Se verificó la solicitud automaticamente');
			}else{
				//Crear notificación
				$form = $this->model('tbs/thirdparties_requests')->get_by_id($_GET['id']);
				$noti_body = 'La solicitud de terceros <b>#'.$_GET['id'].'</b> fue presentada por @'.$form['created_by'];
				$this->model('tbs/notifications')->create('file-text', $noti_body);

				redirect("tbs/thirdparties_requests/details?id={$_GET['id']}", 'Formulario Presentado');
			}
		}
		else
		{
			redirect("tbs/thirdparties_requests/details?id={$_GET['id']}", 'No se pudo presentar el Formulario', 'error');
		}
	}


/*----------------------------------------------------------------------
	APPROVE
----------------------------------------------------------------------*/
	public function approve()
	{
		if ($this->model('tbs/thirdparties_requests')->approve($_GET['id'])) 
		{
			//Crear notificación
			$form = $this->model('tbs/thirdparties_requests')->get_by_id($_GET['id']);
			$noti_body = 'La solicitud de terceros <b>#'.$_GET['id'].'</b> fue aprobada por @'.$_SESSION['user']['username'];
			$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);

			redirect("tbs/thirdparties_requests/details?id={$_GET['id']}", 'Formulario Presentado');
		}
		else
		{
			redirect("tbs/thirdparties_requests/details?id={$_GET['id']}", 'No se pudo presentar el Formulario', 'error');
		}
	}

/*----------------------------------------------------------------------
	VERIFY
----------------------------------------------------------------------*/
	public function verify()
	{
		$workers = $this->model('tbs/thirdparties_workers')->get_by_request_id($_GET['id']);

		$all_allowed = TRUE;

		foreach ($workers as $worker) {
			if ($worker['category_id']!=1) {
				if ($worker['limit_date']=='0000-00-00') {
					$all_allowed = FALSE;
				}else{
					$request_limit_date = strtotime($request['schedule_to']);
					$worker_limit_date = strtotime($worker['limit_date']);
					if ($worker_limit_date<$request_limit_date) {
						$all_allowed = FALSE;
					}
				}
			}
		}

		if ($all_allowed) {
			if ($this->model('tbs/thirdparties_requests')->verify($_GET['id'])) 
			{
				//Crear notificación
				$form = $this->model('tbs/thirdparties_requests')->get_by_id($_GET['id']);
				$noti_body = 'La solicitud de terceros <b>#'.$_GET['id'].'</b> ha sido verificada por @'.$_SESSION['user']['username'];
				$this->model('tbs/notifications')->create('checkmark', $noti_body, 1);

				//Crear notificación
				$noti_body = 'La solicitud de terceros <b>#'.$_GET['id'].'</b> ha sido verificada por @'.$_SESSION['user']['username'];
				$this->model('tbs/notifications')->create('checkmark', $noti_body);

				redirect("tbs/thirdparties_requests/details?id={$_GET['id']}", 'Formulario Verificado');
			}
			else
			{
				redirect("tbs/thirdparties_requests/details?id={$_GET['id']}", 'No se pudo presentar el Formulario', 'error');
			}
		}else{
			redirect("tbs/thirdparties_requests/details?id={$_GET['id']}", 'No se puede verificar esta solicitud, algunos trabajadores no tienen fecha de ARL o ya está vencida', 'error');
		}
		
	}

/*----------------------------------------------------------------------
	REJECT
----------------------------------------------------------------------*/
	public function reject()
	{
		if ($this->model('tbs/thirdparties_requests')->reject($_POST['form_id'])) 
		{
			//Crear notificación
			$form = $this->model('tbs/thirdparties_requests')->get_by_id($_POST['form_id']);
			$noti_body = 'La solicitud de terceros <b>#'.$_POST['form_id'].'</b> fue rechazada por @'.$_SESSION['user']['username'].' por las siguientes razones: '.$_POST['observations'];
			$this->model('tbs/notifications')->create('cancel', $noti_body, 1);

			redirect("tbs/thirdparties_requests/details?id={$_POST['form_id']}", 'Formulario Rechazado', 'error');
		}
		else
		{
			redirect("tbs/thirdparties_requests/details?id={$_POST['form_id']}", 'No se pudo presentar el Formulario', 'error');
		}
	}

/*------------------------------------------------------------------------------
	DETAILS
------------------------------------------------------------------------------*/
	public function details()
	{
		//error_reporting(E_ALL);
		$data['request'] = $this->model('tbs/thirdparties_requests')->get_by_id($_GET['id']);
		$data['workers'] = $this->model('tbs/thirdparties_workers')->get_by_request_id($_GET['id']);
		$data['supports'] = $this->model('tbs/thirdparties_supports')->get_by_request_id($_GET['id']);
		$data['tools'] = $this->model('tbs/thirdparties_requests_tools')->get_by_request_id($_GET['id']);
		$data['thirdparties_works_types'] = $this->model('tbs/thirdparties_works_types')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
				if ($id = $this->model('tbs/thirdparties_requests')->create($_POST))
				{
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("tbs/thirdparties_requests/details?id=".$id);
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		
		$data['companies'] = $this->model('tbs/thirdparties_companies')->get_all();
		$data['thirdparties_works_types'] = $this->model('tbs/thirdparties_works_types')->get_all();
		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['thirdparty_request'] = $this->model('tbs/thirdparties_requests')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_requests");
		}

		if ($_POST)
		{
				if ($this->model('tbs/thirdparties_requests')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("tbs/thirdparties_requests/details?id=".$_GET['id']);
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		
		$data['companies'] = $this->model('tbs/thirdparties_companies')->get_all();
		$data['thirdparties_works_types'] = $this->model('tbs/thirdparties_works_types')->get_all();
		$this->view('', $data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/thirdparties_requests')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("tbs/thirdparties_requests");
	}



/*----------------------------------------------------------------------
	PRINTOUT
----------------------------------------------------------------------*/
	public function printout()
	{
		//error_reporting(E_ALL);
		data('workers', $this->model('tbs/thirdparties_workers')->get_by_request_id($_GET['id']));
		data('supports', $this->model('tbs/thirdparties_supports')->get_by_request_id($_GET['id']));
		data('tools', $this->model('tbs/thirdparties_requests_tools')->get_by_request_id($_GET['id']));
		data('thirdparties_works_types', $this->model('tbs/thirdparties_works_types')->get_all());

		data('request', $this->model('tbs/thirdparties_requests')->get_by_id($_GET['id']));
		render('flat');
	}
}