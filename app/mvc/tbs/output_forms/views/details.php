<h2>Detalles Formulario de Salida</h2>
<?php 
$show = TRUE;
$red = '';
$is_nationalized = TRUE;
if ($output_form['form_state_id']==2 OR $output_form['form_state_id']==3 OR $output_form['form_state_id']==5 OR $output_form['form_state_id']==14) {
		$red = 'background-color:red; color:white';
		if (has_role(1)) {
			
		}else{
			$show = FALSE;
		}
}else if ($output_form['form_state_id']==11) {
	$is_nationalized = FALSE;
}
foreach ($logs as $log) {
	if ($log['form_state_id']==11) {
		$is_nationalized = FALSE;
	}
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
		<th>Estado Actual</th>
		<th>Creado por</th>
		<th>Fecha de creación</th>
		<th class="stretch">Acciones</th>
	</thead>
	<tbody>
		<tr>
			<td style="<?=$red?>"><?=$output_form['state']?></td>
			<td><?=$output_form['created_by_user']?></td>
			<td><?=$output_form['created_at']?></td>
			<td class="nowrap">
				<a href="<?=BASE_URL?>tbs/output_forms/printout?id=<?=$_GET['id']?>" target="_blank" class="button dark"><span class="icon printer"></span></a>
				<?php
				if ($output_form['form_state_id']==1 || $output_form['form_state_id']==6 || $output_form['form_state_id']==4) 
				{
					$change_type = FALSE;
					foreach ($output_forms_products as $ofp) {
						if ($ofp['product_type_id']==1 OR $ofp['product_type_id']==6) {
							$change_type = TRUE;
						}
					}

					if ($change_type) {
						
						$transaction_code = substr($output_form['transaction_code'], 0, 1);
						if ($transaction_code==2 OR $transaction_code==6 OR $transaction_code==8) {
							?>
							<?= make_link('tbs/output_forms/present?id='.$_GET['id'], '<span class="icon open"></span> Presentar', 'button dark create') ?>
							<?php
						}else{
							if ($output_form['transaction_code']==408 OR $output_form['transaction_code']==409 OR $output_form['transaction_code']==418) {
								?>
							<?= make_link('tbs/output_forms/present?id='.$_GET['id'], '<span class="icon open"></span> Presentar', 'button dark create') ?>
							<?php
							}else{
								?>
							<?= make_link('tbs/output_forms/change_type?id='.$_GET['id'], '<span class="icon open"></span> Cambiar Tipo', 'button dark create') ?>
							<?= make_link('tbs/output_forms/reject?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
							
							
							<?php
							}
						}
					}else{
						?>
						<?= make_link('tbs/output_forms/present?id='.$_GET['id'], '<span class="icon open"></span> Presentar', 'button dark create') ?>
						<?php
					}
				}else if ($output_form['form_state_id']==2 OR $output_form['form_state_id']==10){
					?>
					<?= make_link('tbs/output_forms/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span>', 'button create') ?>
					<?php if (has_role(4)) {
						?>
						<?= make_link('tbs/output_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
						<?php
					}else{
						?>
						<?= make_link('tbs/output_forms/reject?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
						<?php
					} ?>
					<?php
				}else if ($output_form['form_state_id']==11){
					?>
					<?= make_link('tbs/output_forms/present?id='.$_GET['id'], '<span class="icon open"></span> Presentar', 'button dark create') ?>
					<?php
				}else if ($output_form['form_state_id'] == 14)
				{
					if ($_SESSION['user']['id']==$output_form['updated_by']) {
?>
					<?=make_link('tbs/output_forms/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span> Continuar Revisión', 'button create') ?>
					<?=make_link('tbs/output_forms/liberate?id='.$_GET['id'], '<span class="icon white checkmark"></span> Liberar', 'button edit') ?>
					<?=make_link('tbs/output_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
<?php
					}else{
						?>
						<span class="button red">En revisión por <b><?=$output_form['updated_by_user']?></b></span>
						<?php
					}
				}
?>
			</td>
		</tr>
	</tbody>
</table>
<h3>Información General</h3>
<table>
	<thead>
		<th>Cliente</th>
		<th>TRM</th>
		<th>Transacción</th>
		<th>Tipo Transporte</th>
		<th>Reembolsable</th>
		<th>Cantidad de bultos</th>
		<th>País Compra</th>
		<th>País Destino</th>
		<th>País Procedencia</th>
		<th>Bandera</th>
		<th>Editar</th>
	</thead>
	<tbody>
		<tr>
			<td <?=checkError('supplier_id', $output_forms_verify)?>>
				<?=$output_form['supplier']?>
			</td>
			<td <?=checkError('exchange_rate', $output_forms_verify)?>>
				<?=$output_form['exchange_rate']?>
			</td>
			<td <?=checkError('transaction_id', $output_forms_verify)?>>
				<?=$output_form['transaction_code']?> - <?=$output_form['transaction']?>
			</td>
			<td <?=checkError('transport_type_id', $output_forms_verify)?>>
				<?=$output_form['transport']?>
			</td>
			<td <?=checkError('refundable', $output_forms_verify)?>>
				<?=($output_form['refundable'] == 1 ? 'Si' : 'No')?>
			</td>
			<td <?=checkError('packages_quantity', $output_forms_verify)?>>
				<?=($output_form['packages_quantity'])?>
			</td>
			<td <?=checkError('flag_id_1', $output_forms_verify)?>>
				<?=$output_form['flag_id_1']?> - <?=$output_form['flag_1']?>
			</td>
			<td <?=checkError('flag_id_2', $output_forms_verify)?>>
				<?=$output_form['flag_id_2']?> - <?=$output_form['flag_2']?>
			</td>
			<td <?=checkError('flag_id_3', $output_forms_verify)?>>
				<?=$output_form['flag_id_3']?> - <?=$output_form['flag_3']?>
			</td>
			<td <?=checkError('flag_id_4', $output_forms_verify)?>>
				<?=$output_form['flag_id_4']?> - <?=$output_form['flag_4']?>
			</td>
			<td class="nowrap">
				<?php 
				if ($show) {
					?>
					<?= make_link('tbs/output_forms/edit?id='.$_GET['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?php } ?>
				</td>
			</tr>
		</tbody>
	</table>

	<table>
		<th>Observaciones</th>
		<tbody>
			<tr>
				<td><p><?= nl2br($output_form['observations']) ?></p></td>
			</tr>
		</tbody>
	</table>
	<?php if ($output_form['form_state_id']==10) {
		?>
		<h3>Soportes de levante</h3>
		<?php if(has_role(3)){
			?>
			<a href="#new_modal" class="modal button pull-right stretch"><span class="icon plus-circle2 white"></span> Agregar Levante</a>
			<?php
		} ?>
		<?php
		$table = new Datagrid();

		$table->set_options('tbs/nationalized_forms_supports', 'get_by_form', $_GET['id'], 'false', 'multi');

		$table->add_column('Numero', 'number');
		$table->add_column('Fecha', 'supp_date');
		$table->add_column_html('Acciones', 'id', '<a href="'.BASE_URL.'tbs/nationalized_forms_supports/delete?id={row_id}" class="button delete confirm_action"><span class=" icon delete"></span></a>', 'toolbar');

		$table->render();
		?>

		<script>

			var number;
			var supp_date;

			function send_form(){
				number = $("input[name=number]").val();
				supp_date = $("input[name=supp_date]").val();

				$.post(
					"<?=BASE_URL.'tbs/nationalized_forms_supports/create'?>",
					{
						number: number,
						supp_date: supp_date,
						form_id: <?=$_GET['id']?>
					},
					function(data, status)
					{
						console.log(data);
						location.href = "<?=BASE_URL.'tbs/output_forms/details?id='.$_GET['id']?>";
					}
					);			
			}
		</script>
		<?php 
		$calendar = new Calendar();
		?>
		<div id="new_modal" class="modal">
			<label>Número levante:</label>
			<input type="text" min="1" name="number">

			<label>Fecha levante:</label>
			<?= $calendar->render('supp_date');?>
			<br><br>
			<button onclick="send_form()" class="button">Agregar</button>
		</div>
		<?php
	} ?>

	<h3>Productos</h3>
	<?php if ($show) {
		if ($is_nationalized) {
			?>
		<p><span class="icon info"></span> Si desea realizar un añadir varios productos al formulario, presione click en el siguiente botón: 
		<a href="#products" class="button modal"><span class="icon white masive"></span> Añadir varios</a>
		<?php
		}
	} ?>

	<table class="datagrid">
		<thead>
			<th>ID Almacen</th>
			<th>Producto</th>
			<th>Subpartida</th>
			<th>Tipo</th>
			<th>Categoria</th>
			<th>Cantidad</th>
			<th>Cant. Comercial</th>
			<th>Peso Neto</th>
			<th>Peso Bruto</th>
			<th>Embalaje</th>
			<th>Valor FOB</th>
			<th>Fletes</th>
			<th>Seguros</th>
			<th>Otros Gastos</th>
			<th>País Origen</th>
			<th>CIF USD</th>
			<th>CIF COP</th>
			<th class="stretch">
				<?php 
				if ($show) {
					if ($is_nationalized) {
					if (TRUE) {
						?>
						<?= make_link('tbs/output_forms_products/create?form_id='.$_GET['id'], '<span class="icon create "></span>', 'button dark create stretch') ?><br>
						<?= make_link('tbs/output_forms_products/create?form_id='.$_GET['id'].'&transformed=1', '<span class="icon white loop"></span>', 'button create stretch') ?>
						<?php
					}else{
						?>

						<?php
					}
				}
				} ?>
			</th>
		</thead>
		<tbody>
			<?php 
			$fob_sum = 0;
				$fletes_sum = 0;
				$seguros_sum = 0;
				$ogastos_sum = 0;
				$gross_weight_sum = 0;
				$net_weight_sum = 0;
			foreach ($output_forms_products as $ofp) 
			{
				?>
				<tr>
					<td>
						<?=$ofp['wid']?>
					</td>
					<td <?=checkError('product_id', $output_forms_verify, $ofp['ofp_id'])?>>
						<?=$ofp['product']?>
					</td>
					<td <?=checkError('tariff_heading_id', $output_forms_verify, $ofp['ofp_id'])?>>
						<?=$ofp['tariff_heading_code']?>
					</td>
					<td>
						<?=$ofp['product_type']?>
					</td>
					<td <?=checkError('product_category_id', $output_forms_verify, $ofp['ofp_id'])?>>
						<?=$ofp['category']?>
					</td>
					<td <?=checkError('quantity', $output_forms_verify, $ofp['ofp_id'])?>>
						<?=$ofp['quantity']?>
					</td>
					<td <?=checkError('commercial_quantity', $output_forms_verify, $ofp['ofp_id'])?>>
						<?=$ofp['commercial_quantity']?>
					</td>
					<td <?=checkError('net_weight', $output_forms_verify, $ofp['ofp_id'])?>>
						<?php $net_weight_sum = $net_weight_sum + $ofp['net_weight']; ?>
						<?=$ofp['net_weight']?>
					</td>
					<td <?=checkError('gross_weight', $output_forms_verify, $ofp['ofp_id'])?>>
						<?php $gross_weight_sum = $gross_weight_sum + $ofp['gross_weight']; ?>
						<?=$ofp['gross_weight']?>
					</td>
					<td <?=checkError('packaging_id', $output_forms_verify, $ofp['ofp_id'])?>>
						<?=$ofp['packing']?>
					</td>
					<td <?=checkError('fob_value', $output_forms_verify, $ofp['ofp_id'])?>>
						<?php $fob_sum = $fob_sum + $ofp['fob_value']; ?>
						<?=$ofp['fob_value']?>
					</td>
					<td <?=checkError('freights', $output_forms_verify, $ofp['ofp_id'])?>>
						<?php $fletes_sum = $fletes_sum + $ofp['freights']; ?>
						<?=$ofp['freights']?>
					</td>
					<td <?=checkError('insurance', $output_forms_verify, $ofp['ofp_id'])?>>
						<?php $seguros_sum = $seguros_sum + $ofp['insurance']; ?>
						<?=$ofp['insurance']?>
					</td>
					<td <?=checkError('other_expenses', $output_forms_verify, $ofp['ofp_id'])?>>
						<?php $ogastos_sum = $ogastos_sum + $ofp['other_expenses']; ?>
						<?=$ofp['other_expenses']?>
					</td>
					<td <?=checkError('flag', $output_forms_verify, $ofp['ofp_id'])?>>
						<?=$ofp['flag']?>
					</td>
					<td><?php $cif_usd = ($ofp['fob_value']+$ofp['freights']+$ofp['insurance']+$ofp['other_expenses']);
					echo "$".number_format($cif_usd, 2); ?></td>
					<td><?php echo "$".number_format(round($cif_usd,2)*$output_form['exchange_rate'], 2); ?></td>
					<td class="nowrap">
						<?php 
						if ($show) {
							if ($is_nationalized) {
								?>
								<?= make_link('tbs/output_forms_products/edit?form_id='.$_GET['id'].'&id='.$ofp['ofp_id'], '<span class="icon edit"></span>', 'button edit') ?>

								<?= make_link('tbs/output_forms_products/delete?id='.$ofp['ofp_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>

								<?php 
								if ($form_state_id==10) {
									if ($ofp['product_type']==1 OR $ofp['product_type']==6) {
										echo make_link('tbs/output_forms_products/change_type?id='.$ofp['ofp_id'], '<span class="icon delete"></span>', 'button delete confirm_action');
									}
								}
								?>
								<?php
							}else{
								?>
								
								<?php
							}
						} ?>
						
					</td>
				</tr>
				<?php
			} ?>
		</tbody>
	</table>
	<h3>Totales</h3>
<table>
	<thead>
		<th>Total valor FOB</th>
		<th>Total fletes</th>
		<th>Total seguros</th>
		<th>Total otros gastos</th>
		<th>Total peso neto</th>
		<th>Total peso bruto</th>
		<th>Total CIF</th>
	</thead>
	<tr>
		<td>$<?=number_format($fob_sum, 2)?></td>
		<td>$<?=number_format($fletes_sum, 2)?></td>
		<td>$<?=number_format($seguros_sum, 2)?></td>
		<td>$<?=number_format($ogastos_sum, 2)?></td>
		<td><?=number_format($net_weight_sum, 3)?></td>
		<td><?=number_format($gross_weight_sum, 3)?></td>
		<td>$<?=number_format($fob_sum + $fletes_sum + $seguros_sum + $ogastos_sum, 2)?></td>
	</tr>
</table>
	<h3>Soportes</h3>
	<table class="datagrid">
		<thead>
			<th>Tipo</th>
			<th>Soporte</th>
			<th>Fecha</th>
			<th>Detalle</th>
			<th class="stretch">
				<?php 
				//if ($show) {
					?>
					<?= make_link('tbs/output_forms_supports/create?form_id='.$_GET['id'], '<span class="icon create"></span>', 'button dark create') ?>
					<?php //} ?>
				</th>
			</thead>
			<tbody>
				<?php foreach ($output_forms_supports as $support) {
					?>
					<tr>
						<td <?=checkError('output_form_support_type_id', $output_forms_verify, $support['supp_id'])?>><?=$support['support_type']?></td>
						<td>
							<a href="<?=BASE_URL."public/uploads/supports/output/{$_SESSION['user']['company_schema']}{$_GET['id']}/{$support['supp_id']}.{$support['file_extension']}"?>" class="button" target="_blank"> Ver adjunto</a>
						</td>
						<td <?=checkError('created_at', $output_forms_verify, $support['supp_id'])?>><?=$support['created_at']?></td>
						<td <?=checkError('details', $output_forms_verify, $support['supp_id'])?>><?=$support['details']?></td>
						<td class="nowrap">
							<?php 
							//if ($show) {
								?>
								<?= make_link('tbs/output_forms_supports/edit?form_id='.$_GET['id'].'&id='.$ofp['ofp_id'], '<span class="icon edit"></span>', 'button edit') ?>

								<?= make_link('tbs/output_forms_supports/delete?id='.$support['supp_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
								<?php //} ?>
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

			<div id="products" class="modal">
				<a id="add_products" href="javascript:;" class="button pull-right purple stretch"><span class="icon plus-circle2 white"></span> Agregar seleccionados</a>
				<?php
				$table = new Datagrid();

				$table->set_options('tbs/products', 'get_all_in_stock', 'a', 'false', 'multi');

				$table->add_column('ID Almacen', 'wid');
				$table->add_column('Formulario', 'form_id');
				$table->add_column('Producto', 'name');
				$table->add_column('Tipo', 'product_type');
				$table->add_column('Subpartida', 'tariff_heading');
				$table->add_column('Unidad', 'physical_unit');
				$table->add_column('Saldo', 'stock');

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
						products_id.push(datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['wid']+'-'+datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['form_id']);
						//console.log(products_id);
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
							"<?=BASE_URL.'tbs/output_forms_products/create_massively'?>",
							{
								form_id: <?=$_GET['id']?>,
								products_id: products_id
							},
							function(data, status)
							{
								console.log(data);
								location.href = "<?=BASE_URL.'tbs/output_forms/details?id='.$_GET['id']?>";
								
							}
							);
					}
					else
					{
						$('#add_products').hide();
					}
				});
			</script>