<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="user_id">User:</label>
		<select name="user_id">
<?php
				foreach($users AS $u)
				{
?>
			<option value="<?=$u['id']?>" <?=($user_company['user_id'] == $u['id'] ? 'selected' : '')?>><?=$u['username']?></option>
<?php
				}
?>
		</select>

		<label for="company_id">Company_id:</label>
		<input name="company_id" value="<?=$user_company['company_id']?>" type="text"/>

		<input class="submit save" type="submit" value="Guardar" />
	</form>