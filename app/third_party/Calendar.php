<?php defined('UMVC') OR exit('No direct script access allowed');

Class Calendar {

	protected static $instance_id = 0;
	protected static $snippet = '';

	function __construct()
	{
		static::$snippet = "<link href='".BASE_URL."public/vendors/Datepicker/css/metallic/zebra_datepicker.css' rel='stylesheet'>";
		static::$snippet .= "<script src='".BASE_URL."public/vendors/Datepicker/zebra_datepicker.src.js'></script>";
	}

	public static function set_options()
	{
		$unique_id = static::$instance_id;
		static::$snippet .= "
			<input id='calendar_{$unique_id}'/>
			<script>
				$(document).ready(function()
				{
					$('input#calendar_{$unique_id}').Zebra_DatePicker(
					{

					});
				});
			</script>
		";

		$snippet = static::$snippet;

		static::$snippet = '';
		static::$instance_id++;

		$snippet = trim(preg_replace('/\t+/', '', $snippet));
		$snippet = trim(preg_replace('/\n+/', '', $snippet));

		echo $snippet;
	}
}
