<style>
/*#test{
	white-space:nowrap;
	
}*/
.card-body{
    padding: 10px;
    padding-right: 0px;
    position:relative;
}

.highlight_row {
    background-color:#CCC !important; 
    color:#000;
}
.float_right{
    float: right;
}

.margindown{
   position: sticky;
    background-color: white;
    top: 0;
    padding-left: 0px;
    padding-right: 0px;
}
#example{
    margin-bottom: 35px;
}
#example tr, td{
    cursor: pointer;
}
.fixed_result{
  position: absolute;
  top: 0;
  /* just used to show how to include the margin in the effect */
  margin-top: 20px;
  border-top: 1px solid purple;
  padding-top: 19px;
}
.fixed_result.fixed {
  position: fixed;
  top: 0;
}
.nopadding{
    padding: 10px 0px !important;
}
.proobing{
    width: 100%;
    height: 485px;
    /* position: relative; */
    overflow-y: auto;
}
.row{
    margin-right: 0px !important;
    margin-left: 0px !important;
}
tr th {
    position: sticky;
    top: 25px;
}
.dataTables_paginate{
    margin: auto !important;
}
.padding_10_000{
    padding: 10px 0px 0px 0px;
}
#example_wrapper{
    position: static;
}
#center_paginate{
    position: absolute;
    width: 100%;
    bottom: 0px;
    padding-left: 0px !important;
    background-color: white;
    padding-bottom: 5px;
    border-top: outset;
    display: flex;
    justify-content: center;
}
</style>

<div class="card h-100">
	<div class="card-body h-100">
		
        <div class="padding_10_000">
            <center><h2>MATRIZ DE SEGUIMIENTO Y MEDICIÓN | ELIMINADOS</h2></center>
        </div>
        
        <div class="proobing custom_scroll" style="height: 93%;">
            <table id="example" class="display fixTableHead no_responsive" cellspacing="0" width="100%">
                <thead class="">
                    <tr >
                        <th class="nopadding">Proceso</th>
                        <th class="nopadding">Indicador</th>
                        <th class="text-center nopadding">Fórmula</th>
                        <th class="text-center nopadding">Ud.</th>
                        <th class="text-center nopadding">Frecuencia</th>
                        <th class="text-center nopadding">Meta</th>
                        <th class="text-center nopadding">Lim Inf</th>
                        <th class="text-center nopadding">Lim Sup</th>
                        <th class="text-center nopadding">Tipo</th>
                        <th class="text-center nopadding">Responsable</th>
                        <!-- <th style="display: none;">wewewe</th> -->
                        
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($indicators as $ind) { ?>
                    <tr id="<?=$ind['id']?>" data-id = "<?=$ind['id']?>">
                        <td id="test"><?=$ind['process']?></td>
                        <td><?=$ind['name']?></td>
                        <td><?=$ind['formula']?></td>
                        <td class="text-center"><?=$ind['unit']?></td>
                        <td class="text-center"><?=$ind['frequency']?></td>
                        <td class="text-center">
                            
                            <?php if( (str_replace(' ', '', $ind['goal']))  == (NULL)) {  ?>
                                <span>N/A</span>
                            <?php }else { ?>
                                <span><?=$ind['goal']?></span>
                            <?php } ?>
                            
                        </td>
                        <td class="text-center">
                            <?php if( str_replace(' ', '', $ind['lower_limit'])  == (NULL)) {  ?>
                                <span>N/A</span>
                            <?php }else { ?>
                                <span><?=$ind['lower_limit']?></span>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if( str_replace(' ', '', $ind['upper_limit'])  == (NULL)) {  ?>
                                <span>N/A</span>
                            <?php }else { ?>
                                <span><?=$ind['upper_limit']?></span>
                            <?php } ?>
                        </td>
                        <td class="text-center">
                            <?php if( str_replace(' ', '', $ind['type'])  == (NULL|| "0" )) {  ?>
                                <span style="color:red;">----</span>
                            <?php }else { ?>
                                <span><?=$ind['type']?></span>
                            <?php } ?>
                        </td>
                        <td class="text-center"><?=$ind['job_position']?>
                            <input type="checkbox" style="appearance:auto; padding: inherit; display: none;">
                        </td>
                       <!--  <td style="">
                            
                        </td> -->
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    		

	</div>
</div>

<script>


function createDropdowns(api) {
    api.columns([0, 1]).every(function(d) {
        if (this.searchable()) {
            var that = this;
            var col = this.index();

            // Only create if not there or blank
            var selected = $('thead tr:eq(0) th:eq(' + col + ') select').val();
            var select = $('<select style="width: 160px;"><option value="">All</option></select>')
            
            if (selected === undefined || selected === '') {
                // Create the `select` element
                $('thead tr:eq(0) th')
                    .eq(col)
                    .empty();
                    select
                    .appendTo( $('thead tr:eq(0) th').eq(col) )
                    .on( 'change', function () {
                        that.search($(this).val()).draw();
                        createDropdowns(api);
                    });
            }
            if(d===0){
                api
                .cells(null, col, {
                    page:   'all'
                })
                .data()
                .sort()
                .unique()
                .each(function(d) {
                    select.append($('<option>' + d + '</option>'));
                });

            }
            if(d===1){
                api
                .cells(null, col, {
                    search: 'applied'
                })
                .data()
                .sort()
                .unique()
                .each(function(d) {
                    select.append($('<option>' + d + '</option>'));
                });
            }
        }
    });
}
$(document).on( 'init.dt', function ( e, settings ) {
    var api = new $.fn.dataTable.Api( settings );
    var state = api.state.loaded();
    if(state != null){
        let col_search_val_p = state.columns[0].search.search;
        let col_search_val_i = state.columns[1].search.search;
        if(col_search_val_p != ''){$(`thead tr:eq(0) th:eq(0) select option:contains(${col_search_val_p})`).attr('selected', 'selected');}
        if(col_search_val_i != ''){$(`thead tr:eq(0) th:eq(1) select option:contains(${col_search_val_i})`).attr('selected', 'selected');}
    }
} );
$(document).ready(function() {

    $.fn.dataTable.Api.register('column().searchable()', function() {
      var ctx = this.context[0];
      return ctx.aoColumns[this[0]].bSearchable;
    });

	$("#datagrid_0").dataTable().fnDestroy();
    var table = $('#example').dataTable( {
        "stateSave": true,
        "fixedHeader": true,
        "orderCellsTop": true,
        "bLengthChange": false,
        "bInfo": false,
        pageLength: 15,
       "columnDefs": [
        { 
            "targets": [0,1 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
        initComplete: function () {
            createDropdowns(this.api());
            $('#example_wrapper').addClass('row')
            $('#example_length').wrap("<div class=\"col-md-6\"></div>");
            $('#example_filter').wrap("<div class=\"col-md-12\"></div>");
            $('#example_filter').addClass('margindown float_right');
            $('#example_paginate').wrap("<div id=\"center_paginate\" class=\"col-md-12\"></div>");
            var buttons = createbuttons();
            $(buttons).insertAfter('#example_wrapper .col-md-12:eq(0)');
        },
        stateLoadParams: function(settings, data) {
            
        }
    } );

var allPages = table.fnGetNodes();

    $(document, allPages).on('click', 'tr:not(th:nth-child(1))', function(){
        
        var tr = $(this);

        var tdcheck = tr.find('td:last-child input')
        var trhig = $('input:checked:not(:disabled)', allPages).closest('tr');
        var tdunch = $('input:checked:not(:disabled)', allPages).closest('tr').find("input");
        trhig.removeClass('highlight_row')
        tdunch.prop("checked", false);
         
        if(tdcheck.prop("checked")){
            tdcheck.prop("checked", false);
        }else{
            tdcheck.prop("checked", true);
            tr.addClass('highlight_row');
            $("#reporinfo").attr("href", "<?=BASE_URL?>indicator/deleted_records/graphic_reports?id="+tr.data('id'))
            $("#restoreinfo").attr("href", "<?=BASE_URL?>indicator/deleted_records/restore?id="+tr.data('id'))
        }
        
    })

    $(`thead tr:eq(0) th:eq(0) select`).change( function(e){
        $(`thead tr:eq(0) th:eq(1) select option:contains(All)`).prop('selected', true).trigger( "change" );
    })
   
     
} );

function createbuttons(){
    var html = `
    <div class="col-md-6"></div>
    <div class="col-md-12 margindown">
    <?php if (has_role(1)) { ?>
        <a id="restoreinfo" href="#" class="button restore blueDf float_right"><span class="fa fa-folder-open"></span>Restaurar</a>
    <?php } ?>   
        <a id="reporinfo" href="#" class="button green float_right confirm"><span class="fa fa-chart-pie"></span>Reporte</a>
                   
    </div>`;
    return html;
}


</script>
