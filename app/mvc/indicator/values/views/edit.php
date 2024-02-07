<style>
	#container2 {
  height: 400px;
}

.highcharts-figure, .highcharts-data-table table {
  min-width: 310px;
  max-width: 800px;
  margin: 1em auto;
}

#datatable {
  font-family: Verdana, sans-serif;
  border-collapse: collapse;
  border: 1px solid #EBEBEB;
  margin: 10px auto;
  text-align: center;
  width: 100%;
  max-width: 500px;
}
#datatable caption {
  padding: 1em 0;
  font-size: 1.2em;
  color: #555;
}
#datatable th {
	font-weight: 600;
  padding: 0.5em;
}
#datatable td, #datatable th, #datatable caption {
  padding: 0.5em;
}
#datatable thead tr, #datatable tr:nth-child(even) {
  background: #f8f8f8;
}
#datatable tr:hover {
  background: #f1f7ff;
}
</style>

<h3>Editar Registro</h3>
	<h5 class="marginb">Indicador: <?=$indicators['name']?></h5>
	<form method="POST"  enctype="multipart/form-data">
    <input type="text" name="indicator_id" style="display: none;" value="<?= $indicators['id'] ?>">

<div class="row marginb">
    
      <div class="col-md-4">
        <label for="period_id">Año:</label>
        <select name="age_id" required>
          <?php foreach($age AS $ag) { ?> ?>
          <option value="<?=$ag['id']?>" <?=($indicators['age_id'] == $ag['id'] ? 'selected' : '')?>><?=$ag['age']?></option>
        <?php }  ?>
      </select>
    </div>
  
  <?php if($indicators['frequency_id']!=1){ ?>
    <div class="col-md-4">
      <label for="period_id">Periodo:</label>
      <select id="age" name="period_id" required>
       <?php foreach($period AS $p) { if ($p['indicator_id'] == $indicators['id']) {  ?> ?>
        <option value="<?=$p['id']?>" <?=($indicators['period_id'] == $p['id'] ? 'selected' : '')?>><?=$p['name']?></option>
        <?php }}  ?>
      </select>
    </div>
  <?php } ?>
  <div class="col">
    <label for="value">Valor:</label>
    <?php if($indicators['unit'] == "Horas" ){ ?>
      <input type="text" name="value" id="durationForm" maxlength=8 pattern="^\s*\d+\s*(([hH]|horas?)?\s*((:)?\s*(?<=:)(\d{1,2}))?\s*(((?<!\d{1})\d)?((min)|(m))?)?)\s*$"
    title="Cantidad de tiempo 00:00 (horas, minutos), 
          puede escribirlo como 
           &quot;00h 00m&quot; o &quot;00h: 00min&quot;."
    placeholder="hh:mm" size=30 value="<?=$indicators['value']?>">
    <?php }else { ?>
      <input name="value" value="<?=$indicators['value']?>" type="text"/>
     <?php } ?>
  </div>
</div>
    <div id="inform_div">
      <div>
        <label style="width:auto" for="analysis">Análisis :</label>
        <input type="text" name="inform_type_id" value="1" style="display: none;">
        <select id="inform_class_id" name="inform_class_id"  style="width: auto;float: inherit;border: #357cbb;">
          <?php foreach ($inform_class as $key) { ?>
            <?php if ($indicators['frequency_id']!=1 && $key['id'] != 2 ) { ?>
              <option value="<?= $key['id'] ?>" <?= ($key['id']==$indicators['inform_class_id'])? 'selected' : '' ?> ><?= $key['name'] ?></option>
            <?php }else{  if ($indicators['frequency_id']==1){ ?>
              <option value="<?= $key['id'] ?>" <?= ($key['id']==$indicators['inform_class_id'])? 'selected' : '' ?> ><?= $key['name'] ?></option>
            <?php }} ?>        
          <?php } ?>      
        </select>
      </div>  
      <textarea class="marginb" name="inform" rows="6" cols="50" required><?=$indicators['inform']?></textarea>
    </div>


<div class="row marginb">
  <div class="col-md-12 marginb">
    <label for="support">Soporte:</label>
    <input type="file" value="<?=$indicators['support']?>" name="support">
  </div>
  <div class="col-md-12">
    <label for="support1">Segundo Soporte:</label>
    <input type="file" value="<?=$indicators['support1']?>" name="support1"><br>
  </div>
</div>
		<div class="btn-group">
      <input class="confirmp save blueDf" type="button" value="Guardar" />
      <input style="display: none;" class="submit save" type="submit" value="Crear" />
    </div>
	</form>
<script  type="text/javascript">

</script>
