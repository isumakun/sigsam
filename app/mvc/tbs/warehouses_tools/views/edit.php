<h2>Editar Herramienta</h2>

<form method='POST'>

	<label>Nombre</label>
	<input type="text" value="<?=$tool['name']?>" name="name">

	<label>Stock</label>
	<input type="text" value="<?=$tool['stock']?>" name="stock">

	<input class="submit" type="submit" value="Guardar" />

</form>
