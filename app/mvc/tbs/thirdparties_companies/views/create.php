<?php 
$calendar = new Calendar();
?>
	<h2>Nueva Empresa</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="nit">Nit:</label>
		<input name="nit" value="<?=$_POST['nit']?>" type="text"/>

		<label for="name">Nombre:</label>
		<input name="name" value="<?=$_POST['name']?>" type="text"/>

		<input class="submit" type="submit" value="Crear" />
	</form>