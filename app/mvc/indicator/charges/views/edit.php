<?php 
$calendar = new Calendar();
?>
	<h2>Editar Responsable</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="user_id">Usuario:</label>
		<select name="user_id">
<?php
				foreach($users AS $u)
				{
?>
			<option value="<?=$u['id']?>" <?=($charge['user_id'] == $u['id'] ? 'selected' : '')?>><?=$u['username']?></option>
<?php
				}
?>
		</select>

		<label for="job_position">Cargo:</label>
		<input name="job_position" value="<?=$charge['job_position']?>" type="text"/>

		<label for="company_id">Empresa:</label>
		<select name="company_id">
<?php
				foreach($companies AS $c)
				{
?>
			<option value="<?=$c['id']?>" <?=($charge['company_id'] == $c['id'] ? 'selected' : '')?>><?=$c['name']?></option>
<?php
				}
?>
		</select>

		<input class="submit save" type="submit" value="Guardar" />
	</form>