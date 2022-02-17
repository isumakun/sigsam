<h2></h2>

<?php
	$table = new Datagrid();

	$table->set_options('tbs/services_concepts', 'get_all', 'a', 'false', 'multi', 'true');
	
	$table->add_column('Concept', 'concept_id');
	$table->add_column('Service', 'service_id');
	$table->add_column_html(make_link('tbs/services_concepts/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
		'<div class="strech nowrap">
		<a href="'.BASE_URL.'tbs/services_concepts/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
		<a href="'.BASE_URL.tbs/services_concepts/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>
		</div>', 'toolbar');

	$table->render();

?>