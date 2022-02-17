<?php
/* ---------------------------------------------------------------------
	UGLY MVC 1.0 (2017-02-28)
		by @diegollinas
----------------------------------------------------------------------*/

//header('Location: ../mantenimiento.php');
error_reporting(0);
ini_set('display_errors', FALSE);
session_start();
setlocale(LC_MONETARY, 'en_US');
define('UMVC', 'executing');
session_name("sigsam");

require 'core/bootstrap.php';
require "app/mvc/{$_SESSION['prefix']}/".strtolower($_SESSION['controller'])."/Controller.php";

$controller = new Controller;
call_user_func(array($controller, $_SESSION['method']));
