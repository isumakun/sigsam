<h2>Nuevo producto</h2>

<form method='POST'>

	<label>Nombre</label>
	<input name='name' required />

	<label>Código Interfaz</label>
	<input type="text" name="interface_code">

	<label>Tipo</label>
	<select name="product_type_id">
		<?php
		foreach ($products_types as $pt) {
			?>
			<option value="<?=$pt['id']?>"><?=$pt['name']?></option>
			<?php
		} ?>
	</select>

	<label>Subpartida</label>
	<input name="tariff_heading_id"
		value="<?=$created_product[0]?>"
		class="populate"
		data-modal="tariff_heading"
		data-label="<?=$created_product[1]?>"
		>	

	<label>Unidad de Manejo</label>
	<select class="select2" name="physical_unit_id">
		<?php 
		foreach ($physical_units as $pu) {
			?>
			<option value="<?=$pu['id']?>"><?=$pu['symbol']?> - <?=$pu['unit']?></option>
			<?php
		} ?>
	</select>

	<input class="submit" type="submit" value="Agregar" />

</form>

<div id="tariff_heading" class="modal">
	<table class="datagrid">
		<thead>
			<th>Código</th>
			<th>Descripción</th>
			<th>Unidad</th>
			<th></th>
		</thead>
		<?php
		foreach ($tariff_headings as $th) {
			?>
			<tr>
				<td><?=$th['code']?></td>
				<td><?=$th['description']?></td>
				<td><?=$th['physical_unit']?></td>
				<td><a href="javascript:;"
					class="button open populate"
					data-values="<?=$th['id']?>"
					data-labels="<?=$th['code']?> - <?=$th['description']?>"
					data-elements="tariff_heading_id"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>