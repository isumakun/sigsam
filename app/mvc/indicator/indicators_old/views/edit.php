<?php 
$calendar = new Calendar();
?>
<style type="text/css">
	textarea.select2-search__field{
		display:none;
	}
  .pdd_20{
    padding-top: 20px;
  }
  .pdd_20 > select{
    border: none;
    text-align-last: center;
  }
span.select2{
	width: inherit !important;
}
/* CSS */
.button-8 {
  background-color: #e1ecf4;
  border-radius: 3px;
  border: 1px solid #7aa7c7;
  box-shadow: rgba(255, 255, 255, .7) 0 1px 0 0 inset;
  box-sizing: border-box;
  color: #39739d;
  cursor: pointer;
  display: inline-block;
  font-family: -apple-system,system-ui,"Segoe UI","Liberation Sans",sans-serif;
  font-size: 13px;
  font-weight: 400;
  line-height: 1.15385;
  margin: 0;
  outline: none;
  padding: 0px .8em;
  position: relative;
  text-align: center;
  text-decoration: none;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: baseline;
  white-space: nowrap;
}

.button-8:hover,
.button-8:focus {
  background-color: #b3d3ea;
  color: #2c5777;
}

.button-8:focus {
  box-shadow: 0 0 0 4px rgba(0, 149, 255, .15);
  outline: 2px solid #5f71bb;
}

.button-8:active {
  background-color: #a0c7e4;
  box-shadow: none;
  color: #2c5777;
}
.center_vertically{
	text-align: center;
  margin: auto
}

/*even uneven divs*/
.box:nth-of-type(odd) {
	background-color:#e4e4e4;
}
    
.box:nth-of-type(even) {
	background-color:#f4f4f4;
	margin-top: 6px;
	margin-bottom: 6px;
}
.box{
	border-radius: 6px;
	margin-top: 6px;
	margin-bottom: 6px;
}
.row{
	margin-left: 0px !important;
	margin-right: 0px !important;
}
/*tooltip*/
.tooltip-container {
  margin: 0 auto;
  display: inline-block;
}

/* EMPIEZA AQUÍ */

.tooltip-container {
  position: relative;
  cursor: pointer;
}

.tooltip-one {
  padding: 18px 32px;
  background: #fff;
  position: absolute;
  width: 143px;
  border-radius: 5px;
  text-align: center;
  filter: drop-shadow(0 3px 5px #e4e4e4);
  line-height: 1.5;
  display: none;
  bottom: 40px;
  right: 50%;
  margin-right: -72px;
}

.tooltip-one:after {
  content: "";
  position: absolute;
  bottom: -9px;
  left: 50%;
  margin-left: -9px;
  width: 18px;
  height: 18px;
  background: white;
  transform: rotate(45deg);
}

.tooltip-trigger:hover + .tooltip-one {
  display: block;
}
.box:nth-of-type(even) .group{
  border-radius: 16px;
  border: 1px solid #d2d2d2 !important;
  padding: 0.01em 16px;
  padding-top: 0.6em;
}
.box:nth-of-type(odd) .group{
  border-radius: 16px;
  border: 1px solid #a29f9f !important;
  padding: 0.01em 16px;
  padding-top: 0.6em;
}
.float_right{
	float: right;
}
.box:nth-of-type(even) .group select:disabled{
  border: none;
  background-color: #f4f4f4;
  font-size: large;
  font-weight: bolder;
  -webkit-appearance: none;
}
.box:nth-of-type(even) .group input:read-only{
    border: none;
    background-color: #f4f4f4;
    font-size: 14px;
}
.box:nth-of-type(odd) .group select:disabled{
  border: none;
  background-color: #e4e4e4;
  font-size: large;
  font-weight: bolder;
  -webkit-appearance: none;
}
.box:nth-of-type(odd) .group input:read-only{
    border: none;
    background-color: #e4e4e4;
    font-size: 14px;
}
.inner_box{
	padding: 10px 20px;
}

  /*tab logic*/
.tabs {
  display: flex;
  flex-wrap: wrap; 
}
.tabs label.diferentiate {
  order: 1; 
  display: block;
  padding: 1rem 2rem;
  margin-right: 0.2rem;
  cursor: pointer;
  background: #90CAF9;
  font-weight: bold;
  transition: background ease 0.2s;
}
.tabs .tab {
  order: 99; 
  flex-grow: 1;
  width: 100%;
  display: none;
  padding: 1rem;
  background: #fff;
}
.tabs input.radio_tabs {
  display: none;
}
.tabs input.radio_tabs:checked + label.diferentiate{
  background: #fff;
}
.tabs input.radio_tabs:checked + label.diferentiate + .tab {
  display: block;
}

@media (max-width: 45em) {
  .tabs .tab,
  .tabs label.diferentiate {
    order: initial;
  }
  .tabs label.diferentiate {
    width: 100%;
    margin-right: 0;
    margin-top: 0.2rem;
  }
}
.button-9{
	background-color: #f4e1e1;
	border: 1px solid #c77a7a;
	color: #9d3939;
}
.button-9:hover, .button-9:focus{
  background-color: #eab3b3;
  color: #772c2c;
}
.button-9:focus{
	outline: 2px solid #c77a7a;
}
</style>
<h2>Editar Registro:</h2>
<form method="POST" enctype="multipart/form-data" name="theForm" id="theForm">

	<div class="tabs">
	  <input class="radio_tabs" type="radio" name="tabs" id="tabone" checked="checked">
	  <label for="tabone" class="diferentiate">Indicador</label>
	  <div class="tab">
	    <div class="row marginb">
				<div class="col-md-12">
					<label for="category_id">Categoría :</label>
					<select name="category_id" id="category">
						<option></option>
						<?php foreach($category AS $ca) { ?>
							<option value="<?=$ca['id']?>" <?=($indicator[0]['category_id'] == $ca['id'] ? 'selected' : '')?>><?=$ca['name']?></option>
						<?php }   ?>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 marginb">
					<label for="name">Nombre:</label>
					<input name="name" value="<?=$indicator[0]['name']?>" type="text"/>
				</div>
				<div class="col-md-12">
					<label for="formula">Fórmula:</label>
					<input name="formula" value="<?=$indicator[0]['formula']?>" type="text"/>
				</div>
			</div>
			
			<div class="row marginb">

			</div>
			<div class="indi row marginb">
				<div class="col-md-4">
					<label for="type_id">Tipo de indicador:</label>
					<select name="type_id">
						<option value=""></option>
						<?php foreach($types AS $t) { ?>
						<option value="<?=$t['id']?>" <?=($indicator[0]['type_id'] == $t['id'] ? 'selected' : '')?>><?=$t['name']?></option>
						<?php  } ?>
					</select>
				</div>
				<div class="col-md-8">
					<label for="process_id">Proceso:</label>
					<select name="process_id">
						<?php foreach($process AS $p) { ?>
							<option value="<?=$p['id']?>" <?=($indicator[0]['process_id'] == $p['id'] ? 'selected' : '')?>><?=$p['name']?></option>
						<?php  } ?>
					</select>
				</div>	
			</div>
			

			<div class="row">

				<div class="col-md-12 marginb">
					<label for="charge_id">Responsables:</label>
					<select class='select2_custom' name='charge_id[]' multiple='multiple' id="charge_id" required>
						<?php foreach($charges AS $c) { echo $c; ?>
							<option value="<?=$c['id']?>" <?=((in_array($c['id'], $charges_ind)) ? 'selected' : '')?>>[<?=$c['first_name']?> <?=$c['last_name']?>] %<?=$c['job_position']?>% </option>
						<?php } ?>
					</select>
				</div>
			</div>
			<div class="row marginb">
				<div class="col-md-6">
					<label for="frequency_id">Frecuencia:</label>
					<select name="frequency_id">
						<?php foreach($frequency AS $f) { ?>
							<option value="<?=$f['id']?>" <?=($indicator[0]['frequency_id'] == $f['id'] ? 'selected' : '')?>><?=$f['name']?></option>
						<?php  } ?>
					</select>
				</div>
				<div class="col-md-6">
					<label for="unit">Unidad:</label>
					<input name="unit" value="<?=$indicator[0]['unit']?>" type="text"/>
				</div>
			</div>
	  </div>
	  
	  <input class="radio_tabs" type="radio" name="tabs" id="tabtwo">
	  <label for="tabtwo" class="diferentiate">Metas y límites</label>
	  <div class="tab row">
	  	<div class="row">
	  		<div class="col-md-12">
	  			<label>
		  			<span>Agregar nuevo valor para a&ntilde;o en curso:</span>
		  		</label>	  		
					<button class="button-8 add_goals" role="button">+</button>
	  		</div>
	  	</div>
	  	<div class="row marginb hidden_add" style="display:none">
				<div class="col-md-6 indi">
					<hr>
					<div class="form-group" id="opciones" >
						<table>
							<label for="">Opciones:</label>
							<th>
								<input type="radio" checked name="opc" value="2" id="input_2" data-value="2" style="appearance: auto; margin-bottom: 0;">Meta
							</th>
							<th>
								<input type="radio" name="opc" value="1" id="input_1" data-value="1" style="appearance: auto;margin-bottom: 0;">Limites
							</th>
						</table>
					</div>
				</div>
				<div class="col-md-6">
					<hr>
					<div class="form-group col-md-12" id="upper_limit1" style="display:none;">
						<div class="row">
							<div class="col-md-6">
							<label for="upper_limit"  >Limite Superior:</label>
							<input name="upper_limit" value="" type="text"/>
						</div>
						<div class="col-md-6">
							<label for="lower_limit">Limite inferior:</label>
							<input name="lower_limit" value="" type="text"/>
						</div>
						</div>
					</div>
					<div class="form-group" id="goal1" style="display:none;">
						<div class="row">
				          <div class="col-md-6 pdd_20">
				            <select name="metakind">
				              <option>&#8805;</option>
				              <option>&leq;</option>
				              <option>&lt;</option>
				              <option>&gt;</option>            
				              <option>&equals;</option>
				            </select>
				          </div>
				          <div class="col-md-6">
							<label for="goal">Meta:</label>
							<input name="goal" value="" type="text"/>
				          </div>
				    </div>
					</div>
				</div>		
			</div>
			<hr>
	  	<div class="row marginb">
	  		<div class="col-md-12">
	  			<label><h4>Hist&oacute;rico:</h4></label>
	  		</div>
	  		<?php $sign= 0; foreach($year_goals as $key => $value){?>
	  			<div class="col-md-12 box">
  					<label><h6 style="margin-top:10px">Periodo: <?= $key ?></h6></label>
  					<div class="inner_box">
		  			<?php foreach ($value as $ke => $val) { ?>
		  				<div class="marginb row group" data-id="<?= $val['id'] ?>">
		  					
		  					<div class="col-md-12">
		  						<label>Fecha de creación: <?= ($val['creation_date'])? $val['creation_date'] : 'No registra' ?></label>
		  						<button class="button-8 float_right log_goals" disabled style="display: none;"><i class="fas fa-file-signature"></i></button>
		  						<button class="button-8 float_right edit_goals" role="button"><i class='fas fa-pen'></i></button>
		  						
		  						<hr>
		  					</div>
		  				<?php
		  				if(isset($val['goal']) && $val['goal'] != ""){ $sign++;?>
		  					
			  				<div class="col-md-12 marginb meta_div">
			  					<div class="row">
			  						<div class="col-md-2 center_vertically">
			  							<label>Meta:</label>
			  						</div>
			  						<div class="col-md-3">
			  							<select id="metakind_<?= $val['id'] ?>" name="meta_edition_goalSing" disabled>
					              <option>&#8805;</option>
					              <option>&leq;</option>
					              <option>&lt;</option>
					              <option>&gt;</option>
					              <option>&equals;</option>
					            </select>
			  						</div>
			  						<div class="col-md-5">
				  						<input type="text" name="meta_edition_goal" readonly value="<?=$val['goal']?>">
				  					</div>
				  					<div class="col-md-2">
					  				</div>
			  					</div>
			  					
			  				</div>
			  			<?php	}

			  			if(isset($val['upper_limit']) && $val['upper_limit'] != "" && isset($val['lower_limit']) && $val['lower_limit'] != ""){ $sign++; ?>
			  				<div class="col-md-12 marginb limit_div">
			  					<div class="row">
			  						<div class="col-md-2 center_vertically">
						  					<label>L&iacute;mites:</label>
						  				</div>
						  				<div class="col-md-4">
						  						Limite superior: <input type="text" name="meta_edition_lsup" readonly value="<?= $val['upper_limit'] ?>"> 
						  				</div>
						  				<div class="col-md-4">
						  					Limite inferior: <input type="text" name="meta_edition_linf" readonly value="<?= $val['lower_limit'] ?>">    
						  				</div>
						  				<div class="col-md-2">
						  				</div>
			  					</div>
			  				</div>
		  				<?php	}
		  			 if($sign>1){ ?>
		  			 	
		  			 	<div class="col-md-12 alert alert-warning" role="alert">
		  			 		
		  			 		<div class="row">
		  			 			<div class="col-md-11">
		  			 				<h6 class="alert-heading">Valores simult&aacute;neos</h6>
		  			 			</div>
		  			 			<div class="col-md-1 center_vertically">
		  			 				<div class="tooltip-container">
		  			 					<i style="font-size:medium;" class="fas fa-info-circle info_warning tooltip-trigger" ></i>
										  <div class="tooltip-one">
										    clic para m&aacute;s informaci&oacute;
										  </div>
										</div>
		  			 				
		  			 			</div>
		  			 		</div>
							  <div class="info_expand_warning" style="display:none">
							  	<hr>
							  	<p>Parece que existen valores tanto para meta como para l&iacute;mites(goal) en el indicador, lo que puede causar que SIGSAM use s&oacute;lo uno de ellos en la gr&aacute;fica de los resportes. </p>
							  </div>
							</div>
		  			 <?php }
		  			 $sign= 0; ?>
		  			 </div>
		  			<?php } ?>
		  			</div>
		  			</div>
		  		<?php } ?>
	  	
	  	</div>
	  </div>
	  
	</div>
	
	<input class="confirmp save" type="button" value="Guardar" />
	<input style="display: none;" class="submit save" type="submit" value="Guardar" />
</form>

<script>
	var divgroupMeta = null
	var divgroupLimit = null
	var divGroup = null
	var buttonLogGoals = null
	var buttonEditGoals = null
	$(document).ready(function(){
		$(document).on('click', 'button.edit_goals', function(e){
			e.preventDefault();
			buttonEditGoals = $(this)
			divGroup = buttonEditGoals.closest('.group')
			buttonLogGoals = divGroup.find('.log_goals')
			divgroupMeta = divGroup.find('.meta_div')
			divgroupLimit = divGroup.find('.limit_div')
			buttonEditGoals.html('<i class="fas fa-save"></i>')
			buttonLogGoals.html('<i class="far fa-times-circle"></i>')
			buttonLogGoals.addClass('remove_withoutsave_goal button-9')
			buttonLogGoals.removeClass('log_goals')
			buttonLogGoals.show()
			buttonLogGoals.prop("disabled", false);

			if(divgroupLimit.length){
				divgroupLimit.find('input').prop("readonly", false);
			}
			if(divgroupMeta.length){
				divgroupMeta.find('select[name=meta_edition_goalSing]').prop("disabled", false);
				divgroupMeta.find('input[name=meta_edition_goal]').prop("readonly", false);
			}
			buttonEditGoals.addClass('save_edit_goals')
			buttonEditGoals.removeClass('edit_goals')

		})
		$(document).on('click', 'button.remove_withoutsave_goal', function(e){
			e.preventDefault()
			let button = $(this)
			if(divgroupLimit.length){
				divgroupLimit.find('input').prop("readonly", true);
			}
			if(divgroupMeta.length){
				divgroupMeta.find('select[name=meta_edition_goalSing]').prop("disabled", true);
				divgroupMeta.find('input[name=meta_edition_goal]').prop("readonly", true);
			}
			// button.html("<i class='fas fa-pen'></i>")
			buttonEditGoals.html("<i class='fas fa-pen'></i>")
			buttonEditGoals.removeClass('save_edit_goals')
			buttonEditGoals.addClass('edit_goals')

			button.addClass('log_goals')
			button.removeClass('remove_withoutsave_goal button-9')
			button.html('<i class="fas fa-file-signature">')
			button.hide()
			button.prop("disabled", true);
		})
		
		$(document).on('click', 'button.save_edit_goals', function(e){
			e.preventDefault();
			let button = $(this)
			let idGoalRecord = button.closest('.group').data('id')
			let select_meta = button.closest('.group').find('.meta_div').find('select[name=meta_edition_goalSing]')
			let input_meta = button.closest('.group').find('.meta_div').find('input[name=meta_edition_goal]')
			let newMeta = null

			if(divgroupMeta.length){
				if(htmlEntityChecker(select_meta.val())==-1){
					newMeta = input_meta.val()
				}else{
					if(input_meta.val()){
						newMeta = select_meta.val()+" "+input_meta.val()	
					}				
				}
			}
			
			
			let nuewLsup = button.closest('.group').find('.limit_div').find('input[name=meta_edition_lsup]').val()
			let nuewLinf = button.closest('.group').find('.limit_div').find('input[name=meta_edition_linf]').val()

			$.post( "/indicator/indicator/indicators/edit_indicator_goals", { id: idGoalRecord, goal: newMeta, upper_limit: nuewLsup, lower_limit:nuewLinf })

        	.done(function( data ) {
        		if(divgroupLimit.length){
							divgroupLimit.find('input').prop("readonly", true);
						}
						if(divgroupMeta.length){
							divgroupMeta.find('select[name=meta_edition_goalSing]').prop("disabled", true);
							divgroupMeta.find('input[name=meta_edition_goal]').prop("readonly", true);
						}
						button.html("<i class='fas fa-pen'></i>")
						button.removeClass('save_edit_goals')
						button.addClass('edit_goals')
						if(!nuewLsup && !nuewLinf &&  !newMeta){
							divGroup.hide('slow');
						}
        	});
		})

		$(document).on('click', '.alert-warning', function(){
			var infoi = $(this).closest('.alert-warning').find('.info_expand_warning')
			if(infoi.css('display') == 'none'){
				infoi.show('medium');
			}else{
				infoi.hide('medium');
			}
		})
		$(document).on('click', '.add_goals', function(e){
			e.preventDefault();
			var button = $(this)
			var div = button.closest('.tab').find('.hidden_add')
			div.show('slow');
			button.html('-')
			button.addClass('remove_goals');
			button.removeClass('add_goals');
		})
		$(document).on('click', '.remove_goals',  function(e){
			e.preventDefault();
			var button = $(this)
			var div = button.closest('.tab').find('.hidden_add')
			div.hide('slow');
			button.html('+')
			button.addClass('add_goals');
			button.removeClass('remove_goals');
		})
		<?php
			$js_array = json_encode($goals);
			echo "var goals = ". $js_array . ";\n";
		?>
		$.each(goals, function(idx, ent) {
        var symbol_html = htmlEntityChecker(ent.goal);
				switch (symbol_html) {
				  case 0:
				    $('select#metakind_'+ent.id+' option:nth-child(1)').attr("selected", true);
				    break;
				  case 1:
				    $('select#metakind_'+ent.id+' option:nth-child(2)').attr("selected", true);
				    break;
				  case 2:
				     $('select#metakind_'+ent.id+' option:nth-child(3)').attr("selected", true);
				    break;
				  case 3:
				    $('select#metakind_'+ent.id+' option:nth-child(4)').attr("selected", true);
				    break;
				  default:
		    		$('select#metakind_'+ent.id+' option:nth-child(5)').attr("selected", true);
				}
    });


		
		$('.select2_custom').prop('required',true);
		if( $('#input_2').prop('checked')){
			document.getElementById("upper_limit1").style.display = "none";
			document.getElementById("goal1").style.display = "block";
		}else{
			document.getElementById("upper_limit1").style.display = "block";
			document.getElementById("goal1").style.display = "none";
		}

		$("input[type=radio]").on( 'keyup click', function () {
			let action = $(this).data("value");
			if(action == '1'){
				document.getElementById("upper_limit1").style.display = "block";
				document.getElementById("goal1").style.display = "none";
			}
			if(action =='2'){
				document.getElementById("upper_limit1").style.display = "none";
				document.getElementById("goal1").style.display = "block";
			}
		} );

	});
</script>