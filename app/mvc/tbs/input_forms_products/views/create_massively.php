<style type="text/css">
	#structure DIV.modal > DIV {
	    max-width: 1000px;
	}
</style>
<h2>Agregar productos masivamente</h2>
<p><span class="icon info"></span><b>IMPORTANTE:</b> Copie y pegue en el siguiente recuadro la información a agregar masivamente. Asegúrese de que las columnas coinciden con la siguiente estructura: <a href="#structure" class="button modal">Ver Estuctura</a></p>

<p style="color: red"><b>ADVERTENCIA:</b> Todos los campos deben estar debidamente diligenciados, en caso de no tener valor, rellenar con 0.</p>

<div class="w25">
	<b>Tipos de producto:</b>
	<br><br>
	<ol>
		<li>Extranjero</li>
		<li>Nacional</li>
		<li>Nacional con acuerdo</li>
		<li>Nacionalizado</li>
		<li>Zona Franca</li>
		<li>Nacional exportado</li>
		<li>Otros</li>
	</ol>
</div>
<div class="w25">
	<b>Categorías:</b>
	<br><br>
	<ol>
		<li>Materias Primas</li>
		<li>Vehículos</li>
		<li>Activos Fijos</li>
		<li>Materiales de consumo</li>
		<li>Repuestos</li>
		<li>Maquinaría y equipo</li>
		<li>Producto Terminado</li>
		<li>Embalaje</li>
		<li>Insumos</li>
		<li>Carga general</li>
	</ol>
</div>

<div class="w25">
	<b>Unidades:</b>
	<br><br>
	<ol>
		<li>Kilogramo</li>
		<li>Quilate</li>
		<li>Metro</li>
		<li>Metro cuadrado</li>
		<li>Metro cúbico</li>
		<li>Centímetro cúbico</li>
		<li>Litro</li>
		<li>Unidades</li>
		<li>Par</li>
		<li>Docena</li>
		<li>Miles de unidades</li>
		<li>Kilovatios por hora</li>
		<li>Galones</li>
		<li>Gramos</li>
	</ol>
</div>

<div class="w25">
	<b>Embalajes:</b>
	<a href="#packaging" class="button modal">Ver embalajes</a>
</div>

<form method="POST">
	<input type="hidden" name="input_form_id" value="<?=$_GET['id']?>">

	<label>Portapapeles (.xls)</label>
	<textarea name="products_from_excel" placeholder="Pegue aquí la información copiada del archivo de excel"></textarea>

	<input type="submit" value="Enviar">
</form>

<div id="packaging" class="modal">
	<table class="datagrid">
		<thead>
			<th>ID</th>
			<th>Embalaje</th>
		</thead>
		<?php foreach ($packaging as $pack) {
			?>
			<tr>
				<td><?=$pack['id']?></td>
				<td><?=$pack['name']?></td>
			</tr>
			<?php
		} ?>
	</table>
</div>

<div id="structure" class="modal">
	<table style="font-size: 12px !IMPORTANT">
		<th>Nombre</th>
		<th>Cod. Interfaz</th>
		<th>Tipo</th>
		<th>Categoría</th>
		<th>Subpartida</th>
		<th>Cant. Comercial</th>
		<th>Cant</th>
		<th>Unidad</th>
		<th>P. Neto</th>
		<th>P. Bruto</th>
		<th>V. Unitario</th>
		<th>FOB</th>
		<th>Fletes</th>
		<th>Seguros</th>
		<th>O. Gastos</th>
		<th>Embalaje</th>
		<th>País</th>
	</table>
</div>