<h2>Inspeccionar Entrada de equipos, materiales y herramientas</h2>

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

<a id="add_products" href="#observations" class="modal button pull-right disabled stretch"><span class="icon plus-circle2 white"></span> Inspeccionar</a>

<table id="datagrid_0" class="datagrid" data-page-length='10'>
		<thead>
			<th>Nit</th>
			<th>Usuario</th>
			<th># Solicitud</th>
			<th>Empresa</th>
			<th>ID Herramienta</th>
			<th>Herramienta</th>
			<th>Cantidad</th>
			<th>Unidad</th>
		</thead>
		<?php 
		foreach ($tools as $tool) {
			foreach ($tool as $t) {
				?>
				<tr>
					<td><?=$t['nit']?></td>
					<td><?=$t['user']?></td>
					<td>SOL-<?=$t['request_id']?></td>
					<td><?=$t['company']?></td>
					<td><?=$t['id']?></td>
					<td><?=$t['tool']?></td>
					<td><?=$t['quantity']?></td>
					<td><?=$t['unit']?></td>
				</tr>
				<?php
			}
		}
		?>
</table>
<script>

	var tools_ids = new Array();
	var datatable_0 = $('#datagrid_0').Datagrid;
	var observations = new Array();
	var count = 0;
	$('#ob_fields tbody').empty();

	$('table#datagrid_0').on('click', 'tr', function()
	{
		$(this).toggleClass('selected');
		
		var nit = $(this).closest("tr").find('td:eq(0)').text();
		var company = $(this).closest("tr").find('td:eq(1)').text();
		var tool_id = $(this).closest("tr").find('td:eq(4)').text();
		var request_id = $(this).closest("tr").find('td:eq(2)').text();
		var name = $(this).closest("tr").find('td:eq(5)').text();

   		tools_ids.push(nit+' - '+tool_id);
   		add_obs(tool_id, request_id, name, count, company);
		//console.log(warehouses_id);
		count++;

   		console.log(tool_id);
		$('#add_products').addClass('disabled');
		//console.log(tools_ids.length);
		if (tools_ids.length > 0)
		{
			$('#add_products').removeClass('disabled');
		}
	});

	function send_form(type){
		
		//console.log(observations);
		//console.log(warehouses_id);
		
		for (var i = 0; i < count; i++) {
			observations.push($('#observation_'+i).val());
		}

		console.log(observations);

		if ($('table#datagrid_0 tr.selected').length)
		{
			var route = "";
			if (type==1) {
				route = "<?=BASE_URL.'tbs/thirdparties_requests_tools/check_entry?type=1'?>";
			}else{
				route = "<?=BASE_URL.'tbs/thirdparties_requests_tools/check_entry?type=2'?>";
			}
			$('#add_products').hide();
			$.post(
				route,
				{
					tools_ids: tools_ids,
					observations: observations
				},
				function(data, status)
				{
					console.log(data);
					location.href = "<?=BASE_URL.'tbs/dashboard/tools'?>";
				}
			);
		}
		else
		{
			//$('#add_products').hide();
		}
	}

	function add_obs(tool_id, request_id, name, count, company){
		$('#ob_fields tbody').append('<tr>'+
			'<td>'+company+'</td>'+
			'<td>'+request_id+'</td>'+
			'<td>'+tool_id+'</td>'+
			'<td>'+name+'</td>'+
			'<td>'+
			'<textarea id="observation_'+count+'"></textarea>'+
			'</td>');
	}
</script>

<div id="observations" class="modal">
	<table id="ob_fields">
		<thead>
			<th>Empresa</th>
			<th># Solicitud</th>
			<th>ID Herramienta</th>
			<th>Nombre</th>
			<th>Observación</th>
		</thead>
		<tbody>
			
		</tbody>
	</table>
	<div class="nowrap">
		<button onclick="send_form(1)" style="width: 50%" class="button">Ingresó</button>
		<button onclick="send_form(2)" style="width: 50%" class="button red">No ingresó</button>
	</div>
</div>