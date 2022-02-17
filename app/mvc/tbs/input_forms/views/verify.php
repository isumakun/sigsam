<style type="text/css">
	td{
		cursor: pointer;
	}
</style>
<h2>Detalles Formulario de Ingreso</h2>

<a href="#" id="send" class="pull-right button">Enviar</a>

<h3>Información General</h3>
<table>
	<thead>
		<th>Proveedor</th>
		<th>TRM</th>
		<th>Transacción</th>
		<th>Tipo Transporte</th>
		<th>Reembolsable</th>
		<th>Cantidad de bultos</th>
		<th># Acuerdo</th>
		<th>País Compra</th>
		<th>País Destino</th>
		<th>País Procedencia</th>
		<th>Bandera</th>
	</thead>
	<tbody>
		<tr>
			<td <?=checkError('supplier_id', $input_forms_verify)?> 
				data-type="1" 
				data-field="supplier_id" 
				data-id="0" 
				data-value="<?=$input_form['supplier_id']?>"
				>
				<?=$input_form['supplier']?>
			</td>
			<td <?=checkError('exchange_rate', $input_forms_verify)?> 
				data-type="1" 
				data-field="exchange_rate" 
				data-id="0" 
				data-value="<?=$input_form['exchange_rate']?>">
				<?=$input_form['exchange_rate']?>
				</td>
			<td <?=checkError('transaction_id', $input_forms_verify)?> 
				data-type="1" 
				data-field="transaction_id" 
				data-id="0"
				data-value="<?=$input_form['transaction_id']?>">
				<?=$input_form['transaction_id']?> - <?=$input_form['transaction']?>
			</td>
			<td <?=checkError('transport_type_id', $input_forms_verify)?> 
				data-type="1" 
				data-field="transport_type_id" 
				data-id="0"
				data-value="<?=$input_form['transport_type_id']?>">
				<?=$input_form['transport']?>
			</td>
			<td <?=checkError('refundable', $input_forms_verify)?> 
				data-type="1" 
				data-field="refundable" 
				data-id="0"
				data-value="<?=$input_form['refundable']?>">
				<?=$input_form['refundable']?>
			</td>
			<td <?=checkError('packages_quantity', $input_forms_verify)?> 
				data-type="1" 
				data-field="packages_quantity" 
				data-id="0"
				data-value="<?=$input_form['packages_quantity']?>">
				<?=$input_form['packages_quantity']?>
			</td>
			<td <?=checkError('agreement_id', $input_forms_verify)?> 
				data-type="1" 
				data-field="agreement_id" 
				data-id="0"
				data-value="<?=$input_form['agreement_id']?>">
				<?=$input_form['agreement']?>
			</td>
			<td <?=checkError('flag_id_1', $input_forms_verify)?> 
				data-type="1" 
				data-field="flag_id_1" 
				data-id="0"
				data-value="<?=$input_form['flag_id_1']?>">
				<?=$input_form['flag_id_1']?> - <?=$input_form['flag_1']?>
			</td>
			<td <?=checkError('flag_id_2', $input_forms_verify)?> 
				data-type="1" 
				data-field="flag_id_2" 
				data-id="0"
				data-value="<?=$input_form['flag_id_2']?>">
				<?=$input_form['flag_id_2']?> - <?=$input_form['flag_2']?>
			</td>
			<td <?=checkError('flag_id_3', $input_forms_verify)?> 
				data-type="1" 
				data-field="flag_id_3" 
				data-id="0"
				data-value="<?=$input_form['flag_id_3']?>">
				<?=$input_form['flag_id_3']?> - <?=$input_form['flag_3']?>
			</td>
			<td <?=checkError('flag_id_4', $input_forms_verify)?> 
				data-type="1"
			 	data-field="flag_id_4" 
			 	data-id="0"
			 	data-value="<?=$input_form['flag_id_4']?>">
			 	<?=$input_form['flag_id_4']?> - <?=$input_form['flag_4']?>
			</td>
		</tr>
	</tbody>
</table>

<h3>Productos</h3>
<table>
	<thead>
		<th>Producto</th>
		<th>Subpartida</th>
		<th>Unidad</th>
		<th>Tipo</th>
		<th>Categoria</th>
		<th>Cantidad</th>
		<th>Cantidad Comercial</th>
		<th>Peso Neto</th>
		<th>Peso Bruto</th>
		<th>Embalaje</th>
		<th>Valor Unitario</th>
		<th>Valor FOB</th>
		<th>Fletes</th>
		<th>Seguros</th>
		<th>Otros Gastos</th>
		<th>Bandera O.</th>
	</thead>
	<tbody>
		<?php 
		$count;
		foreach ($input_forms_products as $ifp) {
			?>
			<tr>
				<td <?=checkError('product_id', $input_forms_verify, $ifp['ifp_id'])?> 
					data-type="2"
					data-field="product_id" 
					data-value="<?=$ifp['product_id']?>"
					data-id="<?=$ifp['ifp_id']?>">
					<?=$ifp['product']?>
				</td>
				<td>
					<?=$ifp['tariff_heading_code']?>
				</td>
				<td>
					<?=$ifp['unit_symbol']?>
				</td>
				<td>
					<?=$ifp['product_type']?>
				</td>
				<td <?=checkError('product_category_id', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2"
					data-field="product_category_id" 
					data-value="<?=$ifp['product_category_id']?>"
					data-id="<?=$ifp['ifp_id']?>">
					<?=$ifp['category']?>
				</td>
				<td <?=checkError('quantity', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2" 
					data-field="quantity" 
					data-value="<?=$ifp['quantity']?>"
					data-id="<?=$ifp['ifp_id']?>">
					<?=number_format($ifp['quantity'])?>
					</td>
				<td <?=checkError('commercial_quantity', $input_forms_verify, $ifp['ifp_id'])?> 
					data-type="2"
					data-field="commercial_quantity"
					data-value="<?=$ifp['commercial_quantity']?>"
					data-id="<?=$ifp['ifp_id']?>">
					<?=number_format($ifp['commercial_quantity'], 4)?>
				</td>
				<td  <?=checkError('net_weight', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2"
					data-field="net_weight" 
					data-value="<?=$ifp['net_weight']?>"
					data-id="<?=$ifp['ifp_id']?>">
					<?=number_format($ifp['net_weight'], 4)?>
					</td>
				<td  <?=checkError('gross_weight', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2" 
					data-field="gross_weight" 
					data-value="<?=$ifp['gross_weight']?>"
					data-id="<?=$ifp['ifp_id']?>">
					<?=number_format($ifp['gross_weight'], 4)?>
				</td>
				<td <?=checkError('packaging_id', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2"
					data-field="packaging_id"
					data-value="<?=$ifp['packaging_id']?>"
					data-id="<?=$ifp['ifp_id']?>">
					<?=$ifp['packing']?>
				</td>
				<td <?=checkError('unit_value', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2" 
					data-field="unit_value"
					data-value="<?=$ifp['unit_value']?>"
					data-id="<?=$ifp['ifp_id']?>">
					$<?=number_format($ifp['unit_value'], 4)?>
					</td>
				<td <?=checkError('fob_value', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2" 
					data-field="fob_value"
					data-value="<?=$ifp['fob_value']?>"
					data-id="<?=$ifp['ifp_id']?>">
					$<?=number_format($ifp['fob_value'], 4)?>
					</td>
				<td <?=checkError('freights', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2"
					data-field="freights"
					data-value="<?=$ifp['freights']?>"
					data-id="<?=$ifp['ifp_id']?>">
					$<?=number_format($ifp['freights'], 4)?>
				</td>
				<td <?=checkError('insurance', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2"
					data-field="insurance"
					data-value="<?=$ifp['insurance']?>"
					data-id="<?=$ifp['ifp_id']?>">
					$<?=number_format($ifp['insurance'], 4)?>
				</td>
				<td <?=checkError('other_expenses', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2" 
					data-field="other_expenses" 
					data-value="<?=$ifp['other_expenses']?>"
					data-id="<?=$ifp['ifp_id']?>">
					$<?=number_format($ifp['other_expenses'], 4)?>
				</td>
				<td <?=checkError('flag_id', $input_forms_verify, $ifp['ifp_id'])?>
					data-type="2"
					data-field="flag_id"
					data-value="<?=$ifp['flag_id']?>"
					data-id="<?=$ifp['ifp_id']?>">
					<?=$ifp['flag_id']?> - <?=$ifp['flag']?>
				</td>
			</tr>
			<?php
			$count++;
		} ?>
	</tbody>
</table>

<?php 

foreach ($input_forms_products as $ifp) {
		$sum_gross_weight += $ifp['gross_weight'];
		$sum_net_weight += $ifp['net_weight'];
		$sum_fob += $ifp['fob_value'];
		$sum_freights += $ifp['freights'];
		$sum_insurance += $ifp['insurance'];
		$sum_other_expenses += $ifp['other_expenses'];
}

$cif_usd = $sum_fob+$sum_freights+$sum_insurance+$sum_other_expenses;
$cif_cop = $cif_usd * $input_form['exchange_rate'];

 ?>
<h3>Totales</h3>
<table>
	<thead>
		<th>Total valor FOB</th>
		<th>Total fletes</th>
		<th>Total seguros</th>
		<th>Total otros gastos</th>
		<th>Total peso neto</th>
		<th>Total peso bruto</th>
		<th>CIF USD</th>
		<th>CIF COP</th>
	</thead>
	<tr>
		<td>$<?=number_format($sum_fob, 4)?></td>
		<td>$<?=number_format($sum_freights, 4)?></td>
		<td>$<?=number_format($sum_insurance, 4)?></td>
		<td>$<?=number_format($sum_other_expenses, 4)?></td>
		<td><?=number_format($sum_net_weight, 1)?></td>
		<td><?=number_format($sum_gross_weight,1)?></td>
		<td>$<?=number_format($cif_usd,2)?></td>
		<td>$<?=number_format($cif_cop,2)?></td>
	</tr>
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
		<?php foreach ($input_forms_supports as $support) {
			?>
			<tr>
				<td <?=checkError('input_form_support_type_id', $input_forms_verify, $support['id'])?> 
					data-type="3"
					data-field="input_form_support_type_id"
					data-value="<?=$ifp['input_form_support_type_id']?>"
					data-id="<?=$support['id']?>">
					<?=$support['support_type']?>
				</td>
				<td>
					<a href="<?=BASE_URL."public/uploads/supports/input/{$_SESSION['user']['company_schema']}{$_GET['id']}/{$support['supp_id']}.{$support['file_extension']}"?>" class="button"> Ver adjunto</a>
				</td>
				<td <?=checkError('created_at', $input_forms_verify, $support['id'])?> 
					data-type="3" 
					data-field="created_at" 
					data-value="<?=$ifp['created_at']?>"
					data-id="<?=$support['id']?>">
					<?=$support['created_at']?>
				</td>
				<td <?=checkError('details', $input_forms_verify, $support['id'])?> 
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
			$('#form').append('<input type="hidden" id="'+type+'-'+id+'-'+field+'" name="bad_fields[]" value="'+type+'#/'+id+'#/'+field+'#/'+value+'">');
		}		
	});

	$('#send').on('click', function(){
		$('#form').submit();
	})

	$('#comment').on('keyup', function(){
		$('#send').addClass('red');
		$('#send').text('Rechazar');
	})
</script>