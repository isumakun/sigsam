<?php 
$calendar = new Calendar();
?>
	<h2>Nuevo Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="concept_id">Concept:</label>
		<select name="concept_id">
<?php
				foreach($concepts AS $c)
				{
?>
			<option value="<?=$c['id']?>" <?=($service_concept['concept_id'] == $c['id'] ? 'selected' : '')?>><?=$c['name']?></option>
<?php
				}
?>
		</select>

		<label for="service_id">Service:</label>
		<select name="service_id">
<?php
				foreach($services AS $s)
				{
?>
			<option value="<?=$s['id']?>" <?=($service_concept['service_id'] == $s['id'] ? 'selected' : '')?>><?=$s['service_type']?></option>
<?php
				}
?>
		</select>

		<input class="submit" type="submit" value="Crear" />
	</form>