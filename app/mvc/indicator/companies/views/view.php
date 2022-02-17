<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="name">Name:</label>
		<input disabled name="name" value="<?=$company['name']?>" type="text"/>

	</form>