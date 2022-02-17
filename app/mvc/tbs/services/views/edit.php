<h2>Nuevo Registro de Servicio</h2>
<?php 
$calendar = new Calendar();
$created_supplier = get_messages('supplier');
$created_concept = get_messages('concept');
?>
<form method='POST'>

	<label>Tipo de servicio</label>
	<select name="service_type">
		<option value="1">Ingreso</option>
		<option <?php if ($service['service_type']==2) {
			echo "selected";
		} ?> value="2">Egreso</option>
	</select>

	<div>
		<label id="name">Cliente</label>
		<input 	name="supplier_id" 
		value="<?=$service['supplier_id']?>" 
		class="populate"
		data-modal="suppliers"
		data-label="<?=$service['supplier']?>"
		>

		<label>Factura</label>
		<input type="text" value="<?=$service['bill_number']?>" name="bill_number">

		<label>Fecha Factura</label>
		<?=$calendar->render('bill_date', $service['bill_date'])?>

		<label for="concepts">Conceptos:</label>
		<select id="select" name="concepts[]" class="select2" multiple>
<?php
				foreach($concepts AS $concept)
				{
					$selected = '';
					foreach ($services_concepts as $sc) {
						if ($sc['concept_id']==$concept['id']) {
							$selected = 'selected';
						}
					}
					?>
						<option value="<?=$concept['id']?>" <?=$selected?> ><?=$concept['name']?></option>
					<?php
				}
?>
		</select>

		<a href="#concepts" class="button dark modal">Lista Conceptos</a>

		<label>Valor</label>
		<input type="text" value="<?=$service['cost']?>" name="cost">

		<input class="submit" type="submit" value="Guardar" />
	</div>

</form>
<script type="text/javascript">
	$('#select').trigger('change');
</script>
<div id="suppliers" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Nit</th>
			<th>Proveedor</th>
			<th class="stretch"><a href="<?=BASE_URL?>/suppliers/create" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($suppliers as $supplier) {
			?>
			<tr>
				<td><?=$supplier['id']?></td>
				<td><?=$supplier['nit']?></td>
				<td><?=$supplier['name']?></td>
				<td class="nowrap">
					<?= make_link('tbs/suppliers/edit?id='.$supplier['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?= make_link('tbs/suppliers/delete?id='.$supplier['id'], '<span class="icon delete"></span>', 'button delete confirm_action confirm_action') ?>
						
					<a href="javascript:;"
					class="button open populate"
					data-values="<?=$supplier['id']?>"
					data-labels="<?=$supplier['name']?>"
					data-elements="supplier_id"><span class="icon open"></span></a>
					</td>
				</tr>
				<?php
			} ?>
		</table>
	</div>
	<div id="concepts" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Nombre</th>
			<th class="stretch"><a href="<?=BASE_URL?>/concepts/create" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($concepts as $concept) {
			?>
			<tr>
				<td><?=$concept['id']?></td>
				<td><?=$concept['name']?></td>
				<td class="nowrap">
					<?= make_link('tbs/concepts/edit?id='.$concept['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?= make_link('tbs/concepts/delete?id='.$concept['id'], '<span class="icon delete"></span>', 'button delete confirm_action confirm_action') ?></td>
				</tr>
				<?php
			} ?>
		</table>
	</div>
<script type="text/javascript">
	$('#type').on('change', function(){
		if ($('#type :selected').val()==1) {
			$('#name').html('Cliente');
			$('#info').show()
		}else if ($('#type :selected').val()==2) {
			$('#name').html('Proveedor');
			$('#info').show()
		}
	})
</script>
