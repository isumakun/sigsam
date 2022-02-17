<h2>Saber en qué formulario de salida está:</h2>
<?php if (!$products) {
	?>
<form method='POST'>

	<label>VIN</label>
	<input name="vin" required />

	<input type="submit"/>

</form>
	<?php
}else{
	foreach ($products as $product) {
		?>
		<h2>El carro está en el formulario de salida #<?=$product['output_form_id']?></h2>
		<a href="<?=BASE_URL.'tbs/output_forms/details?id='.$product['output_form_id']?>" class="button">Ir al formulario</a>
		<?php
	}
} ?>

