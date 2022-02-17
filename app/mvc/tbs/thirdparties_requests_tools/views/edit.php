<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<input type="hidden" name="request_id" value="<?=$thirdparty_request_tool['request_id']?>">
		

		<label for="tool_id">Herramienta, Equipo o Material:</label>
		<input 	name="tool_id" 
		value=<?=$thirdparty_request_tool['tool_id']?>" 
		class="populate"
		data-modal="tools"
		data-label="<?=$thirdparty_request_tool['tool']?>"
		>

		<label for="quantity">Cantidad:</label>
		<input name="quantity" value="<?=$thirdparty_request_tool['quantity']?>" type="text"/>

		<label for="physical_unit">Unidad de medida:</label>
		<select name="physical_unit" class="select2">
<?php
				foreach($physical_units AS $unit)
				{
?>
			<option value="<?=$unit['id']?>" <?=($thirdparty_request_tool['physical_unit'] == $unit['id'] ? 'selected' : '')?>><?=$unit['symbol']?> - <?=$unit['unit']?></option>
<?php
				}
?>
		</select>

		<input class="submit" type="submit" value="Guardar" />
	</form>

<div id="tools" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Nombre</th>
			<th class="stretch"><a href="<?=BASE_URL?>tbs/thirdparties_tools/create" class="button create dark"><span class="icon create"></span></a></th>
		</thead>
		<?php
		foreach ($tools as $tool) {
			?>
			<tr>
				<td><?=$tool['id']?></td>
				<td><?=$tool['name']?></td>
				<td class="nowrap"><a href="javascript:;"
					class="button open populate"
					data-values="<?=$tool['id']?>"
					data-labels="<?=$tool['name']?>"
					data-elements="tool_id"><span class="icon open"></span></a>
					<?= make_link('tbs/thirdparties_tools/edit?id='.$company['id'], '<span class="icon edit"></span>', 'button edit') ?>
					<?= make_link('tbs/thirdparties_tools/delete?id='.$company['id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
				</td>
				</tr>
				<?php
			} ?>
		</table>
	</div>