<?php 
$calendar = new Calendar();
?>
	<h2>Editar Usuario</h2>
	<form method="POST" enctype="multipart/form-data" autocomplete="on">

		<input type="hidden" name="id" value="<?=$_GET['id']?>">
		<input type="hidden" name="old_password" value="<?=$user['password']?>">

		<label for="username">Usuario:</label>
		<input name="username" value="<?=$user['username']?>" type="text"/>

		<label for="first_name">Nombres:</label>
		<input name="first_name" value="<?=$user['first_name']?>" type="text"/>

		<label for="last_name">Apellidos:</label>
		<input name="last_name" value="<?=$user['last_name']?>" type="text"/>

		<label for="password">Cambiar Contraseña:</label>
		<input name="password" type="password"/>

		<label for="email">Email:</label>
		<input name="email" value="<?=$user['email']?>" type="email"/>

		<label for="rol_id">Rol:</label>
		<select name="rol_id" class="select2">
			<option></option>
			<?php foreach ($roles as $rol) {
				if ($rol['id']==$user['role_id']) {
					?>
					<option selected="" value="<?=$rol['id']?>"><?=$rol['name']?></option>
					<?php
				}
			} ?>
		</select>

		<label for="companies">Empresas:</label>
		<select name="companies[]" class="select2" multiple>
			<option value="0" <?=($user_companies[0]['company_id']==0 ? 'selected' : '')?>>Todas</option>
			<?php foreach ($companies as $c) {
				$selected = FALSE;
				foreach ($user_companies as $uc) {
					if ($uc['company_id']==$c['id']) {
						$selected = TRUE;
					}
				}?>
				<option value="<?=$c['id']?>" <?=($selected ? 'selected' : '')?>><?=$c['name']?></option>
			<?php
			} ?>
		</select>

		<input class="submit" type="submit" value="Guardar" />
	</form>
	<script type="text/javascript">
		$(document).ready(function(){
			$('input[name="username"]').on('keyup', function(){
				$('input[name="email"]').val($(this).val());
			})
		})
	</script>