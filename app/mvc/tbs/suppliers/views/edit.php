<h2>Editar Proveedor</h2>

<form method='POST'>

	<label>Nit</label>
	<input name='nit' value="<?=$supplier['nit']?>" required />

	<label>Nombre</label>
	<input type="text" value="<?=$supplier['name']?>" name="name">

	<input class="submit" type="submit" value="Guardar" />

</form>
