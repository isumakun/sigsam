<h2>Almacenes</h2>
<?php
	$table = new Datagrid();

	$table->set_options('tbs/warehouses', 'get_all', 'a', 'false', 'multi', 10);

	$table->add_column('#', 'id');
	$table->add_column('Producto', 'product');
	$table->add_column('Tipo', 'product_type');
	$table->add_column('Unidad', 'product_unit');
	$table->add_column('Virtual', 'virtual');
	$table->add_column('VR', 'virtual_reserved');
	$table->add_column('Bloqueado', 'locked');
	$table->add_column('IPI', 'inspected_to_input');
	$table->add_column('Stock', 'stock');
	$table->add_column('Reservado', 'reserved');
	$table->add_column('Aprobado', 'approved');
	$table->add_column('IPS', 'inspected_to_output');
	$table->add_column('RPS', 'reserved_to_output');
	$table->add_column('Despachado', 'dispatched');
	$table->add_column('Desperdicio', 'waste');
	$table->add_column('Dif. Báscula', 'scale_difference');
	$table->add_column_html('# Form', 'form_id', 'FMM-{row_id}');
	$table->add_column('Tipo Form', 'form_type');
	$table->add_column('ID Producto', 'product_id');
	$table->add_column('Naclzdo', 'nationalized');

$table->render();
?>
