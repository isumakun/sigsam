<?php 
$calendar = new Calendar();
?>
	<h2>Editar Empresa</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="name">Nombre:</label>
		<input name="name" value="<?=$company['name']?>" type="text"/>

		<input class="submit save" type="submit" value="Guardar" />
	</form>