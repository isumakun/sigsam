<style type="text/css">
td{
	cursor: pointer;
}
</style>
<h2>Detalles Formulario de Transformación</h2>

<a href="#" id="send" class="pull-right button">Enviar</a>

<h3>Insumos</h3>
<table>
	<thead>
		<th>Insumo</th>
		<th>Cantidad</th>
		<th>Desperdicio</th>
	</thead>
	<tbody>
		<?php 
		$count;
		foreach ($transformation_forms_consumables as $tfc) {
			?>
			<tr>
				<td <?=checkError('warehouse_id', $transformation_forms_verify, $tfc['tfc_id'])?>
					data-type="3"
					data-field="warehouse_id" 
					data-id="<?=$tfc['tfc_id']?>"
					data-value="<?=$tfc['warehouse_id']?>">
					<?=$tfc['consumable']?>
				</td>
				<td <?=checkError('quantity', $transformation_forms_verify, $tfc['tfc_id'])?>
					data-type="3"
					data-field="quantity"
					data-id="<?=$tfc['tfc_id']?>"
					data-value="<?=$tfc['quantity']?> <?=$tfc['physical_unit']?>">
					<?=$tfc['quantity']?> <?=$tfc['physical_unit']?>
				</td>
				<td <?=checkError('waste', $transformation_forms_verify, $tfc['tfc_id'])?>
					data-type="3" 
					data-field="waste" 
					data-id="<?=$tfc['tfc_id']?>"
					data-value="<?=$tfc['waste']?>">
					<?=$tfc['product_waste']?>
				</td>
			</tr>
			<?php
			$count++;
		} ?>
	</tbody>
</table>
<h3>Productos</h3>
<table>
	<thead>
		<th>Producto</th>
		<th>Tipo</th>
		<th>Cantidad</th>
		<th>Valor FOB</th>
		<th>Clase</th>
	</thead>
	<tbody>
		<?php 
		$count;
		foreach ($transformation_forms_products as $tfp) {
			?>
			<tr>
				<td <?=checkError('product_id', $transformation_forms_verify, $tfp['tfp_id'])?> 
					data-type="2"
					data-field="product_id" 
					data-id="<?=$tfp['tfp_id']?>"
					data-value="<?=$tfp['product_id']?>">
					<?=$tfp['product']?>
				</td>
				<td <?=checkError('product_type_id', $transformation_forms_verify, $tfp['tfc_id'])?>
					data-type="2"
					data-field="product_type_id"
					data-id="<?=$tfp['tfp_id']?>"
					data-value="<?=$tfp['product_type_id']?>">
					<?=$tfp['product_type']?>
				</td>
				<td <?=checkError('quantity', $transformation_forms_verify, $tfp['tfc_id'])?>
					data-type="2"
					data-field="quantity"
					data-id="<?=$tfp['tfp_id']?>"
					data-value="<?=$tfp['quantity']?> <?=$tfp['physical_unit']?>">
					<?=$tfp['quantity']?> <?=$tfp['physical_unit']?>
				</td>
				<td <?=checkError('fob_value', $transformation_forms_verify, $tfp['tfc_id'])?>
					data-type="2"
					data-field="fob_value"
					data-id="<?=$tfp['tfp_id']?>"
					data-value="<?=$tfp['fob_value']?>">
					<?=$tfp['fob_value']?>
				</td>
				<td <?=checkError('is_principal', $transformation_forms_verify, $tfp['tfc_id'])?> 
					data-type="2"
					data-field="is_principal" 
					data-id="<?=$tfp['tfp_id']?>"
					data-value="<?=$tfp['is_principal']?>">
					<?=$tfp['is_principal']?>
				</td>
			</tr>
			<?php
			$count++;
		} ?>
	</tbody>
</table>

<h3>Componentes</h3>
<table>
	<thead>
		<th>Mano de obra</th>
		<th>Utilidad</th>
		<th>Costo indirecto</th>
		<th class="stretch"></th>
	</thead>
	<tbody>
		<tr>
			<td <?=checkError('man_power', $transformation_forms_verify)?> 
				data-type="1" 
				data-field="man_power" 
				data-id="0" 
				data-value="<?=$transformation_form['man_power']?>">
				<?=$transformation_form['man_power']?></td>
			<td <?=checkError('utility', $transformation_forms_verify)?> 
				data-type="1" 
				data-field="utility" 
				data-id="0" 
				data-value="<?=$transformation_form['utility']?>">
				<?=$transformation_form['utility']?></td>
			<td <?=checkError('direct_cost', $transformation_forms_verify)?> 
				data-type="1" 
				data-field="direct_cost" 
				data-id="0" 
				data-value="<?=$transformation_form['direct_cost']?>">
				<?=$transformation_form['direct_cost']?></td>
			<td class="">
				<?php 
				if ($show) {
					?>
					<?= make_link('tbs/transformation_forms/edit?id='.$_GET['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?php
				}
				 ?>
			</td>
		</tr>
	</tbody>
</table>

<h3>Soportes</h3>
<table>
	<thead>
		<th>Tipo</th>
		<th>Soporte</th>
		<th>Fecha</th>
		<th>Detalle</th>
	</thead>
	<tbody>
		<?php foreach ($transformation_forms_supports as $support) {
			?>
			<tr>
				<td <?=checkError('transformation_form_support_type_id', $transformation_forms_verify, $support['supp_id'])?>>
					<?=$support['support_type']?>
				</td>
				<td><a href="<?=BASE_URL."public/uploads/supports/transformation/{$_SESSION['user']['company_schema']}{$_GET['id']}/{$support['supp_id']}.{$support['file_extension']}"?>" target="_blank" class="button"> Ver adjunto</a></td>
				<td <?=checkError('created_at', $transformation_forms_verify, $support['supp_id'])?>><?=$support['created_at']?></td>
				<td <?=checkError('details', $transformation_forms_verify, $support['supp_id'])?>><?=$support['details']?></td>
			</tr>
			<?php
		} ?>
	</tbody>
</table>

<form id="form" method="POST">
	<label>Rechazo por otras razones: </label>
	<textarea id="comment" name="comment" rows="20"></textarea>
	<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
</form>

<script type="text/javascript">
	var tds = $('#main_content table td');

	$('#main_content').on('click', 'td', function()
	{
		var field = $(this).attr('data-field');
		var type = $(this).attr('data-type');
		var id = $(this).attr('data-id');
		var value = $(this).attr('data-value');

		//alert (type+'-'+id+'-'+field);

		if ($(this).hasClass('red')) {
			$(this).removeClass('red');
			$('#'+type+'-'+id+'-'+field).remove();
		}else if ($(this).hasClass('yellow')) {
			$(this).removeClass('yellow');
			$('#'+type+'-'+id+'-'+field).remove();
		}else{
			$(this).addClass('red');
			$('#form').append('<input type="text" id="'+type+'-'+id+'-'+field+'" name="bad_fields[]" value="'+type+'#/'+id+'#/'+field+'#/'+value+'">');
		}		
	});

	$('#send').on('click', function(){
		$('#form').submit();
	})
</script>