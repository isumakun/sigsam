<h2>Buscar soporte</h2>
<?php if (!$support) {
	?>
<form method='POST'>

	<label>Formulario</label>
	<select name="form">
		<option value="1">Ingreso</option>
		<option value="2">Salida</option>
		<option value="3">Pase Ingreso</option>
		<option value="4">Pase Salida</option>
	</select>

	<label>Detalle</label>
	<input name="detail" required />

	<input type="submit"/>

</form>
	<?php
}else{
	?>
	<table>
	<thead>
		<th>Lugar</th>
		<th>Estado<br>Formulario</th>
		<th></th>
	</thead>
	<?php
	foreach ($support as $supp) {
		?>
		<tr>
			<td>
		<p>El soporte con detalle <b>"<?=$supp['details']?>"</b> se encuentra en el formulario #<?=$supp['form_id']?></p></td>
		<td><?=$supp['state']?></td>
		<td>
		<?php if ($type==1) {
			?>
			<a href="<?=BASE_URL.'tbs/input_forms/details?id='.$supp['form_id']?>" class="button">Ir al formulario</a>
			<?php
		}elseif ($type==2) {
			?>
			<a href="<?=BASE_URL.'tbs/output_forms/details?id='.$supp['form_id']?>" class="button">Ir al formulario</a>
			<?php
		}elseif ($type==3) {
			?>
			<a href="<?=BASE_URL.'tbs/transport_input_forms/details?id='.$supp['form_id']?>" class="button">Ir al formulario</a>
			<?php
		}elseif ($type==4) {
			?>
			<a href="<?=BASE_URL.'tbs/transport_output_forms/details?id='.$supp['form_id']?>" class="button">Ir al formulario</a>
			<?php
		} ?>
		</td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
} ?>

