<?php defined('UMVC') OR exit('No direct script access allowed');

Class Calendar {

	protected static $instance_id = 0;
	protected static $snippet = '';

	function __construct()
	{
		static::$snippet = "<link href='".BASE_URL."public/vendors/datepicker/dist/datepicker.min.css' rel='stylesheet'>";
		static::$snippet .= "<script src='".BASE_URL."public/vendors/datepicker/dist/datepicker.js'></script>";
	}

	public function render($name, $value, $is_required = TRUE, $format = 'YYYY-MM-DD', $attr='')
	{
		$value_attribute = '';
		if ($value) $value_attribute = " value='$value'";

		$is_required_attribute = '';
		if ($is_required)	$is_required_attribute = ' required';

		$unique_id = static::$instance_id;
		static::$snippet .= "
			<input id='calendar_{$unique_id}' name='$name'{$value_attribute}{$is_required_attribute} $attr/>
			<script>
				$(document).ready(function()
				{
					$('input#calendar_{$unique_id}').datepicker({
						format: '$format'
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
