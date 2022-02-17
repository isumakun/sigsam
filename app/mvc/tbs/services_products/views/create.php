<h2>Agregar producto</h2>
<?php $created_product = get_messages();?>

<form method="POST">
	<label>Producto</label>
	<input name="product_id"
	value="<?=$created_product[0]?>"
	class="populate"
	data-modal="products"
	data-label="<?=$created_product[1]?>"
	>

	<input type="submit" name="">
</form>

<div id="products" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Producto</th>
			<th>Código de Interfaz</th>
			<th>Tipo</th>
			<th>Subpartida</th>
			<th>Unidad</th>
			<th class="stretch"><a href="<?=BASE_URL?>/products/create" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($products as $product) {
			?>
			<tr>
				<td><?=$product['id']?></td>
				<td><?=$product['name']?></td>
				<td><?=$product['interface_code']?></td>
				<td><?=$product['product_type']?></td>
				<td><?=$product['tariff_heading']?></td>
				<td><?=$product['physical_unit']?></td>
				<td><a href="javascript:;"
					class="button open populate"
					data-values="<?=$product['id']?>,0,0"
					data-labels="<?=$product['name']?>,<?=$product['tariff_heading']?>,<?=$product['physical_unit']?>"
					data-elements="product_id,tariff_heading,physical_unit"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>