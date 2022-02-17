<div class="card">
	<div class="card-body">
<h2>Responsable</h2>
<?php
	$table = new Datagrid();

	$table->set_options('indicator/charges', 'get_all', 'a', 'false', 'multi', 'true');
	
	$table->add_column('Usuario', 'user_id');
	$table->add_column('Cargo', 'job_position');
	$table->add_column('Empresa', 'company_id');
	$table->add_column_html(make_link('indicator/charges/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
		'<div class="strech nowrap">
		<a href="'.BASE_URL.'indicator/charges/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
		<a href="'.BASE_URL.'indicator/charges/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>
		</div>', 'toolbar');

	$table->render();

?>
	</div>
</div>