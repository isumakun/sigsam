<h2>Editar Producto</h2>
<h3>Información General</h3>
<form id="form" method="POST">
	
		<label>Producto</label>
		<input 	name="product_id" 
		value="<?=$input_form_product['product_id']?>" 
		class="populate"
		data-modal="products"
		data-label="<?=$input_form_product['product']?>"
		>
	
		<label>Categoría</label>
		<select required name="product_category_id" data-label="category" <?=checkError('product_category_id', $input_forms_verify, $_GET['id'])?>>
			<option></option>
			<?php 
			foreach ($products_categories as $pc) {
				?>
				<option value="<?=$pc['id']?>" <?=($input_form_product['product_category_id'] == $pc['id'] ? 'selected' : '')?>><?=$pc['name']?></option>
				<?php
			} ?>
		</select>
	
	
		<label>Subpartida</label>
		<input 	name="tariff_heading" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label="<?=$input_form_product['tariff_heading']?>"
		>
	
	
		<label>Cantidad Comercial</label>
		<input type="text" required name="commercial_quantity" data-label="commercial_quantity" value="<?=esc_commas($input_form_product['commercial_quantity'])?>" <?=checkError('commercial_quantity', $input_forms_verify, $_GET['id'])?>>
	
	
		<label>Unidad de manejo</label>
		<input 	name="unit" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label="<?=$input_form_product['physical_unit']?>"
		>
	
	
		<label>Cantidad</label>
		<input type="text" name="quantity" data-label="quantity" required value="<?=esc_commas($input_form_product['quantity'])?>" <?=checkError('quantity', $input_forms_verify, $_GET['id'])?>>
		<span id="unit" style="font-size: 16px; line-height: 35px; padding-left: 5px" ></span>

	<h3>Peso</h3>
	
		<label>Peso Neto</label>
		<input type="text" required name="net_weight" data-label="net_weight" value="<?=esc_commas($input_form_product['net_weight'])?>" <?=checkError('net_weight', $input_forms_verify, $_GET['id'])?>>
	
	
		<label>Peso Bruto</label>
		<input type="text" required name="gross_weight" data-label="gross_weight" value="<?=esc_commas($input_form_product['gross_weight'])?>" <?=checkError('gross_weight', $input_forms_verify, $_GET['id'])?>>
	
	
		<label>Embalaje</label>
		<select required name="packaging_id" data-label="packing" <?=checkError('packaging_id', $input_forms_verify, $_GET['id'])?>>
			<option></option>
			<?php 
			foreach ($packaging as $pu) {
				?>
				<option value="<?=$pu['id']?>" <?=($input_form_product['packaging_id'] == $pu['id'] ? 'selected' : '')?>><?=$pu['name']?></option>
				<?php
			} ?>
		</select>
	

		<h3>Valor/Gastos</h3>
	
		<label>Valor Unitario</label>
		<input type="text" name="unit_value" data-label="unit_value" value="<?=esc_commas($input_form_product['unit_value'])?>" <?=checkError('unit_value', $input_forms_verify, $_GET['id'])?>>

		<label>Valor FOB</label>
		<input type="text" name="fob_value" data-label="fob_value" value="<?=esc_commas($input_form_product['fob_value'])?>" <?=checkError('fob_value', $input_forms_verify, $_GET['id'])?>>
	
	
		<label>Fletes</label>
		<input type="text" name="freights" data-label="freights" value="<?=esc_commas($input_form_product['freights'])?>" <?=checkError('freights', $input_forms_verify, $_GET['id'])?>>
	
	
		<label>Seguro</label>
		<input type="text" name="insurance" data-label="insurance" value="<?=esc_commas($input_form_product['insurance'])?>" <?=checkError('insurance', $input_forms_verify, $_GET['id'])?>>
	
	
		<label>Otros gastos</label>
		<input type="text" name="other_expenses" data-label="other_expenses" value="<?=esc_commas($input_form_product['other_expenses'])?>" <?=checkError('other_expenses', $input_forms_verify, $_GET['id'])?>>
	
	
		<label>País Origen</label>
		<select required name="flag_id" data-label="flag" <?=checkError('flag_id', $input_forms_verify, $_GET['id'])?>>
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>" <?=($input_form_product['flag_id'] == $flag['id'] ? 'selected' : '')?>><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	
	<input type="submit" value="Guardar">
</form>
<div id="products" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Producto</th>
			<th>Tipo</th>
			<th>Subpartida</th>
			<th>Unidad</th>
			<th class="stretch">
					<a href="<?=BASE_URL?>/products/create" class="button create dark"><span class="icon create"></span></a>
			</th>
		</thead>
		<?php
		foreach ($products as $product) {
			?>
			<tr>
				<td><?=$product['id']?></td>
				<td><?=$product['name']?></td>
				<td><?=$product['product_type']?></td>
				<td><?=$product['tariff_heading']?></td>
				<td><?=$product['physical_unit']?></td>
				<td><a href="javascript:;"
					class="button open populate"
					data-values="<?=$product['id']?>,0,0"
					data-labels="<?=$product['name']?>,<?=$product['tariff_heading']?>,<?=$product['physical_unit']?>"
					data-elements="product_id,tariff_heading,unit"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	
	<script type="text/javascript">
		<?php if (count($input_forms_verify)!=0) {
			?>
			var changes;

			$('input').on('change', function(){
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