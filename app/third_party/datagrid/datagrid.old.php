<?php

Class Datagrid {

	protected static $instance_id = 0;
	protected static $url_json = '';
	protected static $state_save = '';
	protected static $columns = '';
	protected static $table = '';

	function __construct()
	{
		static::$table = "<link href=".BASE_URL.'public/vendors/DataTables/datatables.css'." rel='stylesheet'>";
		static::$table .= "<script src=".BASE_URL.'public/vendors/DataTables/datatables.min.js'."></script>";
	}

	public static function set_options($prefix, $class, $method, $params = '', $state_save = 'false')
	{
		static::$state_save = $state_save;

		//$url_json = base_url($url_json);
		$url_json = BASE_URL."umvc/tools/json_table_grid?prefix={$prefix}&class={$class}&method={$method}&params={$params}";

		if ($url_json == FALSE)
		{
			// Acá debería poner la tabla vacía
			die("Ooops");
		}

		$unique_id = static::$instance_id;
		static::$url_json = $url_json;

		static::$table .= "
			<table id='datagrid_{$unique_id}' class='responsive'>
				<thead>
					<tr>
		";
	}

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
					$('#datagrid_{$unique_id}').DataTable(
					{
						deferRender: true,
						select: { style: 'multi' },
						aaSorting: [],
						stateSave: {$state_save},
						lengthMenu: [[10, 25, 50, -1], [10, 25, 50, \"All\"]],
						dom: 'lfrtpi',
/*
						buttons: [
							{
								extend: 'copy',
								text: 'Copiar tabla',
							}
						],
*/
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
