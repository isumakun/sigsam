<style type="text/css">
#confirmation_box div{
	width: auto;
}
#confirmation_box form{
	margin-bottom: 0px;
}
</style>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
<div>
	<?php
		$table = new Datagrid();

		$table->set_options('indicator/values', 'get_all', 'a', 'false', 'multi', 'true');
		
		$table->add_column('Indicator', 'indicator_id');
		$table->add_column('Value', 'value');
		$table->add_column('created_by', 'created_by');
		$table->add_column('created_at', 'created_at');
		$table->add_column('Support', 'support');
		$table->add_column_html('', 'id', 
			'<div class="strech nowrap">
			<a href="'.BASE_URL.'indicator/values/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
			<a href="'.BASE_URL.'indicator/values/delete?id={row_id}" class="button delete"><span class="icon delete"></a>
			</div>', 'toolbar');

		$table->render();

	?>
	
</div>


<div class="modal" id="confirmation_box" tabindex="-1" role="dialog" aria-labelledby="modalCenter" aria-hidden="true" style="">
	<form method='post' enctype="multipart/form-data" action='' id="modal_form">
		<center style="padding: 30px 0px;"><h3>Esta a punto de eliminar este registro, ¿desea continuar?</h3></center>
		<!-- <input type="button" class="btn btn-secondary btn_hide" value="Cancelar"> -->
		<input type="submit" id="confirmation_button" class="btn btn-primary" value="Eliminar">
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function () {
	    $(document).on('click', 'a.delete', function(e) {
		    e.preventDefault();
		    let action = $(this).attr('href');
		    $('#modal_form').attr('action',action);
			
			$('#confirmation_box').modal('show');
		});

	})
</script>