<h2>Inspeccionar Productos de Entrada</h2>

<style>
.color_0 {
	width: 10px;
	background-color: #E74C3C;
	color: #E74C3C;
}

.color_1,
.color_2 {
	width: 10px;
	background-color: #2ECC71;
	color: #2ECC71;
}
</style>

<a id="add_products" href="#observations" class="modal button pull-right disabled stretch"><span class="icon plus-circle2 white"></span> Inspeccionar productos</a>
<?php if ($_SESSION['user']['username']=='icastro') {
	?>
	<a href="#inspect_all" class="button dark modal pull-right">Inspeccionar todos los de un FMM</a>
	<?php
} ?>

<div id="inspect_all" class="modal">
	<form method="POST" action="<?=BASE_URL?>tbs/input_forms_inspections_products/inspect_all">
		<input type="text" name="input_form_id" placeholder="Número de formulario" min="0">
		<input type="text" name="observation" placeholder="Observación">
		<input type="text" name="inspected_by" placeholder="Inspeccionado por">
		<input type="text" name="inspected_at" placeholder="Fecha Inspección">
		<input type="submit" value="Inspeccioname toda esa vaina" class="button">
	</form>
</div>

<?php
$table = new Datagrid();

$table->set_options('tbs/products', 'get_all_in_locked', 'a', 'false', 'multi');

$table->add_column('ID Almacen', 'wid');
$table->add_column('Formulario', 'form_id');
$table->add_column('Producto', 'name');
$table->add_column('Subpartida', 'tariff_heading');
$table->add_column('Unidad', 'physical_unit');
$table->add_column('Saldo', 'locked');

$table->render();
?>

<script>

	var warehouses_id = new Array();
	var observations = new Array();
	var max = 0;

	$('table#datagrid_0').on('click', 'tr', function()
	{
		var count = 0;
		warehouses_id = [];
		$('#ob_fields tbody').empty();
		$(this).toggleClass('selected');
		

		for ($i = 0; $i < datatable_0.rows('.selected')[0].length; $i++)
		{
			warehouses_id.push(datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['wid']);
			add_obs(datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['wid'], datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['form_id'], datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['name'], count);
			//console.log(warehouses_id);
			count++;
		}

		max = count;

		$('#add_products').addClass('disabled');
		//console.log(warehouses_id.length);
		if (warehouses_id.length > 0)
		{
			$('#add_products').removeClass('disabled');
		}
	});

	function send_form(){
		
		//console.log(observations);
		//console.log(warehouses_id);
		
		for (var i = 0; i < max; i++) {
			observations.push($('#observation_'+i).val());
		}

		console.log(observations);

		if ($('table#datagrid_0 tr.selected').length)
		{
			$('#add_products').hide();
			$.post(
				"<?=BASE_URL.'tbs/input_forms_inspections_products/create_massively'?>",
				{
					warehouses_id: warehouses_id,
					observations: observations
				},
				function(data, status)
				{
					console.log(data);
					location.href = "<?=BASE_URL.'tbs/input_forms_inspections_products/'?>";
				}
				);
		}
		else
		{
			//$('#add_products').hide();
		}
	}

	function add_obs(wid, form_id, product, count){
		$('#ob_fields tbody').append('<tr>'+
			'<td>'+wid+'</td>'+
			'<td>'+form_id+'</td>'+
			'<td>'+product+'</td>'+
			'<td>'+
			'<textarea id="observation_'+count+'"></textarea>'+
			'</td>');
	}
</script>

<div id="observations" class="modal">
	<table id="ob_fields">
		<thead>
			<th>ID Almacen</th>
			<th>Formulario</th>
			<th>Producto</th>
			<th>Observación</th>
		</thead>
		<tbody>
			
		</tbody>
	</table>
	<button onclick="send_form()" class="button">Terminar Inspección</button>
</div>