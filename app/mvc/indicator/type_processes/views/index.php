<div class="card">
	<div class="card-body">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h3>Asignar indicadores: </h3>
				</div>
			</div>
			<div class="row">
				<span>por: </span>
				<div class="col-md-2">
					<select>
						<option>Proceso</option>
						<option>Usuario</option>
					</select>
				</div>
				<span>Seleccionar</span>
				<div class="col-md-4">
					<select class="" name="process_id" id="process_id">
						<option></option>
						<?php foreach ($processes as $k) { ?>
							<option value="<?= $k['id'] ?>"> <?= $k['name'] ?> </option>
						<?php } ?>						
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table_container">
						<table id="process_indicator">
							<thead>
								<tr>
									<td> <input type="checkbox" name=""> indicador</td>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var table = $('#process_indicator').DataTable({
		    paging: false,
		    "info": false,
		    "searching": false,
		    "order": [],
		    "lengthChange": false,
		      "columnDefs": [
		        { 
		            "targets": [0], //first column / numbering column
		            "orderable": false, //set not orderable
		        },
		      ]
		  });
		$('#process_id').on('change', function(){
			var process_id = $(this).val()
			$.post( "./type_processes/indicator_process", { process_id: process_id })
	          .done(function( data ) {
	          	console.log(data)
	            datos = JSON.parse(data);
	              var info =``;
	              for (const fa of datos){
	                info=`
	                  <tr>
	                  	<td>${datos}</td>
	                  </tr>`;
	                  table.row.add($(info)).draw();
	              }	              
	          });
		})
		var table1 = $('#tb_01').DataTable({
	        deferRender: true,
	        paging: true,
	        sPaginationType: "simple_numbers",
			aaSorting: [],
	        ajax:{url:"type_processes/json_data", type: "POST"},
	        "columnDefs": [
		    { "targets": 1,
		    	"orderable": false,
		      "render": function(data,type,full,meta) {
		      	console.log(full)
		          return '<a href="u#" class="btn btn-success">sdsdsd<i class="fa fa-key"></i></a>';
		      }
		    }
		    ],
	         columns: [
	            { data: 'name'}
	        ]
	    });
	})
</script>