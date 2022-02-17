<?php 
$calendar = new Calendar();
?>
<h2>Reporte Valor FOB</h2>
<?php if (!$input_data) {
	?>
<form method='POST'>

	<div class="">
		<label for="init_date">Año:</label>
		<input type="number" name="year">
	</div>
	<label></label>
	<input type="submit" value="Generar Reporte" />

</form>
	<?php
}else{
	echo "ENERO <br>";
	foreach ($input_data as $companies) {
		foreach ($companies as $company) {
			echo '<pre>'.print_r($company, TRUE).'</pre>';
			die();
		}
	}
} ?>

