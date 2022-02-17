<h3 style="text-transform: uppercase;">Personas autorizadas para ingreso</h3>
	<table class="datagrid">
		<thead>
			<th>Usuario</th>
			<th>Empresa</th>
			<th>Cedula</th>
			<th>Nombre</th>
			<th>Fecha inicio</th>
			<th>Fecha fin</th>
			<th>Horario</th>
			<th>Vehículo</th>
			<th>Acceso</th>
			<th>Fecha Límite ARL</th>
		</thead>
		<?php 
		foreach ($workers as $worker) {
			foreach ($worker as $w) {
				?>
				<tr>
					<td><?=$w['company']?></td>
					<td><?=$w['user_company']?></td>
					<td><?=$w['citizen_id']?></td>
					<td><?=$w['employee']?></td>
					<td><?=$w['schedule_from']?></td>
					<td><?=$w['schedule_to']?></td>
					<td><?=$w['working_hours']?></td>
					<td><?=$w['vehicle_plate']?></td>
					<td><?=$w['access']?></td>
					<td><?=$w['limit_date']?></td>
				</tr>
				<?php
			}
		}
		?>

<script type="text/javascript">
	setTimeout(function(){
		window.location.reload(1);
	}, 300000);
</script>