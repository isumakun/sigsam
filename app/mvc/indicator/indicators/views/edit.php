<?php 
$calendar = new Calendar();
?>
<style type="text/css">
  .pdd_20{
    padding-top: 20px;
  }
  .pdd_20 > select{
    border: none;
    text-align-last: center;
  }
</style>
<h2>Editar Registro:</h2>
<form method="POST" enctype="multipart/form-data" name="theForm" id="theForm">
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
	<div class="row marginb">
		<div class="col-md-6 indi">
			<div class="form-group" id="opciones" >
				<table>
					<label for="">Opciones:</label>
					<th>
						<input type="radio" checked name="opc" value="2" id="input_2" data-value="2" style="appearance: auto; margin-bottom: 0;" <?= (!$gl1)? 'checked' : '' ?> >Meta
					</th>
					<th>
						<input type="radio" name="opc" value="1" id="input_1" data-value="1" style="appearance: auto;margin-bottom: 0;" <?= ($gl1)?  'checked' : '' ?> >Limites
					</th>
				</table>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group col-md-12" id="upper_limit1" style="display:none;">
				<div class="row">
					<div class="col-md-6">
					<label for="upper_limit"  >Limite Superior:</label>
					<input name="upper_limit" value="<?=$indicator[0]['upper_limit']?>" type="text"/>
				</div>
				<div class="col-md-6">
					<label for="lower_limit">Limite inferior:</label>
					<input name="lower_limit" value="<?=$indicator[0]['lower_limit']?>" type="text"/>
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
					<input name="goal" value="<?=$matches_goal?>" type="text"/>
		          </div>
		        </div>
			</div>
		</div>		
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

		<div class="col-md-12">
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
	<input class="confirmp save" type="button" value="Guardar" />
	<input style="display: none;" class="submit save" type="submit" value="Guardar" />
</form>
<script>
	$(document).ready(function(){
		var symbol_html = htmlEntityChecker('<?=$indicator[0]['goal']?>');
		switch (symbol_html) {
		  case 0:
		    $('select[name="metakind"] option:nth-child(1)').attr("selected", true);
		    break;
		  case 1:
		    $('select[name="metakind"] option:nth-child(2)').attr("selected", true);
		    break;
		  case 2:
		     $('select[name="metakind"] option:nth-child(3)').attr("selected", true);
		    break;
		  case 3:
		    $('select[name="metakind"] option:nth-child(4)').attr("selected", true);
		    break;
		  default:
    		$('select[name="metakind"] option:nth-child(5)').attr("selected", true);
		}
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