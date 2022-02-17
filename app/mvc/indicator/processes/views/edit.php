<?php 
$calendar = new Calendar();
?>
	<h2>Editar Proceso</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="name">Nombre:</label>
		<input name="name" value="<?=$process['name']?>" type="text"/>

		<label for="type_process_id">Tipo de Proceso:</label>
		<select name="type_process_id">
<?php
				foreach($type_processes AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($process['type_process_id'] == $t['id'] ? 'selected' : '')?>><?=$t['name']?></option>
<?php
				}
?>
		</select>

		<input class="submit save" type="submit" value="Guardar" />
	</form>