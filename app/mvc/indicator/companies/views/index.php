<div class="card">
	<div class="card-body">
<h2>Empresas</h2>

<?php
	$table = new Datagrid();

	$table->set_options('indicator/companies', 'get_all', 'a', 'false', 'multi', 'true');
	
	$table->add_column('Nombre', 'name');
	$table->add_column_html(make_link('indicator/companies/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
		'<div class="strech nowrap">
		<a href="'.BASE_URL.'indicator/companies/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
		<a href="'.BASE_URL.'indicator/companies/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>
		</div>', 'toolbar');
	$table->render();

?>
	</div>		
</div>
	