<h2>Formularios de Salida para Inspección</h2>

<table class="datagrid">
	<thead>
		<tr>
			<th>#</th>
			<th>Proveedor</th>
			<th>Transacción</th>
			<th>Modo Transporte</th>
			<th>TRM</th>
			<th>flag_1</th>
			<th>flag_2</th>
			<th>flag_3</th>
			<th>flag_4</th>
			<th>Creado</th>
			<th>Estado</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach ($output_forms as $if) {
			?>
			<tr>
				<td><?=$if['form_id']?></td>
				<td><?=$if['supplier']?></td>
				<td><?=$if['transaction']?></td>
				<td><?=$if['transport']?></td>
				<td><?=$if['exchange_rate']?></td>
				<td><?=$if['flag_1']?></td>
				<td><?=$if['flag_2']?></td>
				<td><?=$if['flag_3']?></td>
				<td><?=$if['flag_4']?></td>
				<td><?=$if['created_at']?></td>
				<td><?=$if['state']?></td>
				<td><a href="<?=BASE_URL?>tbs/output_forms/inspect?id=<?=$if['form_id']?>" class="button open"><span class="icon open"></span></a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>