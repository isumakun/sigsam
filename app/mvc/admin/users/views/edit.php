<?php 
$calendar = new Calendar();
?>
	<style type="text/css">
		textarea.select2-search__field{
			position:absolute;
		}
		span.select2{
			width: inherit !important;
		}
	</style>
	<div class="row">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					<h2>Editar Usuario</h2>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-md-12">
					<form method="POST" enctype="multipart/form-data" autocomplete="on">
						<div class="row marginb">
							<div class="col-md-6">
								<label for="id">Id del Usuario:</label>
								<input class="noBorder" type="" name="id" value="<?=$_GET['id']?>" readonly>
								<input type="hidden" name="old_password" value="<?=$user['password']?>">
							</div>
							<div class="col-md-6">
								<label for="username">Nombre de Usuario:</label>
								<input name="username" value="<?=$user['username']?>" type="text"/ required>
							</div>
						</div>
						<div class="row marginb">
							<div class="col-md-6">
								<label for="first_name">Nombres:</label>
								<input name="first_name" value="<?=$user['first_name']?>" type="text"/ required>
							</div>
							<div class="col-md-6">
								<label for="last_name">Apellidos:</label>
								<input name="last_name" value="<?=$user['last_name']?>" type="text"/ required>
							</div>
						</div>
						<div class="row marginb">
							<div class="col-md-12">
								<label for="email">Email:</label>
								<input name="email" value="<?=$user['email']?>" type="email"/ required>
							</div>
						</div>
						<div class="row marginb">
							<div class="col-md-12">
								<label for="rol_id">Rol:</label>
								<select name="rol_id" class="select2" required>
									<option disabled>Seleccionar</option>
									<?php foreach ($roles as $rol) { ?>
										<option  value="<?=$rol['id']?>" <?=($rol['id'] == $user['role_id'] ? 'selected' : '')?> ><?=$rol['name']?></option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="row marginb">
							<div class="col-md-12">
								<label for="job_position">Cargo:</label>
								<input type="text" name="job_position" value="<?=$user['job_position']?>" required>
							</div>
						</div>
						<div class="row marginb">
							<div class="col-md-12">
								<label for="companies">Empresas:</label>
								<select name="companies[]" class="select2" multiple='multiple' required>
									<option disabled>Seleccionar</option>
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
							</div>
						</div>
						<div class="row marginb">
							<div class="col-md-12">
							<input class="confirmp save blueDf" type="button" value="Guardar" />
							<input style="display: none;" class="submit save" type="submit" value="Guardar"/>
							</div>
						</div>
						<!-- <label for="password">Cambiar Contraseña:</label>
						<input name="password" type="password"/> -->
					</form>
				</div>
			</div>
		</div>
	</div>

	
	
	<script type="text/javascript">
		$(document).ready(function(){
			
		})
	</script>