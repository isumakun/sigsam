<h2>Subpartidas TBS3</h2>

<style type="text/css">
	tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
</style>
<?php
	$table = new Datagrid();

	$table->set_options('tbs/tariff_headings', 'get_all', 'a', 'false', 'multi', 'true');

	$table->add_column('#', 'id');
	$table->add_column('Código', 'code');
	$table->add_column('Descripción', 'description');
	$table->add_column('Unidad', 'physical_unit');

$table->render();
?>
