<?php $calendar = new Calendar(); ?>

<div class="row">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-12">
				<h2>Editar Empresa</h2>		
			</div>
		</div>
		<hr>
		<div class="row">
			<div class="col-md-12">
				<form method="POST" enctype="multipart/form-data">
					<div class="row marginb">
						<div class="col-md-12">
							<label for="name">Nombre:</label>
							<input name="name" value="<?=$company['name']?>" type="text" required/>
						</div>
					</div>
					<div class="row">
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
	
	