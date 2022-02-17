<h2>Editar Formulario</h2>
	<form method="POST">
		
		<label>Conductor</label>
		<input 	name="driver_citizen_id" 
		value="<?=$tof['driver_citizen_id']?>" 
		class="populate"
		<?=checkError('driver_citizen_id', $transport_input_forms_verify)?> 	
		data-modal="drivers"
		data-label="<?=$tof['driver_name']?>"
		>

		<label>Placa del Camión</label>
		<input type="text" name="vehicle_plate" data-label="vehicle_plate" required value="<?=$tof['vehicle_plate']?>" <?=checkError('vehicle_plate', $transport_output_forms_verify)?>>

		<label>Número de Trailer</label>
		<input type="text" name="trailer_number" data-label="trailer_number" required value="<?=$tof['trailer_number']?>" <?=checkError('trailer_number', $transport_input_forms_verify)?>>

		<input type="submit" value="Enviar">
	</form>

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