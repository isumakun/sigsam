<h2>Formularios Transporte de Salida</h2>

<?php
	$table = new Datagrid();

	$table->set_options('tbs/transport_output_forms', 'get_all', '', 'false', 'multi');

	$table->add_column_html('#', 'id', 'FMM-{row_id}');
	$table->add_column('Cédula Conductor', 'driver_citizen_id');
	$table->add_column('Nombre Conductor', 'driver_name');
	$table->add_column('Placa Vehículo', 'vehicle_plate');
	$table->add_column('Creado por', 'created_by');
	$table->add_column('Creado', 'created_at');
	$table->add_column('Presentado', 'presented_at');
	$table->add_column('Aprobado', 'approved_at');
	$table->add_column('Ejecutado', 'executed_at');
	$table->add_column('Estado', 'state');
	$table->add_column_html(make_link('tbs/transport_output_forms/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
		'<div class="nowrap"><a href="'.BASE_URL.'tbs/transport_output_forms/details?id={row_id}" class="button view"><span class="icon open"></span></a>&nbsp; <a href="'.BASE_URL.'tbs/transport_output_forms/printout?id={row_id}" class="button dark"><span class="icon printer"></span></a></div>');

$table->render();
?>