<h2>Solicitudes de Ingreso de terceros</h2>

<table class="datagrid">
	<thead>
		<th id="sort">#</th>
		<th>Empresa</th>
		<th>Persona a cargo</th>
		<th>Fecha Inicio</th>
		<th>Fecha Fin</th>
		<th>Teléfono</th>
		<th>Accceso</th>
		<th>Estado solicitud</th>
		<th>Estado permiso</th>
		<th><?=make_link('tbs/thirdparties_requests/create', '<span class="icon create"></span> Nueva', 'button dark create')?></th>
	</thead>
	<tbody>
		<?php 

			foreach ($requests as $req) {
				?>
				<tr>
					<td><?=$req['id']?></td>
					<td><?=$req['company']?></td>
					<td><?=$req['person_in_charge']?></td>
					<td><?=$req['schedule_from']?></td>
					<td><?=$req['schedule_to']?></td>
					<td><?=$req['contact_phone']?></td>
					<td><?=$req['access']?></td>
					<td><?=$req['form_state']?></td>
					<td><?php if ($req['form_state_id']!=5) {
						$approved_date = ($req['approved_by']);

						if ((time()-(60*60*24)) <= strtotime($approved_date)) {
							echo "Abierta";
						}else{
							echo "Cerrada";
						}
					}else{
						echo "Cerrado";
					} ?></td>
					<td>
						<a href="<?=BASE_URL?>tbs/thirdparties_requests/details?id=<?=$req['id']?>" class="button view"><span class="icon open"></span></a>
						<a href="<?=BASE_URL?>tbs/thirdparties_requests/printout?id=<?=$req['id']?>" class="button dark"><span class="icon printer"></span></a>
					</td>
				</tr>
				<?php
			}

		?>
	</tbody>
</table>

<script type="text/javascript">
	$(document).ready(function(){
		$('#sort').click();
	})
</script>