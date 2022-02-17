<h2>Editar Formulario de Salida</h2>
<form id="form" method='POST'>
	<h3>Información General</h3>
	
	<label>Cliente</label>
	<input 	name="supplier_id" 
	value="<?=$output_form['supplier_id']?>" 
	class="populate"
	data-modal="suppliers"
	data-label="<?=$output_form['supplier']?>"
	>

	<label>TRM</label>
	<input name="exchange_rate" data-label="exchange_rate" required value="<?=$output_form['exchange_rate']?>" <?=checkError('exchange_rate', $output_forms_verify)?> />

	<label>Transacción</label>
	<select required name="transaction_id" data-label="transaction" <?=checkError('transaction_id', $output_forms_verify)?>>
		<option></option>
		<?php
		foreach ($output_forms_transactions as $ift) {
			?>
			<option value="<?=$ift['id']?>" <?=($output_form['transaction_id'] == $ift['id'] ? 'selected' : '')?>><?=$ift['id']?> - <?=$ift['name']?></option>
			<?php
		} ?>
	</select>

	<label>Tipo Transporte</label>
	<select required name="transport_type_id" data-label="transport" <?=checkError('transport_type_id', $output_forms_verify)?>>
		<option></option>
		<?php
		foreach ($transport_types as $tt) {
			?>
			<option value="<?=$tt['id']?>" <?=($output_form['transport_type_id'] == $tt['id'] ? 'selected' : '')?>><?=$tt['id']?> - <?=$tt['name']?></option>
			<?php
		} ?>
	</select>

	<label>Reembolsable</label>
	<select required name="refundable" data-label="refundable" <?=checkError('refundable', $output_forms_verify)?>>
		<option></option>
		<option value="1" <?=($output_form['refundable'] == 1 ? 'selected' : '')?>>Si</option>
		<option value="0" <?=($output_form['refundable'] == 0 ? 'selected' : '')?>>No</option>
	</select>

	<label>Cantidad Bultos</label>
	<input type="text" name="packages_quantity" data-label="packages_quantity" value="<?=$output_form['packages_quantity']?>" <?=checkError('packages_quantity', $output_forms_verify, $_GET['id'])?>>
	
	<div class="w25">
		<label>País Compra</label>
		<select required name="flag_id_1" class="select2" data-label="flag_1" <?=checkError('flag_id_1', $output_forms_verify)?>>
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>" <?=($output_form['flag_id_1'] == $flag['id'] ? 'selected' : '')?>><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	</div>

	<div class="w25">
		<label>País Destino</label>
		<select required name="flag_id_2" class="select2" data-label="flag_2" <?=checkError('flag_id_2', $output_forms_verify)?>>
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>" <?=($output_form['flag_id_2'] == $flag['id'] ? 'selected' : '')?>><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	</div>

	<div class="w25">
		<label>País de Procedencia</label>
		<select required name="flag_id_3" class="select2" data-label="flag_3" <?=checkError('flag_id_3', $output_forms_verify)?>>
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>" <?=($output_form['flag_id_3'] == $flag['id'] ? 'selected' : '')?>><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	</div>

	<div class="w25">
		<label>Bandera</label>
		<select required name="flag_id_4" class="select2" data-label="flag_4" <?=checkError('flag_id_4', $output_forms_verify)?>>
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>" <?=($output_form['flag_id_4'] == $flag['id'] ? 'selected' : '')?>><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	</div>


	<label>Observaciones</label>
	<textarea name="observations" rows="8" data-label="observations" <?=checkError('observations', $output_forms_verify)?>><?=$output_form['observations']?></textarea>

	<input class="submit" type="submit" value="guardar" />
</form>
<div id="suppliers" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Nit</th>
			<th>Cliente</th>
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
		<?php if (count($output_forms_verify)!=0) {
			?>
			var changes;

			$('output').on('change', function(){
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