<?php $calendar = new Calendar(); ?>
<h2>Nuevo Soporte</h2>
<form method="POST" enctype='multipart/form-data'>
	<input type="hidden" name="input_form_id" value="<?=$_GET['id']?>">

	<label>Tipo</label>
	<select required name="input_form_support_type_id" class="select2">
		<option></option>
		<?php
		foreach ($tbs_input_forms_supports_types as $types) {
			?>
			<option value="<?=$types['id']?>"><?=$types['id']?> - <?=$types['name']?></option>
			<?php
		} ?>
	</select>

	<label>Soporte</label>
	<input type="file" required name="support">

	<label>Fecha</label>
	<?=$calendar->render('created_at')?>
	
	<label>Detalles</label>
	<textarea name="details" rows="5"></textarea>

	<input class="submit" type="submit" value="Agregar" />
</form>
