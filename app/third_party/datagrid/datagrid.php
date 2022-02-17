<?php defined('UMVC') OR exit('No direct script access allowed');

Class Datagrid{

	protected static $instance_id = 0;
	protected static $url_json = '';
	protected static $state_save = '';
	protected static $select = '';
	protected static $columns = '';
	protected static $table = '';

	function __construct()
	{
		static::$table = "<link href='".BASE_URL."public/vendors/DataTables/datatables.css' rel='stylesheet'>";
		static::$table .= "<script src='".BASE_URL."public/vendors/DataTables/datatables.min.js'></script>";

		static::$table .= "<link rel='stylesheet' type='text/css' href='".BASE_URL."public/vendors/DataTables2/Responsive-2.1.1/css/responsive.dataTables.css'/>";
		static::$table .= "<script type='text/javascript' src='".BASE_URL."public/vendors/DataTables2/Responsive-2.1.1/js/dataTables.responsive.min.js'></script>";
/*
<link rel='stylesheet' type='text/css' href='<?=BASE_URL?>public/vendors/DataTables2/DataTables-1.10.15/css/jquery.dataTables.min.css'/>
<link rel='stylesheet' type='text/css' href='<?=BASE_URL?>public/vendors/DataTables2/Buttons-1.3.1/css/buttons.dataTables.min.css'/>
<link rel='stylesheet' type='text/css' href='<?=BASE_URL?>public/vendors/DataTables2/Select-1.2.2/css/select.dataTables.min.css'/>

<script type='text/javascript' src='<?=BASE_URL?>public/vendors/DataTables2/DataTables-1.10.15/js/jquery.dataTables.min.js'></script>
<script type='text/javascript' src='<?=BASE_URL?>public/vendors/DataTables2/Buttons-1.3.1/js/dataTables.buttons.min.js'></script>
<script type='text/javascript' src='<?=BASE_URL?>public/vendors/DataTables2/Buttons-1.3.1/js/buttons.colVis.min.js'></script>
<script type='text/javascript' src='<?=BASE_URL?>public/vendors/DataTables2/Buttons-1.3.1/js/buttons.flash.min.js'></script>
<script type='text/javascript' src='<?=BASE_URL?>public/vendors/DataTables2/Buttons-1.3.1/js/buttons.html5.min.js'></script>
<script type='text/javascript' src='<?=BASE_URL?>public/vendors/DataTables2/Select-1.2.2/js/dataTables.select.min.js'></script>
*/

	}

	// public static function set_options($model, $method, $params = '', $state_save = 'false', $select = false, $page = 10)
	// {
	// 	static::$state_save = $state_save;
	// 	static::$select = $select;

	// 	if ($select)
	// 	{
	// 		static::$table .= "<script src=".BASE_URL.'public/vendors/DataTables/Select-1.2.0/js/dataTables.select.min.js'."></script>";
	// 	}

	// 	if (!is_array($params) AND $params != '')
	// 	{
	// 		$params_string = "&params={$params}";
	// 	}
	// 	else
	// 	{
	// 		foreach ($params AS $p)
	// 		{
	// 			$params_string .= "&params[]={$p}";
	// 		}
	// 	}

	// 	$url_json = BASE_URL."umvc/tools/json_table_grid/?model={$model}&method={$method}{$params_string}";

	// 	if ($url_json == FALSE)
	// 	{
	// 		// Acá debería poner la tabla vacía
	// 		die("Ooops");
	// 	}

	// 	$unique_id = static::$instance_id;
	// 	static::$url_json = $url_json;

	// 	static::$table .= "
	// 		<table id='datagrid_{$unique_id}' class='responsive' LOL {$page}>
	// 			<thead>
	// 				<tr>
	// 	";

	// }

	/* ADD COLUMN */
	public static function add_column($title, $column_id, $class = NULL)
	{
		if (!is_null($class)) $class = "class='{$class}'";

		static::$columns[] = "data: '{$column_id}'";
		static::$table .= "<th {$class}>{$title}</th>";
	}

	/* ADD COLUMN WITH HTML TEMPLATE*/
	public static function add_column_html($title, $column_id, $html_template, $class = NULL)
	{
		if (!is_null($class))	$class = "class='{$class}'";

		$html_template = preg_replace("/{row_id}/", "'+data+'", $html_template);

		static::$columns[] = "data: '{$column_id}', render: function(data, type, row){return '{$html_template}'}";
		static::$table .= "<th $class>{$title}</th>";
	}

	public static function render()
	{
		$unique_id = static::$instance_id;
		$url_json = static::$url_json;
		$state_save = static::$state_save;

		$select_statement = '';
		$select = static::$select;
		if ($select)
		{
			$select_statement = "select: 'multi',";
			//$select_statement = "select: '{$select}',";
			//$select_statement = "select: {style: 'os', blurable: true},";
		}

		static::$table .= "
					</tr>
				</thead>
			</table>
			<script>
				$(document).ready(function()
				{
					var data_columns_{$unique_id} = new Array();
";
		foreach (static::$columns AS $index => $value)
		{
			static::$table .= "
				data_columns_{$unique_id}[{$index}] = {{$value}};";
		}
		static::$table .= "
					datatable_{$unique_id} = $('#datagrid_{$unique_id}').DataTable(
					{
						deferRender: true,
						{$select_statement}
						aaSorting: [],
						stateSave: {$state_save},
						lengthMenu: [[10, 25, 50, -1], [10, 25, 50, \"All\"]],
						responsive: true,
						columnDefs: [
							{ responsivePriority: 1, targets: 0 },
							{ responsivePriority: 1, targets: -1 }
						],
						dom: 'lfrtpi',
						ajax: {
							url: '{$url_json}',
							dataSrc: 'data',
							type: 'POST',
							data: {
								key: ''
							}
						},
						columns: data_columns_{$unique_id}
					});

				});
			</script>
		";

		$table = static::$table;

		static::$table = '';
		static::$instance_id++;

		$table = trim(preg_replace('/\t+/', '', $table));
		$table = trim(preg_replace('/\n+/', '', $table));

		echo $table;
	}
}
