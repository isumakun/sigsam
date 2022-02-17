<?php 
$calendar = new Calendar();
?>
	<h2>Registro< de Tipo de Proceso</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="name">Nombre:</label>
		<input disabled name="name" value="<?=$type_process['name']?>" type="text"/>

	</form>