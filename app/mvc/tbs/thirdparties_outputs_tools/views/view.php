<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="output_id">Output:</label>
		<select disabled name="output_id">
<?php
				foreach($thirdparties_outputs AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($thirdparty_output_tool['output_id'] == $t['id'] ? 'selected' : '')?>><?=$t['request_id']?></option>
<?php
				}
?>
		</select>

		<label for="tool_id">Tool:</label>
		<select disabled name="tool_id">
<?php
				foreach($thirdparties_requests_tools AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($thirdparty_output_tool['tool_id'] == $t['id'] ? 'selected' : '')?>><?=$t['request_id']?></option>
<?php
				}
?>
		</select>

		<label for="quantity">Quantity:</label>
		<input disabled name="quantity" value="<?=$thirdparty_output_tool['quantity']?>" type="text"/>

	</form>