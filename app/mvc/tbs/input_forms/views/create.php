<h2>Nuevo Formulario de Ingreso</h2>
<?php 
$created_supplier = get_messages('supplier');
?>
<form method='POST' class="full-width">
	<h3>Información General</h3>

		<label>Proveedor</label>
		<input 	name="supplier_id" 
		value="<?=$created_supplier[0]?>" 
		class="populate"
		data-modal="suppliers"
		data-label="<?=$created_supplier[1]?>"
		>

		<label>TRM</label>
		<input name="exchange_rate" type="text" value="<?=$exchange_rate['exchange_rate']?>" required />

		<label>Transacción</label>
		<input 	name="transaction_id" 
		value="" 
		class="populate"
		data-modal="transactions"
		data-label=""
		>

		<label>Tipo Transporte</label>
		<select required name="transport_type_id">
			<option></option>
			<?php
			foreach ($transport_types as $tt) {
				?>
				<option value="<?=$tt['id']?>"><?=$tt['id']?> - <?=$tt['name']?></option>
				<?php
			} ?>
		</select>

		<label>Reembolsable</label>
		<select required name="refundable">
			<option></option>
			<option value="1">Si</option>
			<option value="0">No</option>
		</select>

		<label>Número de Acuerdo</label>
		<select name="agreement_id">
			<option></option>
			<?php
			foreach ($agreements as $ag) {
				?>
				<option value="<?=$ag['id']?>"><?=$ag['id']?> - <?=$ag['name']?></option>
				<?php
			} ?>
		</select>

		<label>Cantidad Bultos</label>
		<input type="text" name="packages_quantity">

	<div class="w25">
		<label>País Compra</label>
		<select required name="flag_id_1" class="select2">
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>"><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	</div>

	<div class="w25">
		<label>País Destino</label>
		<select required name="flag_id_2" class="select2">
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>"><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	</div>
	<div class="w25">
		<label>País de Procedencia</label>
		<select required name="flag_id_3" class="select2">
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>"><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	</div>
	<div class="w25">
		<label>Bandera</label>
		<select required name="flag_id_4" class="select2">
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>"><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	</div>
	<br>

	<input class="submit" value="Guardar" type="submit"/>
</form>
<div id="suppliers" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Nit</th>
			<th>Proveedor</th>
			<th class="stretch"><a href="<?=BASE_URL?>/suppliers/create" class="button create dark"><span class="icon create"></span> Nuevo</a></th>
		</thead>
		<?php
		foreach ($suppliers as $supplier) {
			?>
			<tr>
				<td><?=$supplier['id']?></td>
				<td><?=$supplier['nit']?></td>
				<td><?=$supplier['name']?></td>
				<td class="nowrap">
					<a href="javascript:;"
					class="button open populate"
					data-values="<?=$supplier['id']?>"
					data-labels="<?=$supplier['name']?>"
					data-elements="supplier_id"><span class="icon open"></span></a>
					<?= make_link('tbs/suppliers/edit?id='.$supplier['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?php if (has_role(3)) {
						?>
						<?= make_link('tbs/suppliers/delete?id='.$supplier['id'], '<span class="icon delete"></span>', 'button delete confirm_action confirm_action') ?>
						<?php
					} ?>
				</td>
				</tr>
				<?php
			} ?>
		</table>
	</div>
<div id="transactions" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Descripción</th>
			<th class="stretch"></th>
		</thead>
		<?php
		foreach ($input_forms_transactions as $transaction) {
			?>
			<tr>
				<td><?=$transaction['id']?></td>
				<td><?=$transaction['name']?></td>
				<td class="nowrap">
					<a href="javascript:;"
					class="button open populate"
					data-values="<?=$transaction['id']?>"
					data-labels="<?=$transaction['id']?> - <?=$transaction['name']?>"
					data-elements="transaction_id"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	</div>