<h2>Editar Producto</h2>
	<form method="POST">
		<input type="hidden" name="form_id" value="<?=$_GET['form_id']?>">

		<label>Saldo Actual: <?=$transport_output_form_product['inspected_to_output']?></p></label>

		<input type="hidden" name="warehouse_id" value="<?=$transport_output_form_product['warehouse_id']?>">
		<label>Cantidad</label>
		<input required type="text" name="quantity" value="<?=$transport_output_form_product['quantity']?>">
		<input type="hidden" name="old_quantity" value="<?=$transport_output_form_product['quantity']?>">
		<input type="hidden" name="balance" value="<?=$transport_output_form_product['inspected_to_output']?>">

		<input type="submit" value="Enviar">
	</form>