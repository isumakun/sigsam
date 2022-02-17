<h2>Servicios</h2>

	<table class="datagrid">
		<thead>
			<th>#</th>
			<th>Tipo</th>
			<th>Proveedor/Cliente</th>
			<th>Factura</th>
			<th>Fecha factura</th>
			<th>Conceptos</th>
			<th>Costo</th>
			<th class="toolbar"><?=make_link('tbs/services/create', '<span class="icon create"></span> Nuevo', 'button dark create')?></th>
		</thead>
		<?php
		foreach ($services as $service) {
		?>
			<tr>
				<td><?=$service['id']?></td>
				<td>
					<?php if ($service['service_type']==1) {
						echo "Ingreso";
					}else{
						echo "Egreso";
					} ?>
				</td>
				<td><?=$service['supplier']?></td>
				<td><?=$service['bill_number']?></td>
				<td><?=$service['bill_date']?></td>
				<td><?php 
					foreach ($services_concepts as $concept) {
					 	if ($service['id']==$concept['service_id']) {
					 		echo $concept['concept']."<br>";
					 	}
					 } ?></td>
				<td><?=$service['cost']?></td>
				<td>
					<div class="nowrap">
						<a href="<?=BASE_URL?>tbs/services/details?id=<?=$service['id']?>" class="button view"><span class="icon open"></span></a>
					</div>
				</td>
			</tr>
		<?php
		}?>
	</table>
