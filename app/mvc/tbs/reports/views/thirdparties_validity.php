<table>
	<thead>
		<th>Persona</th>
		<th>Fecha límite</th>
		<th>Verificado por</th>
		<th>Aprobado por</th>
	</thead>
	<?php foreach ($results as $result) {
		foreach ($result as $data) {
			?>
			<tr>
				<td><?=$data['name']?></td>
				<td><?=$data['limit_date']?></td>
				<td><?=$data['verified_by']?></td>
				<td><?=$data['approved_by']?></td>
			</tr>
			<?php
		}
	} ?>
</table>