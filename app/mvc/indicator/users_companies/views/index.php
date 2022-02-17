<h2></h2>

<?php
	$table = new Datagrid();

	$table->set_options('indicator/users_companies', 'get_all', 'a', 'false', 'multi', 'true');
	
	$table->add_column('User', 'user_id');
	$table->add_column('Company_id', 'company_id');
	$table->add_column_html(make_link('indicator/users_companies/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
		'<div class="strech nowrap">
		<a href="'.BASE_URL.'indicator/users_companies/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
		<a href="'.BASE_URL.indicator/users_companies/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>
		</div>', 'toolbar');

	$table->render();

?>