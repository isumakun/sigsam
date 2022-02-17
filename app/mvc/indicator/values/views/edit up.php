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
	<h5><?=$indicators['name']?></h5>
	<form method="POST" enctype="multipart/form-data">

 <?php
   if($frequencies['frequency_id']!=1){
 ?>
		<label for="period_id">Año:</label>
		<select name="age_id">
     <?php foreach($age AS $ag) { ?> ?>
			<option value="<?=$ag['id']?>" <?=($indicators['age_id'] == $ag['id'] ? 'selected' : '')?>><?=$ag['age']?></option>
      <?php }  ?>
    </select>
    <?php
      }
    ?>
		<label for="period_id">Periodo:</label>
		<select id="age" name="period_id">
     <?php foreach($period AS $p) { if ($p['indicator_id'] == $indicators['id']) {  ?> ?>
			<option value="<?=$p['id']?>" <?=($indicators['period_id'] == $p['id'] ? 'selected' : '')?>><?=$p['name']?></option>
      <?php }}  ?>
		</select>

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
		
		<label for="analysis">Análisis del periodo :</label>
    <textarea name="analysis" rows="4" cols="50" required><?=$indicators['analysis']?></textarea>
    <div class="indi">
		<label for="analysis_end">Análisis del año :</label>
    <textarea name="analysis_end" rows="4" cols="50"><?=$indicators['analysis_end']?></textarea>
    </div>
		<label for="support">Soporte:</label>
		<input type="file" value="<?=$indicators['support']?>" name="support">
		<label for="support1">Segundo Soporte:</label>
		<input type="file" value="<?=$indicators['support1']?>" name="support1"><br>
		<div class="btn-group"><input class="submit save" type="submit" value="editar" /></div>
	</form>
<script  type="text/javascript">
$('#age').on('change',function(){
        var selectValor = $(this).val();
        console.log(selectValor)
        if (selectValor == 105 || selectValor == 96 || selectValor == 100 || selectValor == 102) {
            $('.indi').show();
        }else {
          $('.indi').hide();
        }
    });
	</script>
