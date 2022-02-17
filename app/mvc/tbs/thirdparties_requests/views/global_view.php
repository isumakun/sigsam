<h2>Solicitudes de Ingreso de terceros [Global]</h2>

<table class="datagrid">
	<thead>
		<th>Empresa</th>
		<th>#</th>
		<th>Persona a cargo</th>
		<th>Fecha Inicio</th>
		<th>Fecha Fin</th>
		<th>Teléfono</th>
		<th>Accceso</th>
		<th></th>
	</thead>
	<tbody>
		<?php 

		foreach ($requests as $request) {
			foreach ($request as $req) {
				?>
				<tr>
					<td><?=$req['request_company']?></td>
					<td><?=$req['id']?></td>
					<td><?=$req['person_in_charge']?></td>
					<td><?=$req['schedule_from']?></td>
					<td><?=$req['schedule_to']?></td>
					<td><?=$req['contact_phone']?></td>
					<td><?=$req['access']?></td>
					<td>
						<a href="<?=BASE_URL?>tbs/thirdparties_requests/redirect?id=<?=$req['id']?>&nit=<?=$req['nit']?>" class="button view"><span class="icon open"></span></a>
					</td>
				</tr>
				<?php
			}
		}

		?>
	</tbody>
</table>