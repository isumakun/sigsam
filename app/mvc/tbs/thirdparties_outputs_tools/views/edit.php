<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<input type="hidden" name="output_id" value="<?=$thirdparty_output_tool['output_id']?>">
		<input type="hidden" name="tool_id" value="<?=$thirdparty_output_tool['tool_id']?>">

		<label for="quantity">Cantidad de salida:</label>
		<input name="quantity" value="<?=$thirdparty_output_tool['quantity']?>" type="text"/>

		<input class="submit" type="submit" value="Guardar" />
	</form>