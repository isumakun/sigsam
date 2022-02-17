<h2>Editar información de carga</h2>
	<form method="POST">

		<label>Números de unidad de carga manifestada</label>
		<textarea name="charge_unit_number_manifested"><?=$tif['charge_unit_number_manifested']?></textarea>

		<label>Números de unidad de carga recibida</label>
		<textarea name="charge_unit_number_verified"><?=$tif['charge_unit_number_verified']?></textarea>

		<label>Números de precinto manifestado</label>
		<textarea name="seal_number_manifested"><?=$tif['seal_number_manifested']?></textarea>

		<label>Números de precinto recibido</label>
		<textarea name="seal_number_verified"><?=$tif['seal_number_verified']?></textarea>

		<input type="submit" value="Enviar">
	</form>