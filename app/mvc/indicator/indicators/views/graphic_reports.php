<style type="text/css">
  .highcharts-figure, .highcharts-data-table table {
    min-width: 310px; 
    max-width: 800px;
    margin: unset;
  }
  .highcharts-data-table table {
  	font-family: Verdana, sans-serif;
  	border-collapse: collapse;
  	border: 1px solid #EBEBEB;
  	margin: 10px auto;
  	text-align: center;
  	width: 100%;
  	max-width: 500px;
  }
  .highcharts-data-table caption {
      padding: 1em 0;
      font-size: 1.2em;
      color: #555;
  }
  .highcharts-data-table th {
  	font-weight: 600;
      padding: 0.5em;
  }
  .highcharts-data-table td, .highcharts-data-table th, .highcharts-data-table caption {
      padding: 0.5em;
  }
  .highcharts-data-table thead tr, .highcharts-data-table tr:nth-child(even) {
      background: #f8f8f8;
  }
  .highcharts-data-table tr:hover {
      background: #f1f7ff;
  }


  /* Link the series colors to axis colors */
  .highcharts-color-0 {
  	fill: #7cb5ec;
  }
  .highcharts-axis.highcharts-color-0 .highcharts-axis-line {
  	stroke: #7cb5ec;
  }
  .highcharts-axis.highcharts-color-0 text {
  	fill: #7cb5ec;
  }
  .highcharts-color-1 {
  	fill: #90ed7d;
  	stroke: #90ed7d;
  }
  .highcharts-axis.highcharts-color-1 .highcharts-axis-line {
  	stroke: #90ed7d;
  }
  .highcharts-axis.highcharts-color-1 text {
  	fill: #90ed7d;
  }


  .highcharts-yaxis .highcharts-axis-line {
  	stroke-width: 2px;
  }
  .fixTableHead {
        overflow-y: auto;
        height: 110px;
      }
      .fixTableHead thead th {
        position: sticky;
        top: 0;
      }
      table {
        border-collapse: collapse;        
        width: 100%;
      }
  #main_content{
  	background: white;
  }
  .relative{
    position: relative;
  }
  .insd_rltv{
    position: absolute;
    top: 0;
    left: 0;
    font-size: 16px;
  }
  .hide_insd{
    display: none;
  }
  .highlight_row, .highlight_row + tr{
    background-color:#CCC !important; 
    color:#000;
  }
  .details-control{
    cursor: pointer;
  }
  thead th{
    z-index: 2;
  }
  .pdd_left_15{
    padding-left: 15px !important;
  }
</style>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/coloraxis.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<!-- <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script> -->
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" type="text/javascript">
</script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript">
</script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js" type="text/javascript"></script>
<!-- <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" /> -->
<input type="text" id="frequency_id" name="frequency_id" value="<?= $indicators[0]['frequency_id'] ?>" style="display: none;">
<div class="row" style="height: 100%">
	<div class="col-md-4">
		<figure class="highcharts-figure" style="padding-top:40px; height: 90%;">
		    <div id="container23" style="height: 100%;"></div>
        <center>
          <button id="plain">Plana</button>
          <button id="inverted">Invertida</button>
          <button id="polar">Polar</button>
        </center>
        
		</figure>
	</div>
  
  
<div class="col" style="overflow-y: auto; height: 100%;">
  <div class="col fixTableHead no_responsive custom_scroll" style="width: 100%; height: 100%;">
    <div class="col-md-12" style="margin: 15px 0;">
    <div class="row">
      <div class="col-md-4">
      <label for="age" style="display:inline-block; width: auto;">Año:    </label>
      <select name="age_id" id="age_id" style="width: 90%;">
      <?php foreach($ages AS $a) { ?>
        <option value="<?=$a['name']?>" <?=($indicators[0]['age_id'] == $a['id'] ? 'selected' : '')?>><?=$a['name']?></option>
           <?php  } ?>
      </select>
      </div>
      <div class="col-md-">
      <label for="registers_type" style="display:inline-block; width: auto;">Registros:</label>
      <select name="registers_type" id="registers_type" style="width: 90%;">
        <option value="1" <?=($indicators[0]['inform_class_id'] == 1 ? 'selected' : '')?>>Peri&oacute;dicos</option>
        <option value="3" <?=($indicators[0]['inform_class_id'] == 3 ? 'selected' : '')?>>Finales</option>
        </select>
      </div>
    </div>
    </div>
    <div class="div_info_table">
      <table id="info_table">
        <thead>
          <tr>
            <th>Periodo</th>
            <th>Resultado</th>
            <th>Analisis</th>
          </tr>
        </thead>
        <tbody id="table_yellow">
          <?php foreach ($indicators as $cb) { ?>
                <tr>
                  <td class="relative pdd_left_15">
                    <div class="insd_rltv">
                      <i class="fas fa-angle-right"></i>
                    </div>
                    <?= ($cb['frequency_id']=='1')? $cb['name'] : $cb['period']  ?>
                  </td>
                  <td><?=$cb['value']?></td>
                  <td><?=$cb['inform']?></td>
                  <td>
                    <?php if (has_role(1)) { ?>
                      <div class=" ">
                        <a href="../values/edit?id=<?=$cb['id']?>" class="button edit"><span class="icon edit"></span></a>&nbsp;
                        <a href="../values/delete?id=<?=$cb['id']?>" class="delete button "><span class="icon delete"></span></a>
                      </div>
                    <?php } ?>
                  </td>
                  <td >
                    <div>
                      <?php if (!empty($cb['support'])) { ?>
                              <a data-toggle="tooltip" data-placement="bottom" title="Descargar" href="<?=download_support($cb['name_support'])?>" download="<?= $cb['name_support'] ?>"><i class="fas fa-file-download fa-2x" ></i><?= $cb['name_support'] ?></a>
                      <?php } ?>                    
                    </div>
                    <div>
                      <?php if (!empty($cb['support1'])) { ?>
                        <a data-toggle="tooltip" data-placement="bottom" title="Descargar" href="<?=download_support($cb['name_support1'])?>" download="<?= $cb['name_support1'] ?>"><i class="fas fa-file-download fa-2x" ></i><?= $cb['name_support1'] ?></a>
                    <?php } ?>
                    </div>                  
                  </td>
                </tr>
              <?php } ?>
        </tbody>      
      </table>
    </div>
      
  </div>
</div>
</div>


<script>
  var type = "<?= $analysis[0]['unit']; ?>"; 
  var name = "<?= $analysis[0]['ind']; ?>";
  var data_csv =  "<?= $graph[0]['value']; ?>";
  var catg = "<?=$graph[0]['period'] ?>"
  var upper_l = "<?= $upper_l; ?>";
  var lower_l = "<?= $lower_l; ?>";
  var metakind = htmlEntityChecker('<?= $data['analysis'][0]['goal'] ?>');
  var gl1 = "<?= $gl1; ?>";
  var gl2 = "<?= $gl2; ?>";
  var BAR_URL = "<?php echo BASE_URL ?>";
  catg = catg.split(',');
  data_csv = data_csv.split(',');
  data_csv.forEach(logArrayElements);

 function format (d) {
    // `d` is the original data object for the row

  return '<div class="hide_insd">'+
            '<table cellpadding="5" cellspacing="0" border="0">'+
              '<tr>'+
                  '<td>'+
                  `<div>
                    ${d[4]}
                  </div>`+
                  '</td>'+
                  '<td style="width:10px">' + d[3] + '</td>'+
              '</tr>'+
            '</table>'+
          '</div>';
}

$(document).ready(function(){
  var table = $('#info_table').DataTable({
    paging: false,
    "info": false,
    "searching": false,
    "order": [],
    "lengthChange": false,
      "columnDefs": [
        // hide the needed column
        { "visible": false, "targets": [3,4] },
        {
          "className": 'details-control',
          "targets": [0,1,2]
        },
        { 
            "targets": [0,1,2 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
      ]
  });

   // Add event listener for opening and closing details
  $('#info_table tbody').on('click', 'td.details-control', function () {
      var tr = $(this).closest('tr');
      var td_div = tr.find('td:nth-child(1) div.insd_rltv')
      var row = table.row( tr );

      if ( row.child.isShown() ) {
          tr.removeClass('highlight_row');
          // This row is already open - close it
          $('.hide_insd').slideUp('slow', function(){
            td_div.html('<i class="fas fa-angle-right"></i>');
            tr.removeClass('shown');
            row.child.hide();
          })
      }
      else {
        // Open this row
        if (table.row('.shown').length) $('.details-control', table.row('.shown').node()).click();
        row.child( format(row.data()) ).show();
        $('.hide_insd').slideDown('slow')
        td_div.html('<i class="fas fa-angle-down"></i>');
        tr.addClass('shown highlight_row');
      }
  } );

  $('#age_id').on("change", function () {
    var id1 = <?=$_GET['id']?>;
    var age_id = $('#age_id').val()
    var frequency_id = $('#frequency_id').val()
    var type = $('#registers_type').val()
      if($('#age_id').val()){
        table
          .rows()
          .remove()
          .draw();
          get_table_register(age_id, id1,table, type);
          get_graphic_register(age_id, id1, frequency_id, type);      

          
          
        }
      });

      $('#registers_type').on('change',function(){
        var id1 = <?=$_GET['id']?>;
        var age_id = $('#age_id').val()
        var type = $('#registers_type').val()
        var frequency_id = $('#frequency_id').val()
        table
          .rows()
          .remove()
          .draw();
        get_table_register(age_id, id1,table, type);
        get_graphic_register(age_id, id1, frequency_id, type);       
      })
  })
	
  $('.no_responsive div.responsive').removeClass("responsive");
		
   const charts = Highcharts.chart('container23', {

        title: { 
          text:  name
          },

        subtitle: {
          text: 'Plana'
        },
        
         yAxis: [{
            className: 'highcharts-color-0',
            labels: {
              style: {
                  color: '#7cb5ec',
                  'stroke': '#7cb5ec'
              }
          },
            plotLines: [{
              value: lower_l,
              id: 'first',
              dashStyle: 'LongDash',
              zIndex: 10,
              width: 2,
              color: '#ff0000',
              label:{
                text:gl1+': '+ lower_l,
                x: -55,
              style: {
                color: '#FFFFFF',
                'textOutline': '1px contrast'
              }
            }
          },
          {
              value: upper_l,
              id: 'second',
              dashStyle: 'LongDash',
              zIndex: 5,
              width: 2,
              color: '#ff0000',
              label:{
                text: `${(gl2)? gl2+': '+ upper_l : ''}`,
                align: 'left',
                x: -55,
                y:-10,
                style: {
                  color: '#FFFFFF',
                  'textOutline': '1px contrast',

                }
            }
          }
          ]
        }],

        xAxis: {
          categories: catg,
          labels: {
          padding: 0,
          style: {
            fontSize: '10px'
            }
          }
        },
        legend: {
            layout: 'vertical',
            valueDecimals: 0,
            backgroundColor: 'rgba(255,255,255,0.9)',
            symbolRadius: 0,
            symbolHeight: 10,
            itemStyle: {
            fontSize: '11px',
            enabled: false

          }
        },
        colorAxis: {
          dataClasses: [
          

          ]
        },
        series: [ {
          type: 'column',
          colorByPoint: false,
          data: data_csv,
          showInLegend: false,
        },
        {
            type: 'scatter',
            name: 'goal',
            data: [lower_l*1],
            marker: {
              enabled: false
            },
            dataLabels:{
              enabled: false,

            }
          },
         
        ],
         plotOptions: {
          series: {
            color: '#FF2424',
            dataLabels: {
              enabled: true,
              inside: true
            }
          }
        }
      });
var axis = $('#container23').highcharts().colorAxis[0];

  delimit_boundaries(axis, metakind, lower_l, upper_l, gl2);

  function delimit_boundaries(axis, metakind, lower_l, upper_l, gl2){
    console.log(metakind)
    if(metakind == 2 ){
    
        axis.update({
            dataClasses: [{
                to: lower_l,
                color: '#4AAD45',
                name: 'Cumple'

            }, {
               from: lower_l,
              color: '#FF2424',
              name: 'No cumple'
            }]
        });
    }
    if(metakind == 3 ){
      
        axis.update({
            dataClasses: [{
                from: lower_l,
                color: '#4AAD45',
                name: 'Cumple',

            }, {
               to: lower_l,
              color: '#FF2424',
              name: 'No cumple'
            }]
        });
    }
    if(metakind == 0 ){
      
        axis.update({
            dataClasses: [
            {
                from: lower_l,
                color: '#4AAD45',
                name: 'Cumple'

            },
            {
               to: ((lower_l*1 - 0.1)),
              color: '#FF2424',
              name: 'No cumple'
            }]
        });
    }
    if(metakind == 1 ){
      
        axis.update({
            dataClasses: [
            {
                to: lower_l,
                color: '#4AAD45',
                name: 'Cumple'

            },
            { 
              from: (lower_l*1 + 0.1),
              color: '#FF2424',
              name: 'No cumple'
            }]
        });
    }
    if(metakind == -1){
      
      if(!gl2){
        
        axis.update({
            dataClasses: [
            {
              //  to: upper_l,
              // from: lower_l,   
              color: '#4AAD45',
              name:  'Cumple'
            },
            // {
            //   to:(lower_l-5),         
            //   color: '#FF2424',
            //   name: 'No cumple'

            // },
            ]
        });
      }else{
        var sign_u = htmlEntityChecker('<?= $data['analysis'][0]['upper_limit'] ?>')
        var sign_d = htmlEntityChecker('<?= $data['analysis'][0]['lower_limit'] ?>')
        if(sign_u == -1 && sign_d == -1){
          axis.update({
              dataClasses: [
              {
                from : lower_l,
                 to: upper_l,
                color: '#4AAD45',
                name:  'Cumple'
              },
              {
                from: (upper_l*1 + 0.1),            
                color: '#FF2424',
                name: 'No cumple'

              },
              ]
          });
        }
        
      }      
    }
  }
  function get_table_register(year, ind, table, type){
    $.post( "/indicator/indicator/indicators/graphic_reports", { age_id: year, id: ind, type:type })
          .done(function( data ) {
            datos = JSON.parse(data);
              var info =``;
              for (const fa of datos.indicators){
                let support = fa.support;
                let id = fa.id;
                let id_inf = fa.inform_id
                info=`
                  <tr>
                    <td class="relative pdd_left_15">
                    <div class="insd_rltv">
                      <i class="fas fa-angle-right"></i>
                    </div>${(fa.frequency_id==1)? fa.name : fa.period }</td>
                    <td>`+ fa.value +`</td>
                    <td>`+ fa.inform +`</td>
                    <td>
                      <?php if (has_role(1)) { ?>
                        <div class=" ">
                          <a href="../values/edit?id=${fa.id}" class="button edit"><span class="icon edit"></span></a>&nbsp;
                          <a href="../values/delete?id=${fa.id}" class="delete button "><span class="icon delete"></span></a>
                        </div>
                      <?php } ?>
                    </td>
                    <td>
                      <div>
                        ${(fa.support)?` 
                            <a data-toggle="tooltip" data-placement="bottom" title="Descargar" href="https://nx001.nexter.us-nyc1.upcloudobjects.com/indicator/${fa.name_support}" download="${fa.name_support}"><i class="fas fa-file-download fa-2x" ></i>${fa.name_support}</a>
                           ` :""}              
                      </div>
                      <div>
                        ${(fa.support1)?` 
                            <a data-toggle="tooltip" data-placement="bottom" title="Descargar" href="https://nx001.nexter.us-nyc1.upcloudobjects.com/indicator/${fa.name_support1}" download="${fa.name_support1}"><i class="fas fa-file-download fa-2x" ></i>${fa.name_support1}</a>
                           ` :""}              
                      </div>
                      <div>
                        
                      </div> 
                    </td>
                  </tr>`;
                  table.row.add($(info)).draw();
              }
              
                  // var catalogTable = $('#info_table').dataTable();
                  // catalogTable.fnAddData(info);
                  
              // document.getElementById("table_yellow").innerHTML= info

              
          });
  }
  function get_graphic_register(age_id, id1, frequency_id, type){
    $.post( "/indicator/indicator/indicators/report_graph_filter", { age_id: age_id, id: id1, frequency_id: frequency_id, type:type })
            .done(function( data ) {
              
              data = JSON.parse(data);
              chart2 = $('#container23').highcharts();
              chart2.yAxis[0].removePlotLine('first');
              chart2.yAxis[0].removePlotLine('second');
              
              if(data.graph[0]['value']!=null){
                var catg = data.graph[0]['period'].split(',');
                data_csv = data.graph[0]['value'].split(',');
                data_csv.forEach(logArrayElements);
                
                
                chart2.yAxis[0].addPlotLine({
                  value: data.lower_l,
                  id: 'first',
                  dashStyle: 'LongDash',
                  zIndex: 10,
                  width: 2,
                  color: '#ff0000',
                  label:{
                    text:data.gl1+': '+ data.lower_l,
                    x: -55,
                  style: {
                    color: '#FFFFFF',
                    'textOutline': '1px contrast'
                  }
                }
                });
                chart2.yAxis[0].addPlotLine({
                    value: data.upper_l,
                    id: 'second',
                    dashStyle: 'LongDash',
                    zIndex: 5,
                    width: 2,
                    color: '#ff0000',
                    label:{
                      text: `${(data.gl2)? data.gl2+': '+ data.upper_l : ''}`,
                      align: 'left',
                      x: -55,
                      y:-10,
                      style: {
                        color: '#FFFFFF',
                        'textOutline': '1px contrast',

                      }
                  }
                });
                chart2.series[0].update({data: data_csv});
                chart2.series[1].update({data: [data.lower_l]});
                chart2.series[0].show();
                chart2.series[1].show();
                chart2.xAxis[0].update({categories:catg});
                delimit_boundaries(axis, htmlEntityChecker(data.analysis[0].goal), data.lower_l, data.upper_l, data.gl2);
              }else{
                chart2.series[0].hide();
                chart2.series[1].hide();
                chart2.xAxis[0].update({categories:""});
              }
              
              chart2.yAxis[0].redraw();
              
            });
  }
 

$('#polar').click(function () {
charts.update({
  chart: {
    inverted: false,
    polar: true
  },
  subtitle: {
    text: 'Polar'
  }
});
});
// $('#polar').click(function () {
 
// });
$('#plain').click(function () {
  charts.update({
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
  charts.update({
    chart: {
      inverted: true,
      polar: false
    },
    subtitle: {
      text: 'Invertida'
    }
  });
});
</script>
