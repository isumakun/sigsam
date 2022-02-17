<h2>Salidas Temporales</h2>

<?php if ($temporary_forms) {
	?>
	<table>
		<th>#</th>
		<th>Proveedor</th>
		<th>Transporte</th>
		<th>Fecha de salida</th>
		<th></th>
		<tbody>
			<?php 
			foreach ($temporary_forms as $tf) {
				?>
				<tr>
					<td><?=$tf['form_id']?></td>
					<td><?=$tf['supplier']?></td>
					<td><?=$tf['transport']?></td>
					<td><?=$tf['approved_at']?></td>
					<td class="strech nowrap">
						<a href="details?id=<?=$tf['form_id']?>" class="button view" target="_blank"><span class="icon open"></span></a>&nbsp;
						<a href="#re_enter" onclick="set_form_id(<?=$tf['form_id']?>)" class="button dark modal">Reingresar</a>
					</td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
	<?php
}else{
	?>
	<center><h3>No hay salidas temporales activas</h3></center>
	<?php
} ?>

<div id="re_enter" class="modal">
	<form method="POST" action="re_enter">
		<label>Observación</label>
		<textarea type="text" name="observations"></textarea>
		<input type="hidden" name="form_id" id="form_id">
		<input type="submit" value="Reingresar formulario">
	</form>
</div>

<script type="text/javascript">
	function set_form_id(id){
		$('#form_id').val(id);
	}
</script>