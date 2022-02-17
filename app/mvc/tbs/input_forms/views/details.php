<h2>Detalles Formulario de Ingreso</h2>
<?php
$show = TRUE;
if ($input_form['form_state_id']==2 OR $input_form['form_state_id']==3 OR $input_form['form_state_id']==5 OR $input_form['form_state_id']==13 OR $input_form['form_state_id']==14)
{
	$red = 'background-color:red; color:white';
	if (has_role(1)) {
		
	}else{
		$show = FALSE;
	}
}
?>
<table>
	<thead>
		<th>Estado Actual</th>
		<th>Creado por</th>
		<th>Fecha de creación</th>
		<th>Execute</th>
		<th class="stretch">Acciones</th>
	</thead>
	<tbody>
		<tr>
			<td style="<?=$red?>"><?=$input_form['state']?></td>
			<td><?=$input_form['created_by_user']?></td>
			<td><?=$input_form['created_at']?></td>
			<td><?php if ($input_form['form_state_id'] == 3) {
				if (has_role(1)) {
					?>
					<a href="#confirm" class="button dark modal"> Ejecutar</a>
					<a href="cancel?id=<?=$_GET['id']?>" class="button red modal confirm_action"> Cancelar</a>
					<?php
				}
			}elseif ($input_form['form_state_id'] == 3) {
				echo $input_form['executed_at'];
			} ?></td>
			<td class="nowrap">
<?php
				if ($input_form['form_state_id'] == 1 OR $input_form['form_state_id'] == 6 OR $input_form['form_state_id'] == 4)
				{
?>
					<?=make_link('tbs/input_forms/present?id='.$_GET['id'], '<span class="icon open"></span> Presentar', 'button dark create') ?>
<?php
				}
				else if ($input_form['form_state_id'] == 2)
				{
?>
					<?=make_link('tbs/input_forms/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span>', 'button create') ?>
					<?=make_link('tbs/input_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
<?php
				}else if ($input_form['form_state_id'] == 14)
				{
					if ($_SESSION['user']['id']==$input_form['updated_by']) {
?>
					<?=make_link('tbs/input_forms/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span> Continuar Revisión', 'button create') ?>
					<?=make_link('tbs/input_forms/liberate?id='.$_GET['id'], '<span class="icon white checkmark"></span> Liberar', 'button edit') ?>
					<?=make_link('tbs/input_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
<?php
					}else{
						?>
						<span class="button red">En revisión por <b><?=$input_form['updated_by_user']?></b></span>
						<?php
					}
				}
?>
			<a href="<?=BASE_URL?>tbs/input_forms/printout?id=<?=$_GET['id']?>" class="button dark"><span class="icon printer"></span></a>
			</td>
		</tr>
	</tbody>
</table>

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
		<th>Editar</th>
	</thead>
	<tbody>
		<tr>
			<td <?=checkError('supplier_id', $input_forms_verify)?>>
				<?=$input_form['supplier']?>
			</td>
			<td <?=checkError('exchange_rate', $input_forms_verify)?>>
				<?=$input_form['exchange_rate']?>
			</td>
			<td <?=checkError('transaction_id', $input_forms_verify)?>>
				<?=$input_form['transaction_code']?> - <?=$input_form['transaction']?>
			</td>
			<td <?=checkError('transport_type_id', $input_forms_verify)?>>
				<?=$input_form['transport']?>
			</td>
			<td <?=checkError('refundable', $input_forms_verify)?>>
				<?=($input_form['refundable'] == 1 ? 'Si' : 'No')?>
			</td>
			<td <?=checkError('packages_quantity', $input_forms_verify)?>>
				<?=$input_form['packages_quantity']?>
			</td>
			<td <?=checkError('agreement_id', $input_forms_verify)?>>
				<?=$input_form['agreement']?>
			</td>
			<td <?=checkError('flag_id_1', $input_forms_verify)?>>
				<?=$input_form['flag_1']?>
			</td>
			<td <?=checkError('flag_id_2', $input_forms_verify)?>>
				<?=$input_form['flag_2']?>
			</td>
			<td <?=checkError('flag_id_3', $input_forms_verify)?>>
				<?=$input_form['flag_3']?>
			</td>
			<td <?=checkError('flag_id_4', $input_forms_verify)?>>
				<?=$input_form['flag_4']?>
			</td>
			<td class="nowrap">
				<?php
				if ($show) {
					?>
					<?= make_link('tbs/input_forms/edit?id='.$_GET['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?php
				}
				?>
			</td>
		</tr>
	</tbody>
</table>

<h3>Productos</h3>
<?php
	if ($show)
	{
?>
		<p><span class="icon info"></span> Si desea realizar un cargue masivo de productos desde un archivo de excel, presione click en el siguiente botón: <?=make_link('tbs/input_forms_products/create_massively?form_id='.$_GET['id'], '<span class="icon white masive"></span> Masivos', 'button')?>
<?php
}
		if ($_SESSION['user']['username']=='icastro') {
			?>
			<p><span class="icon info"></span> Si desea realizar un cargue masivo de productos desde un archivo de excel, presione click en el siguiente botón: <?=make_link('tbs/input_forms_products/create_massively?form_id='.$_GET['id'], '<span class="icon white masive"></span> Masivos', 'button dark')?>
			<a href="trick_1?id=<?=$_GET['id']?>" class="button dark">Do Magic!</a>
			<?php
		}
?>

</p>
<table class="datagrid">
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
		<th>País Origen</th>
		<th class="toolbar">
			<div class="stretch nowrap">
<?php
				if ($show)
				{
					echo make_link('tbs/input_forms_products/create?form_id='.$_GET['id'], '<span class="icon create"></span>', 'button dark create').'<br/>';
				}
?>
			</div>
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
		foreach ($input_forms_products as $ifp)
		{
			?>
			<tr>
				<td <?=checkError('product_id', $input_forms_verify, $ifp['ifp_id'])?>>
					<?=$ifp['product']?>
				</td>
				<td>
					<?=$ifp['tariff_heading']?>
				</td>
				<td>
					<?=$ifp['unit_symbol']?>
				</td>
				<td>
					<?=$ifp['product_type']?>
				</td>
				<td <?=checkError('product_category_id', $input_forms_verify, $ifp['ifp_id'])?>>
					<?=$ifp['category']?>
				</td>
				<td <?=checkError('quantity', $input_forms_verify, $ifp['ifp_id'])?>>
					<?=$ifp['quantity']?>
				</td>
				<td <?=checkError('commercial_quantity', $input_forms_verify, $ifp['ifp_id'])?>>
					<?=$ifp['commercial_quantity']?>
				</td>
				<td <?=checkError('net_weight', $input_forms_verify, $ifp['ifp_id'])?>>
					<?php $net_weight_sum = $net_weight_sum + $ifp['net_weight']; ?>
					<?=$ifp['net_weight']?>
				</td>
				<td <?=checkError('gross_weight', $input_forms_verify, $ifp['ifp_id'])?>>
					<?php $gross_weight_sum = $gross_weight_sum + $ifp['gross_weight']; ?>
					<?=$ifp['gross_weight']?>
				</td>
				<td <?=checkError('packaging_id', $input_forms_verify, $ifp['ifp_id'])?>>
					<?=$ifp['packing']?>
				</td>
				<td <?=checkError('unit_value', $input_forms_verify, $ifp['ifp_id'])?>>
					$<?=number_format($ifp['unit_value'], 4)?>
				</td>
				<td <?=checkError('fob_value', $input_forms_verify, $ifp['ifp_id'])?>>
					<?php $fob_sum = $fob_sum + $ifp['fob_value']; ?>
					$<?=number_format($ifp['fob_value'], 4)?>
				</td>
				<td <?=checkError('freights', $input_forms_verify, $ifp['ifp_id'])?>>
					<?php $fletes_sum = $fletes_sum + $ifp['freights']; ?>
					$<?=number_format($ifp['freights'], 4)?>
				</td>
				<td <?=checkError('insurance', $input_forms_verify, $ifp['ifp_id'])?>>
					<?php $seguros_sum = $seguros_sum + $ifp['insurance']; ?>
					$<?=number_format($ifp['insurance'], 4)?>
				</td>
				<td <?=checkError('other_expenses', $input_forms_verify, $ifp['ifp_id'])?>>
					<?php $ogastos_sum = $ogastos_sum + $ifp['other_expenses']; ?>
					$<?=number_format($ifp['other_expenses'], 4)?>
				</td>
				<td <?=checkError('flag_id', $input_forms_verify, $ifp['ifp_id'])?>>
					<?=$ifp['flag']?>
				</td>
				<td class="nowrap">
					<?php
					if ($show) {
						?>
						<?= make_link('tbs/input_forms_products/edit?form_id='.$_GET['id'].'&id='.$ifp['ifp_id'], '<span class="icon edit"></span>', 'button edit') ?>

						<?= make_link('tbs/input_forms_products/delete?id='.$ifp['ifp_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
						<?php
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
	</thead>
	<tr>
		<td>$<?=number_format($fob_sum, 4)?></td>
		<td>$<?=number_format($fletes_sum, 4)?></td>
		<td>$<?=number_format($seguros_sum, 4)?></td>
		<td>$<?=number_format($ogastos_sum, 4)?></td>
		<td><?=number_format($net_weight_sum, 1)?></td>
		<td><?=number_format($gross_weight_sum,1)?></td>
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
			if ($show) {
				?>
				<?= make_link('tbs/input_forms_supports/create?form_id='.$_GET['id'], '<span class="icon create"></span>', 'button dark create') ?>
				<?php
			}else{
				if (has_role(3)) {
					?>
					<?= make_link('tbs/input_forms_supports/create?form_id='.$_GET['id'], '<span class="icon create"></span>', 'button dark create') ?>
					<?php
				}
			}
			?>
		</th>
	</thead>
	<tbody>
		<?php foreach ($input_forms_supports as $support) {
			?>
			<tr>
				<td <?=checkError('input_form_support_type_id', $input_forms_verify, $support['supp_id'])?>>
					<?=$support['support_type']?>
				</td>
				<td><a href="<?=BASE_URL."public/uploads/supports/input/{$_SESSION['user']['company_schema']}{$_GET['id']}/{$support['supp_id']}.{$support['file_extension']}"?>" class="button" target="_blank"> Ver adjunto</a></td>
				<td <?=checkError('created_at', $input_forms_verify, $support['supp_id'])?>><?=$support['created_at']?></td>
				<td <?=checkError('details', $input_forms_verify, $support['supp_id'])?>><?=$support['details']?></td>
				<td class="nowrap">
					<?php
					if ($show) {
						?>
						<?= make_link('tbs/input_forms_supports/edit?form_id='.$_GET['id'].'&id='.$support['supp_id'], '<span class="icon edit"></span>', 'button edit') ?>

						<?= make_link('tbs/input_forms_supports/delete?id='.$support['supp_id'].'&form_id='.$_GET['id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
						<?php
					}
					if (has_role(3)) {
							?>
							<?= make_link('tbs/input_forms_supports/edit?form_id='.$_GET['id'].'&id='.$support['supp_id'], '<span class="icon edit"></span>', 'button edit') ?>

							<?= make_link('tbs/input_forms_supports/delete?id='.$support['supp_id'].'&form_id='.$_GET['id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
							<?php
					}
				?>
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

<h3>Inspecciones</h3>
<table class="datagrid">
	<thead>
		<th>Producto</th>
		<th>Fecha Inspección</th>
		<th>Observación</th>
	</thead>
	<tbody>
		<?php foreach ($inspections as $product) {
			?>
			<tr>
				<td><?=$product['product']?></td>
				<td><?=$product['inspected_at']?></td>
				<td><?=$product['observations']?></td>
			</tr>
			<?php
		} ?>
	</tbody>
</table>
<div id="confirm" class="modal small">
	<center>
		<p style="text-align: center !important; font-size: 14px"><b>¿Seguro que desea ejecutar este formulario?<br><span style="color: red">Todos los productos que no hallan ingresado pasaran al almacen diferencia en báscula</span></b></p>
		<a href="execute?id=<?=$_GET['id']?>" class="button create">Si, ejecutar el formulario</a>
	</center>
</div>
