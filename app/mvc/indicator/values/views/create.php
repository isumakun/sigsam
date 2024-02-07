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
<?php 
$calendar = new Calendar();
?>
<h2>Registro</h2>

<form method="POST" action="" enctype="multipart/form-data">
		
	<label for="indicator_id">Indicador: <?= $indicators[0]['name'] ?></label>
  <input style="display:none;" type="text" name="indicator_id" value="<?= $indicators[0]['id'] ?>">
	
  
  <div class="row marginb">
    
      <?php if($frequencies['frequency_id']!=1){ ?>
    <div class="col-md-4">
      <label for="age_id">Periodo:</label>
       <select id="age" name="period_id" required>
        <option selected="selected" disabled="disabled" value="">Seleccionar</option>
          <?php foreach($period AS $p) { ?>
            
            <option value="<?=$p['id']?>" ><?=$p['name']?></option>
          <?php }  ?>
      </select>
    </div>
    <?php } ?>
    
    <div class="col-md-4">
      <label for="period_id">Año:</label>
      <select name="age_id" required>
        <option selected="selected" disabled="disabled" value="">Seleccionar</option>
          <?php foreach($age AS $ag) { ?> ?>
            <option value="<?=$ag['id']?>" ><?=$ag['age']?></option>
          <?php }  ?>
      </select>
     
    </div>
    <div class="col">
      <label for="value">Valor:</label>
       <?php if ($indicators[0]['unit']=="Horas") {?>

          <input type="text" name="value" id="durationForm" maxlength=8 pattern="^\s*\d+\s*(([hH]|horas?)?\s*((:)?\s*(?<=:)(\d{1,2}))?\s*(((?<!\d{1})\d)?((min)|(m))?)?)\s*$"
      title="Cantidad de tiempo 00:00 (horas, minutos), 
            puede escribirlo como 
             &quot;00h 00m&quot; o &quot;00h: 00min&quot;."
      placeholder="hh:mm" size=30 required>
      <?php }else{ ?>
        <input name="value" type="text" required/>
     <?php } ?>
    </div>
  </div>
  <div class="row marginb" id="final_report_option">
    
  </div>
  
<div id="inform_div" >
  <div>
    <label style="width:auto" for="analysis">Análisis :</label>
    <input type="text" name="inform_type" value="1" style="display: none;">
    <select id="inform_class" name="inform_class"  style="width: auto;float: inherit;border: #357cbb;">
      <?php foreach ($inform_class as $key) { ?>
        <?php if ($frequencies['frequency_id']!=1 && $key['id'] != 2 ) { ?>
          <option value="<?= $key['id'] ?>"><?= $key['name'] ?></option>
        <?php }else{  if ($frequencies['frequency_id']==1){ ?>
          <option value="<?= $key['id'] ?>"><?= $key['name'] ?></option>
        <?php }} ?>        
      <?php } ?>      
    </select>
  </div>  
  <textarea class="marginb" name="inform" rows="4" cols="50" required></textarea>
  <div id="final_inform">

  </div>
</div>
	

<!--   <div class="indi">
    <label for="analysis_end">Análisis del año :</label>
    <textarea name="analysis_end" rows="4" cols="50"></textarea>
  </div> -->
  <div class="row marginb" style="display: inline-flex !important;">
    <div class="col-md-12 marginb">
      <label for="support">Soporte:</label>
      <input type="file"  name="support" required >
    </div>
    <div class="col-md-12">
      <label for="support">Segundo Soporte:</label>
      <input type="file"  name="support1">
    </div>
  </div>
	
	<input class="confirmp save blueDf" type="button" value="Guardar" />
  <input style="display: none;" class="submit save" type="submit" value="Crear" />
</form>

<script src="<?=BASE_URL?>public/highcharts.js"></script>
<script src="<?=BASE_URL?>public/data.js"></script>
<script src="<?=BASE_URL?>public/exporting.js"></script>
<script src="<?=BASE_URL?>public/accessibility.js"></script>
<script  type="text/javascript">

  $(document).ready(function() {

  $('#age').on('change',function(){
    var selectValor = $(this).val();    
    var html =`
    <div class="col-md-12">
      <table>
        <th>
          <input class="final_report" type="checkbox" name="final_report" value="1" style="appearance: auto; margin-bottom: 0;"><span> Agregar análisis final?</span>
        </th>
      </table>      
    </div>`;

    if (selectValor == 105 || selectValor == 96 || selectValor == 100 || selectValor == 102) {
      $('#final_report_option').hide();
      $('#final_report_option').html(html);
      $('#final_report_option').show('slow');
    }else {
      $('#final_report_option').hide('slow');
      $('#final_report_option').html('');

    }
  });

  $('#final_report_option').on('change', function(){ 
  
    var type = "<?= $indicators[0]['unit']; ?>";
    var regex = /^\s*\d+\s*(([hH]|horas?)?\s*((:)?\s*(?<=:)(\d{1,2}))?\s*(((?<!\d{1})\d)?((min)|(m))?)?)\s*$/;
    let option1 = `<input type="text" name="finalValue" id="finalDurationForm" maxlength=8 pattern=""
      title="Cantidad de tiempo 00:00 (horas, minutos), 
            puede escribirlo como 
             &quot;00h 00m&quot; o &quot;00h: 00min&quot;."
      placeholder="hh:mm" size=30 required>`;
      let option2 = `<input name="finalValue" type="text" required/>`;
    var html = `
    <div>
    <div>
      <label for="value">Valor:</label>${(type=='Horas')? option1 : option2} 
    </div>
      <label style="width:auto">Análisis : Final</label>
      <textarea class="marginb" name="final_inform" rows="4" cols="50" required></textarea>
    </div>`;
     
    if( $('input.final_report').prop('checked') ){
      $('#final_inform').hide();
      $('#final_inform').html(html);
      $('#final_inform').show('slow');
    }else{
      $('#final_inform').hide('slow');
      $('#final_inform').html('');
    }
  })


  // two or more digits, to be more precise (might get relevant for durations >= 100h)

} );





// var twoDigits = function (oneTwoDigits) {
//     if (oneTwoDigits < 10) {oneTwoDigits = "0" + oneTwoDigits}; 
//     return oneTwoDigits;
// }

// var Time = function (durationFormValue) {
//     var hmsString = String(durationFormValue);
//     var hms = hmsString.match(/^(?:(?:(\d+)\:)?(\d+)\:)?(\d+)$/);
//     if (hms === null) {
//         throw new TypeError("Parameter " + hmsString + 
//                             " must have the format ((int+:)?int+:)?int+");
//     }
//     var hoursNumber = +hms[1] || 0;
//     var minutesNumber = +hms[2] || 0;
//     var secondsNumber = +hms[3] || 0;
//     this.seconds = twoDigits(secondsNumber % 60);
//     minutesNumber += Math.floor(secondsNumber / 60);
//     this.minutes = twoDigits(minutesNumber % 60);
//     hoursNumber += Math.floor(minutesNumber / 60);
//     this.hours = twoDigits(hoursNumber);
// };

// Time.prototype.equals = function (otherTime) {
//     return (this.hours === otherTime.hours) &&    
//        (this.minutes === otherTime.minutes) &&
//            (this.seconds === otherTime.seconds);
// };    

// Time.prototype.toString = function () {
//     return this.hours + ":" + this.minutes + ":" + this.seconds;
// }


	</script>
