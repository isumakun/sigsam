<?php 
$calendar = new Calendar();
?>
<?php $created_employee = get_messages('employee'); ?>

	<h2>Nuevo Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="employee_id">Empleado:</label>
		<input 	name="employee_id" 
		value="<?=$created_employee[0]?>" 
		class="populate"
		data-modal="employees"
		data-label="<?=$created_employee[1]?>"
		>

		<label for="category_id">Categoria:</label>
		<select name="category_id">
<?php
				foreach($thirdparties_workers_categories AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($thirdparty_worker['category_id'] == $t['id'] ? 'selected' : '')?>><?=$t['name']?></option>
<?php
				}
?>
		</select>

		<input type="hidden" name="request_id" value="<?=$_GET['id']?>">
		
		<label for="vehicle_plate">Placa del vehículo (Opcional):</label>
		<input name="vehicle_plate" value="<?=$_POST['vehicle_plate']?>" type="text"/>

		<label for="arl">ARL:</label>
		<input name="arl" value="<?=$_POST['arl']?>" type="text"/>

		<label for="eps">EPS:</label>
		<input name="eps" value="<?=$_POST['eps']?>" type="text"/>

		<label>Es empleado?</label>
		<label class="switch">
		  <input name="is_employee" type="checkbox">
		  <span class="slider round"></span>
		</label>

		<input class="submit" type="submit" value="Crear" />
	</form>

<div id="employees" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Cedula</th>
			<th>Nombre</th>
			<th class="stretch"><a href="<?=BASE_URL?>tbs/thirdparties_employees/create" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($thirdparties_employees as $employee) {
			?>
			<tr>
				<td><?=$employee['id']?></td>
				<td><?=$employee['citizen_id']?></td>
				<td><?=$employee['name']?></td>
				<td class="nowrap"><a href="javascript:;"
					class="button open populate"
					data-values="<?=$employee['id']?>"
					data-labels="<?=$employee['name']?>"
					data-elements="employee_id"><span class="icon open"></span></a>
					<?= make_link('tbs/thirdparties_employees/edit?id='.$employee['id'], '<span class="icon edit"></span>', 'button edit') ?>
				</td>
				</tr>
				<?php
			} ?>
		</table>
	</div>