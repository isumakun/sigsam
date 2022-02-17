<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="name">Nombre:</label>
		<input disabled name="name" value="<?=$indicator['name']?>" type="text"/>

		<label for="formula">Formula:</label>
		<input disabled name="formula" value="<?=$indicator['formula']?>" type="text"/>

		<label for="upper_limit">Limite Superior:</label>
		<input disabled name="upper_limit" value="<?=$indicator['upper_limit']?>" type="text"/>

		<label for="lower_limit">Limite Inferior:</label>
		<input disabled name="lower_limit" value="<?=$indicator['lower_limit']?>" type="text"/>

		<label for="type_id">Tipo de indicador:</label>
		<select disabled name="type_id">
<?php
				foreach($types AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($indicator['type_id'] == $t['id'] ? 'selected' : '')?>><?=$t['name']?></option>
<?php
				}
?>
		</select>

		<label for="chager_id">Responsable:</label>
		<select disabled name="chager_id">
<?php
				foreach($charges AS $c)
				{
?>
			<option value="<?=$c['id']?>" <?=($indicator['chager_id'] == $c['id'] ? 'selected' : '')?>><?=$c['user_id']?></option>
<?php
				}
?>
		</select>

		<label for="frequency">Frecuencia:</label>
		<input disabled name="frequency" value="<?=$indicator['frequency']?>" type="text"/>

		<label for="unit">Unidad:</label>
		<input disabled name="unit" value="<?=$indicator['unit']?>" type="text"/>

	</form>