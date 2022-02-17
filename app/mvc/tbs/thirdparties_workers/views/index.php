<h2></h2>

<?php
	$table = new Datagrid();

	$table->set_options('tbs/thirdparties_workers', 'get_all', 'a', 'false', 'multi', 'true');
	
	$table->add_column('Employee', 'employee_id');
	$table->add_column('Category', 'category_id');
	$table->add_column('Work_type', 'work_type_id');
	$table->add_column('Request', 'request_id');
	$table->add_column('Arl', 'arl');
	$table->add_column('Eps', 'eps');
	$table->add_column_html(make_link('tbs/thirdparties_workers/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
		'<div class="strech nowrap">
		<a href="'.BASE_URL.'tbs/thirdparties_workers/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
		<a href="'.BASE_URL.tbs/thirdparties_workers/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>
		</div>', 'toolbar');

	$table->render();

?>