<h2>Editar Insumo</h2>
	<form id="form" method="POST">
		
		<label>Insumo</label>
		<input 	name="warehouse_id" 
		value="<?=$transformation_form_consumable['wid']?>" 
		class="populate"
		data-modal="products"
		data-label="<?=$transformation_form_consumable['consumable']?>"
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
		<input 	name="stock" 
			value="" readonly
			class="populate"
			data-modal=""
			data-label=""
			>

		<label>Cantidad</label>
		<input type="text" value="<?=esc_commas($transformation_form_consumable['quantity'])?>" name="quantity" data-label="quantity" <?=checkError('quantity', $transformation_forms_verify, $_GET['id'])?>>

		<label>Desperdicio</label>
		<input type="text" value="<?=esc_commas($transformation_form_consumable['waste'])?>" name="waste" data-label="waste" <?=checkError('waste', $transformation_forms_verify, $_GET['id'])?>>

		<input type="submit" value="Enviar">
	</form>
<script type="text/javascript">
	<?php if (count($transformation_forms_verify)!=0) {
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
				var value = $(this).attr('data-label');
				console.log(value);
			   $('#form').append('<input type="hidden" name="field_names[]" value="'+value+'">');
			});
		})
		<?php
	} ?>
</script>

<div id="products" class="modal">
		<table class="datagrid">
			<thead>
				<th>ID Almacen</th>
				<th>Producto</th>
				<th>Subpartida</th>
				<th>Formulario</th>
				<th>Saldo</th>
				<th>Unidad</th>
				<th class="stretch"><?php if (!$_SESSION['user']['company_schema']=='tbs3_900324176') {
					?>
					<a href="<?=BASE_URL?>/products/create" class="button create dark"><span class="icon create"></span></a>
					<?php
				} ?>
				</th>
			</thead>
			<?php
			foreach ($products as $product) {
				?>
				<tr>
					<td><?=$product['wid']?></td>
					<td><?=$product['name']?></td>
					<td><?=$product['tariff_heading']?></td>
					<td><?=$product['form_id']?></td>
					<td><?=$product['stock']?></td>
					<td><?=$product['symbol']?></td>
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