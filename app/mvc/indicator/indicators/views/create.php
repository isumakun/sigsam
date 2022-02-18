<?php 
$calendar = new Calendar();
?>
<style type="text/css">
	textarea.select2-search__field{
		/* display:none; */
    position: absolute;
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
</style>
<h2> Registro</h2>
<form method="POST" enctype="multipart/form-data">
  <div class="row marginb">
    <div class="col-md-4">
      <label for="category_id">Categoría :</label>
      <select name="category_id" id="category">
        <option></option>
        <?php foreach($category AS $ca) { ?>
          <option value="<?=$ca['id']?>" ><?=$ca['name']?></option>
        <?php }   ?>
      </select>
    </div>
    <div class="col-md-8">
      <label for="name">Nombre:</label>
      <input name="name" autocomplete="off" required/>
    </div>
  </div>
  <div class="row marginb">
    <div class="col-md-12">
      <label for="formula">Fórmula:</label>
      <input name="formula" autocomplete="off" required/>
    </div>
  </div>
  <div class="row marginb">
    <div class="col-md-6 indi">
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
      <div class="form-group col-md-12" id="upper_limit1" style="display:none;">
        <div class="row">
          <div class="col-md-6">
            <label for="upper_limit"  >Limite Superior:</label>
            <input name="upper_limit" type="text"/>
          </div>
          <div class="col-md-6">
            <label for="lower_limit">Limite inferior:</label>
            <input name="lower_limit" type="text"/>
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
            <input name="goal" type="text"/>
          </div>
        </div>          
      </div>
    </div>    
  </div>
  <div class="row marginb">
    <div class="col-md-4">
      <label for="type_id">Tipo de indicador:</label>
      <select name="type_id">
        <option value=""></option>
        <?php foreach($types AS $t) { ?>
          <option value="<?=$t['id']?>" ><?=$t['name']?></option>
        <?php  } ?>
      </select>
    </div>
    <div class="col-md-8">
      <label for="process_id">Proceso:</label>
      <select name="process_id">
        <option value=""></option>
        <?php foreach($process AS $p) { ?>
          <option value="<?=$p['id']?>" ><?=$p['name']?></option>
        <?php  } ?>
      </select>
    </div>
  </div>

    <div class="row marginb">
      <div class="col-md-12">
        <label for="charge_id">Responsables:</label>
        <select class='select2_custom' name='charge_id[]' multiple='multiple' id="charge_id">
          <?php foreach($charges AS $c) { ?>
            <option value="<?=$c['id']?>">[<?=$c['first_name']?> <?=$c['last_name']?>] %<?=$c['job_position']?>% </option>
          <?php } ?>
        </select>
      </div>
      <div class="col-md-6 marginb">
        <label for="frequency_id">Frecuencia:</label>
        <select name="frequency_id">
          <option value=""></option>
          <?php foreach($frequency AS $f) { ?>
            <option value="<?=$f['id']?>"><?=$f['name']?></option>
          <?php  } ?>
        </select>
      </div>
      <div class="col-md-6 marginb">
        <label for="unit">Unidad:</label>
        <input name="unit" type="text"/>
      </div>
    </div>
  
  <input class="confirmp save" type="button" value="Guardar" />
  <input style="display: none;" class="submit save" type="submit" value="Guardar" />
</form>
<script>
  jQuery(document).ready(function($){
    $('.select2_custom').prop('required',true);
    $(document).ready(function() {
      $('.js-example-basic-multiple-limit').select2();
    });
  });
  $('#category').on('change',function(){
    var selectValor = $(this).val();
    if (selectValor == '2') {
      $('.indi').show();
    }else {
      $('.indi').hide();
    }
  });

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
</script>