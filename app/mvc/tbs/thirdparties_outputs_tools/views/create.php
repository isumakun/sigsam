<?php 
$calendar = new Calendar();
?>
	<h2>Nuevo Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="output_id">Output:</label>
		<input type="hidden" name="<?=$_GET['id']?>">

		<label for="tool_id">Tool:</label>
		<select name="tool_id">
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
		<input name="quantity" value="<?=$_POST['quantity']?>" type="text"/>

		<input class="submit" type="submit" value="Crear" />
	</form>