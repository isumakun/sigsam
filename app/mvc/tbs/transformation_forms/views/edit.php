<h2>Editar Formulario de Transformación</h2>

<form id="form" method='POST'>
	<h3>Información General</h3>
	
	<label>Mano de obra</label>
	<input name="man_power" data-label="man_power" value="<?=$transformation_form['man_power']?>" type="text" required />

	<label>Utilidad</label>
	<input name="utility" data-label="utility" value="<?=$transformation_form['utility']?>" type="text" required />

	<label>Costo directo</label>
	<input name="direct_cost" data-label="direct_cost" value="<?=$transformation_form['direct_cost']?>" type="text" required />

	<label>Observaciones</label>
	<textarea name="observations" data-label="observations">
		<?=$transformation_form['observations']?>
	</textarea>

	<input class="submit" type="submit"/>
</form>
<div id="suppliers" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Nit</th>
			<th>Proveedor</th>
			<th class="stretch"><a href="<?=BASE_URL?>/suppliers/create" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($suppliers as $supplier) {
			?>
			<tr>
				<td><?=$supplier['id']?></td>
				<td><?=$supplier['nit']?></td>
				<td><?=$supplier['name']?></td>
				<td class="nowrap">
					<?= make_link('tbs/suppliers/edit?id='.$supplier['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?= make_link('tbs/suppliers/delete?id='.$supplier['id'], '<span class="icon delete"></span>', 'button delete confirm_action confirm_action') ?>
					<a href="javascript:;"
					class="button open populate"
					data-values="<?=$supplier['id']?>"
					data-labels="<?=$supplier['name']?>"
					data-elements="supplier_id"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	</div>
	<script type="text/javascript">
		<?php if (count($input_forms_verify)!=0) {
			?>
			var changes;

			$('input').on('change', function(){
				checkChange($(this));
			})
			
			$('.select2').on('change', function(){
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