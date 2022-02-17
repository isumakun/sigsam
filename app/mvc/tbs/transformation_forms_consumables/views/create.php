<h2>Agregar Insumo</h2>
	<form method="POST">
		
		<label>Insumo</label>
		<input 	name="warehouse_id" 
		value="<?=$created_product[0]?>" 
		class="populate"
		data-modal="products"
		data-label=""
		>

		<label>Subpartida</label>
		<input 	name="tariff_heading" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label=""
		>
		
		<label>Unidad</label>
		<input 	name="unit" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label=""
		>

		<label>Saldo</label>
		<input 	name="stock" 
			value="" readonly
			class="populate"
			data-modal=""
			data-label=""
			>

		<label>Cantidad</label>
		<input type="text" name="quantity">

		<label>Desperdicio</label>
		<input type="text" name="waste">

		<input type="submit" value="Enviar">
	</form>
<div id="products" class="modal">
		<table class="datagrid">
			<thead>
				<th>ID Almacen</th>
				<th>Producto</th>
				<th>Subpartida</th>
				<th>Formulario</th>
				<th>Saldo</th>
				<th>Unidad</th>
				<th class="stretch">
					<?php if (!$_SESSION['user']['company_schema']=='tbs3_900324176') {
						?>
						<a href="<?=BASE_URL?>/products/create" class="button create dark"><span class="icon create"></span></a>
						<?php
					} ?>
				</th>
			</thead>
			<?php
			foreach ($products as $product) {
				?>
				<tr>
					<td><?=$product['wid']?></td>
					<td><?=$product['name']?></td>
					<td><?=$product['tariff_heading']?></td>
					<td><?=$product['form_id']?></td>
					<td><?=$product['stock']?></td>
					<td><?=$product['symbol']?></td>
					<td><a href="javascript:;"
						class="button open populate"
						data-values="<?=$product['wid']?>,0,0,0"
						data-labels="<?=$product['name']?>,<?=$product['tariff_heading']?>,<?=$product['physical_unit']?>,<?=$product['stock']?>"
						data-elements="warehouse_id,tariff_heading,unit,stock"><span class="icon open"></span></a></td>
					</tr>
					<?php
				} ?>
			</table>
		</div>