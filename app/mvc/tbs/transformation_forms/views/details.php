<h2>Detalles Formulario de Transformación</h2>
<?php 
$show = TRUE;
if ($transformation_form['form_state_id']==2 OR $transformation_form['form_state_id']==3 OR $transformation_form['form_state_id']==5 OR $transformation_form['form_state_id']==14) {
	$show = FALSE;
}
?>
<table>
	<thead>
		<th>Estado</th>
		<th>Usuario</th>
		<th>Fecha</th>
		<th class="stretch">Acciones</th>
	</thead>
	<tbody>
		<tr>
			<td><?=$transformation_form['state']?></td>
			<td><?=$transformation_form['created_by']?></td>
			<td><?=$transformation_form['created_at']?></td>
			<td class="nowrap">
				<a href="<?=BASE_URL?>tbs/transformation_forms/printout?id=<?=$_GET['id']?>" target="_blank" class="button dark"><span class="icon printer"></span></a>
				<?php
				if ($transformation_form['form_state_id']==1 || $transformation_form['form_state_id']==6 || $transformation_form['form_state_id']==4) 
				{
					?>
					<?= make_link('tbs/transformation_forms/present?id='.$_GET['id'], '<span class="icon open"></span> Presentar', 'button dark create') ?>
					<?php
				}else if ($transformation_form['form_state_id']==2){
					?>
					<?= make_link('tbs/transformation_forms/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span>', 'button create') ?>
					<?= make_link('tbs/transformation_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
					<?php
				}else if ($transformation_form['form_state_id'] == 14)
				{
					if ($_SESSION['user']['id']==$input_form['updated_by']) {
?>
					<?=make_link('tbs/transformation_forms/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span> Continuar Revisión', 'button create') ?>
					<?=make_link('tbs/transformation_forms/liberate?id='.$_GET['id'], '<span class="icon white checkmark"></span> Liberar', 'button edit') ?>
					<?=make_link('tbs/transformation_forms/recover?id='.$_GET['id'], '<span class="icon cancel"></span>', 'button delete confirm_action') ?>
<?php
					}else{
						?>
						<span class="button red">En revisión por <b><?=$transformation_form['updated_by_user']?></b></span>
						<?php
					}
				}
				?>
			</td>
		</tr>
	</tbody>
</table>

<h3>Insumos</h3>
<table>
	<thead>
		<th>ID Almacen</th>
		<th>Insumo</th>
		<th>Cantidad</th>
		<th>Desperdicio</th>
		<th class="stretch">
			<?php 
			if ($show) {
				?>
				<?= make_link('tbs/transformation_forms_consumables/create?form_id='.$_GET['id'], '<span class="icon create"></span>', 'button dark create') ?>
				<?php } ?>
			</th>
		</thead>
		<tbody>
			<?php foreach ($transformation_forms_consumables as $consumable) {
				?>
				<tr>
					<td><?=$consumable['warehouse_id']?></td>
					<td <?=checkError('warehouse_id', $transformation_forms_verify, $consumable['tfc_id'])?>>
						<?=$consumable['consumable']?>
					</td>
					<td <?=checkError('quantity', $transformation_forms_verify, $consumable['tfc_id'])?>>
						<?=$consumable['quantity']?>
					</td>
					<td <?=checkError('waste', $transformation_forms_verify, $consumable['tfc_id'])?>>
						<?= $consumable['product_waste'] ?>
					</td>
					<td class="nowrap">
						<?php 
						if ($show) {
							?>
							<?= make_link('tbs/transformation_forms_consumables/edit?form_id='.$_GET['id'].'&id='.$consumable['tfc_id'], '<span class="icon edit"></span>', 'button edit') ?>

							<?= make_link('tbs/transformation_forms_consumables/delete?id='.$consumable['tfc_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
							<?php } ?>
						</td>
					</tr>
					<?php
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
				<th class="stretch">
					<?php 
					if ($show) {
						?>
						<?= make_link('tbs/transformation_forms_products/create?form_id='.$_GET['id'], '<span class="icon create"></span>', 'button dark create') ?>
						<?php } ?>
					</th>
				</thead>
				<tbody>
					<?php 
					foreach ($transformation_forms_products as $tfp) 
					{
						?>
						<tr>
							<td <?=checkError('product_id', $transformation_forms_verify, $tfp['tfp_id'])?>>
								<?=$tfp['product']?>
							</td>
							<td <?=checkError('product_type_id', $transformation_forms_verify, $tfp['tfp_id'])?>>
								<?=$tfp['product_type']?>
							</td>
							<td <?=checkError('quantity', $transformation_forms_verify, $tfp['tfp_id'])?>>
								<?=$tfp['quantity']?>
							</td>
							<td <?=checkError('fob_value', $transformation_forms_verify, $tfp['tfp_id'])?>>
								<?=$tfp['fob_value']?>
							</td>
							<td <?=checkError('is_principal', $transformation_forms_verify, $tfp['tfp_id'])?>>
								<?php
								if ($tfp['is_principal']==1) {
									echo "Principal";
								}else if ($tfp['is_principal']==2) {
									echo "Subproducto";
								}
								?>
							</td>
							<td class="nowrap">
								<?php 
								if ($show) {
									?>
									<?= make_link('tbs/transformation_forms_products/edit?form_id='.$_GET['id'].'&id='.$tfp['tfp_id'], '<span class="icon edit"></span>', 'button edit') ?>

									<?= make_link('tbs/transformation_forms_products/delete?id='.$tfp['tfp_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
									<?php } ?>
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
				<?= make_link('tbs/transformation_forms_supports/create?form_id='.$_GET['id'], '<span class="icon create"></span> Agregar', 'button dark create') ?>
				<?php 
			}

			if (has_role(1)) {
				?>
				<?= make_link('tbs/transformation_forms_supports/create?form_id='.$_GET['id'], '<span class="icon create"></span> Agregar', 'button dark create') ?>
				<?php 
			}
			?>
		</th>
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
				<td class="nowrap">
					<?php 
					if ($show) {
						?>
						<?= make_link('tbs/transformation_forms_supports/edit?form_id='.$_GET['id'].'&id='.$support['supp_id'], '<span class="icon edit"></span>', 'button edit') ?>

						<?= make_link('tbs/transformation_forms_supports/delete?id='.$support['supp_id'].'&form_id='.$_GET['id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
						<?php 
					}

					if (has_role(1)) {
					 	?>
						<?= make_link('tbs/transformation_forms_supports/edit?form_id='.$_GET['id'].'&id='.$support['supp_id'], '<span class="icon edit"></span>', 'button edit') ?>

						<?= make_link('tbs/transformation_forms_supports/delete?id='.$support['supp_id'].'&form_id='.$_GET['id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
						<?php 
					 } ?>
				</td>
			</tr>
			<?php
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
			<td <?=checkError('man_power', $transformation_forms_verify)?>>
				<?=$transformation_form['man_power']?></td>
			<td <?=checkError('utility', $transformation_forms_verify)?>>
				<?=$transformation_form['utility']?></td>
			<td <?=checkError('direct_cost', $transformation_forms_verify)?>>
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
