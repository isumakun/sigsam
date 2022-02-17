<style>

</style>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
<div class="card">
  <figure class="highcharts-figure">
    <div id="container"></div>
    <p class="highcharts-description"></p>

    <div class="row">
      <div class="col text-center">
        <button id="plain" class="square_button">Plana</button>
        <button id="inverted" class="square_button">Invertida</button>
        <button id="polar" class="square_button">Polar</button>
      </div>
        
    </div>
    
  </figure>
  <div class="col-md-12">
    <center>
      <div class="col-md-4">
        <label for="age">Año</label>
        <select name="age_id" id="age_id">
        <?php foreach($ages AS $a) { ?>
    			<option value="<?=$a['id']?>" <?=($indicator['age_id'] == $a['id'] ? 'selected' : '')?>><?=$a['name']?></option>
             <?php  } ?>
        </select>
      </div><br>
    </center>
    <div class="row">
      <section class="tabs">
        <input id="tab-1" type="radio" name="radio-set" class="tab-selector-1" checked="checked" />
            <label for="tab-1" class="tab-label-1">Periodico</label>
    
              <input id="tab-2" type="radio" name="radio-set" class="tab-selector-2" />
            <label for="tab-2" class="tab-label-2">Parciales</label>
    
              <input id="tab-3" type="radio" name="radio-set" class="tab-selector-3" />
            <label for="tab-3" class="tab-label-3">Finales </label>
            
          <div class="clear-shadow"></div>

        <div class="content_">
          <div class="content-1">
            <table class="dataTables_wrapper no-footer" >
              <thead>
                <th>Periodo</th>
                <th>Valor</th>
                <th>Analisis</th>
                <th>Acciones</th>
              </thead>
              <tbody  id="table_yellow">
                <?php foreach ($indicators as $cb) { ?>
                  <tr>
                    <td><?=$cb['period']?></td>
                    <td><?=$cb['value']?></td>
                    <td><?=$cb['inform']?></td>
                    <td>
                      <?php if (has_role(1)) { ?>
                        <div class="strech nowrap">
                          <a href="../values/edit?id=<?=$cb['id']?>" class="button edit"><span class="icon edit"></span></a>&nbsp;
                          <a href="../values/delete?id=<?=$cb['id']?>" class="delete button "><span class="icon delete"></span></a>
                        </div>
                      <?php } ?>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          <div class="content-2"></div>
          <div class="content-3"></div>
        </div>
      </section>        
    </div>
  </div>
</div>

<script>
  
  var type = "<?= $analysis[0]['unit']; ?>";  
  var data_csv =  "<?= $graph[0]['value']; ?>";
  data_csv = data_csv.split(',');
  data_csv.forEach(logArrayElements);
  // if(type == "Horas"){
    
  //   data_csv.forEach(logArrayElements);
  // }

function logArrayElements(element, index, array) {
// console.log(element)
  let match = element.toString().match(/^\s*\d+\s*(([hH]|horas?)?\s*((:)?\s*(?<=:)(\d{1,2}))?\s*(((?<!\d{1})\d)?((min)|(m))?)?)\s*$/g);
  let n1=0;
  let n2 = 0;
  if(match){
    // console.log(match[0].match(/\d+/g)[1])
    if(n1 = match[0].match(/\d+/g)[0]){
      if(n2 = match[0].match(/\d+/g)[1]){
        array[index] = (n1+'.'+n2)*1;
      }else{
        array[index] = n1*1;
      }
    }
  }else{
    array[index] = element*1;
  }
}

    var chart = Highcharts.chart('container', {

title: {
    <?php foreach ($analysis AS $key) { ?>
        text:  '<?=$key['ind']?>'
  <?php } ?>
},

subtitle: {
  text: 'Plana'
},

xAxis: {
  categories: [<?= $graph[0]['period']; ?>]
},

series: [ {
  type: 'column',
  colorByPoint: true,
  data: data_csv,
  showInLegend: false
},
{
    type: 'spline',
    name: 'Tendencia',
    data: data_csv,
    marker: {
      lineWidth: 2,
      lineColor: Highcharts.getOptions().colors[1],
      fillColor: 'white'
    }
  },
 
]

});


$('#plain').click(function () {
chart.update({
  chart: {
    inverted: false,
    polar: false
  },
  subtitle: {
    text: 'Plana'
  }
});
});

$('#inverted').click(function () {
chart.update({
  chart: {
    inverted: true,
    polar: false
  },
  subtitle: {
    text: 'Invertida'
  }
});
});

$('#polar').click(function () {
  chart.update({
    chart: {
      inverted: false,
      polar: true
    },
    subtitle: {
      text: 'Polar'
    }
  });
});
    $('#age_id').on("keyup change", function () {
      var id1 = <?=$_GET['id']?>;
        if($('#age_id').val()){
            $.get("/indicator/indicator/indicators/report_filter", 
            { age_id: $('#age_id').val(),
              id: id1
             }, function(data) {
                datos= JSON.parse(data);
                var info ='';
                for (const fa of datos.filter_age){
                  info+=`<tr><td>`+ fa.period +`</td>
                   <td>`+ fa.value +`</td>
                   <td>`+ fa.inform +`</td>
                   <td>
                    <?php if (has_role(1)) { ?>
                      <div class="strech nowrap">
                      <a href="../values/edit?id=`+ fa.id +`" class="button edit"><span class="icon edit"></span></a>&nbsp;
                      <a href="../values/delete?id=`+ fa.id +`" class="delete button "><span class="icon delete"></span></a>
                    </div>
                    <?php } ?>
                   </td>
                   </tr>`;
                }
                document.getElementById("table_yellow").innerHTML= info

            }
            
            )
            $.get("/indicator/indicator/indicators/report_graph_filter", 
            { age_id: $('#age_id').val(),
              id: id1
             }, function(data) {
                datos= JSON.parse(data);
                var info ='';
                for (const fa of datos.filter_graph){
                  var period1 =fa.period
                  var value1 = fa.value 
               
                console.log(datos.filter_graph)
              }
                var chart = Highcharts.chart('container', {

title: {
  <?php foreach ($analysis AS $key) { ?>

        text:  '<?=$key['ind']?>'
        <?php
  }
        ?>
},

subtitle: {
  text: 'Plana'
},
xAxis: {
  categories: [period1]
},

series: [ {
  type: 'column',
  colorByPoint: true,
  data: [value1],
  showInLegend: false
},
{
    type: 'spline',
    name: 'Tendencia',
    data: [value1],
    marker: {
      lineWidth: 2,
      lineColor: Highcharts.getOptions().colors[1],
      fillColor: 'white'
    }
  },
]

});


$('#plain').click(function () {
chart.update({
  chart: {
    inverted: false,
    polar: false
  },
  subtitle: {
    text: 'Plana'
  }
});
});

$('#inverted').click(function () {
chart.update({
  chart: {
    inverted: true,
    polar: false
  },
  subtitle: {
    text: 'Invertida'
  }
});
});

$('#polar').click(function () {
chart.update({
  chart: {
    inverted: false,
    polar: true
  },
  subtitle: {
    text: 'Polar'
  }
});
});
              
                
            }
            
            );
       
          }
     
    } );
</script>