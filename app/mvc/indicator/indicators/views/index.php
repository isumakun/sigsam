<style>
/*#test{
	white-space:nowrap;
	
}*/
</style>
<script src="//code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" />
<div class="card">
	<div class="card-body">
		<center><h2>MATRIZ DE INDICADORES</h2></center>
		<br>
		<table id="example" class="display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>Proceso</th>
                    <th>Indicador</th>
                    <th class="text-center">Fórmula</th>
                    <th class="text-center">Ud.</th>
                    <th class="text-center">Frecuencia</th>
                    <th class="text-center">Meta</th>
                    <th class="text-center">Lim Sup</th>
                    <th class="text-center">Lim Inf</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Responsable</th>
                    <th>	<?php
                      if (has_role(1)) {
                    ?>		<a href="indicators/create" class="button create"><span class="dark create"></span> Nuevo</span></a>&nbsp;
                    <?php
                      }
                    ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($indicators as $ind) { ?>
                <tr>
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
                    <td class="text-center"><?=$ind['job_position']?></td>
                    <td>
                    <div class="strech nowrap">
                    	<?php
                            if (has_role(1)) {
                        ?><a href="indicators/edit?id=<?=$ind['id']?>" class="button edit"><span class="icon edit"></span></a>&nbsp;
                        <?php
                             }
                        ?>
                    	<a href="values/create?id=<?=$ind['id']?>" class="button"><span class="fa fa-chart-line"></span></a>&nbsp;
                    	<a href="indicators/supports?id=<?=$ind['id']?>" class="button create"><span class="fa fa-file "></span></a>
                    	<a href="indicators/graphic_reports?id=<?=$ind['id']?>" class="button green"><span class="fa fa-chart-pie"></span></a>
                        <?php
                            if (has_role(1)) {
                        ?>
                    	<a href="indicators/delete?id=<?=$ind['id']?>" class="button delete"><span class="icon delete"></span></a>
                        <?php
                            }
                        ?>
                    </div>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
	</div>
</div>

<script>
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
	$("#datagrid_0").dataTable().fnDestroy();
    var table = $('#example').DataTable( {
        "fixedHeader": true,
        "orderCellsTop": true,
       "columnDefs": [
        { 
            "targets": [0,1 ], //first column / numbering column
            "orderable": false, //set not orderable
        },
        ],
        initComplete: function () {
            createDropdowns(this.api());
        }
    } );
} );



</script>
