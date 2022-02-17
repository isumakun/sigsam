<h2></h2>

<?php
	$table = new Datagrid();

	$table->set_options('tbs/thirdparties_tools', 'get_all', 'a', 'false', 'multi', 'true');
	
	$table->add_column('Name', 'name');
	$table->add_column_html(make_link('tbs/thirdparties_tools/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
		'<div class="strech nowrap">
		<a href="'.BASE_URL.'tbs/thirdparties_tools/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
		<a href="'.BASE_URL.tbs/thirdparties_tools/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>
		</div>', 'toolbar');

	$table->render();

?>