<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="request_id">Request:</label>
		<select disabled name="request_id">
<?php
				foreach($thirdparties_requests AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($thirdparty_request_tool['request_id'] == $t['id'] ? 'selected' : '')?>><?=$t['company_id']?></option>
<?php
				}
?>
		</select>

		<label for="tool_id">Tool:</label>
		<select disabled name="tool_id">
<?php
				foreach($thirdparties_tools AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($thirdparty_request_tool['tool_id'] == $t['id'] ? 'selected' : '')?>><?=$t['name']?></option>
<?php
				}
?>
		</select>

		<label for="quantity">Quantity:</label>
		<input disabled name="quantity" value="<?=$thirdparty_request_tool['quantity']?>" type="text"/>

	</form>