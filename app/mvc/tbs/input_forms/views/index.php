<h2>Formularios de ingreso</h2>

<style type="text/css">
	tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
<?php
	$table = new Datagrid();

	$table->set_options('tbs/input_forms', 'get_all', 'a', 'false', 'multi', 'true');

	$table->add_column_html('#', 'form_id', 'FMM-{row_id}');
	$table->add_column('Proveedor', 'supplier');
	$table->add_column('Transacción', 'transaction');
	$table->add_column('Transporte', 'transport');
	$table->add_column('TRM', 'exchange_rate');
	$table->add_column('Creado', 'created_at');
	$table->add_column('Presentado', 'presented_at');
	$table->add_column('Aprobado', 'approved_at');
	$table->add_column('Ejecutado', 'executed_at');
	$table->add_column('Estado', 'state');
	$table->add_column_html(
		make_link('tbs/input_forms/create', '<span class="icon create"></span> Nuevo', 'button dark create'),
		'form_id',
		'<div class="nowrap">
			<a href="'.BASE_URL.'tbs/input_forms/details?id={row_id}" class="button view"><span class="icon open"></span></a>&nbsp;
			<a href="'.BASE_URL.'tbs/input_forms/printout?id={row_id}" class="button dark" target="_blank"><span class="icon printer"></span></a>
		</div>');

$table->render();
?>
