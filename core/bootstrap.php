<?php defined('UMVC') OR exit('No direct script access allowed');

setlocale(LC_ALL, 'es_CO.utf8');

/* CONFIG FILES ----------------------------------------------------- */
require 'app/configurations/general.php';

//error_reporting(0);
if ($config['state']['development'] === TRUE)
{
	error_reporting(E_ALL);
}

if ($config['state']['flag'] === TRUE)
{
	echo "{$config['state']['message']}";
	die();
}

/* URI (ROUTES) ----------------------------------------------------- */
$request_uri = explode('?', $_SERVER['REQUEST_URI']);
$current_uri = explode('/', $request_uri[0]);

$_SESSION['prefix']		= $current_uri[2];
$_SESSION['controller']	=  (isset($current_uri[3])? ucfirst($current_uri[3]) : NULL);
$_SESSION['method']		= (isset($current_uri[4])? ucfirst($current_uri[4]) : NULL);

if ($_SESSION['prefix']		== '') $_SESSION['prefix']		= $config['routes']['home']['prefix'];
if ($_SESSION['controller']	== '') $_SESSION['controller']	= $config['routes']['home']['controller'];
if ($_SESSION['method']		== '') $_SESSION['method']		= $config['routes']['home']['method'];

if ($_SERVER['SERVER_NAME'] == $_SERVER['SERVER_ADDR'])
{
	$config['general']['server'] = "{$_SERVER['SERVER_ADDR']}:{$_SERVER['SERVER_PORT']}";
}

/* CONSTANT --------------------------------------------------------- */
define('FULL_PATH',				$config['project_dir'].'/');
define('APPPATH',				$config['project_dir'].'/app');

define('SERVER',				'http://'.$config['general']['server']);
define('BASE_URL',				SERVER."/{$config['general']['base_url']}/");

define('CURRENT_URL',			SERVER.$_SERVER['REQUEST_URI']);
define('CURRENT_PREFIX',		$_SESSION['prefix']);
define('CURRENT_CONTROLLER',	$_SESSION['controller']);
define('CURRENT_METHOD', 		$_SESSION['method']);

define('CURRENT_PARAMS', 		(isset($request_uri[1])? $request_uri[1] : NULL));

/* HOOK ------------------------------------------------------------- */
require ('core/helpers/general.php');
require 'app/helpers/general.php';

if (empty($_SERVER['HTTP_X_REQUESTED_WITH']) OR strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')
{
	if (isset($_SESSION['last']))
	{
		if (
			($_SESSION['last']['prefix'] 		!= $_SESSION['prefix']) 	OR
			($_SESSION['last']['controller']	!= $_SESSION['controller'])	OR
			($_SESSION['last']['method'] 		!= $_SESSION['method'])
		)
		{
			$_SESSION['penultimate']['prefix']		= $_SESSION['last']['prefix'];
			$_SESSION['penultimate']['controller']	= $_SESSION['last']['controller'];
			$_SESSION['penultimate']['method']		= $_SESSION['last']['method'];
			$_SESSION['penultimate']['params']		= $_SESSION['last']['params'];
			$_SESSION['penultimate']['uri']			= (($_SESSION['last']['uri'])? $_SESSION['last']['uri'] : NULL);

			$_SESSION['last']['prefix']		= $_SESSION['prefix'];
			$_SESSION['last']['controller']	= $_SESSION['controller'];
			$_SESSION['last']['method']		= $_SESSION['method'];
			$_SESSION['last']['params']		= CURRENT_PARAMS;
			$_SESSION['last']['uri']		= CURRENT_URL;
		}
	}
}

/* CLEANING GLOBAL GET (JUST NUMBER ALLOWED) ------------------------ *
if ($_GET)
{
	foreach ($_GET AS $index => $value)
	{
		// Esto es por DATATABLES, dentro de poco no será necesario.
		if ($index != 'model' AND $index != 'method' AND $index != 'params')
		{
			$_GET[$index] = 0;
			if (is_numeric($value))
				$_GET[$index] = $value;
		}
	}
}

/* SCAPPING? GLOBAL POST -------------------------------------------- */
if ($_POST)
{
	foreach ($_POST AS $index => $value)
	{
		if (!is_array($value))
		{
			// Debo hacer una prueba de rendimiento para ver si vale la pena. Creería que sí. :)
			$_POST[$index] = htmlspecialchars($value, ENT_QUOTES);
		}
	}
}

/* MODEL BASE ------------------------------------------------------- */
class ModelBase {

	protected $db;
	protected $db_schema;

	public function __construct()
	{
		require 'app/configurations/db.php';

		$this->db_schema = $config['db']['database'];

		$this->db = new PDO('mysql:dbname=' . $config['db']['database'] . ';host=' . $config['db']['host'] . ';charset=utf8;', $config['db']['username'], $config['db']['password']);

		$this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
		$this->db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_SILENT);

		return $this->db;
	}
}

function data($key, $value)
{
	return $GLOBALS['_DATA'][$key] = $value;
}

function get_data($key)
{
	return $GLOBALS['_DATA'][$key];
}

function render($template = 'default')
{
	if(isset($GLOBALS['_DATA'])){
		extract($GLOBALS['_DATA']);
	}
	

	ob_start();
	require "app/templates/{$template}.php";
	$content = ob_get_contents();
	ob_end_clean();

	echo $content;
	die();
}

/* CONTROLLERS BASE ------------------------------------------------- */
class ControllerBase {

	function model($model_path)
	{
		$model_name = str_replace('/', '_', $model_path).'\\Model';

		if (!defined("app/mvc/{$model_path}/Model.php"))
		{
			require "app/mvc/{$model_path}/Model.php";
			define("app/mvc/{$model_path}/Model.php", 1);
		}

		return new $model_name;
	}

	/* Cuando migre COMPLETAMENTE lo quito... */
	function view($title = '', Array $data = NULL, $template = 'default'){
		$data['title'] = $title;

		extract($data);

		ob_start();
		require "app/templates/{$template}.php";
		$content = ob_get_contents();
		ob_end_clean();

		echo $content;
	}
}

if (!has_privilege($_SESSION['prefix'], $_SESSION['controller'], $_SESSION['method']))
{
	if ($_SESSION['prefix'] != 'umvc' AND $_SESSION['controller'] != 'Tasks')
	{
		if ($_SESSION['user']['id'])
		{
			redirect('admin/users/logout', 'No tiene los privilegios suficientes para esta acción', 'error');
		}
		else
		{
			if (CURRENT_URL != BASE_URL.'admin/users/login')
			{
				$_SESSION['last']['uri'] = CURRENT_URL;
				redirect('admin/users/login');
			}
		}
	}
}

/* Library ---------------------------------------------------------- */
spl_autoload_register(function($class)
{
	require 'core/libraries/'.$class.'.php';
});