<h2>Fecha aprobación</h2>
<?php if (!$data) {
	?>
<form method='POST'>

	<div class="">
		<label>Tipo</label>
		<select name="type">
			<option value="1">Ingresos</option>
			<option value="2">Salidas</option>
			<option value="3">Planilla de Recepción Ingresos</option>
		</select>

		<label for="month">Mes:</label>
		<input type="number" placeholder="En número" name="month">

		<label for="year">Año:</label>
		<input type="number" name="year">
	</div>
	<label></label>
	<input type="submit" value="Generar Reporte" />

</form>
	<?php
}else{
	$head_date1 = 'Fecha presentación';
	$head_date2 = 'Fecha aprobación';
	if ($type==3) {
		$head_date1 = 'Fecha Recepción';
		$head_date2 = 'Fecha aprobación <br> ultimo transporte';
	}
	?>
	<table>
		<thead>
			<th>Empresa</th>
			<th>Formulario</th>
			<th>Transacción</th>
			<th><?=$head_date1?></th>
			<th><?=$head_date2?></th>
			<th>Tiempo de aprobación (Horas)</th>
		</thead>
	
	<?php
	foreach ($data as $forms) {
			if ($type<3) {
				foreach ($forms as $ip) {
				?>
				<tr>
					<td><?=$ip['company']?></td>
					<td><?=$ip['form_id']?></td>
					<td><?=$ip['transaction_id']?></td>
					<td><?=$ip['presented_at']?></td>
					<td><?=$ip['approved_at']?></td>
					<td>
						<?php 
						$date1 = new DateTime($ip['presented_at']);
						$date2 = new DateTime($ip['approved_at']);

						// The diff-methods returns a new DateInterval-object...
						$diff = $date2->diff($date1);

						// Call the format method on the DateInterval-object
						echo $diff->format('%h');
						?>
					</td>
				</tr>
				<?php
			}
			}else{
				?>
				<tr>
					<td><?=$forms['company']?></td>
					<td><?=$forms['iid']?></td>
					<td><?=$forms['transaction_id']?></td>
					<td><?=$forms['reception_date']?></td>
					<td><?=$forms['approved']?></td>
					<td>
						<?php 
						if (!empty($forms['reception_date'])) {
							$date1 = new DateTime($forms['reception_date']);
							$date2 = new DateTime($forms['approved']);

							// The diff-methods returns a new DateInterval-object...
							$diff = $date2->diff($date1);

							// Call the format method on the DateInterval-object
							echo $diff->format('%h');
						}
						?>
					</td>
				</tr>
				<?php
			}
	}
	?>
</table>
<?php
} ?>

