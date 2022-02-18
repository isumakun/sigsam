<?php
if (isset($_SESSION['notifications']))
{
	?>
	<div class="notification">
		<ul>
			<?php
			$i = 0;
			foreach ($_SESSION['notifications'] AS $n)
			{
				?>
				<li class="<?=$n['type']?>"><span class="<?=$n['icon']?> noti-icon"></span><p><?=$n['message']?></p></li>
				<?php
				unset($_SESSION['notifications'][$i]);
				$i++;
			}
			?>
		</ul>
	</div>
	<?php
}
?>
<style type="text/css">
	#analisis_modal .row{

	}
</style>
<div id="change_company" class="modal" >
	<form action="<?=BASE_URL?>indicator/dashboard/change_company" method="POST">
		<select name="company">
			<?php foreach ($_SESSION['user_companies'] as $company) {
				?>
				<option value="<?=$company['id']?>"><?=$company['id']?> - <?=$company['name']?></option>
				<?php
			} ?>
		</select>
		<input type="submit" value="Cambiar Empresa" class="button dark">
	</form>
</div>

<div class="modal better_modal" id="confirmation_box" tabindex="-1" role="dialog" aria-labelledby="modalCenter" aria-hidden="true" style="">
	<form method='post' enctype="multipart/form-data" action='' id="modal_form">
		<center style="padding: 30px 0px;"><h3>Esta a punto de eliminar este registro, ¿desea continuar?</h3></center>
		<!-- <input type="button" class="btn btn-secondary btn_hide" value="Cancelar"> -->
		<input type="submit" id="confirmation_button" class="btn btn-primary" value="Eliminar">
	</form>
</div>

<div class="modal better_modal" id="confirmation_save_box" tabindex="-1" role="dialog" aria-labelledby="modalCenter" aria-hidden="true" style="">
	
		<center style="padding: 30px 0px;"><h3>¿Guardar Cambios?</h3></center>
		<!-- <input type="button" class="btn btn-secondary btn_hide" value="Cancelar"> -->
		<input type="button" id="confirmation_button" class="btn btn-primary confirm" value="Guardar">
	
</div>

<div class="modal better_modal" id="analisis_modal" tabindex="-1" role="dialog" aria-labelledby="modalCenter" aria-hidden="true" style="">
	<form method='post' enctype="multipart/form-data" action='<?= BASE_URL ?>indicator/indicators/analysis_filter_results' id="analisismodal_form">
		
	</form>
</div>

<div class="modal better_modal" id="edit_ind_modal" tabindex="-1" role="dialog" aria-labelledby="modalCenter" aria-hidden="true" style="">
	<form method='post' enctype="multipart/form-data" action='' id="analisismodal_form">
		
	</form>
</div>


<script type="text/javascript">

	$(document).ready(function() {
		$('.select2').select2();

		$('.select2_custom').select2({
			templateResult: formatState,
			templateSelection: formatState_o
		});

		function formatState (state) {
			if (!state.id) {
				return state.text;
			}

			var position = state.text.match(/(?<=\%).+?(?=\%)/g);
			var name = state.text.match(/(?<=\[).+?(?=\])/g);
			//var baseUrl = "/user/pages/images/flags";
			var $state = $(
				'<div class="select_div">' + name + '<span style="float: right;">'+position+'</span> </div>'
				);
			return $state;
		};
		function formatState_o (state){
			if (!state.id) {
				return state.text;
			}

			var name = state.text.match(/(?<=\[).+?(?=\])/g);
			//var baseUrl = "/user/pages/images/flags";
			// var $state = $(
			// 	'<div class="select_div">' + name + '<span style="float: right;"></span> </div>'
			// 	);
			return name;
		}

		$("form").submit(function() {
			$('input[type=submit]').prop('disabled',true);
			$('a').attr('disabled', 'disabled');
			return true;
		});

		/* SHOW MODAL DECIDE ANALISIS ------------------------------------------- */
		$('#analisismodal_show').on('click', function(e){
			e.preventDefault();
			var url = "<?= BASE_URL ?>indicator/indicators/analysis_filter";
			var url_action = "<?= BASE_URL ?>indicator/indicators/analysis_filter_results";
			
			$('#analisis_modal').add('show');
			$.ajax({
				type  : 'POST',
				url   : url,
				success  : function(data) {	
				 	data = JSON.parse(data);
				 	var html = `
				 	<div class="row">
                        
                        <div class="col-md-6">
                        <div class="row">
							<div class="col-md-12">
	                            <label>Proceso</label>
	                            <select class="browser-default select2" name="process" id="process">
	                                <option selected></option>
	                                ${  data['processes'].map((item, i) => `
	                           
	                                <option value="${item.id}">
	                                    ${item.name}</option>
	                                
	                                `.trim()).join('') }
	                            </select>
                        	</div>
						</div>
                        <div class="row">
                        	<div class="col-md-12">
	                            <label>Periodo</label>
	                            <select class="browser-default select2" name="age" id="age">
	                                <option selected></option>
	                                ${  data['periods'].map((item, i) => `
	                                
	                                    <option value="${item.age}">
	                                        ${item.age}</option>
	                                    
	                                    `.trim()).join('') }
	                            </select>
	                        </div>
						</div>
                            
                        </div>
                        <div class="col-md-6">
                        	<div class="row">
                        		<div class="col-md-12">
                        			<label>Indicador</label>
		                            <select class="browser-default select2 mine" name="indicators" id="indicators">
		                                <option selected></option>
		                                 ${  data['indicators'].map((item, i) => `
		                                    <option data-process="${item.process}" value="${item.id}">
		                                        ${item.name}</option>
		                                    `.trim()).join('') }
		                            </select>
								</div>
                        	</div>
							<div class="row" id="indicatorsinfo" style="margin-top: 10px;">
							</div> 
                        </div>
                        
                        <div class="row" style="margin-top: 30px;">
							<div class="col-md-6">
								<input type="submit" id="nanalisismodalform_button1" class="btn btn-primary" value="Cargar">
							</div>
							<div class="col-md-6">
								<input type="submit" id="nanalisismodalform_button2" class="btn btn-primary" value="visualizar">
							</div>
						</div>
	                                
							
                	</div>`;

                    $('#analisismodal_form').html(html);
					}
	        	})
			
			})

		$('#analisismodal_form').on('change', '#process', function(){
			var id = $(this).val()
			var url = "<?= BASE_URL ?>indicator/indicators/analysis_filter_ajax";
			$.ajax({
				type: 'POST',
				url : url,
				data:{
					id: id,
					type:'process'
				},
				success : function(data){
					data = JSON.parse(data);
					// console.log(data)
					let html = ''
					if(data['indicators'].length){
						html = `
						${  data['indicators'].map((item, i) =>`
                                
                        <option value="${item.id}">${item.name}</option>
                        	
                        `.trim()).join('') }
						`;

					}else{
						html = `                            
	                        <option value="" disabled selected>No hay indicadores para este proceso</option>
						`;
					}
					
					$('#analisismodal_form #indicators').html(html);
					call_indicator_info($('#analisis_modal select#indicators').val())
				}
			})
		})

		$('#analisis_modal').on('change', 'select#indicators', function(){
			var id = $(this).val()
			var url = "<?= BASE_URL ?>indicator/indicators/analysis_filter_ajax";
			call_indicator_info(id)
			
		})

		 // $('body #analisismodal_form #process').change(function(e) {
	  //       const process_id = $(this).val()
	  //       console.log(process_id)
	  //       $('body #analisismodal_form #indicators > option').each(function() {

	  //           if ($(this).data("process") == process_id) $(this).show()
	  //           else $(this).hide()
	  //       });
	  //   });
	  function call_indicator_info(ind_id){
	  	var url = "<?= BASE_URL ?>indicator/indicators/analysis_filter_ajax";
	  	$.ajax({
			type: 'POST',
			url : url,
			data:{
				id: ind_id,
				type:'indicators'
			},
			success : function(data){
				data = JSON.parse(data);
				// console.log(data)
				let html = ''
				if(data['indinfo'].length){
					html = `

					${  data['indinfo'].map((item, i) =>`
                        <div class="col-md-12">
                        <label for="info">Informacion del indicador: </label>
							<input type="text" name="info" readonly value="Frecuencia: ${item.frequency}" style="border: none;">
						</div>
                    
                    `.trim()).join('') }
					`;

				}else{
					html = `                                
                        <div class="col-md-12">
                        <label for="info">Informacion del indicador: </label>
							<input type="text" name="info" readonly value="Informacion no disponible">
						</div>
					`;
				}
				
				$('#analisismodal_form #indicatorsinfo').html(html);
			}
		})
	  }
	});
</script>