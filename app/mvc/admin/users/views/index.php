<div class="card">
	<div class="card-body">
		<h2>Usuarios</h2>
		<br>
		<?php
		$table = new Datagrid();

		$table->set_options('admin/users', 'get_all', 'a', 'false', 'multi', 'true');

		$table->add_column('Usuario', 'username');
		$table->add_column('Nombre', 'name');
		$table->add_column('Email', 'email');
		$table->add_column('Empresas', 'companies');
		$table->add_column('Rol', 'rol');
		$table->add_column('Estado', 'state');
		
		$table->add_column_html(make_link('admin/users/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
			'<div class="strech nowrap">
				<a href="'.BASE_URL.'admin/users/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
				<a href="'.BASE_URL.'admin/users/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>
			</div>', 'toolbar');

		$table->render();

		?>
	</div>
</div>