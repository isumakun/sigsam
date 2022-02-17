<?php 

$show_granel = FALSE;

	if ($transport_input_forms_products[0]['packaging_id']==48) {
		$show_granel = TRUE;
	}
 ?>
<style type="text/css">
	.clickeable td{
		cursor: pointer;
	}
</style>

<?php if (!$_SESSION['user']['username']=='icastro') {
	?>
	<!--<div style="width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); position: fixed; z-index: 9999; top: 0;
    left: 0; bottom: 0">
		<center><h1 style="vertical-align: middle; color: white; font-weight: 1000; margin-top: 20%; margin-left: 10%; margin-right: 10%">Perdone, en el momento estamos teniendo problemas técnicos, en breve estará disponible esta sección</h1></center>
	</div>-->
	<?php
} ?>
<h2>Verificar Transporte Formulario de Ingreso</h2>

<a href="#" id="send" class="pull-right button">Enviar</a>
<h3>Información General</h3>
<table class="clickeable">
	<thead>
		<th>Cédula Conductor</th>
		<th>Nombre Conductor</th>
		<th>Placa Camión</th>
		<th>Número de trailer</th>
		<th>Cliente/Proveedor</th>
		<th>Peso Entrada</th>
		<th>Peso Salida</th>
	</thead>
	<tbody>
		<tr>
			<td <?=checkError('driver_citizen_id', $transport_input_form_verify)?> data-type="1" data-field="driver_citizen_id" data-id="0">
				<?=$transport_input_form['driver_citizen_id']?>
			</td>
			<td>
				<?=$transport_input_form['driver_name']?>
			</td>
			<td <?=checkError('vehicle_plate', $transport_input_form_verify)?> data-type="1" data-field="vehicle_plate" data-id="0">
				<?=$transport_input_form['vehicle_plate']?>
			</td>
			<td <?=checkError('trailer_number', $transport_input_form_verify)?> data-type="1" data-field="trailer_number" data-id="0">
				<?=$transport_input_form['trailer_number']?>
			</td>
			<td <?=checkError('supplier_id', $transport_input_form_verify)?> data-type="1" data-field="supplier_id" data-id="0">
				<?=$transport_input_form['supplier']?>
			</td>
			<td>
				<?=$transport_input_form['starting_weight_value']?>
			</td>
			<td>
				<?=$transport_input_form['ending_weight_value']?>
			</td>v
		</tr>
	</tbody>
</table>

<h3>Información de Carga</h3>
	<table>
		<thead>
			<th># de unidad de carga manifestada</th>
			<th># de unidad de carga recibida</th>
			<th># de precinto manifestado</th>
			<th># de precinto recibido</th>
				<th class="stretch">
						<?php if (has_role(3)) { ?>
						<?= make_link('tbs/transport_input_forms/edit_charge_info?id='.$_GET['id'], '<span class="icon edit"></span>', 'button edit') ?>
						<?php } ?>
					</th>
			</th>
		</thead>
			<tbody>
				<tr>
					<?php 
					$cunm = explode(PHP_EOL, $transport_input_form['charge_unit_number_manifested']);
					$cunv = explode(PHP_EOL, $transport_input_form['charge_unit_number_verified']);
					$snm = explode(PHP_EOL, $transport_input_form['seal_number_manifested']);
					$snv = explode(PHP_EOL, $transport_input_form['seal_number_verified']);
					for ($i=0; $i < count($cunm); $i++) { 
					?>
						<tr>
							<td><?=$cunm[$i]?></td>
							<td><?=$cunv[$i]?></td>
							<td><?=$snm[$i]?></td>
							<td><?=$snv[$i]?></td>
							<td></td>
						</tr>
					<?php
					}
					 ?>
				</tr>
			</tbody>
		</table>

		<table>
				<tr>
					<th>Cantidad Manifestada</th>
					<th>Cantidad Recibida</th>
				</tr>
					<tr>
						
						<td>
						<?php if ($transport_input_form['quantity_manifested']!='') {
							echo number_format($transport_input_form['quantity_manifested'], 2);
							if ($show) {
								?>
								<a href="#cantidad" class="button edit modal"><span class="icon edit"></span></a>
								<?php
							}
						}else{
							if ($show) {
								?>
								<a href="#cantidad" class="button dark modal">Registrar Cantidad</a>
								<?php
							}
						} ?>
				</td>
				<td>
					<?=number_format($transport_input_form['starting_weight_value'] - $transport_input_form['ending_weight_value'], 2)?>
					</td>
					</tr>
			</table>


<h3>Productos</h3>
<table class="clickeable">
	<thead>
		<th>Id Almacen</th>
		<th>Formulario</th>
		<th>Producto</th>
		<th>Cantidad</th>
		<th>Ejecuta el formulario?</th>
	</thead>
	<tbody>
		<?php 
		foreach ($transport_input_forms_products as $tifp) 
		{
			?>
			<tr style="cursor: auto !important">
				<td>
					<?=$tifp['wid']?>
				</td>
				<td>
					<?=$tifp['input_form_id']?>
				</td>
				<td <?=checkError('product', $transport_input_forms_verify, $tifp['ifp_id'])?> data-type="2" data-field="product" data-id="<?=$tifp['id']?>">
					<?=$tifp['product']?>
				</td>
				<td <?=checkError('quantity', $transport_input_forms_verify, $tifp['ifp_id'])?> data-type="2" data-field="quantity" data-id="<?=$tifp['id']?>">
					
										<?=number_format($tifp['quantity'], 2)?>
										
				</td>
				<td>
					<?php 
									if ($show_granel) {
										if ($tifp['execute']==1) {
											?>
											<b>Si </b> 
											<?php if ($show) { ?>
											<a href="<?=BASE_URL?>tbs/transport_input_forms_products/set_execute_form?product_id=<?=$tifp['tifp_id']?>&value=0" class="button red">No</a>
											<?php } ?>
											<?php
										}else{
											?>
											<?php if ($show) { ?>
											<a href="<?=BASE_URL?>tbs/transport_input_forms_products/set_execute_form?product_id=<?=$tifp['tifp_id']?>&value=1" class="button">Si</a>
											<?php } ?>
											<b>No </b> 
											<?php
										}
									}
								 ?>
				</td>
			</tr>
			<?php
		} ?>
	</tbody>
</table>

<h3>Soportes</h3>
					<table class="clickeable">
						<thead>
							<th>Tipo</th>
							<th>Soporte</th>
							<th>Fecha</th>
							<th>Detalle</th>
							<th class="stretch">
								<?php if ($form_state==3 OR $form_state==5) {
									if (has_role(3)) {
										?>
										<?= make_link('tbs/transport_input_forms_supports/create?form_id='.$_GET['id'], '<span class="icon create"></span> Agregar', 'button dark create') ?>
										<?php
									}
								}else{
									?>
									<?= make_link('tbs/transport_input_forms_supports/create?form_id='.$_GET['id'], '<span class="icon create"></span> Agregar', 'button dark create') ?>
									<?php
								} ?>
							</th>
						</thead>
						<tbody>
							<?php foreach ($transport_input_forms_supports as $support) {
								?>
								<tr>
									<td <?=checkError('input_form_support_type_id', $transport_input_forms_verify, $support['supp_id'])?>>
										<?=$support['support_type']?>
									</td>
									<td><a href="<?=BASE_URL."public/uploads/supports/transport_input/{$_SESSION['user']['company_schema']}{$_GET['id']}/{$support['supp_id']}.{$support['file_extension']}"?>" class="button" target="_blank"> Ver adjunto</a></td>
									<td <?=checkError('created_at', $transport_input_forms_verify, $support['supp_id'])?>><?=$support['created_at']?></td>
									<td <?=checkError('details', $transport_input_forms_verify, $support['supp_id'])?>><?=$support['details']?></td>
									<td class="nowrap">
										<?php if ($show) { ?>
										<?= make_link('tbs/transport_input_forms_supports/edit?form_id='.$_GET['id'].'&id='.$support['supp_id'], '<span class="icon edit"></span>', 'button edit') ?>

										<?= make_link('tbs/transport_input_forms_supports/delete?id='.$support['supp_id'].'&form_id='.$_GET['id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
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
	var tds = $('#main_content table.clickeable td');

	$('#main_content').on('click', '.clickeable td', function()
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