<h2>Agregar producto</h2>
<h3>Información General</h3>
<?php $created_product = get_messages();?>
<form method="POST">
	
		<input type="hidden" name="input_form_id" value="<?=$_GET['id']?>">

		<label>Producto</label>
		<input name="product_id"
		value="<?=$created_product[0]?>"
		class="populate"
		data-modal="products"
		data-label="<?=$created_product[1]?>"
		>
	
	
		<label>Categoría</label>
		<select required name="product_category_id">
			<option></option>
			<?php 
			foreach ($products_categories as $pc) {
				?>
				<option value="<?=$pc['id']?>"><?=$pc['name']?></option>
				<?php
			} ?>
		</select>
	
	
		<label>Subpartida</label>
		<input 	name="tariff_heading" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label="<?=$created_product[2]?>"
		>		
	
		<label>Cantidad Comercial</label>
		<input type="text" required min="0" required name="commercial_quantity">
		<span></span>
	
	
		<label>Unidad de manejo</label>
		<input 	name="physical_unit" 
		value="" readonly
		class="populate"
		data-modal=""
		data-label="<?=$created_product[3]?>"
		>
	
	
		<label>Cantidad</label>
		<input type="text" required min="0" name="quantity">
		<span id="unit" style="font-size: 16px; line-height: 35px; padding-left: 5px" ></span>
	

	<h3>Peso</h3>
	

		<label>Peso Neto</label>
		<input type="text" min="0" required name="net_weight">
	
	
		<label>Peso Bruto</label>
		<input type="text" min="0" required name="gross_weight">	
	
		<label>Embalaje</label>
		<select required name="packaging_id" class="select2">
			<option></option>
			<?php 
			foreach ($packaging as $pu) {
				?>
				<option value="<?=$pu['id']?>"><?=$pu['id']?> - <?=$pu['name']?></option>
				<?php
			} ?>
		</select>
	

	<h3>Valor/Gastos</h3>
		
		<label>Valor Unitario</label>
		<input type="text" min="0" name="unit_value">
	
		<label>Valor FOB</label>
		<input type="text" min="0" name="fob_value">
	
	
		<label>Fletes</label>
		<input type="text" min="0" name="freights">
	
	
		<label>Seguro</label>
		<input type="text" min="0" name="insurance">

	
		<label>Otros gastos</label>
		<input type="text" min="0" name="other_expenses">
	
	
		<label>País Origen</label>
		<select required name="flag_id" class="select2">
			<option></option>
			<?php 
			foreach ($flags as $flag) {
				?>
				<option value="<?=$flag['id']?>"><?=$flag['id']?> - <?=$flag['name']?></option>
				<?php
			} ?>
		</select>
	
	<input type="submit" value="Enviar">
	
</form>

<div id="products" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Producto</th>
			<th>Código de Interfaz</th>
			<th>Tipo</th>
			<th>Subpartida</th>
			<th>Unidad</th>
			<th class="stretch">
				
					<a href="<?=BASE_URL?>/products/create" class="button create dark"><span class="icon create"></span></a>
			</th>
		</thead>
		<?php
		foreach ($products as $product) {
			?>
			<tr>
				<td><?=$product['id']?></td>
				<td><?=$product['name']?></td>
				<td><?=$product['interface_code']?></td>
				<td><?=$product['product_type']?></td>
				<td><?=$product['tariff_heading']?></td>
				<td><?=$product['physical_unit']?></td>
				<td><a href="javascript:;"
					class="button open populate"
					data-values="<?=$product['id']?>,0,0"
					data-labels="<?=$product['name']?>,<?=$product['tariff_heading']?>,<?=$product['physical_unit']?>"
					data-elements="product_id,tariff_heading,physical_unit"><span class="icon open"></span></a></td>
				</tr>
				<?php
			} ?>
		</table>
	
