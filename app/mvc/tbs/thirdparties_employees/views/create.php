<?php 
$calendar = new Calendar();
?>
	<h2>Nuevo Empleado de Terceros</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="citizen_id">Cedula:</label>
		<input name="citizen_id" value="<?=$_POST['citizen_id']?>" type="text"/>

		<label for="name">Nombre:</label>
		<input name="name" value="<?=$_POST['name']?>" type="text"/>

		<input class="submit" type="submit" value="Crear" />
	</form>