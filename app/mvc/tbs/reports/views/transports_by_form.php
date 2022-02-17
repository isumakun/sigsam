<center>
	<h2>Pases por formulario</h2>
</center>
<?php if (!$forms) {
	?>
<div class="col-md-6 offset-md-3">
	<form method='POST'>

	<label>Tipo</label>
	<select name="type">
		<option value="1">Ingresos</option>
		<option value="2">Salidas</option>
	</select>

	<label>Número de formulario</label>
	<input name="form_id" required />

	<label></label>
	<input type="submit"/>

</form>
</div>
	<?php
}else{
	?>
	<h3><b>Formulario # <?=$forms[0]['iid']?></b></h3>
	<table>
		<th># Pase</th>
		<th>Peso recibido</th>
		<th>Estado</th>
		<th>Productos</th>
		<th>Cantidades</th>
		<th>Aprobado</th>
		<th></th>
	
	<?php
	$total_manifested = 0;
	$total_recived = 0;
	foreach ($forms as $form) {
		$total_manifested += $form['quantity_manifested'];
		?>
		<tr>
			<td><?=$form['tid']?></td>
			<td><?php
			$quantity = $form['starting_weight_value'] - $form['ending_weight_value'];
			if ($quantity<0) {
				$quantity = $form['ending_weight_value'] - $form['starting_weight_value'];
			}
			if ($quantity == 0) {
				if ($form['form_state_id']==3) {
					echo $form['quantity_manifested'];
				}
			}else{
				echo $quantity;
			}
			$total_recived += $quantity;
			?></td>
			<td><?=$form['state']?></td>
			<td><?php echo $form['products']; ?></td>
			<td></td>
			<td><?=$form['approved']?></td>
			<td><?php if ($type==1) {
				?>
				<a href="<?=BASE_URL.'tbs/transport_input_forms/details?id='.$form['tid']?>" class="button create dark" target="_blank">Ir al pase</a>
				<?php
			}else  if ($type==2) {
				?>
				<a href="<?=BASE_URL.'tbs/transport_output_forms/details?id='.$form['tid']?>" class="button create dark" target="_blank">Ir al pase</a>
				<?php
			} ?></td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
} ?>

