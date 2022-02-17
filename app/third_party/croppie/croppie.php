<?php defined('UMVC') OR exit('No direct script access allowed');

Class Croppie {

	protected static $instance_id = 0;

	function __construct()
	{
		static::$croppie = "<link href=".BASE_URL.'public/vendors/Croppie-master/croppie.css'." rel='stylesheet'>";
		static::$croppie .= "<script src=".BASE_URL.'public/vendors/Croppie-master/croppie.min.js'."></script>";
	}

	public static function render()
	{
		$unique_id = static::$instance_id;
		static::$croppie .= "
			<img class='my-image' src='demo/demo-1.jpg' />
			<script>
				$(document).ready(function()
				{
					$('.my-image').croppie();
				}
			</script>
";

		$croppie = static::$croppie;

		static::$croppie = '';
		static::$instance_id++;

		$croppie = trim(preg_replace('/\t+/', '', $croppie));
		$croppie = trim(preg_replace('/\n+/', '', $croppie));

		echo $croppie;
	}
}
