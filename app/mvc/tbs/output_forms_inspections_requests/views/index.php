<h2>Solicitud de inspección de productos de salida</h2>


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

<a id="add_products" href="#observations" class="modal button pull-right disabled stretch"><span class="icon plus-circle2 white"></span> Solicitar Inspección</a>

<a href="dashboard/turns" class="button dark pull-right">Ver Turnos</a>
<!--<a href="#inspect_all" class="button dark modal pull-right stretch" style="margin-right: 5px"><span class="icon inspection white"></span> Solicitar por número de FMM</a>-->

<div id="inspect_all" class="modal">
	<form method="POST" action="<?=BASE_URL?>tbs/input_forms_inspections_requests/inspect_all">
		<input type="text" name="input_form_id" placeholder="Número de formulario de entrada" min="0">
		<input type="submit" value="Inspeccionar" class="button">
	</form>
</div>

<?php
$table = new Datagrid();

$table->set_options('tbs/products', 'get_all_approved', 'a', 'false', 'multi');

$table->add_column('ID Almacen', 'wid');
$table->add_column('Formulario', 'output_form_id');
$table->add_column('Producto', 'name');
$table->add_column('Subpartida', 'tariff_heading');
$table->add_column('Unidad', 'physical_unit');
if ($_SESSION['user']['company_schema']!='tbs3_900324176') {
	$table->add_column('Cantidad', 'approved');
}else{
	$table->add_column('Cantidad', 'quantity');
}

$table->render();
?>

<script>

	var warehouses_id = new Array();
	var observations = new Array();
	var count = 0;

	$('table#datagrid_0').on('click', 'tr', function()
	{
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

		$('#add_products').addClass('disabled');
		//console.log(warehouses_id.length);
		if (warehouses_id.length > 0)
		{
			$('#add_products').removeClass('disabled');
		}
	});

	function send_form(){

		if ($('table#datagrid_0 tr.selected').length)
		{
			$.post(
				"<?=BASE_URL.'tbs/output_forms_inspections_requests/create_massively'?>",
				{
					warehouses_id: warehouses_id,
					observations: $('#place').val()
				},
				function(data, status)
				{
					console.log(data);
					location.href = "<?=BASE_URL.'tbs/output_forms_inspections_requests/'?>";
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
			'<td>'+product+'</td>');
	}
</script>

<div id="observations" class="modal">
	<h3>Revise los productos a solicitar inspección:</h3>
	<table id="ob_fields">
		<thead>
			<th>ID Almacen</th>
			<th>Formulario</th>
			<th>Producto</th>
		</thead>
		<tbody></tbody>
	</table>
	<label>Lugar de la inspección:</label>
	<input type="text" required id="place">
	<br><br>
	<button onclick="send_form()" class="button">Solicitar</button>
</div>