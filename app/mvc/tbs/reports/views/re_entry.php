<h2>Reingreso Carros</h2>
<?php if (!$products) {
	?>
<form method='POST'>

	<label>Número de formulario de salida</label>
	<input name="form_id" required />

	<label></label>
	<input type="submit"/>

</form>
	<?php
}else{
	?>
	<h3><b>Reingreso del formulario de salida #<?=$products[0]['output_form_id']?></b></h3>
	<table style="font-size: 12px">
		<th>Nombre</th>
		<th>Interfaz</th>
		<th>Tipo</th>
		<th>Categoria</th>
		<th>Subpartida</th>
		<th>C. Comercial</th>
		<th>Cantidad</th>
		<th>Unidad</th>
		<th>P. Neto</th>
		<th>P. Bruto</th>
		<th>V. Unitario</th>
		<th>FOB</th>
		<th>Fletes</th>
		<th>Seguros</th>
		<th>O. Gastos</th>
		<th>Embalaje</th>
		<th>País</th>
	
	<?php
	$cant = count($products);

	foreach ($products as $product) {
		?>
		<tr>
			<td><?=$product['product']?></td>
			<td><?=$product['interface_code']?></td>
			<td><?=$product['product_type_id']?></td>
			<td><?=$product['product_category_id']?></td>
			<td><?=$product['tariff_heading_code']?></td>
			<td><?=$product['commercial_quantity']?></td>
			<td><?=$product['quantity']?></td>
			<td><?=$product['physical_unit_id']?></td>
			<td><?=$product['net_weight']?></td>
			<td><?=$product['gross_weight']?></td>
			<td><?=$product['fob_value']?></td>
			<td><?=$product['fob_value']?></td>
			<td><?=$product['freights']?></td>
			<td><?=$product['insurance']?></td>
			<td><?=$product['other_expenses']?></td>
			<td><?=$product['packaging_id']?></td>
			<td><?=$product['flag_id']?></td>
		</tr>
		<?php
	}
	?>
	</table>
	<?php
} ?>

