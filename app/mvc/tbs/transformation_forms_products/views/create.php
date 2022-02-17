<h2>Agregar Producto</h2>
<?php $created_product = get_messages(); ?>
<form method="POST">
	<input type="hidden" name="input_form_id" value="<?=$_GET['id']?>">

	<label>Producto</label>
	<input 	name="warehouse_id" 
	value="<?=$created_product[0]?>" 
	class="populate"
	data-modal="products"
	data-label="<?=$created_product[1]?>"
	>

	<label>Subpartida</label>
	<input 	name="tariff_heading" 
	value="" readonly
	class="populate"
	data-modal=""
	data-label="<?=$created_product[2]?>"
	>

	<label>Unidad</label>
	<input 	name="unit" 
	value="" readonly
	class="populate"
	data-modal=""
	data-label="<?=$created_product[3]?>"
	>

	<label>Cantidad</label>
	<input type="text" name="quantity">

	<label>Valor FOB</label>
	<input type="text" name="fob_value">

	<label>Es producto principal?</label>
	<select required name="is_principal">
		<option value="1">Si</option>
		<option value="2">No</option>
	</select>

	<input type="submit" value="Enviar">
</form>
<div id="products" class="modal" style="min-width: 600px !important">
	<table class="datagrid">
		<thead>
			<th>ID Almacen</th>
			<th>Producto</th>
			<th>Subpartida</th>
			<th>Tipo</th>
			<th class="stretch"><a href="<?=BASE_URL?>/products/create_transformed" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($products as $product) {
			?>
			<tr>
				<td><?=$product['wid']?></td>
				<td><?=$product['name']?></td>
				<td><?=$product['tariff_heading']?></td>
				<td><?=$product['product_type']?></td>
				<td><a href="javascript:;"
					class="button open populate"
					data-values="<?=$product['wid']?>,0,0,0"
					data-labels="<?=$product['name']?>,<?=$product['tariff_heading']?>,<?=$product['physical_unit']?>,<?=$product['stock']?>"
					data-elements="warehouse_id,tariff_heading,unit,stock"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	</div>

