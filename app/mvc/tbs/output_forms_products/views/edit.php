<?php 
//$editable = 'readonly';
$editable = '';
if (has_role(2)) {
	$editable = '';
}
 ?>
<h2>Editar Producto</h2>
<form id="form" method="POST">
		<label>Producto</label>
		<input 	name="warehouse_id" 
		value="<?=$output_form_product['warehouse_id']?>" 
		class="populate"
		data-modal="products"
		data-label="<?=$output_form_product['product']?>"
		>

		<label>Categoría</label>
		<select required name="product_category_id" data-label="category" <?=checkError('category', $output_forms_verify, $_GET['id'])?>>
			<option></option>
			<?php 
			foreach ($products_categories as $pc) {
				?>
				<option value="<?=$pc['id']?>" <?=($output_form_product['product_category_id'] == $pc['id'] ? 'selected' : '')?>><?=$pc['name']?></option>
				<?php
			} ?>
		</select>


		<label>Subpartida</label>
		<input 	name="tariff_heading_id" 
		value="<?=$output_form_product['tariff_heading_id']?>" 
		class="populate"
		data-modal="tariff_heading"
		data-label="<?=$output_form_product['tariff_heading']?>"
		>
	
	
		<label>Cantidad Comercial</label>
		<input type="text" required name="commercial_quantity" data-label="commercial_quantity" value="<?=esc_commas($output_form_product['commercial_quantity'])?>" <?=checkError('commercial_quantity', $output_forms_verify, $_GET['id'])?>>
	
	
		<label>Unidad de manejo</label>
		<input 	name="unit" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label="<?=$output_form_product['physical_unit']?>"
		>
	
	
		<label>Saldo</label>
		<input 	name="stock" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label="<?=$output_form_product['stock']?>"
		>

		<label>Cantidad</label>
		<input type="text" name="quantity" data-label="quantity" value="<?=esc_commas($output_form_product['quantity'])?>" <?=checkError('quantity', $output_forms_verify, $_GET['id'])?>>
		<span id="unit" style="font-size: 16px; line-height: 35px; padding-left: 5px" ></span>
	
	<h3>Peso</h3>
	
		<label>Peso Neto</label>
		<input type="text" required name="net_weight" data-label="net_weight" value="<?=esc_commas($output_form_product['net_weight'])?>" <?=checkError('net_weight', $output_forms_verify, $_GET['id'])?>>

		<label>Peso Bruto</label>
		<input type="text" required name="gross_weight" data-label="gross_weight" value="<?=esc_commas($output_form_product['gross_weight'])?>" <?=checkError('gross_weight', $output_forms_verify, $_GET['id'])?>>

		<label>Embalaje</label>
		<select required name="packaging_id" class="select2" data-label="packing" <?=checkError('packing', $output_forms_verify, $_GET['id'])?>>
			<option></option>
			<?php 
			foreach ($packaging as $pu) {
				?>
				<option value="<?=$pu['id']?>" <?=($output_form_product['packaging_id'] == $pu['id'] ? 'selected' : '')?>><?=$pu['id']?> - <?=$pu['name']?></option>
				<?php
			} ?>
		</select>
	
	<h3>Valor/Gastos</h3>
	
		<label>Valor FOB</label>
		<input type="text" name="fob_value" <?=$editable?> data-label="fob_value" value="<?=esc_commas($output_form_product['fob_value'])?>" <?=checkError('fob_value', $output_forms_verify, $_GET['id'])?>>

		<label>Fletes</label>
		<input type="text" name="freights" <?=$editable?> data-label="freights" value="<?=esc_commas($output_form_product['freights'])?>" <?=checkError('freights', $output_forms_verify, $_GET['id'])?>>

		<label>Seguro</label>
		<input type="text" name="insurance" <?=$editable?> data-label="insurance" value="<?=esc_commas($output_form_product['insurance'])?>" <?=checkError('insurance', $output_forms_verify, $_GET['id'])?>>
	
	
		<label>Otros gastos</label>
		<input type="text" name="other_expenses" <?=$editable?> data-label="other_expenses" value="<?=esc_commas($output_form_product['other_expenses'])?>" <?=checkError('other_expenses', $output_forms_verify, $_GET['id'])?>>

		<label>País Origen</label>
		<select required name="flag_id" class="select2" data-label="flag" <?=checkError('flag', $output_forms_verify, $_GET['id'])?>>
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>" <?=($output_form_product['flag_id'] == $flag['id'] ? 'selected' : '')?>><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	
	<input type="submit" value="Guardar">
</form>

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
	
<div id="products" class="modal">
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
				<td><a href="javascript:set_product(<?=json_encode($product)?>);"
					class="button open populate"
					data-values="<?=$product['wid']?>,<?=$product['tariff_heading_id']?>,0"
					data-labels="<?=$product['name']?>,<?=$product['tariff_heading']?>,<?=$product['physical_unit']?>"
					data-elements="warehouse_id,tariff_heading_id,unit"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	

	<script type="text/javascript">
		<?php if (count($output_forms_verify)!=0) {
			?>
			var changes;

			$('input').on('change', function(){
				checkChange($(this));
			})

			$('textarea').on('change', function(){
				checkChange($(this));
			})
			
			$('select').on('change', function(){
				checkChange($(this));
			})

			function checkChange(element){
				if (element.hasClass('red')) {
					element.removeClass('red');
					element.addClass('yellow');
				}else{
					element.addClass('yellow');
				}
			}

			$('#form').on('submit', function(e){
				$(".yellow").each(function() {
					var label = $(this).attr('data-label');
					var value = $(this).val();
					console.log(value);
					$('#form').append('<input type="hidden" name="field_names[]" value="'+label+'">');
					$('#form').append('<input type="hidden" name="field_values[]" value="'+value+'">');
				});
			})
			<?php
		} ?>
	</script>
	<script type="text/javascript">
		$('#product').on('change', function(){
			var attr = $( "#product option:selected" ).attr('data-unit');
			$('#unit').text(attr);
		})
	</script>

<script type="text/javascript">
	function set_product(product) {
		console.log(product);

		$('select[name=product_category_id]').val(product['product_category_id']);

		$('input[name=quantity]').val(product['quantity']);
		$('input[name=commercial_quantity]').val(product['commercial_quantity']);
		$('input[name=net_weight]').val(product['net_weight']);
		$('input[name=gross_weight]').val(product['gross_weight']);
		$('input[name=packages_quantity]').val(product['packages_quantity']);

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