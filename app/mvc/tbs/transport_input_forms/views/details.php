<h2>Detalles Formulario Transporte de Ingreso</h2>
<?php 
$show = TRUE;
$is_last_truck = FALSE;
$form_state = $transport_input_form['form_state_id'];

if ($form_state==2 OR $form_state==3) {
	$show = FALSE;
}

$show_granel = FALSE;

	
if ($transport_input_forms_products[0]['packaging_id']==48) {
	$show_granel = TRUE;
}

$recived = $transport_input_form['starting_weight_value'] - $transport_input_form['ending_weight_value'];

?>

<style>
.color_0 {
	width: 10px;
	background-color: #E74C3C;
	color: #E74C3C;
}

.color_1,
.color_2 {
	width: 10px;
	background-color: #2ECC71;
	color: #2ECC71;
}

</style>

<table>
	<thead>
		<th>Fecha</th>
		<th>Creado por</th>
		<th>Estado</th>
		<th class="stretch">
		</th>
	</thead>
	<tbody>
		<tr>
			<td><?=$transport_input_form['created_at']?></td>
			<td><?=$transport_input_form['created_by_user']?></td>
			<td><?=$transport_input_form['state']?></td>
			<td class="nowrap">
				<a href="<?=BASE_URL?>tbs/transport_input_forms/printout?id=<?=$_GET['id']?>" target="_blank" class="button dark"><span class="icon printer"></span></a>
				<?php
				if ($form_state==1 || $form_state==6 || $form_state==4) 
				{
					?>
					<?= make_link('tbs/transport_input_forms/present?id='.$_GET['id'], '<span class="icon open"></span> Presentar', 'button dark create') ?>
					<?= make_link('tbs/transport_input_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
					<?php
				}else if ($form_state==2){
					if ($show_granel) {
						if ($transport_input_form['ending_weight_value']!='') {
							?>
							<?= make_link('tbs/transport_input_forms/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span>', 'button create') ?>
							<?php
						}
						?>
						<?= make_link('tbs/transport_input_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
						<?php
					}else{
						?>
						<?= make_link('tbs/transport_input_forms/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span>', 'button create') ?>
						<?= make_link('tbs/transport_input_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
						<?php
					}
					?>
					
					<?php
				}
				?></td>
			</tr>
		</tbody>
	</table>

	<table>
		<thead>
			<th>Cédula Conductor</th>
			<th>Nombre Conductor</th>
			<th>Placa Camión</th>
			<th>Número de trailer</th>
			<th>Cliente/Proveedor</th>
			<th>Peso Entrada</th>
			<th>Peso Sálida</th>
			<th class="stretch"></th>
		</thead>
		<tbody>
			<tr>
				<td <?=checkError('driver_citizen_id', $transport_input_forms_verify)?>>
					<?=$transport_input_form['driver_citizen_id']?>
				</td>
				<td>
					<?=$transport_input_form['driver_name']?>
				</td>
				<td <?=checkError('vehicle_plate', $transport_input_forms_verify)?>>
					<?=$transport_input_form['vehicle_plate']?>
				</td>
				<td <?=checkError('trailer_number', $transport_input_forms_verify)?>>
					<?=$transport_input_form['trailer_number']?>
				</td>
				<td <?=checkError('supplier_id', $transport_input_forms_verify)?>>
					<?=$transport_input_form['supplier']?>
				</td>
				<td><?php
					if ($transport_input_form['starting_weight_value']!='') {
						?>
						<?=number_format($transport_input_form['starting_weight_value'],2)?> KG
						<?php
						if (has_role(3)) {
							?>
							<a href="#inicial" class="button edit modal"><span class="icon edit"></span></a>
							<?php
						}
					}else{
						if (has_role(3)) {
							?>
							<a href="#inicial" class="button dark modal">Registrar Peso</a>
							<?php
						}
					}
				?></td>
				<td><?php
					if ($transport_input_form['starting_weight_value']!='') {
						if ($transport_input_form['ending_weight_value']) {
							?>
							<?=number_format($transport_input_form['ending_weight_value'], 2)?> KG
							<?php
							if (has_role(3)) {
								?>
								<a href="#final" class="button edit modal"><span class="icon edit"></span></a>
								<?php
							}
						}else{
							if (has_role(3)) {
								?>
								<a href="#final" class="button modal">Registrar Peso</a>
								<?php
							}
						}
					}else{
						?>

						<?php
					}
				?></td>
				<td><?php 
				if ($show) {
					?>
					<?= make_link('tbs/transport_input_forms/edit?id='.$_GET['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?php } ?>
				</td>
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
								<a href="#cantidad" id="open_cant" class="button edit modal"><span class="icon edit"></span></a>
								<?php
							}
						}else{
							if ($show) {
								?>
								<a href="#cantidad" id="open_cant" class="button dark modal">Registrar Cantidad</a>
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
		<?php
		if ($show)
		{
				if (!$show_granel) {
					?>
					<p><span class="icon info"></span> Si desea realizar un añadir todos los productos de un formulario, presione click en el siguiente botón: 
					<a href="#formularios" class="button modal"><span class="icon white masive"></span> Seleccionar FMM</a>
				<?php
				}
		}else{
			if ($_SESSION['user']['username']=='icastro') {
				?>
				<a href="#direct_to_locked" class="button modal"><span class="icon white masive"></span> Seleccionar FMM</a>
				<?php
			}
		}
		?>

			<table class="datagrid">
				<thead>
					<th>Id Almacen</th>
					<th>Formulario</th>
					<th>Producto</th>
					<th>Cantidad</th>
					<th>Cantidad<br> a Ingresar</th>
					<th>Ejecuta formulario?</th>
					<th class="stretch">
						<?php 
						if ($show) {
							?>
							<?php if (has_role(4)) {
								if (!$show_granel) {
									?>
									<a href="#products" class="button dark create modal"><span class="icon create"></span> Agregar</a>
									<?php
								}
							} ?>

							<?php }else{
								if ($_SESSION['user']['username']=='icastro') {
									?>
									<a href="#products" class="button dark create modal"><span class="icon create"></span> Agregar</a>
									<?php
								}
							} ?>
						</th>
					</thead>
					<tbody>
						<?php
						$sum = 0;
						foreach ($transport_input_forms_products as $tifp) 
						{
							$sum += $tifp['quantity'];
						}

						$scale_diff = $transport_input_form['starting_weight_value'] - $transport_input_form['ending_weight_value'];
						$count = 1;
						foreach ($transport_input_forms_products as $tifp) 
						{
							if ($show_granel) {
								$current_product = $tifp['product_id'];
							}
							?>
							<tr>
								<td>
									<?=$tifp['wid']?>
								</td>
								<td>
									<?=$tifp['input_form_id']?>
								</td>
								<td <?=checkError('product', $transport_input_forms_verify, $tifp['tif_id'])?>>
									<?=$tifp['product']?>
								</td>
								<td <?=checkError('quantity', $transport_input_forms_verify, $tifp['tif_id'])?>>
									
										<?=number_format($tifp['quantity'], 2)?>
								</td>
								<td>
									<?php
									if ($show_granel) {
										$num_pro = count($transport_input_forms_products);
										if ($num_pro>1) {
											if ($count==1) {
												$scale_diff -= $tifp['quantity'];
												echo number_format($tifp['quantity'], 2);
											}else{
												if ($count==$num_pro) {
													echo number_format($scale_diff, 2);
												}else{
													$scale_diff -= $tifp['quantity'];
													echo number_format($tifp['quantity'], 2);
												}
											}
										}else{
											echo number_format($scale_diff, 2);
										}
									}else{
										echo number_format($tifp['quantity'], 2);
									}
									?>
								</td>
								<td>
									<?php 
									$kk = 'No';
									$value = 1;
										if ($tifp['execute']==1) {
											$kk = 'Si';
											$value = 0;
										}
											?>
											<b><?=$kk?></b> 
											<?php if ($show) { ?>
											<a href="<?=BASE_URL?>tbs/transport_input_forms_products/set_execute_form?product_id=<?=$tifp['tifp_id']?>&value=<?=$value?>" class="button edit"><span class="icon loop white"></span></a>
											<?php } ?>
								</td>
								<td class="nowrap">
									<?php 
									if ($show) {
										?>
										<?= make_link('tbs/transport_input_forms_products/edit?form_id='.$_GET['id'].'&id='.$tifp['tifp_id'], '<span class="icon edit"></span>', 'button edit') ?>

										<?= make_link('tbs/transport_input_forms_products/delete?id='.$tifp['tifp_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
										<?php } ?>
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
										<?php 
										} 

										if (has_role(1)) {
										 	?>
										 	<?= make_link('tbs/transport_input_forms_supports/edit?form_id='.$_GET['id'].'&id='.$support['supp_id'], '<span class="icon edit"></span>', 'button edit') ?>

											<?= make_link('tbs/transport_input_forms_supports/delete?id='.$support['supp_id'].'&form_id='.$_GET['id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
										 	<?php
										 } ?>
									</td>
								</tr>
								<?php
							} ?>
						</tbody>
					</table>

					<h3>Logs</h3>
					<table>
						<thead>
							<th>Estado</th>
							<th>Usuario</th>
							<th>Fecha</th>
						</thead>
						<tbody>
							<?php foreach ($logs as $log) {
								?>
								<tr>
									<td><?=$log['state']?></td>
									<td><?=$log['created_by']?></td>
									<td><?=$log['created_at']?></td>
								</tr>
								<?php
							} ?>
						</tbody>
					</table>
					<div id="inicial" class="modal">
						<form method="POST" action="set_weight">
							<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
							<input type="hidden" name="type" value="1">
							<input type="text" name="weight" placeholder="Peso de entrada" min="0">
							<input type="submit" value="Registrar" class="button">
						</form>
					</div>
					<div id="final" class="modal">
						<form method="POST" action="set_weight">
							<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
							<input type="hidden" name="type" value="2">
							<input type="text" name="weight" placeholder="Peso de Sálida" min="0">
							<input type="submit" value="Registrar" class="button">
						</form>
					</div>
					<div id="cantidad" class="modal">
						<h3 id="disclaimer" style="color: red; display: none;">Primero quite todos los producto y despues si cambie la cantidad manifestada</h3>
						<form method="POST" id="cant_form" action="set_quantity">
							<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
							<input type="text" name="quantity" placeholder="Cantidad Manifestada" min="0">
							<input type="submit" value="Registrar" class="button">
						</form>
					</div>

					<div id="products" class="modal">
						<a id="add_products" href="javascript:;" class="button pull-right purple stretch"><span class="icon plus-circle2 white"></span> Agregar seleccionados</a>
						<!--<span class="icon info"></span><p>Si el transporte es para productos a grandel y desea fraccionarlo, debe seleccionar primero el producto del cual se tomará </p>-->
						<?php
						$table = new Datagrid();

						$table->set_options('tbs/products', 'get_all_in_virtual', 'a', 'false', 'multi');

						$table->add_column('ID Almacen', 'wid');
						$table->add_column_html('Formulario', 'form_id', 'FMM - {row_id}');
						$table->add_column('Producto', 'name');
						$table->add_column('Subpartida', 'tariff_id');
						$table->add_column('Proveedor', 'supplier');
						$table->add_column('Unidad', 'physical_unit');
						$table->add_column('Saldo', 'virtual');

						$table->render();
						?>
					</div>

					<div id="formularios" class="modal">
						<form method="POST" action="<?=BASE_URL?>tbs/transport_input_forms_products/add_products_by_form">
							<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
							<input type="text" name="input_form_id" placeholder="Número de formulario" min="0">
							<input type="submit" value="Añadir productos de este formulario" class="button">
						</form>
					</div>

					<div id="set_last_truck" class="modal">
						<form method="POST" action="<?=BASE_URL?>tbs/transport_input_forms_products/set_last_truck">
							<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
							<input type="text" name="input_form_id" placeholder="Número de formulario" min="0">
							<input type="submit" value="Añadir productos de este formulario" class="button">
						</form>
					</div>

					<div id="direct_to_locked" class="modal">
						<form method="POST" action="<?=BASE_URL?>tbs/transport_input_forms_products/add_products_by_form_MAGIC">
							<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
							<input type="text" name="input_form_id" placeholder="Número de formulario" min="0">
							<input type="submit" value="Añadir y pasar a bloqueado" class="button">
						</form>
					</div>

					<script>
						$('#add_products').hide();

						var products_id = new Array();

						$('table#datagrid_0').on('click', 'tr', function()
						{
							
							//products_id = [];

							$(this).toggleClass('selected');

							var selected = datatable_0.row(this).data()['wid'];
							var index = products_id.indexOf(selected);

							if (index > -1) {
							    products_id.splice(index, 1);
							}else{
								products_id.push(selected);
							}

							//console.log(products_id);

							$('#add_products').hide();
							//console.log(products_id.length);
							if (products_id.length > 0)
							{
								$('#add_products').show();
							}
						});



						$('#add_products').click(function()
						{
							$('#loading').show();
							
							if ($('table#datagrid_0 tr.selected').length)
							{
								$.post(
									"<?=BASE_URL.'tbs/transport_input_forms_products/create_massively'?>",
									{
										form_id: <?=$_GET['id']?>,
										products_id: products_id
									},
									function(data, status)
									{
										console.log(data);
										location.href = "<?=BASE_URL.'tbs/transport_input_forms/details?id='.$_GET['id']?>";
									}
									);
							}
							else
							{
								$('#add_products').hide();
							}
						});
					</script>

<script type="text/javascript">
	$(document).ready(function(){
		var selected = <?=$transport_input_form['is_last_truck']?>;
		if (selected==1) {
			$('#table_forms').show();
		}else{
			$('#table_forms').hide();
		}
	})

	$('#open_cant').on('click', function(){
		var cant_products = <?=count($transport_input_forms_products)?>;
		$('#disclaimer').hide();
		$('#cant_form').show();
		if (cant_products>0) {
			$('#disclaimer').show();
			$('#cant_form').hide();
		}
	})

	$('#truck').on('change', function(){
		var selected = $('#truck').val();
		if (selected==1) {
			$('#table_forms').show();
		}else{
			$('#table_forms').hide();
		}
	})
</script>