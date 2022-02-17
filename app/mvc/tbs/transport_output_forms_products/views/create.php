<h2>Agregar Producto</h2>
	<form method="POST">
		<input type="hidden" name="form_id" value="<?=$_GET['form_id']?>">

		<label>Producto</label>
		<input 	name="warehouse_id" 
		value="" 
		class="populate"
		data-modal="products"
		data-label=""
		>

		<label>Subpartida</label>
		<input 	name="tariff_heading" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label=""
		>
		<label>Unidad</label>
		<input 	name="unit" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label=""
		>

		<label>Saldo</label>
		<input 	name="virtual" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label=""
		>

		<label>Cantidad</label>
		<input required type="text" name="quantity">

		<input type="submit" value="Enviar">
	</form>
<div id="products" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Producto</th>
			<th>Subpartida</th>
			<th>Unidad</th>
			<th>Saldo</th>
			<th class="stretch"></th>
		</thead>
		<?php
		foreach ($products as $product) {
			?>
			<tr>
				<td><?=$product['warehouse_id']?></td>
				<td><?=$product['name']?></td>
				<td><?=$product['tariff_heading']?></td>
				<td><?=$product['physical_unit']?></td>
				<td><?=$product['approved']?></td>
				<td><a href="javascript:;"
					class="button open populate"
					data-values="<?=$product['warehouse_id']?>,0,0,0"
					data-labels="<?=$product['name']?>,<?=$product['tariff_heading']?>,<?=$product['physical_unit']?>,<?=$product['approved']?>"
					data-elements="warehouse_id,tariff_heading,unit,virtual"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	</div>
