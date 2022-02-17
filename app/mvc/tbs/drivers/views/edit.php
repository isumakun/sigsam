<h2>Editar Conductor</h2>

<form method='POST'>

	<label>Cedula</label>
	<input type="text" name="new_id" value="<?=$driver['id']?>" />

	<label>Nombre</label>
	<input type="text" value="<?=$driver['name']?>" name="name">

	<input class="submit" type="submit" value="Guardar" />

</form>
