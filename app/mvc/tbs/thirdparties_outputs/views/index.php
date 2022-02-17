<h2>Salida de terceros</h2>

<?php
	$table = new Datagrid();

	$table->set_options('tbs/thirdparties_outputs', 'get_all', 'a', 'false', 'multi', 'true');
	
	$table->add_column('# Salida', 'id');
	$table->add_column('Solicitud de Ingreso', 'request_id');
	$table->add_column('Empresa', 'company');
	$table->add_column('Empleado', 'employee');
	$table->add_column('Vehículo', 'vehicle_plate');
	$table->add_column('Creado por', 'created_by');
	$table->add_column('Fecha', 'created_at');
	$table->add_column_html(make_link('tbs/thirdparties_outputs/create', '<span class="icon create"></span>', 'button dark create'), 'id', 
		'<div class="strech nowrap">
		<a href="'.BASE_URL.'tbs/thirdparties_outputs/details?id={row_id}" class="button"><span class="icon open"></span></a>
		<a href="'.BASE_URL.'tbs/thirdparties_outputs/printout?id={row_id}" class="button dark" target="_blank"><span class="icon printer"></span></a>
		</div>', 'toolbar');

	$table->render();

?>