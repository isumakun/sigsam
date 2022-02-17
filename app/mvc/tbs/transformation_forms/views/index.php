<h2>Formularios de Transformación</h2>

<?php
	$table = new Datagrid();

	$table->set_options('tbs/transformation_forms', 'get_all', 'a', 'false', 'multi');

	$table->add_column_html('#', 'form_id', 'FMM-{row_id}');
	$table->add_column('Creado', 'created_at');
	$table->add_column('Presentado', 'presented_at');
	$table->add_column('Aprobado', 'approved_at');
	$table->add_column('Ejecutado', 'executed_at');
	$table->add_column('Estado', 'state');
	$table->add_column_html(make_link('tbs/transformation_forms/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'form_id', 
		'<div class="strech nowrap">
		<a href="'.BASE_URL.'tbs/transformation_forms/details?id={row_id}" class="button view"><span class="icon open"></span></a>&nbsp;
		<a href="'.BASE_URL.'tbs/transformation_forms/printout?id={row_id}" class="button dark" target="_blank"><span class="icon printer"></span></a>
		</div>', 'toolbar');

$table->render();
?>