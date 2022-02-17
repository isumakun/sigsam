<h2>Agregar Producto</h2>
<form method="POST">
	<input type="hidden" name="output_form_id" value="<?=$_GET['id']?>">

		<label>Producto</label>
		<input 	name="warehouse_id" 
		value="<?=$created_product[0]?>"
		class="populate"
		data-modal="products"
		data-label=""
		>

		<div style="display: none">
		<label>Form_id</label>
		<input name="form_id" 
		value="" readonly="" 
		class="populate"
		data-modal="form_id"
		data-label=""
		>
		</div>

		<label>Categoría</label>
		<select required name="product_category_id">
			<option></option>
			<?php 
			foreach ($products_categories as $pc) {
				?>
				<option value="<?=$pc['id']?>"><?=$pc['name']?></option>
				<?php
			} ?>
		</select>

		<p><span class="icon info"></span> Si va a cambiar la subpartida, la nueva subpartida debe tener la misma unidad que la anterior.</p>

		<label>Subpartida</label>
		<input name="tariff_heading_id"
		value=""
		class="populate"
		data-modal="tariff_heading"
		data-label=""
		>

		<label>Cantidad Comercial</label>
		<input type="text" required name="commercial_quantity">

		<label>Unidad de manejo</label>
		<input 	name="unit" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label=""
		>

		<label>Saldo</label>
		<input 	name="stock" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label=""
		>

		<label>Cantidad</label>
		<input type="text" name="quantity">
		<span id="unit" style="font-size: 16px; line-height: 35px; padding-left: 5px" ></span>

		<input type="hidden" name="unit_value">
	<h3>Peso</h3>

		<label>Peso Neto</label>
		<input type="text" required name="net_weight">

		<label>Peso Bruto</label>
		<input type="text" required name="gross_weight">

		<label>Embalaje</label>
		<select required name="packaging_id" class="select2">
			<option></option>
			<?php 
			foreach ($packaging as $pu) {
				?>
				<option value="<?=$pu['id']?>"><?=$pu['id']?> - <?=$pu['name']?></option>
				<?php
			} ?>
		</select>

	<h3>Valor/Gastos</h3>
		<!-- Poner readonly a estos campos -->
		<label>Valor FOB</label>
		<input type="text"  name="fob_value">

		<label>Fletes</label>
		<input type="text"  name="freights">

		<label>Seguro</label>
		<input type="text" name="insurance">

		<label>Otros gastos</label>
		<input type="text" name="other_expenses">

		<label>País Origen</label>
		<select required name="flag_id" class="select2">
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>"><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	<input type="submit" value="Enviar">
</form>
<div id="products" class="modal" style="min-width: 600px !important">
	<table class="datagrid">
		<thead>
			<th>ID Almacen</th>
			<th>Formulario</th>
			<th>Producto</th>
			<th>Subpartida</th>
			<th>Tipo</th>
			<th>Saldo</th>
			<th>Unidad</th>
			<th class="stretch"></th>
		</thead>
		<?php
		foreach ($products as $product) {
			?>
			<tr>
				<td><?=$product['wid']?></td>
				<td><?=$product['form_id']?></td>
				<td><?=$product['name']?></td>
				<td><?=$product['tariff_heading']?></td>
				<td><?=$product['product_type']?></td>
				<td><?=$product['stock']?></td>
				<td><?=$product['symbol']?></td>
				<td><a href='javascript:set_product(<?=json_encode($product)?>);'
					class="button open populate"
					data-values="<?=$product['wid']?>,<?=$product['tariff_heading_id']?>,0,0"
					data-labels="<?=$product['name']?>,<?= str_replace(',', '-', $product['tariff_heading_long']) ?>,<?=$product['physical_unit']?>,<?=$product['stock']?>"
					data-elements="warehouse_id,tariff_heading_id,unit,stock"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	</div>
<script type="text/javascript">
	function set_product(product) {
		//console.log(product);

		$('select[name=product_category_id]').val(product['product_category_id']);

		$('input[name=quantity]').val(product['stock']);
		$('input[name=unit_value]').val(product['unit_value']);
		$('input[name=commercial_quantity]').val(product['stock']);
		$('input[name=net_weight]').val(product['net_weight']);
		$('input[name=gross_weight]').val(product['gross_weight']);
		$('select[name=packaging_id]').val(product['packaging_id']).trigger('change.select2');;
		//$('select[name=packaging_id]').text(product['packaging']);

		$('input[name=fob_value]').val(product['fob_value']);
		$('input[name=freights]').val(product['freights']);
		$('input[name=insurance]').val(product['insurance']);
		$('input[name=other_expenses]').val(product['other_expenses']);

		$('select[name=flag_id]').val(product['flag_id']).trigger('change.select2');;
		//$('select[name=flag_id]').text(product['flag']);
	}
</script>

<div id="tariff_heading" class="modal">
	<table class="datagrid">
		<thead>
			<th>Código</th>
			<th>Descripción</th>
			<th>Unidad</th>
			<th></th>
		</thead>
		<?php
		foreach ($tariff_headings as $th) {
			?>
			<tr>
				<td><?=$th['code']?></td>
				<td><?=$th['description']?></td>
				<td><?=$th['physical_unit']?></td>
				<td><a href="javascript:;"
					class="button open populate"
					data-values="<?=$th['id']?>"
					data-labels="<?=$th['code']?> - <?=$th['description']?> [<?=$th['physical_unit']?>]"
					data-elements="tariff_heading_id"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	</div>

<?php if ($output_form['transaction_id']==426) {
	?>
	<script type="text/javascript">
		$('input[name=quantity]').on('change', function(){
			var result = $('input[name=quantity]').val()*$('input[name=unit_value]').val();
			$('input[name=fob_value]').val(result);
		})
	</script>
	<?php
} ?>