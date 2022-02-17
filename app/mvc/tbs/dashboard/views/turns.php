<h2>Turnos para inspección</h2>

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
<table class="datagrid" data-page-length='50'>
		<thead>
			<th>Turno</th>
			<th>Fecha</th>
			<th>Empresa</th>
			<th>Formulario</th>
			<th>Lugar</th>
			<th>VINES</th>
		</thead>
		<?php
		$count = 1;
			foreach ($out_inspec as $in) {
				?>
				<tr>
					<td><?=$count?></td>
					<td><?=$in['requested_at']?></td>
					<td><?=$in['company']?></td>
					<td>FMM-<?=$in['form_id']?></td>
					<td><?=$in['place']?></td>
					<td><?php
					$vines = explode(',', $in['vins']);
					foreach ($vines as $vin) {
						echo $vin.'<br>';
					}
					?></td>
				</tr>
				<?php
				$count++;
			}
		?>
	</table>