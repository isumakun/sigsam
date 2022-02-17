<?php $calendar = new Calendar(); ?>
<h2>Editar Soporte</h2>
<form id="form" method="POST" enctype='multipart/form-data'>
	<input type="hidden" name="input_form_id" value="<?=$_GET['id']?>" >

	<label>Tipo</label>
	<select required name="input_form_support_type_id" class="select2" data-label="support_type" <?=checkError('support_type', $input_forms_verify, $_GET['id'])?>>
		<option></option>
		<?php
		foreach ($input_forms_supports_types as $types) {
			?>
			<option value="<?=$types['id']?>" <?=($transport_input_form_support['input_form_support_type_id'] == $types['id'] ? 'selected' : '')?>><?=$types['id']?> - <?=$types['name']?></option>
			<?php
		} ?>
	</select>

	<label>Soporte</label>
	<input type="file" name="support">

	<?php $class = checkError('created_at', $input_forms_verify, $_GET['id']); ?>
	<label>Fecha</label>
	<?=$calendar->render('created_at', $transport_input_form_support['created_at'], TRUE, 'YYYY-MM-DD', $class.' data-label="created_at"')?>
	
	<label>Detalles</label>
	<textarea name="details" rows="5" data-label="details" <?=checkError('details', $input_forms_verify, $_GET['id'])?>><?=$transport_input_form_support['details']?></textarea>

	<input class="submit" type="submit" value="Agregar" />
</form>
<script type="text/javascript">
	<?php if (count($input_forms_verify)!=0) {
		?>
		var changes;

		$('input').on('change', function(){
			checkChange($(this));
		})

		$('textarea').on('change', function(){
			checkChange($(this));
		})
		
		$('select').on('change', function(){
			checkChange($(this));
		})

		function checkChange(element){
			if (element.hasClass('red')) {
				element.removeClass('red');
				element.addClass('yellow');
			}else{
				element.addClass('yellow');
			}
		}

		$('#form').on('submit', function(e){
			$(".yellow").each(function() {
				var value = $(this).attr('data-label');
				console.log(value);
			   $('#form').append('<input type="hidden" name="field_names[]" value="'+value+'">');
			});
		})
		<?php
	} ?>
</script>