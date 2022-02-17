<h2><span class="icon loop2 large"></span> Crear contraseña</h2>

<form method="post">

	<input name="ei" value="<?=global_get('ei')?>" hidden required />
	<input name="t" value="<?=global_get('t')?>" hidden required />

	<label for="password">Contraseña nueva:</label>
	<input name="new_password" class="form-control" type="password">

	<label for="password">Confirmar contraseña nueva:</label>
	<input name="confirm_new_password" class="form-control" type="password">

	<label></label>
	<input type="submit" value="Cambiar contraseña"/>

</form>
