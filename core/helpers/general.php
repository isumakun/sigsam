<?php defined('UMVC') OR exit('No direct script access allowed');

/* GLOBAL GET ------------------------------------------------------- */
function global_get($variable, $default = FALSE)
{
	return isset($_GET[$variable]) ? $_GET[$variable] : $default;
}

/* SET NOTIFICATION ------------------------------------------------- */
function set_notification($message, $type = 'success')
{
	if ($type == 'success') {
		$icon = 'fas fa-check';
	}elseif ($type == 'info') {
		$icon = 'fas fa-info-circle';
	}elseif ($type == 'error') {
		$icon = 'fas fa-times';
	}

	$notification = array(
		'type'				=> $type,
		'icon'				=> $icon,
		'message'			=> $message,
		'keep_alive_x_time'	=> $keep_alive_x_time
	);

	$_SESSION['notifications'][] = $notification;
	return TRUE;
}

/* MAKE LINK -------------------------------------------------------- */
function make_link($uri, $content, $class = FALSE, $target = '_self')
{
	$request_uri = explode('?', $uri);
	$current_uri = explode('/', $request_uri[0]);

	$prefix		= $current_uri[0];
	$controller	= $current_uri[1];
	$method		= $current_uri[2];

	if ($prefix		== '') $prefix		= 'dhr';
	if ($controller	== '') $controller	= 'dashboard';
	if ($method		== '') $method		= 'index';

	if (has_privilege($prefix, $controller, $method))
	{
		if ($prefix == $_SESSION['prefix'] AND ucfirst($controller) == $_SESSION['controller'] AND $method == $_SESSION['method'])
			$class = 'active';

		if ($class)
			$class = "class='$class'";

		$uri = BASE_URL.$uri;

		if ($target != '_self') $target = "target='$target'";

		return "<a href='$uri' $class $target>$content</a>";
	}
	return FALSE;
}

/* MAKE LINK -------------------------------------------------------- */
function make_link_menu($uri, $content, $class = FALSE, $target = '_self')
{
	$request_uri = explode('?', $uri);
	$current_uri = explode('/', $request_uri[0]);

	$prefix		= $current_uri[0];
	$controller	= $current_uri[1];
	$method		= $current_uri[2];

	if ($prefix		== '') $prefix		= 'dhr';
	if ($controller	== '') $controller	= 'dashboard';
	if ($method		== '') $method		= 'index';

	if (has_privilege($prefix, $controller, $method))
	{
		if ($prefix == $_SESSION['prefix'] AND ucfirst($controller) == $_SESSION['controller'] AND $method == $_SESSION['method'])
			$class = 'active';

		if ($class)
			$class = "class='$class'";

		$uri = BASE_URL.$uri;

		if ($target != '_self') $target = "target='$target'";

		return "<li class='nav-item'>
                <a class='nav-link' href='$uri' $class $target>
                  $content
              </li>";
	}
	return FALSE;
}

/* HAS PRIVILEGE ---------------------------------------------------- */
function has_privilege($prefix, $controller, $method = 'index')
{

	$controller = ucfirst($controller);

	// die($_SESSION);
	// print_r($_SESSION);
	// die();
	// echo '<pre>'.print_r($_SESSION, TRUE).'</pre>'; die();
	if (isset($_SESSION['user']['privileges'][$prefix][$controller][$method]) 
		OR isset($_SESSION['user']['privileges'][$prefix][$controller]['*']) 
		OR isset($_SESSION['user']['privileges'][$prefix]['*']['*']) 
		OR isset($_SESSION['user']['privileges']['*']['*']['*']) 
		OR $_SESSION['prefix']=='public' 
		OR $_SESSION['last']['method'] == 'Auto_login'
		OR $_SESSION['method'] == 'Auto_login'){
			
			return TRUE;
		}
	

	return FALSE;
}

/* HAS ROLE --------------------------------------------------------- */
function has_role($rol_id){

	if (isset($_SESSION['user']['roles'][$rol_id])){
		return TRUE;
	}else{
		return FALSE;
	}
	

	
}

/* HAS ROLE --------------------------------------------------------- */
function an_route($id, $inf_id, $suport){
	$route=null;
	if(isset($suport)){
		$tmp = explode('.',$suport);
		$route = $_SERVER['DOCUMENT_ROOT']."/indicator/public/uploads/".$id.".".end($tmp);
	  $route2 = $_SERVER['DOCUMENT_ROOT']."/indicator/public/uploads/".$inf_id.".".end($tmp);
	  $solution = $_SERVER['DOCUMENT_ROOT']."/indicator".substr($suport, 1);

	  if(!file_exists($solution)){
	    if(file_exists($route2)){
	        $route = "../../public/uploads/".$inf_id.".".end($tmp);
	    }else{
	        $route = "../../public/uploads/".$id.".".end($tmp);
	    }
		}else{
		    $route = "../../".$suport;
		}
	}
	
	
	return $route;
}

function check_if_only_spaces($tocheck){
	$matches = NULL;
	preg_match(
		'/.*\S.*/',
		$tocheck,
		$matches
	);
	return $matches;
}

function logchekElements($element) {
	$match = NULL;
	preg_match(
		'/^([≥=<>≤])?\s*\d+\s*(([hH]|horas?)?\s*((:)?\s*(?<=:)(\d{1,2}))?\s*(((?<!\d{1})\d)?((min)|(m))?)?)\s*$/u',
		$element,
		$match
	);
  $n =null;
	if($match[0]){
		preg_match_all('/\d+/', $match[0], $n);
		if($n[0][0]){
			if($n[0][1]){
			  return "{$n[0][0]}.{$n[0][1]}";
			}else{
			  return $n[0][0];
			}
		}
	}else{
		preg_match(
			'/\d+(\.)?(?<=\.)\d+$/u',
			$element,
			$match
		);
		if($match[0]){
			return $match[0];
		}else{
			return $element;
		}
	}
}

/* NO BACK (PREVENT BACK BUTTON FROM BROWSER ) ---------------------- */
function noback()
{
	return TRUE;
	//return "<script type=\"text/javascript\">history.pushState(null, null, '{$_SERVER['REQUEST_URI']}');window.addEventListener('popstate', function(event){ window.location.assign('{$_SESSION['penultimate']['uri']}'); });</script>";
}

/* Redirect, notification and die :) -------------------------------- */
function redirect($uri, $message = FALSE, $message_type = 'success')
{
	if ($message) set_notification($message, $message_type);

	header('HTTP/1.1 302 Found');
	header('Location: '.BASE_URL.$uri);
	die();
}

/* REDIRECT_BACK, NOTIFICATION AND DIE :) --------------------------- */
function redirect_back($message = FALSE, $message_type = 'success')
{
	if ($message) set_notification($message, $message_type);

	header('HTTP/1.1 302 Found');
	header('Location: '.$_SESSION['penultimate']['uri']);
	die();
}

/* ELLIPSIS --------------------------------------------------------- */
function ellipsis($string, $length)
{
	if (strlen($string) > $length) $string = mb_substr($string, 0, $length, 'utf-8').' ...';
	return $string;
}

/* SELECT OPTION ---------------------------------------------------- */
function select_option($value, $statement, $select_value = NULL)
{
	$selected_statement = '';
	if ($value == $select_value)
	{
		$selected_statement = ' selected';
	}

	return "<option value='$value'$selected_statement>$statement</option>";
}

/* SET FLASH MESSAGE ------------------------------------------------ */
function set_message($message, $variable='msg')
{
	$_SESSION['flash'][$variable]['message'] = $message;
}

/* GET FLASH MESSAGE ------------------------------------------------ */
function get_messages($variable)
{
	$message = $_SESSION['flash'][$variable]['message'];
	unset($_SESSION['flash']);
	return $message;
}
