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
   position: absolute;
    background-color: white;
    top: 12px;
	right: 18px;
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
    top: 0px;
	z-index: 1;
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
		<h2>Usuarios</h2>
		<br>

		<div class="proobing custom_scroll" style="height: 93%;">
            <table id="example" class="display fixTableHead no_responsive" cellspacing="0" width="100%">
                <thead class="">
                    <tr >
                        <th class="nopadding">Usuario</th>
                        <th class="nopadding">Nombre</th>
                        <th class="text-center nopadding">Email</th>
                        <th class="text-center nopadding">Empresas</th>
                        <th class="text-center nopadding">Rol</th>
                        <th class="text-center nopadding">Estado</th>
                        <th class="text-center nopadding">
							<?= make_link('admin/users/create', '<span class="icon create"></span> Nuevo', 'button dark create') ?>
						</th>                        
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($users as $u) { ?>
                    <tr id="<?=$u['id']?>" data-id = "<?=$u['id']?>">
                        <td id=""><?=$u['username']?></td>
                        <td><?=$u['name']?></td>
                        <td><?=$u['email']?></td>
                        <td class="text-center"><?=$u['companies']?></td>
                        <td class="text-center"><?=$u['rol']?></td>
                        <td class="text-center"><?=$u['state']?></td>
						<td class="text-center">
							<div class="strech nowrap">
								<a href="<?=BASE_URL?>admin/users/edit?id=<?=$u['id']?>" class="button edit"><span class="icon edit"></span></a>
								<a href="<?=BASE_URL?>admin/users/delete?id=<?=$u['id']?>&is_active=<?=$u['is_active']?>" class="button change_state blue"><span style="font-size: initial;font-weight: bold;" class="icon-action-redo confirm_action"></span></a>
							</div>
						</td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
		<!-- <?php
			$table = new Datagrid();

			$table->set_options('admin/users', 'get_all', 'a', 'false', 'multi', 'true');

			$table->add_column('Nombre', 'name');
			$table->add_column('Usuario', 'username');
			$table->add_column('Email', 'email');
			$table->add_column('Empresas', 'companies');
			$table->add_column('Rol', 'rol');
			$table->add_column('Estado', 'state');
			
			$table->add_column_html(make_link('admin/users/create', '<span class="icon create"></span> Nuevo', 'button dark create'), 'id', 
				'<div class="strech nowrap">'. 
					'<a href="'.BASE_URL.'admin/users/edit?id={row_id}" class="button edit"><span class="icon edit"></span></a>'.
					'<a href="'.BASE_URL.'admin/users/delete?id={row_id}" class="button delete"><span class="icon delete confirm_action"></span></a>'.
				'</div>', 'toolbar');

			$table->render();

		?> -->
	</div>
</div>
<script>
    $(document).on( 'init.dt', function ( e, settings ) {
        var api = new $.fn.dataTable.Api( settings );
        var state = api.state.loaded();
        
        if(state != null){
            let col_0 = state.columns[0].search.search;
            let col_1 = state.columns[1].search.search;
            let col_2 = state.columns[2].search.search;
            let col_3 = state.columns[3].search.search;
            let col_4 = state.columns[4].search.search;
            let col_5 = state.columns[5].search.search;
            let col_6 = state.columns[6].search.search;
            if(col_0 != ''){$(`thead tr:eq(1) th:eq(0) input`).val(col_0);}
            if(col_1 != ''){$(`thead tr:eq(1) th:eq(1) input`).val(col_1);}
            if(col_2 != ''){$(`thead tr:eq(1) th:eq(2) input`).val(col_2);}
            if(col_3 != ''){$(`thead tr:eq(1) th:eq(3) input`).val(col_3);}
            if(col_4 != ''){$(`thead tr:eq(1) th:eq(4) input`).val(col_4);}
            if(col_5 != ''){$(`thead tr:eq(1) th:eq(5) input`).val(col_5);}
            if(col_6 != ''){$(`thead tr:eq(1) th:eq(6) input`).val(col_6);}
        }
    } );
    $(document).ready(function() {
        $('#example thead tr').clone(true).addClass('filters').appendTo('#example thead')

        var table = $('#example').dataTable( {
            "stateSave": true,
            "fixedHeader": true,
            "orderCellsTop": true,
            "bLengthChange": false,
            "bInfo": false,
            pageLength: 30,
            initComplete: function () {
                var api = this.api();
                $('#example_wrapper').addClass('row');
                $('#example_filter').addClass('margindown float_right');
                $('#example_filter').addClass('margindown float_right');
                $('#example_paginate').wrap("<div id=\"center_paginate\" class=\"col-md-12\"></div>");

                // For each column
                api.columns().eq(0).each(function(colIdx) {
                    // Set the header cell to contain the input element
                    var cell = $('.filters th').eq($(api.column(colIdx).header()).index());
                    var title = $(cell).text();
                    $(cell).html( '<input type="text" placeholder="'+title+'" />' );
                    // On every keypress in this input
                    $('input', $('.filters th').eq($(api.column(colIdx).header()).index()) )
                        .off('keyup change')
                        .on('keyup change', function (e) {
                            e.stopPropagation();
                            // Get the search value
                            $(this).attr('title', $(this).val());
                            var regexr = '{search}'; //$(this).parents('th').find('select').val();
                            var cursorPosition = this.selectionStart;
                            // Search the column for that value
                            api
                                .column(colIdx)
                                .search((this.value != "") ? regexr.replace('{search}', this.value) : "", this.value != "", this.value == "")
                                .draw();
                            $(this).focus()[0].setSelectionRange(cursorPosition, cursorPosition);
                        });
                });

            },
            stateLoadParams: function(settings, data) {
                
            }
        } );

    } );
</script>