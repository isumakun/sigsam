<h2>Reporte Saldos a la fecha</h2>

<a href="javascript:tableToExcel('table_report', 'Reporte saldos a la fecha')" id="btnExport" class="button dark pull-right"> Exportar a Excel</a>
<hr>
<table id="table_report">
	<thead>
		<th>Producto</th>
			<th>Cód. Interfaz</th>
			<th>Tipo</th>
			<th>Subpartida</th>
			<th>Unidad de manejo</th>
			<th>Cantidad en almacen</th>
			<th>Valor Unitario</th>
			<th>Soportes</th>
	</thead>
	<tbody>
<?php
foreach ($categories as $category) {
	?>
	<tr>
		<td colspan="7"><p style="font-weight: 700; text-transform: uppercase;"><?=$category['name']?></p></td>
	</tr>

		
		
			<?php foreach ($results as $result) {
				if ($result['product_category_id']==$category['id']) {
						?>
						<tr>
							<td><?=$result['product']?></td>
							<td><?=$result['interface_code']?></td>
							<td><?=$result['type']?></td>
							<td><?=$result['tariff_heading']?></td>
							<td><?=$result['unit']?></td>
							<td><?=$result['quantity']?></td>
							<td><?=($result['unit_value'])?></td>
							<td><?php 
							if ($_SESSION['user']['company_schema']=='tbs3_830078966' OR $_SESSION['user']['company_schema']=='900500691') {
								$print = 'Saldo de migración';
							}else{
								$print = '';
							}
							
							foreach ($bls as $bl) {
								if ($bl['product']==$result['product']) {
									if ($result['product_category_id'] == 2 OR $result['product_category_id'] == 3 OR $result['product_category_id'] == 6) {
										$print = $bl['detail'];
									}
								}
							}
							echo $print;
							?></td>
						</tr>
						<?php
				}
			} ?>
		<?php
}?>
</tbody>
</table>

 <script type="text/javascript">
		function tableToExcel(name1, name2){

		    //getting data from our table
		    var data_type = 'data:application/vnd.ms-excel';
		    var table_div = document.getElementById('table_report');
		    var html = table_div.outerHTML.replace(/ /g, '%20');

		     while (html.indexOf('á') != -1) html = html.replace('á', '&aacute;');
			  while (html.indexOf('é') != -1) html = html.replace('é', '&eacute;');
			  while (html.indexOf('í') != -1) html = html.replace('í', '&iacute;');
			  while (html.indexOf('ó') != -1) html = html.replace('ó', '&oacute;');
			  while (html.indexOf('ú') != -1) html = html.replace('ú', '&uacute;');
			  while (html.indexOf('º') != -1) html = html.replace('º', '&ordm;');

		    var a = document.createElement('a');
		    a.href = data_type + ', ' + html;
		    a.download = name2+'.xls';
		    a.click();
		}
		</script>