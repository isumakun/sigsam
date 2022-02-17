<?php 
$calendar = new Calendar();
?>
	<h2>Editar Empresa</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="nit">Nit:</label>
		<input name="nit" value="<?=$thirdparty_company['nit']?>" type="text"/>

		<label for="name">Nombre:</label>
		<input name="name" value="<?=$thirdparty_company['name']?>" type="text"/>

		<input class="submit" type="submit" value="Guardar" />
	</form>