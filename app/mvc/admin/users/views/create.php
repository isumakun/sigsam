<?php 
$calendar = new Calendar();
?>
	<h2>Nuevo Usuario</h2>
	<form method="POST" enctype="multipart/form-data" autocomplete="on">
		
		<label for="username">Usuario:</label>
		<input name="username" value="<?=$user['username']?>" type="text"/>

		<label for="first_name">Nombres:</label>
		<input name="first_name" value="<?=$user['first_name']?>" type="text"/>

		<label for="last_name">Apellidos:</label>
		<input name="last_name" value="<?=$user['last_name']?>" type="text"/>

		<label for="password">Contraseña:</label>
		<input name="password" value="<?=$user['password']?>" type="password"/>

		<label for="password2">Confirme Contraseña:</label>
		<input name="password2" value="<?=$user['password2']?>" type="password"/>

		<label for="email">Email:</label>
		<input name="email" value="<?=$user['email']?>" type="email"/>

		<label for="rol_id">Rol:</label>
		<select name="role_id" class="select2">
			<option></option>
			<?php foreach ($roles as $rol) {
				?>
				<option value="<?=$rol['id']?>" <?=($user['role_id'] == $rol['id'] ? 'selected' : '')?>><?=$rol['name']?></option>
				<?php
			} ?>
		</select>

		<label for="companies">Empresas:</label>
		<select name="companies[]" class="select2" multiple>
			<option value="0">Todas</option>
			<?php foreach ($companies as $c) {
				?>
				<option value="<?=$c['id']?>" <?=($user['company_id'] == $c['id'] ? 'selected' : '')?>><?=$c['name']?></option>
				<?php
			} ?>
		</select>

		<input class="submit" type="submit" value="Crear" />
	</form>
	<script type="text/javascript">
		$(document).ready(function(){
			$('input[name="username"]').on('keyup', function(){
				$('input[name="email"]').val($(this).val());
			})
		})
	</script>