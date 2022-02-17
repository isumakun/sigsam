<?php defined('UMVC') OR exit('No direct script access allowed');

/* GENERAL ---------------------------------------------------------- */
$config['general']['server']	= "portal.daabon.com.co";
$config['general']['base_url']	= "indicator";

/* PATH ------------------------------------------------------------- */
$config['project_dir']	= "/var/www/indicator";

/* STATE ------------------------------------------------------------ */
$config['state']['flag']	= FALSE;
$config['state']['message']	= "Tradebox System 3.0 se encuentra en una actualizaci&oacute;n prioritaria. Por favor, intente nuevamente en 5 minutos.";
$config['state']['development']	= TRUE;

/* ROUTES ----------------------------------------------------------- */
$config['routes']['home']['prefix']		= 'indicator';
$config['routes']['home']['controller']	= 'Dashboard';
$config['routes']['home']['method']		= 'index';
