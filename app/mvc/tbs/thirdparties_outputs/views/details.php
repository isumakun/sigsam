<h2>Salida de terceros</h2>

<h3>Información general</h3>

<table>
	<th>Solicitud de ingreso #</th>
	<th>Empresa</th>
	<th>Empleado</th>
	<th>Vehículo</th>
	<th>Creado por</th>
	<th>Fecha de creación</th>
	<th class="strech"></th>
	<tr>
		<td><?=$output['request_id']?></td>
		<td><?=$output['company']?></td>
		<td><?=$output['employee']?></td>
		<td><?=$output['vehicle_plate']?></td>
		<td><?=$output['created_by']?></td>
		<td><?=$output['created_at']?></td>
		<td>
			<?= make_link('tbs/Thirdparties_outputs/edit?id='.$output['id'], '<span class="icon edit"></span>', 'button edit') ?>
		</td>
	</tr>
</table>

<h3>Materiales, Herramientas y Equipos</h3>
<table>
	<th>Detalle</th>
	<th>Cantidad de salida</th>
	<th>Fecha de creación</th>
	<th>Ingresó?</th>
	<th class="stretch">
	</th>
	<tbody>
		<?php foreach ($tools as $tool) {
			?>
			<tr>
				<td><?=$tool['tool']?></td>
				<td><?=$tool['quantity']?></td>
				<td><?=$tool['created_at']?></td>
				<td><?php if ($tool['entry']!='0000-00-00 00:00:00') {
					echo "Si [{$tool['entry']}]";
				}else{
					echo "No";
				}?></td>
				<td class="nowrap">
					<?php if ($tool['entry']=='0000-00-00 00:00:00') {
						?>
						<?= make_link('tbs/thirdparties_outputs_tools/edit?id='.$tool['tot_id'], '<span class="icon edit"></span>', 'button edit') ?>
						<?php
					} ?>
				</td>
			</tr>
			<?php
		} ?>
	</tbody>
</table>