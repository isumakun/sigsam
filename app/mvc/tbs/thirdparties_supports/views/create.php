<h2>Nuevo Soporte</h2>
<form method="POST" enctype="multipart/form-data">
	
	<input type="hidden" name="request_id" value="<?=$_GET['id']?>">

	<label for="details">Detalles:</label>
	<input name="details" value="<?=$_POST['details']?>" type="text"/>

	<label>Soporte</label>
	<input type="file" name="support">

	<input class="submit" type="submit" value="Crear" />
</form>