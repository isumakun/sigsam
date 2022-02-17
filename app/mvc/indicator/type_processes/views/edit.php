<?php 
$calendar = new Calendar();
?>
	<h2>Editar Tipo de Proceso</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="name">Nombre:</label>
		<input name="name" value="<?=$type_process['name']?>" type="text"/>

		<input class="submit save" type="submit" value="Guardar" />
	</form>