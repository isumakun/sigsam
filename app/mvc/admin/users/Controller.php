<?php defined('UMVC') OR exit('No direct script access allowed');
use \Third_party\Token\JWT as JWT;
class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$this->view('', null, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			if ($_POST['password']!=$_POST['password2']) {
				set_notification('Las contraseñas no coinciden', 'error');
			}else{
				if ($this->model('admin/users')->create())
				{
					set_notification("Usuario creado correctamente", 'success', TRUE);
					redirect("admin/users");
				}
				else
				{
					set_notification("El usuario no pudo ser creado", 'error');
				}
			}
		}
		
		$data['roles'] = $this->model('admin/users')->get_all_roles();
		$data['types'] = $this->model('indicator/types')->get_all();
		$data['charges'] = $this->model('indicator/charges')->get_all();
		$data['companies'] = $this->model('indicator/companies')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['user'] = $this->model('admin/users')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("admin/users");
		}

		if ($_POST)
		{
			if (!empty($_POST['password'])) {
				if (sha1($_POST['password'])==$_POST['old_password']) {
					set_notification("La nueva contraseña no puede ser igual a la anterior", 'error');
				}else{
					$_POST['password'] = sha1($_POST['password']);
					if ($this->model('admin/users')->update_by_id($_GET['id'], $_POST))
					{
						set_notification("Guardado");
						redirect("admin/users");
					}
					else
					{
						set_notification("El registro no pudo ser actualizado", 'error');
					}
				}
			}else{
				$_POST['password'] = $_POST['old_password'];

				if ($this->model('admin/users')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("admin/users");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
			}
		}
		
		$data['roles'] = $this->model('admin/users')->get_all_roles();
		$data['types'] = $this->model('indicator/types')->get_all();
		$data['charges'] = $this->model('indicator/charges')->get_all();
		$data['companies'] = $this->model('indicator/companies')->get_all();
		$data['user_companies'] = $this->model('indicator/users_companies')->get_by_user_id($_GET['id']);

		$this->view('',$data);
	}

	private function prevent_hacking($jj, $message=null) {
		sleep(3);

		switch ($message) {
			case 1:
				message('Usuario bloqueado, comuníquese con el administrador del sistema', 'error');
				break;
			default:
				message('Usuario o contraseña incorreto', 'error');
				break;
		}

		unset($_POST);
		render('login');
		die();
	}
/*----------------------------------------------------------------------
	LOGIN
----------------------------------------------------------------------*/
	public function login()
	{
		//error_reporting(E_ALL);
		//ini_set('display_errors', TRUE);


		// if (isset($_GET['t'])) {
		// 	if ($jwt = JWT::session_decode($_GET['t']))
		// 		if ($_COOKIE['portaldaabon'] == $jwt->cookie && (time() - $jwt->time <= 3600))
		// 			$cbox_username = $jwt->username;

		// 	if (!isset($cbox_username))
		// 		$this->prevent_hacking($jj);
		// }
		// if ($jj->get('POST') || isset($cbox_username)) {
		// 	$jj->clear('SESSION.last_uri');
		// 	render('dashboard');
		// }

		if ($_POST)
		{
			if ($user = $this->model('admin/users')->validate_user($_POST['username'], $_POST['password'])){
				$_SESSION['last']['prefix']		= CURRENT_PREFIX;
				$_SESSION['last']['controller']	= CURRENT_CONTROLLER;
				$_SESSION['last']['method']		= CURRENT_METHOD;

				$_SESSION['user']['id'] = $user['id'];
				$_SESSION['user']['username'] = $user['username'];
				$_SESSION['user']['first_name'] = $user['first_name'];
				$_SESSION['user']['main_page'] = $user['main_page'];

				$companies = $this->model('indicator/users_companies')->get_by_user_id($user['id']);

				$_SESSION['user']['company_id'] = $companies[0]['company_id'];
				$_SESSION['user']['company_name'] = $companies[0]['company'];
				$_SESSION['user']['companies'] = $companies;

				foreach ($this->model('admin/users')->get_roles($user['id']) AS $r)
				{
					$_SESSION['user']['roles'][$r['role_id']] = TRUE;
				}

				foreach ($this->model('admin/users')->get_privileges($user['id']) AS $p)
				{
					$_SESSION['user']['privileges'][$p['prefix']][$p['controller']][$p['method']] = TRUE;
				}

				if (!isset($_SESSION['penultimate']['uri'])){$_SESSION['penultimate']['uri'] = BASE_URL;}

				header('HTTP/1.1 302 Found');
				if (has_role(1)) {
					if (strpos($_SESSION['penultimate']['uri'], 'public') !== false) {
					    header("Location: ".BASE_URL);
					}else{
						header("Location: {$_SESSION['penultimate']['uri']}");
					}
					die();
				}
				if (has_role(6)) {
					//echo BASE_URL."tbs/dashboard/security";
					header("Location: ".BASE_URL."tbs/dashboard/security");
					die();
				}else{
					if (strpos($_SESSION['penultimate']['uri'], 'public') !== false) {
					    header("Location: ".BASE_URL."tbs/dashboard");
					}else{
						header("Location: {$_SESSION['penultimate']['uri']}");
					}
					die();
				}
			}
			else
			{
				if ($_SESSION['user']['id']){
					session_destroy();
				}

				redirect('admin/users/login', 'El nombre de usuario o la contraseña son incorrectos', 'error');
			}
		}

		render('login');
	}

/*----------------------------------------------------------------------
	AUTO LOGIN
----------------------------------------------------------------------*/
	public function auto_login()
	{
		//error_reporting(E_ALL);
		//ini_set('display_errors', TRUE);

		session_name('sigsam');
		$username = $_POST['username'];
		if (empty($username)) {
			$username = $_GET['username'];
		}
		$user = $this->model('admin/users')->get_by_username($username);

		if ($user) {
			$_SESSION['last']['prefix']		= CURRENT_PREFIX;
			$_SESSION['last']['controller']	= CURRENT_CONTROLLER;
			$_SESSION['last']['method']		= CURRENT_METHOD;

			$_SESSION['user']['id'] = $user['id'];
			$_SESSION['user']['username'] = $user['username'];
			$_SESSION['user']['first_name'] = $user['first_name'];
			$_SESSION['user']['main_page'] = $user['main_page'];

			$companies = $this->model('indicator/users_companies')->get_by_user_id($user['id']);

			$_SESSION['user']['company_id'] = $companies[0]['company_id'];
			$_SESSION['user']['company_name'] = $companies[0]['company'];
			$_SESSION['user']['companies'] = $companies;

			foreach ($this->model('admin/users')->get_roles($user['id']) AS $r)
			{
				$_SESSION['user']['roles'][$r['role_id']] = TRUE;
			}

			foreach ($this->model('admin/users')->get_privileges($user['id']) AS $p)
			{
				$_SESSION['user']['privileges'][$p['prefix']][$p['controller']][$p['method']] = TRUE;
			}

			if (!$_SESSION['penultimate']['uri']) $_SESSION['penultimate']['uri'] = BASE_URL;

			//header('HTTP/1.1 302 Found');
			redirect('./', 'Bienvenido');
			// if (has_role(1)) {
			// 	redirect('indicator/dashboard', 'Bienvenido');
			// }else{
			//     redirect('indicator/dashboard', 'Bienvenido');
			// }
			die();
		}else{
			redirect('admin/users/login', 'El usuario no existe', 'error');
		}

	}



/*----------------------------------------------------------------------
	CHANGE PASSWORD
----------------------------------------------------------------------*/
	public function change_password()
	{
		if ($_POST)
		{
			if ($_POST['new_password'] == $_POST['confirm_new_password'])
			{
				$users_model = $this->model('admin/users');

				if ($users_model->validate_user($_SESSION['user']['username'], $_POST['old_password']))
				{
					$users_model->change_password($_SESSION['user']['id'], $_POST['new_password']);

					redirect('/', 'La contraseña ha sido cambiada correctamente');
				}
				else
				{
					set_notification('La contraseña original no es correcta', 'error');
				}
			}
			else
			{
				set_notification('La nueva contraseña y la confirmación no coinciden', 'error');
			}

			redirect('admin/users/change_password');
		}

		$this->view('Cambiar contraseña');
	}

/*----------------------------------------------------------------------
	NEW PASSWORD
----------------------------------------------------------------------*/
	public function new_password()
	{
		if ($_POST)
		{
			if ($_POST['new_password'] == $_POST['confirm_new_password'])
			{
				$users_model = $this->model('admin/users');

				if ($users_model->validate_user($_SESSION['user']['username'], $_POST['old_password']))
				{
					$users_model->change_password($_SESSION['user']['id'], $_POST['new_password']);

					set_notification('La contraseña ha sido cambiada correctamente');
					redirect('/');
				}
				else
				{
					set_notification('La contraseña original no es correcta', 'error');
				}
			}
			else
			{
				set_notification('La nueva contraseña y la confirmación no coinciden', 'error');
			}

			redirect('admin/users/change_password');
		}

		$this->view('Cambiar contraseña');
	}

/*----------------------------------------------------------------------
	LOGOUT
----------------------------------------------------------------------*/
	public function logout()
	{
		session_destroy();
		
		//unset($_SESSION);
		redirect('admin/users/login');
	}
}
