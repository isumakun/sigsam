<h3>VIN searcher</h3>

<?php if (!$results) {
	?>
	<form method="POST">
		<label>VINES declaración</label>
		<textarea name="block" rows="6"></textarea>

		<label>VINES a buscar</label>
		<textarea name="vins" rows="6"></textarea>

		<input type="submit" value="Buscar">
	</form>
	<?php
}else{
	?>
	<h4>VINES Encontrados</h4>
	<table>
		<th>VIN</th>
		<?php 
		foreach ($true_vins as $vin) {
			?>
			<tr>
				<td><?=$vin?></td>
			</tr>
			<?php
		}
		 ?>
	</table>

	<h4>VINES NO Encontrados</h4>
	<table>
		<th>VIN</th>
		<?php 
		foreach ($false_vins as $vin) {
			?>
			<tr>
				<td><?=$vin?></td>
			</tr>
			<?php
		}
		 ?>
	</table>
	<?php
} ?>