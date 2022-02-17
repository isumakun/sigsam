<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="user_id">User:</label>
		<select disabled name="user_id">
<?php
				foreach($users AS $u)
				{
?>
			<option value="<?=$u['id']?>" <?=($charge['user_id'] == $u['id'] ? 'selected' : '')?>><?=$u['username']?></option>
<?php
				}
?>
		</select>

		<label for="job_position">Job_position:</label>
		<input disabled name="job_position" value="<?=$charge['job_position']?>" type="text"/>

		<label for="company_id">Company:</label>
		<select disabled name="company_id">
<?php
				foreach($companies AS $c)
				{
?>
			<option value="<?=$c['id']?>" <?=($charge['company_id'] == $c['id'] ? 'selected' : '')?>><?=$c['name']?></option>
<?php
				}
?>
		</select>

	</form>