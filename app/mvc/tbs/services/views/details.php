<h3>Formulario de Servicios</h3>
<?php
if ($service['service_type']==1) {
	$service_type = 'Ingreso';
	$aux = 'Cliente';
}else{
	$service_type = 'Egreso';
	$aux = 'Proveedor';
}
 ?>
<table>
	<thead>
		<th>#</th>
		<th>Tipo Servicio</th>
		<th><?=$aux?></th>
		<th>Factura</th>
		<th>Fecha Factura</th>
		<th>Conceptos</th>
		<th>Valor</th>
		<th class="toolbar"></th>
	</thead>
	<tbody>
		<tr>
			<td><?=$service['id']?></td>
			<td><?=$service_type?></td>
			<td><?=$service['supplier']?></td>
			<td><?=$service['bill_number']?></td>
			<td><?=$service['bill_date']?></td>
			<td><?php 
			foreach ($services_concepts as $concept) {
			 	echo $concept['concept']."<br>";
			 } ?></td>
			<td><?=$service['cost']?></td>
			<td><a href="edit?id=<?=$_GET['id']?>" class="button edit"><span class="icon white edit"></span></a></td>
		</tr>
	</tbody>
</table>

<a href="#products" class="button modal">Productos Masivo</a>
<table class="datagrid">
	<thead>
		<th>Producto</th>
		<th class="toolbar">
			<div class="stretch nowrap">
<?php
					echo make_link('tbs/services_products/create?form_id='.$_GET['id'], '<span class="icon create"></span>', 'button dark create').'<br/>';
?>
			</div>
		</th>
	</thead>
	<tbody>
		<?php
		foreach ($services_products as $sp)
		{
			?>
			<tr>
				<td>
					<?=$sp['name']?>
				</td>
				<td class="nowrap">
					<?= make_link('tbs/services_products/delete?id='.$ifp['ifp_id'], '<span class="icon delete"></span>', 'button delete confirm_action') ?>
				</td>
			</tr>
			<?php
		} ?>
	</tbody>
</table>

<div id="products" class="modal">
				<a id="add_products" href="javascript:;" class="button pull-right purple stretch"><span class="icon plus-circle2 white"></span> Agregar seleccionados</a>
				<?php
				$table = new Datagrid();

				$table->set_options('tbs/products', 'get_all', 'a', 'false', 'multi');

				$table->add_column('ID', 'id');
				$table->add_column('Producto', 'product');
				$table->add_column('Tipo', 'product_type');
				$table->add_column('Subpartida', 'tariff_heading');
				$table->add_column('Unidad', 'physical_unit');

				$table->render();
				?>
			</div>

			<script>
				$('#add_products').hide();

				var products_id = new Array();

				$('table#datagrid_0').on('click', 'tr', function()
				{
					products_id = [];

					$(this).toggleClass('selected');
					
					for ($i = 0; $i < datatable_0.rows('.selected')[0].length; $i++)
					{
						products_id.push(datatable_0.row(datatable_0.rows('.selected')[0][$i]).data()['id']);
						//console.log(products_id);
					}

		$('#add_products').hide();
		//console.log(products_id.length);
		if (products_id.length > 0)
		{
			$('#add_products').show();
		}
	});

				$('#add_products').click(function()
				{
					if ($('table#datagrid_0 tr.selected').length)
					{
						$.post(
							"<?=BASE_URL.'tbs/services_products/create_massively'?>",
							{
								form_id: <?=$_GET['id']?>,
								products_id: products_id
							},
							function(data, status)
							{
								console.log(data);
								location.href = "<?=BASE_URL.'tbs/services/details?id='.$_GET['id']?>";
								
							}
							);
					}
					else
					{
						$('#add_products').hide();
					}
				});
			</script>