<?php defined('UMVC') OR exit('No direct script access allowed');

Class Datagrid {

	protected static $instance_id = 0;
	protected static $columns = array();
	protected static $table = '';

	protected static $model = '';
	protected static $method = '';
	protected static $params = '';

	protected static $state_save = '';

	public static function set_options($model, $method, $params, $state_save = TRUE)
	{
		static::$model = $model;
		static::$method = $method;
		static::$params = $params;

		static::$state_save = $state_save;

		$unique_id = static::$instance_id;

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

		array_push(static::$columns, "data: '{$column_id}'");
		static::$table .= "<th {$class}>{$title}</th>";
	}

	/* ADD COLUMN WITH HTML TEMPLATE*/
	public static function add_column_html($title, $column_id, $html_template, $class = NULL)
	{
		if (!is_null($class))	$class = "class='{$class}'";

		$html_template = preg_replace("/{row_id}/", "'+data+'", $html_template);

		array_push(static::$columns, "data: '{$column_id}', render: function(data, type, row){return '{$html_template}'}");
		static::$table .= "<th $class>{$title}</th>";
	}

	public static function render()
	{
		$unique_id = static::$instance_id;


		$url_json = BASE_URL."umvc/tools/json_table_grid";

		$model = static::$model;
		$method = static::$method;
		$params = static::$params;

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
					datatable_{$unique_id} = $('#datagrid_{$unique_id}').DataTable(
					{
						paging: true,
						aaSorting: [],
						responsive: true,
						autoWidth: false,
						stateSave: {$state_save},
						pageLength: 10,
						columnDefs: [
							{ responsivePriority: 1, targets: 0 },
							{ responsivePriority: 2, targets: -1 }
						],
						dom: 'lfrtpi',
						ajax: {
							url: '{$url_json}',
							type: 'POST',
							data: {
								model: '{$model}',
								method: '{$method}',
								params: '{$params}'
							}
						},
						columns: data_columns_{$unique_id}
					});
				});
			</script>
		";

		$table = static::$table;

		static::$table = '';
		static::$columns = '';
		static::$instance_id++;

		$table = trim(preg_replace('/\t+/', '', $table));
		$table = trim(preg_replace('/\n+/', '', $table));

		echo $table;
	}
}
