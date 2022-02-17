<style>
/*#test{
	white-space:nowrap;
	
}*/
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
    position: relative;
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
</style>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
<div class="card">
	<div class="card-body">
		<center><h2>MATRIZ DE SEGUIMIENTO Y MEDICIÓN</h2></center>
		<br>
        <div class="">
            
        </div>
        
        <div class="proobing">
            <table id="example" class="display fixTableHead no_responsive" cellspacing="0" width="100%">
                <thead class="">
                    <tr >
                        <th class="nopadding">Proceso</th>
                        <th class="nopadding">Indicador</th>
                        <th class="text-center nopadding">Fórmula</th>
                        <th class="text-center nopadding">Ud.</th>
                        <th class="text-center nopadding">Frecuencia</th>
                        <th class="text-center nopadding">Meta</th>
                        <th class="text-center nopadding">Lim Sup</th>
                        <th class="text-center nopadding">Lim Inf</th>
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
                            <?php if( str_replace(' ', '', $ind['upper_limit'])  == (NULL|| "0" )) {  ?>
                                <span>N/A</span>
                            <?php }else { ?>
                                <span><?=$ind['upper_limit']?></span>
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

// function removeclass(classname,tablenodes){

//     $("tr."+ classname, tablenodes).removeClass(classname);
//     console.log($("tr."+ classname+"", tablenodes))
// }

function createDropdowns(api) {
    api.columns([0, 1]).every(function() {
        if (this.searchable()) {
            var that = this;
            var col = this.index();

            // Only create if not there or blank
            var selected = $('thead tr:eq(0) th:eq(' + col + ') select').val();
            
            if (selected === undefined || selected === '') {
                // Create the `select` element
                $('thead tr:eq(0) th')
                    .eq(col)
                    .empty();
                var select = $('<select style="width: 160px;"><option value=""></option></select>')
                    .appendTo( $('thead tr:eq(0) th').eq(col) )
                    .on( 'change', function () {
                        that.search($(this).val()).draw();
                        createDropdowns(api);
                    });

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
$(document).ready(function() {
    
     // var tables = $('#example').dataTable();
    
    
    $('.confirm').on('click', function(e) {
        var href = this.href;
        e.preventDefault();

        swal({
            title: 'Warning!',
            text: "Seguro que desea anular este turno?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si'
        }).then(function() {
            window.location.href = href;
        })
    })

    $.fn.dataTable.Api.register('column().searchable()', function() {
      var ctx = this.context[0];
      return ctx.aoColumns[this[0]].bSearchable;
    });
	$("#datagrid_0").dataTable().fnDestroy();
    var table = $('#example').dataTable( {
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
            $('#example_filter').addClass('margindown float_right')
            var buttons = createbuttons();
            $(buttons).insertAfter('#example_wrapper .col-md-12:eq(0)');
        }
    } );

var allPages = table.fnGetNodes();

    $(document, allPages).on('click', 'tr', function(){
        
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
            $("#cargarinfo").attr("href", "<?=BASE_URL?>indicator/values/create?id="+tr.data('id'))
            $("#reporinfo").attr("href", "<?=BASE_URL?>indicator/indicators/graphic_reports?id="+tr.data('id'))
            $("#editinfo").attr("href", "<?=BASE_URL?>indicator/indicators/edit?id="+tr.data('id'))
            $("#deleteinfo").attr("href", "<?=BASE_URL?>indicator/indicators/delete?id="+tr.data('id'))
        }
        
    })

    // var top = $('.fixed_result').offset().top - parseFloat($('.fixed_result').css('marginTop').replace(/auto/, 0));
    //   $(window).scroll(function (event) {
    //     // what the y position of the scroll is
    //     var y = $(this).scrollTop();

    //     // whether that's below the form
    //     if (y >= top) {
    //       // if so, ad the fixed class
    //       $('.fixed_result').addClass('fixed');
    //     } else {
    //       // otherwise remove it
    //       $('.fixed_result').removeClass('fixed');
    //     }
    //   });
   
     
} );

function createbuttons(){
    var html = `
    <div class="col-md-6"></div>
    <div class="col-md-12 margindown">
        <?php if (has_role(1)) { ?>     
            <a href="./indicators/create" class="button create"><span class="dark create"></span> Nuevo Indicador</span></a>&nbsp;
        <?php } ?>
        <?php if (has_role(1)) { ?>
            <a id="deleteinfo" href="#" class="button delete float_right"><span class="icon delete"></span>Eliminar</a>
        <?php } ?>
        <?php if (has_role(1)) { ?>
            <a id="editinfo" href="#" class="button edit float_right"><span class="icon edit"></span>Editar</a>&nbsp;
        <?php } ?>
        <a id="reporinfo" href="#" class="button green float_right"><span class="fa fa-chart-pie">Reporte</span></a>
        <a id="cargarinfo" href="#" class="button float_right"><span class="fa fa-chart-line">Cargar informacion</span></a>&nbsp;
        
        <!-- <a href="#" class="button create float_right"><span class="fa fa-file "></span></a> -->
        
        
        
    </div>`
    ;
    return html;
}


</script>
