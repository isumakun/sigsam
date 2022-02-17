<h3 style="text-transform: uppercase;">Vehículos autorizados ingresar mercancias</h3>
	<table class="datagrid">
		<thead>
			<th>Cedula</th>
			<th>Conductor</th>
			<th>Placa Camión</th>
			<th>Formulario</th>
			<th>Productos</th>
			<th>Empresa</th>
			<th># Contenedor</th>
			<th># Precinto</th>
			<th>Fecha</th>
		</thead>
		<?php 
		foreach ($inputs as $input) {
			foreach ($input as $in) {
				?>
				<tr>
					<td><?=$in['driver_citizen_id']?></td>
					<td><?=$in['driver_name']?></td>
					<td><?=$in['vehicle_plate']?></td>
					<td><?=$in['id']?></td>
					<td><?=$in['products']?></td>
					<td><?=$in['company_name']?></td>
					<td><?=$in['charge_unit_number_manifested']?></td>
					<td><?=$in['seal_number_manifested']?></td>
					<td><?=$in['presented_at']?></td>
				</tr>
				<?php
			}
		}
		?>
	</table>

	<h3 style="text-transform: uppercase;">Vehículos autorizados para cargar</h3>
	<table class="datagrid">
		<thead>
			<th>Cedula</th>
			<th>Conductor</th>
			<th>Placa Camión</th>
			<th>Empresa</th>
			<th>Fecha</th>
		</thead>
		<?php 
		foreach ($outputs_created as $output) {
			foreach ($output as $out) {
				?>
				<tr>
					<td><?=$out['driver_citizen_id']?></td>
					<td><?=$out['driver_name']?></td>
					<td><?=$out['vehicle_plate']?></td>
					<td><?=$out['company_name']?></td>
					<td><?=$out['created_at']?></td>
				</tr>
				
				<?php
			}
		}
		?>
	</table>

	<h3 style="text-transform: uppercase;">Vehículos autorizados retirar mercancia</h3>
	<a href="#approved" class="button modal">Ver placas aprobadas</a>
	<table class="datagrid">
		<thead>
			<th>Cedula</th>
			<th>Conductor</th>
			<th>Placa Camión</th>
			<th>Productos</th>
			<th>Empresa</th>
			<th>Fecha</th>
		</thead>
		<?php 
		foreach ($outputs as $output) {
			foreach ($output as $out) {
				?>
				<tr>
					<td><?=$out['driver_citizen_id']?></td>
					<td><?=$out['driver_name']?></td>
					<td><?=$out['vehicle_plate']?></td>
					<td><?=$out['products']?></td>
					<td><?=$out['company_name']?></td>
					<td><?=$out['presented_at']?></td>
				</tr>
				<?php
			}
		}
		?>
	</table>
	<div id="approved" class="modal">
		<table class="datagrid">
		<thead>
			<th>Cedula</th>
			<th>Conductor</th>
			<th>Placa Camión</th>
			<th>Productos</th>
			<th>Empresa</th>
			<th>Aprobado</th>
		</thead>
		<?php
		foreach ($approved as $forms) {
			foreach ($forms as $form) {
				?>
			<tr>
					<td><?=$form['driver_citizen_id']?></td>
					<td><?=$form['driver_name']?></td>
					<td><?=$form['vehicle_plate']?></td>
					<td><?=$form['products']?></td>
					<td><?=$form['company_name']?></td>
					<td><?=$form['approved_at']?></td>
				</tr>
				<?php
			}
			} ?>
		</table>
	</div>

<script type="text/javascript">
	setTimeout(function(){
		window.location.reload(1);
	}, 300000);
</script>