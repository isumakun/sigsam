<?php defined('UMVC') OR exit('No direct script access allowed');

/* MONTHS ----------------------------------------------------------- */
	$months[1] = 'Ene';
	$months[2] = 'Feb';
	$months[3] = 'Mar';
	$months[4] = 'Abr';
	$months[5] = 'May';
	$months[6] = 'Jun';
	$months[7] = 'Jul';
	$months[8] = 'Ago';
	$months[9] = 'Sept';
	$months[10] = 'Oct';
	$months[11] = 'Nov';
	$months[12] = 'Dic';

/* GLOBAL GET ------------------------------------------------------- *
function global_get($variable, $default = FALSE)
{
	if (isset($_GET["{$variable}"]))
		if (is_numeric($_GET["{$variable}"]))
			return $_GET["{$variable}"];

	return $default;
}
/**/
