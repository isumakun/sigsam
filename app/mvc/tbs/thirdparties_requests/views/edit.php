<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="company_id">Empresa:</label>
		<input 	name="company_id" 
		value="<?=$thirdparty_request['company_id']?>" 
		class="populate"
		data-modal="companies"
		data-label="<?=$thirdparty_request['company']?>"
		>

		<label for="person_in_charge">Persona a cargo:</label>
		<input name="person_in_charge" value="<?=$thirdparty_request['person_in_charge']?>" type="text"/>

		<label for="schedule_from">Fecha Inicio:</label>
		<?=$calendar->render('schedule_from',$thirdparty_request['schedule_from'], TRUE, 'YYYY-MM-DD', $class.' data-label="schedule_from"')?>

		<label for="schedule_to">Fecha fin:</label>
		<?=$calendar->render('schedule_to',$thirdparty_request['schedule_to'], TRUE, 'YYYY-MM-DD', $class.' data-label="schedule_to"')?>

		<label for="contact_phone">Télefono de contacto:</label>
		<input name="contact_phone" value="<?=$thirdparty_request['contact_phone']?>" type="text"/>

		<label>Acceso</label>
		<select name="access">
			<option <?=($thirdparty_request['access'] == 'Principal' ? 'selected' : '')?>>Principal</option>
			<option <?=($thirdparty_request['access'] == 'M5' ? 'selected' : '')?>>M5</option>
			<option <?=($thirdparty_request['access'] == 'Ambas' ? 'selected' : '')?>>Ambas</option>
		</select>

		<label for="working_hours">Horario de trabajo:</label>
		<input name="working_hours" value="<?=$thirdparty_request['working_hours']?>" type="text"/>

		<label for="work_types">Tipo de trabajos:</label>
		<select class="select2" name="work_types[]" multiple>
		<?php
			$work_types = explode(',', $thirdparty_request['work_types']);

			foreach($thirdparties_works_types AS $t)
			{
				$selected = '';
				foreach ($work_types as $wt) {
					if ($wt==$t['id']) {
						$selected = 'selected';
					}
				}
				?>
				<option <?=$selected?> value="<?=$t['name']?>"><?=$t['name']?></option>
				<?php
			}
		?>
		</select>

		<label>Observaciones</label>
		<textarea name="observations"><?=$thirdparty_request['observations']?></textarea>

		<input class="submit" type="submit" value="Guardar" />
	</form>

<script type="text/javascript">
	$('#work_types').trigger('change');
</script>
<div id="companies" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Nit</th>
			<th>Empresa</th>
			<th class="stretch"><a href="<?=BASE_URL?>tbs/thirdparties_companies/create" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($companies as $company) {
			?>
			<tr>
				<td><?=$company['id']?></td>
				<td><?=$company['nit']?></td>
				<td><?=$company['name']?></td>
				<td class="nowrap"><a href="javascript:;"
					class="button open populate"
					data-values="<?=$company['id']?>"
					data-labels="<?=$company['name']?>"
					data-elements="company_id"><span class="icon open"></span></a>
					<?= make_link('tbs/thirdparties_companies/edit?id='.$company['id'], '<span class="icon edit"></span>', 'button edit') ?>
				</td>
				</tr>
				<?php
			} ?>
		</table>
	</div>