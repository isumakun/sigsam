<h2>Editar</h2>
	<form method="POST">
		
		<label>Conductor</label>
		<input 	name="driver_citizen_id" 
		value="<?=$tif['driver_citizen_id']?>" 
		class="populate"
		<?=checkError('driver_citizen_id', $transport_input_forms_verify)?> 	
		data-modal="drivers"
		data-label="<?=$tif['driver_name']?>"
		>

		<label>Placa del Camión</label>
		<input type="text" name="vehicle_plate" data-label="vehicle_plate" required value="<?=$tif['vehicle_plate']?>" <?=checkError('vehicle_plate', $transport_input_forms_verify)?>>

		<label>Número de Trailer</label>
		<input type="text" name="trailer_number" data-label="trailer_number" value="<?=$tif['trailer_number']?>" <?=checkError('trailer_number', $transport_input_forms_verify)?>>

		<label>Cliente/Proveedor</label>
		<input 	name="supplier_id" 
		value="<?=$tif['supplier_id']?>" 
		class="populate"
		<?=checkError('supplier_id', $transport_input_forms_verify)?> 	
		data-modal="suppliers"
		data-label="<?=$tif['supplier']?>"
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