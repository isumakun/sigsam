<h2>Productos</h2>


<?php
	$table = new Datagrid();

	$table->set_options('tbs/products', 'get_all', 'a', 'false', 'multi');

	$table->add_column('#', 'id');
	$table->add_column('Producto', 'product');
	$table->add_column('Código de Interface', 'interface_code');
	$table->add_column('Tipo', 'product_type');
	$table->add_column('Subpartida', 'tariff_heading');
	$table->add_column('Unidad Física', 'physical_unit');
	$table->add_column_html(make_link('tbs/products/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
		'<div class="nowrap">
		<a href="'.BASE_URL.'tbs/products/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>
		</div>', 'toolbar');

$table->render();
?>