<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="name">Name:</label>
		<input name="name" value="<?=$thirdparty_worker_category['name']?>" type="text"/>

		<input class="submit" type="submit" value="Guardar" />
	</form>