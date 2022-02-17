<?php 
$calendar = new Calendar();
?>
<?php $created_company = get_messages('company'); ?>
	<h2>Nuevo Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="company_id">Empresa:</label>
		<input 	name="company_id" 
		value="<?=$created_company[0]?>" 
		class="populate"
		data-modal="companies"
		data-label="<?=$created_company[1]?>"
		>

		<label for="person_in_charge">Persona a cargo:</label>
		<input name="person_in_charge" value="<?=$_POST['person_in_charge']?>" type="text"/>

		<label for="schedule_from">Fecha inicio:</label>
		<?=$calendar->render('schedule_from')?>

		<label for="schedule_to">Fecha fin:</label>
		<?=$calendar->render('schedule_to')?>

		<label for="contact_phone">Télefono de contacto:</label>
		<input name="contact_phone" value="<?=$_POST['contact_phone']?>" type="text"/>

		<label>Acceso</label>
		<select name="access">
			<option>Principal</option>
			<option>M5</option>
			<option>Ambas</option>
		</select>

		<label for="working_hours">Horario de trabajo:</label>
		<input name="working_hours" value="<?=$_POST['working_hours']?>" type="text"/>

		<label for="work_types">Tipo de trabajos:</label>
		<select name="work_types[]" class="select2" multiple>
<?php
				foreach($thirdparties_works_types AS $t)
				{
?>
			<option value="<?=$t['id']?>"><?=$t['name']?></option>
<?php
				}
?>
		</select>

		<label>Observaciones</label>
		<textarea name="observations"></textarea>

		<input class="submit" type="submit" value="Crear" />
	</form>


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