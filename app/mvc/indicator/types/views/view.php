<?php 
$calendar = new Calendar();
?>
	<h2>Editar Tipo de Indicador</h2>
	<form method="POST" enctype="multipart/form-data">
		<label for="name">Nombre:</label>
		<input disabled name="name" value="<?=$type['name']?>" type="text"/>
	</form>