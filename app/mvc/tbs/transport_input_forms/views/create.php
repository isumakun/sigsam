<?php 
$created_driver = get_messages('driver');
$created_supplier = get_messages('supplier');
?>
<h2>Nuevo Transporte de entrada</h2>
	<form method="POST">
		
		<label>Conductor</label>
		<input 	name="driver_citizen_id" 
		value="<?=$created_driver[0]?>" 
		class="populate"
		data-modal="drivers"
		data-label="<?=$created_driver[0]?>  <?=$created_driver[1]?>"
		>

		<label>Placa del Camión</label>
		<input type="text" name="vehicle_plate">

		<label>Número de Trailer</label>
		<input type="text" name="trailer_number">

		<label>Cliente/Proveedor</label>
		<input 	name="supplier_id" 
		value="<?=$created_supplier[0]?>" 
		class="populate"
		data-modal="suppliers"
		data-label="<?=$created_supplier[1]?>"
		>

		<input type="submit" value="Enviar">
	</form>
<div id="suppliers" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Nit</th>
			<th>Proveedor</th>
			<th class="stretch"><a href="<?=BASE_URL?>/suppliers/create?opt=no" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($suppliers as $supplier) {
			?>
			<tr>
				<td><?=$supplier['id']?></td>
				<td><?=$supplier['nit']?></td>
				<td><?=$supplier['name']?></td>
				<td class="nowrap">
					<?= make_link('tbs/suppliers/edit?id='.$supplier['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?= make_link('tbs/suppliers/delete?id='.$supplier['id'], '<span class="icon delete"></span>', 'button delete confirm_action confirm_action') ?>
					<a href="javascript:;"
					class="button open populate"
					data-values="<?=$supplier['id']?>"
					data-labels="<?=$supplier['name']?>"
					data-elements="supplier_id"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	</div>

<div id="drivers" class="modal">
	<table class="datagrid">
		<thead>
			<th>Cedula</th>
			<th>Nombre</th>
			<th class="stretch"><a href="<?=BASE_URL?>/drivers/create" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($drivers as $driver) {
			?>
			<tr>
				<td><?=$driver['id']?></td>
				<td><?=$driver['name']?></td>
				<td class="nowrap">
					<?= make_link('tbs/drivers/edit?id='.$driver['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?= make_link('tbs/drivers/delete?id='.$driver['id'], '<span class="icon delete"></span>', 'button delete confirm_action confirm_action') ?>
					<a href="javascript:;"
					class="button open populate"
					data-values="<?=$driver['id']?>"
					data-labels="<?=$driver['id']?> - <?=$driver['name']?>"
					data-elements="driver_citizen_id"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	</div>