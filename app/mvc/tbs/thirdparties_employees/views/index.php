<h2></h2>

<?php
	$table = new Datagrid();

	$table->set_options('tbs/input_forms', 'get_all', 'a', 'false', 'multi', 'true');
	
	$table->add_column('Citizen_id', 'citizen_id');
	$table->add_column('Name', 'name');

	$table->render();

	?>