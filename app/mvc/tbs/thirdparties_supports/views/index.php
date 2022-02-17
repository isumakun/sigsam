<h2></h2>

<?php
	$table = new Datagrid();

	$table->set_options('tbs/thirdparties_supports', 'get_all', 'a', 'false', 'multi', 'true');
	
	$table->add_column('Request', 'request_id');
	$table->add_column('Details', 'details');
	$table->add_column('File_extension', 'file_extension');
	$table->add_column('Created_at', 'created_at');
	$table->add_column_html(make_link('tbs/thirdparties_supports/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
		'<div class="strech nowrap">
		<a href="'.BASE_URL.'tbs/thirdparties_supports/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
		<a href="'.BASE_URL.tbs/thirdparties_supports/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>
		</div>', 'toolbar');

	$table->render();

?>