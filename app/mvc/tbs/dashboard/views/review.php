<h3>Módulos de Revisión</h3>

<div style="position: fixed; bottom: 0; right: 0; margin: 20px; z-index: 999999; text-align: right;">
	<a href="#inputs" class="button"><span class="icon input white"></span></a>
	<a href="#tinputs" class="button dark"><span class="icon transport white"></span></a>
	<a href="#outputs" class="button red"><span class="icon output white"></span></a>
	<a href="#toutputs" class="button black"><span class="icon transport white"></span></a>
	<a href="#o_inspec" class="button black"><span class="icon checkmark white"></span></a>
	<a href="#transform" class="button purple"><span class="icon loop white"></span></a>
</div>
<h2 id="inputs">Ingresos</h2>
<table class="datagrid" data-page-length='10'>
		<thead>
			<th>Empresa</th>
			<th>#</th>
			<th>Proveedor</th>
			<th>Transacción</th>
			<th>Transporte</th>
			<th>Creado</th>
			<th>Presentado</th>
			<th>Estado</th>
			<th></th>
		</thead>
		<?php 
		foreach ($inputs as $input) {
			foreach ($input as $in) {
				?>
				<tr>
					<td><?=$in['company']?></td>
					<td><?=$in['form_id']?></td>
					<td><?=$in['supplier']?></td>
					<td><?=$in['transaction']?></td>
					<td><?=$in['transport']?></td>
					<td><?=$in['created_at']?></td>
					<td><?=$in['presented_at']?></td>
					<td><?=$in['state']?></td>
					<td>
						<a href="<?=BASE_URL?>tbs/dashboard/redirect?id=<?=$in['form_id']?>&company_id=<?=$in['company_id']?>&type=1" class="button view"><span class="icon open"></span></a>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
<hr>
<h2 id="tinputs">Transportes de Ingreso</h2>
<table class="datagrid" data-page-length='10'>
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
			<th></th>
		</thead>
		<?php 
		foreach ($transport_inputs as $input) {
			foreach ($input as $in) {
				?>
				<tr>
					<td><?=$in['driver_citizen_id']?></td>
					<td><?=$in['driver_name']?></td>
					<td><?=$in['vehicle_plate']?></td>
					<td><?=$in['form_id']?></td>
					<td><?=$in['products']?></td>
					<td><?=$in['company_name']?></td>
					<td><?=$in['charge_ucompany_id_number_manifested']?></td>
					<td><?=$in['seal_number_manifested']?></td>
					<td><?=$in['presented_at']?></td>
					<td>
						<a href="<?=BASE_URL?>tbs/dashboard/redirect?id=<?=$in['id']?>&company_id=<?=$in['company_id']?>&type=2" class="button view"><span class="icon open"></span></a>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
<hr>
<h2 id="outputs">Salidas</h2>
<table class="datagrid" data-page-length='10'>
		<thead>
			<th>Empresa</th>
			<th>#</th>
			<th>Proveedor</th>
			<th>Transacción</th>
			<th>Transporte</th>
			<th>Creado</th>
			<th>Presentado</th>
			<th>Estado</th>
			<th></th>
		</thead>
		<?php 
		foreach ($outputs as $output) {
			foreach ($output as $in) {
				?>
				<tr>
					<td><?=$in['company']?></td>
					<td><?=$in['form_id']?></td>
					<td><?=$in['supplier']?></td>
					<td><?=$in['transaction']?></td>
					<td><?=$in['transport']?></td>
					<td><?=$in['created_at']?></td>
					<td><?=$in['presented_at']?></td>
					<td><?=$in['state']?></td>
					<td>
						<a href="<?=BASE_URL?>tbs/dashboard/redirect?id=<?=$in['form_id']?>&company_id=<?=$in['company_id']?>&type=3" class="button view"><span class="icon open"></span></a>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
<hr>

<?php
	function sortFunction( $a, $b ) {
	    return strtotime($a["date"]) - strtotime($b["date"]);
	}

	$out_inspec = array();

	foreach ($output_inspections as $output) {
		foreach ($output as $in) {
			array_push($out_inspec, $in);
		}
	}

	usort($out_inspec, "sortFunction");
?>
<h2 id="o_inspec">Solicitudes de inspección para salida</h2>
<table class="datagrid" data-page-length='10'>
		<thead>
			<th>Turno</th>
			<th>Fecha</th>
			<th>Empresa</th>
			<th>Formulario</th>
			<th>Lugar</th>
			<th></th>
		</thead>
		<?php
		$count = 1;
			foreach ($out_inspec as $in) {
				?>
				<tr>
					<td><?=$count?></td>
					<td><?=$in['requested_at']?></td>
					<td><?=$in['company']?></td>
					<td><?=$in['form_id']?></td>
					<td><?=$in['place']?></td>
					<td>
						<a href="<?=BASE_URL?>tbs/dashboard/redirect?company_id=<?=$in['company_id']?>&type=7" class="button view"><span class="icon open"></span></a>
					</td>
				</tr>
				<?php
				$count++;
			}
		?>
	</table>
<hr>
<h2 id="toutputs">Transportes de Salida</h2>
<table class="datagrid" data-page-length='10'>
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
			<th></th>
		</thead>
		<?php 
		foreach ($transport_outputs as $output) {
			foreach ($output as $in) {
				?>
				<tr>
					<td><?=$in['driver_citizen_id']?></td>
					<td><?=$in['driver_name']?></td>
					<td><?=$in['vehicle_plate']?></td>
					<td><?=$in['form_id']?></td>
					<td><?=$in['products']?></td>
					<td><?=$in['company_name']?></td>
					<td><?=$in['charge_ucompany_id_number_manifested']?></td>
					<td><?=$in['seal_number_manifested']?></td>
					<td><?=$in['presented_at']?></td>
					<td>
						<a href="<?=BASE_URL?>tbs/dashboard/redirect?id=<?=$in['id']?>&company_id=<?=$in['company_id']?>&type=4" class="button view"><span class="icon open"></span></a>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
<hr>
<h2 id="transform">Trasformaciones</h2>
<table class="datagrid" data-page-length='10'>
		<thead>
			<th>Empresa</th>
			<th>#</th>
			<th>Creado</th>
			<th>Presentado</th>
			<th>Estado</th>
			<th></th>
		</thead>
		<?php 
		foreach ($transformations as $trans) {
			foreach ($trans as $in) {
				?>
				<tr>
					<td><?=$in['company']?></td>
					<td><?=$in['form_id']?></td>
					<td><?=$in['created_at']?></td>
					<td><?=$in['presented_at']?></td>
					<td><?=$in['state']?></td>
					<td>
						<a href="<?=BASE_URL?>tbs/dashboard/redirect?id=<?=$in['form_id']?>&company_id=<?=$in['company_id']?>&type=5" class="button view"><span class="icon open"></span></a>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>
	<hr>
<h2 id="kk">Terceros</h2>
<table class="datagrid" data-page-length='10'>
		<thead>
			<th>Empresa</th>
			<th>#</th>
			<th>Creado</th>
			<th>Presentado</th>
			<th>Estado</th>
			<th></th>
		</thead>
		<?php 
		foreach ($transformations as $trans) {
			foreach ($trans as $in) {
				?>
				<tr>
					<td><?=$in['company']?></td>
					<td><?=$in['id']?></td>
					<td><?=$in['created_at']?></td>
					<td><?=$in['presented_at']?></td>
					<td><?=$in['state']?></td>
					<td>
						<a href="<?=BASE_URL?>tbs/dashboard/redirect?id=<?=$in['id']?>&company_id=<?=$in['company_id']?>&type=6" class="button view"><span class="icon open"></span></a>
					</td>
				</tr>
				<?php
			}
		}
		?>
	</table>