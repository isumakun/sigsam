<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data" name="theForm" id="theForm">
	<label for="category_id">Categoría :</label>
		<select name="category_id" id="category">
			<option></option>
            <?php foreach($category AS $ca) { ?>
			<option value="<?=$ca['id']?>" <?=($indicator['category_id'] == $ca['id'] ? 'selected' : '')?>><?=$ca['name']?></option>
            <?php }   ?>
		</select>
		<label for="name">Nombre:</label>
		<input name="name" value="<?=$indicator['name']?>" type="text"/>

		<label for="formula">Fórmula:</label>
		<input name="formula" value="<?=$indicator['formula']?>" type="text"/>
        <div class="row">

		</div>
		<div class="col-md-5 indi">
		<div class="form-group" id="opciones" >
                    <label for="">Opciones:</label>
                    <input type="radio" name="opc" value="2" onchange="mostrar(this.value);"><br>Meta<br>
					<br><input type="radio" name="opc" value="1"  onchange="mostrar(this.value);">Limites
                </div>
                <div class="form-group" id="upper_limit1" style="display:none;">
				<label for="upper_limit"  >Limite Superior:</label>
				 <input name="upper_limit" value="<?=$indicator['upper_limit']?>" type="text"/>
				 <label for="lower_limit">Limite inferior:</label>
		        <input name="lower_limit" value="<?=$indicator['lower_limit']?>" type="text"/>
                </div>
                <div class="form-group" id="goal1" style="display:none;">
				<label for="goal">Meta:</label>
				 <input name="goal" value="<?=$indicator['goal']?>" type="text"/>
                </div>
            </div>
	
		<div class="indi">
		<label for="type_id">Tipo de indicador:</label>
		<select name="type_id">
		<option value=""></option>
       <?php foreach($types AS $t) { ?>
			<option value="<?=$t['id']?>" <?=($indicator['type_id'] == $t['id'] ? 'selected' : '')?>><?=$t['name']?></option>
         <?php  } ?>
		</select>
		</div>
		<label for="process_id">Proceso:</label>
		<select name="process_id">
		<option value=""></option>
       <?php foreach($process AS $p) { ?>
			<option value="<?=$p['id']?>" <?=($indicator['process_id'] == $p['id'] ? 'selected' : '')?>><?=$p['name']?></option>
         <?php  } ?>
		</select>
		<label for="charge_id">Responsable:</label>
		<select name="charge_id">
		<option value=""></option>
        <?php foreach($charges AS $c) { ?>
			<option value="<?=$c['id']?>" <?=($indicator['charge_id'] == $c['id'] ? 'selected' : '')?>><?=$c['first_name']?> <?=$c['last_name']?></option>
         <?php } ?>
		</select>
		<label for="frequency_id">Frecuencia:</label>
		<select name="frequency_id">
		<option value=""></option>
       <?php foreach($frequency AS $f) { ?>
			<option value="<?=$f['id']?>" <?=($indicator['frequency_id'] == $f['id'] ? 'selected' : '')?>><?=$f['name']?></option>
         <?php  } ?>
		</select>
	
		<label for="unit">Unidad:</label>
		<input name="unit" value="<?=$indicator['unit']?>" type="text"/>
		<input class="submit save" type="submit" value="Guardar" />
	</form>
	<script>
	function mostrar(dato){
        if(dato=="1"){
            document.getElementById("upper_limit1").style.display = "block";
            document.getElementById("goal1").style.display = "none";
        }
        else{
            document.getElementById("upper_limit1").style.display = "none";
            document.getElementById("goal1").style.display = "block";
        }
     
    }
	</script>