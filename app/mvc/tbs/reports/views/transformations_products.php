<h2>Producto en transformaciones</h2>
<?php if (!$products) {
	?>
<form method='POST'>

	<label>ID Almacen</label>
	<input name="warehouse_id" required />

	<input type="submit"/>

</form>
<?php
}else{
?>

<h3><b>Lista de transformaciones</b></h3>

<table style="font-size: 12px">
		<th>Transformación</th>
		<th>Cantidad</th>
		<th></th>
		<?php 
		foreach ($products as $product) {
		?>
		<tr>
			<td><?=$product['form_id']?></td>
			<td><?=$product['quantity']?></td>
			<td><a href="<?=BASE_URL.'tbs/transformation_forms/details?id='.$product['form_id']?>" class="button create dark" target="_blank">Ir al formulario</a></td>
		</tr>
		<?php
		}
		?>
	</table>
<?php
}
?>