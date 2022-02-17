<style type="text/css">
	td{
		cursor: pointer;
	}
</style>
<h2>Verificar Transporte Formulario de Ingreso</h2>

<a href="#" id="send" class="pull-right button">Enviar</a>
<h3>1. Información General</h3>
<table>
	<thead>
		<th>Cédula Conductor</th>
		<th>Nombre Conductor</th>
		<th>Placa Camión</th>
	</thead>
	<tbody>
		<tr>
			<td <?=checkError('driver_citizen_id', $transport_output_form_verify)?> data-type="1" data-field="driver_citizen_id" data-id="0">
				<?=$transport_output_form['driver_citizen_id']?>
			</td>
			<td <?=checkError('driver_name', $transport_output_form_verify)?> data-type="1" data-field="driver_name" data-id="0">
				<?=$transport_output_form['driver_name']?>
			</td>
			<td <?=checkError('vehicle_plate', $transport_output_form_verify)?> data-type="1" data-field="vehicle_plate" data-id="0">
				<?=$transport_output_form['vehicle_plate']?>
			</td>
		</tr>
	</tbody>
</table>

<h3>Productos</h3>
<table>
	<thead>
		<th>Formulario de Salida</th>
		<th>ID Almacen</th>
		<th>Producto</th>
		<th>Cantidad</th>
	</thead>
	<tbody>
		<?php 
		foreach ($transport_output_forms_products as $tifp) 
		{
			?>
			<tr>
				<td>
					FMM - <?=$tifp['output_form_id']?>
				</td>
				<td>
					<?=$tifp['warehouse_id']?>
				</td>
				<td <?=checkError('product', $transport_output_forms_verify, $tifp['ifp_id'])?> data-type="2" data-field="product" data-id="<?=$tifp['id']?>">
					<?=$tifp['product']?>
				</td>
				<td <?=checkError('quantity', $transport_output_forms_verify, $tifp['ifp_id'])?> data-type="2" data-field="quantity" data-id="<?=$tifp['id']?>">
					<?=number_format($tifp['quantity'], 2)?>
				</td>
			</tr>
			<?php
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
					<th class="stretch">
						<?php 
						if ($show) {
							?>
							<?= make_link('tbs/transport_output_forms_supports/create?form_id='.$_GET['id'], '<span class="icon create"></span>', 'button dark create') ?>
							<?php } ?>
						</th>
					</thead>
					<tbody>
						<?php foreach ($transport_output_forms_supports as $support) {
							?>
							<tr>
								<td <?=checkError('output_form_support_type_id', $transport_output_forms_verify, $support['supp_id'])?>><?=$support['support_type']?></td>
								<td>
									<a href="<?=BASE_URL."public/uploads/supports/transport_output/{$_SESSION['user']['company_schema']}{$_GET['id']}/{$support['supp_id']}.{$support['file_extension']}"?>" class="button" target="_blank"> Ver adjunto</a>
								</td>
								<td <?=checkError('created_at', $transport_output_forms_verify, $support['supp_id'])?>><?=$support['created_at']?></td>
								<td <?=checkError('details', $transport_output_forms_verify, $support['supp_id'])?>><?=$support['details']?></td>
								<td class="nowrap">
									<?php 
									if ($show) {
										?>
										<?= make_link('tbs/transport_output_forms_supports/edit?form_id='.$_GET['id'].'&id='.$ifp['ifp_id'], '<span class="icon edit"></span>', 'button edit') ?>

										<?= make_link('tbs/transport_output_forms_supports/delete?id='.$support['supp_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
										<?php } ?>
									</td>
								</tr>
								<?php
							} ?>
						</tbody>
					</table>


<form id="form" method="POST" class="hidden">
	<input type="text" name="form_id" value="<?=$_GET['id']?>">
</form>

<script type="text/javascript">
	var tds = $('#main_content table td');

	$('#main_content').on('click', 'td', function()
	{
		var field = $(this).attr('data-field');
		var type = $(this).attr('data-type');
		var id = $(this).attr('data-id');

		//alert (type+'-'+id+'-'+field);

		if ($(this).hasClass('red')) {
			$(this).removeClass('red');
			$('#'+type+'-'+id+'-'+field).remove();
		}else if ($(this).hasClass('yellow')) {
			$(this).removeClass('yellow');
			$('#'+type+'-'+id+'-'+field).remove();
		}else{
			$(this).addClass('red');
			$('#form').append('<input type="text" id="'+type+'-'+id+'-'+field+'" name="bad_fields[]" value="'+type+'-'+id+'-'+field+'">');
		}		
	});

	$('#send').on('click', function(){
		$('#form').submit();
	})
</script>