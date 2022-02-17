<?php 
$calendar = new Calendar();
?>
<?php $created_company = get_messages('company'); ?>
<?php $created_employee = get_messages('employee'); ?>

	<h2>Nuevo Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="request_id">Solicitud de Ingreso #:</label>
		<input 	name="request_id" 
		value="<?=$created[0]?>" 
		class="populate"
		data-modal="requests"
		data-label="<?=$created[1]?>"
		>

		<label for="company_id">Empresa:</label>
		<input 	name="company_id" 
		value="<?=$created_company[0]?>" 
		class="populate"
		data-modal="companies"
		data-label="<?=$created_company[1]?>"
		>

		<label for="employee_id">Empleado:</label>
		<input 	name="employee_id" 
		value="<?=$created_employee[0]?>" 
		class="populate"
		data-modal="employees"
		data-label="<?=$created_employee[1]?>"
		>

		<label for="vehicle_plate">Vehículo:</label>
		<input name="vehicle_plate" value="<?=$_POST['vehicle_plate']?>" type="text"/>

		<input class="submit" type="submit" value="Crear" />
	</form>

<div id="requests" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Empresa</th>
			<th>Persona a cargo</th>
			<th>Fecha Inicio</th>
			<th>Fecha Fin</th>
			<th class="stretch"></th>
		</thead>
		<?php
		foreach ($thirdparties_requests as $request) {
			?>
			<tr>
				<td><?=$request['id']?></td>
				<td><?=$request['company']?></td>
				<td><?=$request['person_in_charge']?></td>
				<td><?=$request['schedule_from']?></td>
				<td><?=$request['schedule_to']?></td>
				<td class="nowrap"><a href="javascript:;"
					class="button open populate"
					data-values="<?=$request['id']?>"
					data-labels="<?=$request['id']?> - <?=$request['company']?>"
					data-elements="request_id"><span class="icon open"></span></a>
				</td>
				</tr>
				<?php
			} ?>
		</table>
	</div>

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

<div id="companies" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Nit</th>
			<th>Empresa</th>
			<th class="stretch"><a href="<?=BASE_URL?>tbs/thirdparties_companies/create" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($thirdparties_companies as $company) {
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