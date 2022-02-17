<h2>Editar Producto</h2>
	<form id="form" method="POST">

		<label>Producto</label>
		<select required name="product_id" data-label="product" <?=checkError('product', $transformation_forms_verify, $_GET['id'])?>>
			<option></option>
			<?php
			foreach ($products as $p) {
				?>
				<option value="<?=$p['id']?>" <?=($transformation_form_product['product_id'] == $p['id'] ? 'selected' : '')?>><?=$p['name']?></option>
				<?php
			} ?>
		</select>

		<label>Cantidad</label>
		<input type="text" value="<?=esc_commas($transformation_form_product['quantity'])?>" name="quantity" data-label="quantity" <?=checkError('quantity', $transformation_forms_verify, $_GET['id'])?>>

		<label>Valor FOB</label>
		<input type="text" value="<?=esc_commas($transformation_form_product['fob_value'])?>" name="fob_value" data-label="fob_value" <?=checkError('fob_value', $transformation_forms_verify, $_GET['id'])?>>

		<label>Es producto principal?</label>
		<select required name="is_principal" data-label="is_principal" <?=checkError('is_principal', $transformation_forms_verify, $_GET['id'])?>>
			<option value="1" <?=($transformation_form_product['is_principal'] == 1 ? 'selected' : '')?>>Si</option>
			<option value="2" <?=($transformation_form_product['is_principal'] == 2 ? 'selected' : '')?>>No</option>
		</select>

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