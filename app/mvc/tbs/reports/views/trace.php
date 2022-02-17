<?php
error_reporting(E_ALL);
	if ($result)
	{
?>
		<h3>Información del producto</h3>


		<h3>Detalle de la trazabilidad</h3>
<?php
		if ($input)
		{
?>
			<h3>Ingreso</h3>
			<table>
				<thead>
					<tr>
						<th>FMM ID</th>
						<th>Cantidad</th>
						<th class="stretch"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?=$input[0]['form_id']?></td>
						<td><?=number_format($input[0]['quantity'], 2)?></td>
						<td><a href="<?=BASE_URL?>tbs/input_forms/printout?id=<?=$input[0]['form_id']?>" class="button printer" target="_blank"><span class="icon printer"></span></a></td>
					</tr>
				</tbody>
			</table>
<?php
		}

		if ($transport_input)
		{
?>
			<h3>Transportes Ingreso</h3>
			<table>
				<thead>
					<tr>
						<th>FMM ID</th>
						<th>Cantidad</th>
						<th class="stretch"></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><?=$input[0]['form_id']?></td>
						<td><?=$input[0]['quantity']?></td>
						<td><a href="<?=BASE_URL?>tbs/transport_input_forms/printout?id=<?=$input[0]['form_id']?>" class="button printer" target="_blank"><span class="icon printer"></span></a></td>
					</tr>
				</tbody>
			</table>
<?php
		}

		if ($output)
		{
?>
			<h3>Salida</h3>
			<table>
				<thead>
					<tr>
						<th>FMM ID</th>
						<th>Cantidad</th>
						<th class="stretch"></th>
					</tr>
				</thead>
				<tbody>
<?php
				foreach ($output AS $o)
				{
?>
					<tr>
						<td><?=$o['form_id']?></td>
						<td><?=$o['quantity']?></td>
						<td><a href="<?=BASE_URL?>tbs/output_forms/printout?id=<?=$o['form_id']?>" class="button printer" target="_blank"><span class="icon printer"></span></a></td>
					</tr>
<?php
				}
?>
				</tbody>
			</table>
<?php
		}

		if ($transport_output)
		{
?>
			<h3>Transportes de Salida</h3>
			<table>
				<thead>
					<tr>
						<th>FMM ID</th>
						<th>Cantidad</th>
						<th class="stretch"></th>
					</tr>
				</thead>
				<tbody>
<?php
				foreach ($output AS $o)
				{
?>
					<tr>
						<td><?=$o['form_id']?></td>
						<td><?=$o['quantity']?></td>
						<td><a href="<?=BASE_URL?>tbs/transport_output_forms/printout?id=<?=$o['form_id']?>" class="button printer" target="_blank"><span class="icon printer"></span></a></td>
					</tr>
<?php
				}
?>
				</tbody>
			</table>
<?php
		}

		if ($nationalized)
		{
?>
			<h3>Nacionalizado</h3>
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Cantidad</th>
						<th class="stretch"></th>
					</tr>
				</thead>
				<tbody>
<?php
				foreach ($nationalized AS $n)
				{
?>
					<tr>
						<td><?=$n['form_id']?></td>
						<td><?=$n['quantity']?></td>
						<td><a href="javascript:;" class="button printer"><span class="icon printer"></span></a></td>
					</tr>
<?php
				}
?>
				</tbody>
			</table>
<?php
		}

		if ($transformation)
		{
?>
			<h3>Transformaciones</h3>
			<table>
				<thead>
					<tr>
						<th>ID</th>
						<th>Cantidad</th>
						<th class="stretch"></th>
					</tr>
				</thead>
				<tbody>
<?php
				foreach ($transformation AS $t)
				{
?>
					<tr>
						<td><?=$t['form_id']?></td>
						<td><?=$t['quantity']?></td>
						<td><a href="javascript:;" class="button printer"><span class="icon printer"></span></a></td>
					</tr>
<?php
				}
?>
				</tbody>
			</table>
<?php
		}
	}
?>