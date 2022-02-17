<div class="card">
	<div class="card-body">
<h2>Tipo de Proceso</h2>
<?php
		$table = new Datagrid();
		$table->set_options('indicator/type_processes', 'get_all', 'a', 'false', 'multi', 'true');
		$table->add_column('Nombre', 'name');
		$table->add_column_html(make_link('indicator/type_processes/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
			'<div class="strech nowrap">
			<a href="'.BASE_URL.'indicator/type_processes/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
			<a href="'.BASE_URL.'indicator/type_processes/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>
			</div>', 'toolbar');
		$table->render();
   ?>
	</div>
</div>