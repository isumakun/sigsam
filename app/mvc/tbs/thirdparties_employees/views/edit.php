<?php 
$calendar = new Calendar();
?>
	<h2>Editar Empleado de Terceros</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="citizen_id">Cedula:</label>
		<input name="citizen_id" value="<?=$thirdparty_employee['citizen_id']?>" type="text"/>

		<label for="name">Nombre:</label>
		<input name="name" value="<?=$thirdparty_employee['name']?>" type="text"/>

		<input class="submit" type="submit" value="Guardar" />
	</form>