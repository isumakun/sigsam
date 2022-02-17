<style type="text/css">
td{
	cursor: pointer;
}
</style>
<h2>Detalles Formulario de Salida</h2>

<div class="pull-right">
		<label>Sólo cambiar tipo</label>
		<label class="switch">
		  <input id="only_check" type="checkbox">
		  <span class="slider round"></span>
		</label>
	<a href="#" id="send" class="pull-right button">Enviar</a>
</div>
<h3>Información General</h3>
<table>
	<thead>
		<th>Proveedor</th>
		<th>TRM</th>
		<th>Transacción</th>
		<th>Tipo Transporte</th>
		<th>Reembolsable</th>
		<th>Cant. Bultos</th>
		<th>País Compra</th>
		<th>País Destino</th>
		<th>País Procedencia</th>
		<th>Bandera</th>
		<th>Observaciones</th>
	</thead>
	<tbody>
		<tr>
			<td <?=checkError('supplier_id', $output_forms_verify)?> 
				data-type="1" 
				data-field="supplier_id" 
				data-id="0"
				data-value="<?=$output_form['supplier_id']?>" >
				<?=$output_form['supplier']?>
			</td>
			<td <?=checkError('exchange_rate', $output_forms_verify)?> 
				data-type="1" 
				data-field="exchange_rate" 
				data-id="0"
				data-value="<?=$output_form['exchange_rate']?>">
				<?=$output_form['exchange_rate']?>
			</td>
			<td <?=checkError('transaction_id', $output_forms_verify)?> 
				data-type="1" 
				data-field="transaction_id" 
				data-id="0"
				data-value="<?=$output_form['transaction']?>">
				<?=$output_form['transaction']?>
			</td>
			<td <?=checkError('transport_type_id', $output_forms_verify)?> 
				data-type="1" 
				data-field="transport_type_id" 
				data-id="0"
				data-value="<?=$output_form['transport_type_id']?>">
				<?=$output_form['transport']?>
			</td>
			<td <?=checkError('refundable', $output_forms_verify)?> 
				data-type="1" 
				data-field="refundable" 
				data-id="0"
				data-value="<?=$output_form['refundable']?>">
				<?=$output_form['refundable']?>
			</td>
			<td <?=checkError('packages_quantity', $output_forms_verify)?> 
				data-type="1" 
				data-field="packages_quantity" 
				data-id="0"
				data-value="<?=$output_form['packages_quantity']?>">
				<?=$output_form['packages_quantity']?>
			</td>
			<td <?=checkError('flag_id_1', $output_forms_verify)?> 
				data-type="1" 
				data-field="flag_id_1" 
				data-id="0"
				data-value="<?=$output_form['flag_id_1']?>">
				<?=$output_form['flag_id_1']?> - <?=$output_form['flag_1']?>
			</td>
			<td <?=checkError('flag_id_2', $output_forms_verify)?> 
				data-type="1" 
				data-field="flag_id_2" 
				data-id="0"
				data-value="<?=$output_form['flag_id_2']?>">
				<?=$output_form['flag_id_2']?> -<?=$output_form['flag_2']?>
			</td>
			<td <?=checkError('flag_id_3', $output_forms_verify)?> 
				data-type="1" 
				data-field="flag_id_3" 
				data-id="0"
				data-value="<?=$output_form['flag_id_3']?>">
				<?=$output_form['flag_id_3']?> -<?=$output_form['flag_3']?>
			</td>
			<td <?=checkError('flag_id_4', $output_forms_verify)?> 
				data-type="1" 
				data-field="flag_id_4" 
				data-id="0"
				data-value="<?=$output_form['flag_id_4']?>">
				<?=$output_form['flag_id_4']?> -<?=$output_form['flag_4']?>
			</td>
			<td>
				<?=$output_form['observations']?> 
			</td>
		</tr>
	</tbody>
</table>

<?php if ($output_form['form_state_id']==10) {
	?>
	<h3>Soportes de levante</h3>
	<?php
	$table = new Datagrid();

	$table->set_options('tbs/nationalized_forms_supports', 'get_by_form', $_GET['id'], 'false');

	$table->add_column('Numero', 'number');
	$table->add_column('Fecha', 'supp_date');

	$table->render();
}
?>
<h3>Productos</h3>
<table>
	<thead>
		<th>Producto</th>
		<th>Categoría</th>
		<th>Subpartida</th>
		<th>Cantidad</th>
		<th>Cantidad Comercial</th>
		<th>Peso Neto</th>
		<th>Peso Bruto</th>
		<th>Embalaje</th>
		<th>Valor FOB</th>
		<th>Fletes</th>
		<th>Seguros</th>
		<th>Otros Gastos</th>
		<th>Bandera O.</th>
	</thead>
	<tbody>
		<?php 
		$count;
		foreach ($output_forms_products as $ofp) {
			?>
			<tr>
				<td <?=checkError('product_id', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2" 
					data-field="product_id" 
					data-id="<?=$ofp['ofp_id']?>"
					data-value="<?=$ofp['product_id']?>">
					<?=$ofp['product']?>
				</td>
				<td <?=checkError('product_category_id', $output_forms_verify, $ofp['ofp_id'])?> 
					data-type="2"
					data-field="product_category_id" 
					data-id="<?=$ofp['ofp_id']?>"
					data-value="<?=$ofp['product_category_id']?>">
					<?=$ofp['category']?>
				</td>
				<td <?=checkError('tariff_heading_id', $output_forms_verify, $ofp['ofp_id'])?> 
					data-type="2"
					data-field="tariff_heading_id" 
					data-id="<?=$ofp['ofp_id']?>"
					data-value="<?=$ofp['tariff_heading_id']?>">
					<?=$ofp['tariff_heading_code']?>
				</td>
				<td <?=checkError('quantity', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2" 
					data-field="quantity" 
					data-id="<?=$ofp['ofp_id']?>"
					data-value="<?=$ofp['quantity']?> <?=$ofp['physical_unit']?>">
					<?=$ofp['quantity']?> <?=$ofp['physical_unit']?>
				</td>
				<td <?=checkError('commercial_quantity', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2"
					data-field="commercial_quantity"
					data-id="<?=$ofp['ofp_id']?>"
					data-value="<?=$ofp['commercial_quantity']?>">
					<?=$ofp['commercial_quantity']?>
				</td>
				<td  <?=checkError('net_weight', $output_forms_verify, $ofp['ifp_id'])?>
					data-type="2"
					data-field="net_weight" 
					data-value="<?=$ofp['net_weight']?>"
					data-id="<?=$ofp['ofp_id']?>">
					<?=number_format($ofp['net_weight'], 2)?>
				</td>
				<td  <?=checkError('gross_weight', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2" 
					data-field="gross_weight" 
					data-value="<?=$ofp['gross_weight']?>"
					data-id="<?=$ofp['ofp_id']?>">
					<?=number_format($ofp['gross_weight'],2)?>
				</td>
				<td <?=checkError('packaging_id', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2"
					data-field="packaging_id"
					data-value="<?=$ofp['packaging_id']?>"
					data-id="<?=$ofp['ofp_id']?>">
					<?=$ofp['packing']?>
				</td>
				<td <?=checkError('fob_value', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2" 
					data-field="fob_value"
					data-value="<?=$ofp['fob_value']?>"
					data-id="<?=$ofp['ofp_id']?>">
					<?=number_format($ofp['fob_value'], 2)?>
				</td>
				<td <?=checkError('freights', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2"
					data-field="freights"
					data-value="<?=$ofp['freights']?>"
					data-id="<?=$ofp['ofp_id']?>">
					<?=number_format($ofp['freights'], 2)?>
				</td>
				<td <?=checkError('insurance', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2"
					data-field="insurance"
					data-value="<?=$ofp['insurance']?>"
					data-id="<?=$ofp['ofp_id']?>">
					<?=number_format($ofp['insurance'], 2)?>
				</td>
				<td <?=checkError('other_expenses', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2" 
					data-field="other_expenses" 
					data-value="<?=$ofp['other_expenses']?>"
					data-id="<?=$ofp['ofp_id']?>">
					<?=number_format($ofp['other_expenses'], 2)?>
				</td>
				<td <?=checkError('flag_id', $output_forms_verify, $ofp['ofp_id'])?>
					data-type="2"
					data-field="flag_id"
					data-value="<?=$ofp['flag_id']?>"
					data-id="<?=$ofp['ofp_id']?>">
					<?=$ofp['flag_id']?> - <?=$ofp['flag']?>
				</td>
			</tr>
			<?php
			$count++;
		} ?>
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
		<?php foreach ($output_forms_supports as $support) {
			?>
			<tr>
				<td <?=checkError('output_form_support_type_id', $output_forms_verify, $support['id'])?> 
					data-type="3"
					data-field="output_form_support_type_id"
					data-value="<?=$ifp['output_form_support_type_id']?>"
					data-id="<?=$support['id']?>">
					<?=$support['support_type']?>
				</td>
				<td>
					<a href="<?=BASE_URL."public/uploads/supports/output/{$_SESSION['user']['company_schema']}{$_GET['id']}/{$support['supp_id']}.{$support['file_extension']}"?>" class="button" target="_blank"> Ver adjunto</a>
				</td>
				<td <?=checkError('created_at', $output_forms_verify, $support['id'])?> 
					data-type="3" 
					data-field="created_at" 
					data-value="<?=$ifp['created_at']?>"
					data-id="<?=$support['id']?>">
					<?=$support['created_at']?>
				</td>
				<td <?=checkError('details', $output_forms_verify, $support['id'])?> 
					data-type="3" 
					data-field="details" 
					data-value="<?=$ifp['details']?>"
					data-id="<?=$support['id']?>">
					<?=$support['details']?>
				</td>
			</tr>
			<?php
		} ?>
	</tbody>
</table>
<form id="form" method="POST">
	<label>Rechazo por otras razones: </label>
	<textarea id="comment" name="comment" rows="20"></textarea>
	<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
	<input type="hidden" name="only_change_type" id="only_change_type">
</form>

<script type="text/javascript">
	var tds = $('#main_content table td');
	var only_change_type = 0;

	$('#only_check').on('change', function(){

		if (only_change_type==0) {
			only_change_type = 1;
		}else{
			only_change_type = 0;
		}
	})

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
			$('#form').append('<input type="hidden" id="'+type+'-'+id+'-'+field+'" name="bad_fields[]" value="'+type+'#/'+id+'#/'+field+'#/'+value+'">');
		}		
	});

	$('#send').on('click', function(){
		//console.log(only_change_type);
		$('#only_change_type').val(only_change_type);
		$('#form').submit();
	})

	$('#comment').on('keyup', function(){
		$('#send').addClass('red');
		$('#send').text('Rechazar');
	})
</script>