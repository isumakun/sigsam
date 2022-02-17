<?php 
$calendar = new Calendar();
?>
	<h2>Nuevo Registro</h2>
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
		<input name="company_id" value="<?=$_POST['company_id']?>" type="text"/>

		<input class="submit" type="submit" value="Crear" />
	</form>