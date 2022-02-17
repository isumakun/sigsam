<?php 
/*if ($_SESSION['user']['username']!='icastro') {
 	?>
 	<center>
 		<h1><b>Estamos trabajando en esta sección, por favor espere un momento</b></h1>
 		<img src="http://tbs.daabon.com.co:8090/tbs3/public/assets/images/pitboy_worker.png">
 	</center>
 	<?php
 	die();
 }*/ ?>
<h2>Detalles Formulario Transporte de Salida</h2>
<?php 
$show = TRUE;
if ($transport_output_form['form_state_id']==2 OR $transport_output_form['form_state_id']==3 OR $transport_output_form['form_state_id']==12) {
	$show = FALSE;
}
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
		<th>Verificado</th>
		<th>Estado</th>
		<th class="stretch"></th>
	</thead>
	<tbody>
		<tr>
			<td><?=$transport_output_form['created_at']?></td>
			<td><?=$transport_output_form['created_by_user']?></td>
			<td><?php if (has_role(3)) {
					$verified = FALSE;
					foreach ($logs as $log) {
						if ($log['form_state_id'] == 12) {
							$verified = TRUE;
						}
					}
					if ($verified) {
						echo "SI";
					}else{
						?>
						<a href="<?=BASE_URL?>tbs/transport_output_forms/verified?id=<?=$_GET['id']?>" target="_blank" class="button dark"><span class="icon white checkmark"></span> Verificar para salida</a>
						<?php
					}
			} ?></td>
			<td><?=$transport_output_form['state']?></td>
			<td class="nowrap">
				<a href="<?=BASE_URL?>tbs/transport_output_forms/printout?id=<?=$_GET['id']?>" target="_blank" class="button dark"><span class="icon printer"></span></a>
				<?php
				if ($transport_output_form['form_state_id']==1 || $transport_output_form['form_state_id']==6 || $transport_output_form['form_state_id']==4) 
				{
					?>
					<?= make_link('tbs/transport_output_forms/present?id='.$_GET['id'], '<span class="icon open"></span> Presentar', 'button dark create') ?>
					<?php
				}else if (!$show){
					?>
					<?= make_link('tbs/transport_output_forms/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span>', 'button create') ?>
					<?= make_link('tbs/transport_output_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
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
			<th>Número de Trailer</th>
			<th>Peso Entrada</th>
			<th>Peso Sálida</th>
			<th class="stretch"></th>
		</thead>
		<tbody>
			<tr>
				<td <?=checkError('driver_citizen_id', $transport_output_forms_verify)?>>
					<?=$transport_output_form['driver_citizen_id']?>
				</td>
				<td <?=checkError('driver_name', $transport_output_forms_verify)?>>
					<?=$transport_output_form['driver_name']?>
				</td>
				<td <?=checkError('vehicle_plate', $transport_output_forms_verify)?>>
					<?=$transport_output_form['vehicle_plate']?>
				</td>
				<td <?=checkError('trailer_number', $transport_output_forms_verify)?>>
					<?=$transport_output_form['trailer_number']?>
				</td>
				<td><?php
				if ($transport_output_form['starting_weight_value']!='') {
					?>
					<?=$transport_output_form['starting_weight_value']?> KG
					<a href="#inicial" class="button edit modal"><span class="icon edit"></span></a>
					<?php
				}else{
					?>
					<a href="#inicial" class="button dark modal">Registrar Peso</a>
					<?php
				}
				?></td>
				<td><?php
				if ($transport_output_form['starting_weight_value']!='') {
					if ($transport_output_form['ending_weight_value']) {
						?>
						<?=$transport_output_form['ending_weight_value']?> KG
						<a href="#final" class="button edit modal"><span class="icon edit"></span></a>
						<?php
					}else{
						?>
						<a href="#final" class="button modal">Registrar Peso</a>
						<?php
					}
				}else{
					?>
					
					<?php
				}
				?></td>
				<td>
					<?php 
					if ($show) {
						?>
						<?= make_link('tbs/transport_output_forms/edit?id='.$_GET['id'], '<span class="icon edit"></span>', 'button edit') ?>
						<?php } ?>
					</td>
				</tr>
			</tbody>
		</table>

		<h3>Información de Carga</h3>
	<table>
		<thead>
			<th># de unidad de carga recibida</th>
			<th># de precinto recibido</th>
				<th class="stretch">
						<?php if (has_role(3)) { ?>
						<?= make_link('tbs/transport_output_forms/edit_charge_info?id='.$_GET['id'], '<span class="icon edit"></span>', 'button edit') ?>
						<?php } ?>
					</th>
			</th>
		</thead>
			<tbody>
					<?php 
					$cunv = explode(PHP_EOL, $transport_output_form['charge_unit_number_verified']);
					$snv = explode(PHP_EOL, $transport_output_form['seal_number_verified']);
					for ($i=0; $i < count($cunv); $i++) { 
					?>
						<tr>
							<td><?=$cunv[$i]?></td>
							<td><?=$snv[$i]?></td>
							<td></td>
						</tr>
					<?php
					}
					 ?>
			</tbody>
		</table>

		<h3>Productos</h3>
		<table class="datagrid">
			<thead>
				<th>Formulario Salida</th>
				<th>ID Almacen</th>
				<th>Producto</th>
				<th>Cantidad</th>
				<th class="stretch">
					<?php if ($show) {
						if (has_role(4)) {
							?>
							<a href="#products" class="button dark create modal stretch"><span class="icon create"></span></a><br>
							<a href="#products_transformated" class="button purple create modal stretch"><span class="icon white loop"></span></a>
							<?php }
						} ?>
					</th>
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
							<td <?=checkError('product', $transport_output_forms_verify, $tifp['ifp_id'])?>>
								<?=$tifp['product']?>
							</td>
							<td <?=checkError('quantity', $transport_output_forms_verify, $tifp['ifp_id'])?>>
								<?=number_format($tifp['quantity'], 2)?>
							</td>
							<td class="nowrap">
								
								<?php 
								if ($show) {
									?>
									<?= make_link('tbs/transport_output_forms_products/edit?form_id='.$_GET['id'].'&id='.$tifp['tofp_id'], '<span class="icon edit"></span>', 'button edit') ?>

									<?= make_link('tbs/transport_output_forms_products/delete?id='.$tifp['tofp_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
									<?php
								}
								 ?>
								
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
							<?php }elseif (has_role(3)) {
								?>
								<?= make_link('tbs/transport_output_forms_supports/create?form_id='.$_GET['id'], '<span class="icon create"></span>', 'button dark create') ?>
								<?php
							} ?>
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
										<?php }elseif (has_role(3)) {
											?>
											<?= make_link('tbs/transport_output_forms_supports/edit?form_id='.$_GET['id'].'&id='.$ifp['ifp_id'], '<span class="icon edit"></span>', 'button edit') ?>

											<?= make_link('tbs/transport_output_forms_supports/delete?id='.$support['supp_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
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
					<div id="charge_number" class="modal">
						<form method="POST" action="set_charge_number">
							<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
							<input type="text" name="charge_number" placeholder="Número unidad de carga verificado" min="0">
							<input type="submit" value="Registrar número" class="button">
						</form>
					</div>

					<div id="products" class="modal">
						<a id="add_products" href="javascript:;" class="button pull-right purple stretch"><span class="icon plus-circle2 white"></span> Agregar seleccionados</a>
						<?php
						$table = new Datagrid();

						$table->set_options('tbs/products', 'get_all_inspected_to_output', 'a', 'false', 'multi');

						$table->add_column('ID Almacen', 'wid');
						$table->add_column_html('Formulario', 'output_form_id', '{row_id}');
						$table->add_column('Producto', 'name');
						$table->add_column('Subpartida', 'tariff_heading');
						$table->add_column('Unidad', 'physical_unit');
						$table->add_column('Cant. Form', 'quantity');
						$table->add_column('Saldo', 'inspected_to_output');

						$table->render();
						?>
					</div>

					<div id="products_transformated" class="modal">
						<a id="add_products_transformated" href="javascript:;" class="button pull-right purple stretch"><span class="icon plus-circle2 white"></span> Agregar seleccionados</a>
						<?php
						$table = new Datagrid();

						$table->set_options('tbs/products', 'get_all_inspected_to_output_transformated', 'a', 'false', 'multi');

						$table->add_column('ID Almacen', 'wid');
						$table->add_column_html('Formulario', 'output_form_id', '{row_id}');
						$table->add_column('Producto', 'name');
						$table->add_column('Subpartida', 'tariff_heading');
						$table->add_column('Unidad', 'physical_unit');
						$table->add_column('Cant. Form', 'quantity');
						$table->add_column('Saldo', 'inspected_to_output');

						$table->render();
						?>
					</div>

					<script>
						$('#add_products').hide();

						var products_id = new Array();

						$('table#datagrid_0').on('click', 'tr', function()
						{
							products_id = [];

							$(this).toggleClass('selected');

							for ($i = 0; $i < datatable_0.rows('.selected')[0].length; $i++)
							{
								products_id.push(datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['wid']+' - '+datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['output_form_id']);
								console.log(products_id);
							}

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
									"<?=BASE_URL.'tbs/transport_output_forms_products/create_massively'?>",
									{
										form_id: <?=$_GET['id']?>,
										products_id: products_id
									},
									function(data, status)
									{
										console.log(data);
										//alert('Estamos arreglando algo, por favor intente de nuevo en 5min');
										location.href = "<?=BASE_URL.'tbs/transport_output_forms/details?id='.$_GET['id']?>";
									}
									);
							}
							else
							{
								$('#add_products').hide();
							}
						});
					</script>


<script>
						$('#add_products_transformated').hide();

						var products_id = new Array();
						var output_form_ids = new Array();

						$('table#datagrid_1').on('click', 'tr', function()
						{
							products_id = [];
							output_form_ids = [];

							$(this).toggleClass('selected');

							for ($i = 0; $i < datatable_1.rows('.selected')[0].length; $i++)
							{
								products_id.push(datatable_1.row(datatable_1.rows('.selected')[0][$i]).data()['wid']+' - '+datatable_1.row(datatable_1.rows('.selected')[0][$i]).data()['output_form_id']);
								console.log(products_id);
							}

							$('#add_products_transformated').hide();
							//console.log(products_id.length);
							if (products_id.length > 0)
							{
								$('#add_products_transformated').show();
							}
						});

						$('#add_products_transformated').click(function()
						{
							$('#loading').show();
							if ($('table#datagrid_1 tr.selected').length)
							{
								$.post(
									"<?=BASE_URL.'tbs/transport_output_forms_products/create_massively_transformated'?>",
									{
										form_id: <?=$_GET['id']?>,
										products_id: products_id,
										output_form_ids: output_form_ids
									},
									function(data, status)
									{
										console.log(data);
										location.href = "<?=BASE_URL.'tbs/transport_output_forms/details?id='.$_GET['id']?>";
									}
									);
							}
							else
							{
								$('#add_products_transformated').hide();
							}
						});
					</script>
