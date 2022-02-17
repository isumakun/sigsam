<h2>Inspeccionar Productos de Salida</h2>


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

<a id="add_products" href="javascript:;" class="button pull-right disabled stretch"><span class="icon plus-circle2 white"></span> Inspeccionar productos</a>
<?php if (has_role(3)) {
	?>
	<a id="recover_products" href="#observations" class="button pull-right disabled stretch red modal"><span class="icon plus-circle2 white"></span> Devolver</a>
	<?php
} ?>
		<?php
		$table = new Datagrid();

		$table->set_options('tbs/products', 'get_all_for_output_inspection', 'a', 'false', 'multi');

		$table->add_column('ID Almacen', 'wid');
		$table->add_column('Formulario', 'output_form_id');
		$table->add_column('Producto', 'name');
		$table->add_column('Subpartida', 'tariff_heading');
		$table->add_column('Unidad', 'physical_unit');
		$table->add_column('Saldo', 'approved');
		$table->add_column('Lugar de Inspección', 'place');
		$table->add_column('Solicitado a las', 'requested_at');

		$table->render();
	?>

<script>

	var warehouses_id = new Array();

	$('table#datagrid_0').on('click', 'tr', function()
	{
		warehouses_id = [];

		$(this).toggleClass('selected');
		
		for ($i = 0; $i < datatable_0.rows('.selected')[0].length; $i++)
		{
			warehouses_id.push(datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['wid']+'-'+datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['output_form_id']);

			//console.log(warehouses_id);
			//console.log(warehouses_id);
		}

		$('#add_products').addClass('disabled');
		//console.log(warehouses_id.length);
		if (warehouses_id.length > 0)
		{
			$('#add_products').removeClass('disabled');
			$('#recover_products').removeClass('disabled');
		}
	});

	$('#add_products').click(function()
	{
		$('#loading').show();
		
		if ($('table#datagrid_0 tr.selected').length)
		{
			$.post(
				"<?=BASE_URL.'tbs/output_forms_inspections_products/create_massively'?>",
				{
					warehouses_id: warehouses_id
				},
				function(data, status)
				{
					console.log(data);
					location.href = "<?=BASE_URL.'tbs/output_forms_inspections_products/'?>";
				}
			);
		}
		else
		{
			//$('#add_products').hide();
		}
	});

	function send_form(){
		
		//console.log(observations);
		//console.log(warehouses_id);

		if ($('table#datagrid_0 tr.selected').length)
		{
			$.post(
				"<?=BASE_URL.'tbs/output_forms_inspections_products/recover'?>",
				{
					warehouses_id: warehouses_id,
					observations: $('#observation').val()
				},
				function(data, status)
				{
					console.log(data);
					location.href = "<?=BASE_URL.'tbs/output_forms_inspections_products/'?>";
				}
				);
		}
		else
		{
			//$('#add_products').hide();
		}
	}
</script>

<div id="observations" class="modal">
	<label>Motivo de devolución:</label>
	<textarea id="observation"></textarea>
	<button onclick="send_form()" class="button">Devolver</button>
</div>