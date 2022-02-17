<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="indicator_id">Indicator:</label>
		<select disabled name="indicator_id">
<?php
				foreach($indicators AS $i)
				{
?>
			<option value="<?=$i['id']?>" <?=($value['indicator_id'] == $i['id'] ? 'selected' : '')?>><?=$i['name']?></option>
<?php
				}
?>
		</select>

		<label for="value">Value:</label>
		<input disabled name="value" value="<?=$value['value']?>" type="text"/>

		<label for="created_by">created_by:</label>
		<select disabled name="created_by">
<?php
				foreach($users AS $u)
				{
?>
			<option value="<?=$u['id']?>" <?=($value['created_by'] == $u['id'] ? 'selected' : '')?>><?=$u['username']?></option>
<?php
				}
?>
		</select>

		<label for="support">Support:</label>
		<input disabled name="support" value="<?=$value['support']?>" type="text"/>

	</form>