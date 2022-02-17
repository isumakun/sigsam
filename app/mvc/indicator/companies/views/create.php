<?php 
$calendar = new Calendar();
?>
	<h2>Registro de Empresa</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="name">Nombre:</label>
		<input name="name" value="<?=$_POST['name']?>" type="text"/>

		<input class="submit" type="submit" value="Crear" />
	</form>