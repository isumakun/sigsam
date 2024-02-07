<?php 
$calendar = new Calendar();
?>
<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<h2>Crear Proceso</h2>
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<form method="POST" enctype="multipart/form-data">
					<div class="row marginb">
						<div class="col-md-6">
							<label for="name">Nombre:</label>
							<input name="name" value="" type="text" required/>
						</div>
						<div class="col-md-6">
							<label for="type_process_id">Tipo de Proceso:</label>
							<select name="type_process_id">
								<?php foreach($type_processes AS $t){ ?>
									<option value="<?=$t['id']?>"><?=$t['name']?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<div class="row marginb">
						<div class="col-md-12">
							<input class="confirmp save blueDf" type="button" value="Guardar" />
							<input style="display: none;" class="submit save" type="submit" value="Guardar"/>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

