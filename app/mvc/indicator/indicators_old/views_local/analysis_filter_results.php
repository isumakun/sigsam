<style type="text/css">
	@import 'https://code.highcharts.com/css/highcharts.css';

.highcharts-figure, .highcharts-data-table table {
    min-width: 310px; 
	max-width: unset !important;
    margin: unset !important;
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
	stroke: #7cb5ec;
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

.custom_drops ul,li{
	list-style:none;
	padding:0;
	margin:0;
}
.custom_drops ul{
    width:100%;
}
.custom_drops li {
    float:left;
    margin:5px;
    position:relative;
}
.custom_drops li{
	width: 230px;
	height: 120px;
}
.grow {
	width: 100%;
  height: 100px;
  position: absolute;
  z-index: 1;
  background: white;
  -webkit-transition:all 0.1s ease-in-out;
  overflow: hidden;
}
.grow p{
	background: white;
}
.grow:hover {
	background: white;
  height: 100%;
  z-index: 2;
  overflow: unset;
  -webkit-transform:translate(-5px,-5px);
   -webkit-box-shadow: 1px 1px 1px #888;
}
#container23{
	height: 300px;
	width: 100%;
}

.item h4{
	text-align: center;
}

.item {
    overflow: hidden;
    width: 100%;
    height: 100%;
    background-color: #eee;
    border:1px solid #ccc;
    position:absolute;
    z-index:1;
    -webkit-transition:all 0.1s ease-in-out;
}
.item:hover {
  	padding: 8px;
    width: 100%;
    height:auto;
    z-index:2;
    -webkit-transform:translate(-5px,-5px);
    -webkit-box-shadow: 1px 1px 1px #888;
}

</style>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
<script src="https://unpkg.com/jquery-filepond/filepond.jquery.js"></script>
<div class="row">
	<div class="col">
		<figure class="highcharts-figure">
		    <div id="container23"></div>
		</figure>
	</div>	
</div>
<div class="row">
	<div class="col-md-12 custom_drops">
		<ul>
			<li>
				<div class="grow item">
					<h4>Enero</h4>
					<p>
						Durante el mes de enero se presentaron problemas por escape de vacío en la válvula final de descarga del evaporador del MONG que causó disminución en el flujo de la planta. Sin embargo, se logró cumplir con el indicador con un valor del 97,5%.
					</p> 
				</div>
			</li>
			<li>
				
				<div class="grow item">
					<h4>Febrero</h4>
					<p>
						El valor alcanzado para este periodo fue de 94,1%, quedando por debajo de la meta. Se encontraron problemas con la bomba P.173.2 y con escapes de vacío, lo cual implicó en reducción del flujo de planta y adicionalmente parada por mantenimiento para la intervención de la bomba.
					</p> 
				</div>
				
			</li>
			<li>
				
				<div class="grow item">
					<h4>Marzo</h4>
					<p>
						Se cumple con el indicador superando lo estimado con un valor de 108%. Fueron intervenidas la bomba P.173.2 y la válvula de descarga del evaporador del MONG, lo cual permitió aumentar los flujos de la planta.
					</p> 
				</div>
				
			</li>
			<li>
				
				<div class="grow item">
					<h4>Abril</h4>
					<p>
						Durante el periodo el valor del indicador fue del 97.8%. Aunque quedó por encima del valor base, se tuvieron múltiples problemas relacionados al corte de energía no programados que incidieron directamente en la falla de las calderas y por ende en pérdidas de vacío en las plantas. Debido a esto se redujo el flujo en planta y se tuvo que parar en diferentes ocasiones debido al alto nivel de la columna de destilación.
					</p> 
				</div>
				
			</li>
			<li>
			
				<div class="grow item">
					<h4>Mayo</h4>
					<p>
						El cumplimiento del indicador para el periodo fue de 112,7%. Se le hicieron ajustes a las aspas internas del evaporador del MONG que permitió mejorar la transferencia calórica entre el equipo y el producto saliente. A su vez, permitió aumentar el flujo de salida de MONG de la columna de destilación y por ende mejorar los niveles dentro de la misma, lo que conllevó a un aumento considerable de la producción.
					</p> 
				</div>
				
			</li>
			<li>
				
				<div class="grow item">
					<h4>Junio</h4>
					<p>
						Se obtiene un valor del 105.2% para el indicador en el mes de junio 2021. Este valor se debe principalmente a que la planta produjo glicerina para mantener en stock, ya que por problemas presentados en las vías del país muchos de los clientes que en principio iban a comprar la glicerina, no pudieron definir sus compras al final.
					</p> 
				</div>
				
			</li>
		</ul>
	</div>
	
</div>
<div class="row" style="margin: 40px 1px; background: white;">
	<div class="col">
		<form method="POST" action="" enctype="multipart/form-data">
		
			<label for="indicator_id">Indicador: Nombre del Indicador</label>
			<input style="display:none;" type="text" name="indicator_id" value="">
			
		  
		  <div class="row marginb" style="margin-top: 15px;">	    
		      
		    <div class="col-md-4">
		      <label for="period_id">Año:</label>
		      <select name="age_id">
		        <option selected="selected" disabled="disabled" value="">Seleccionar</option>
		          
		            <option value="">2020</option>
		            <option value="">2021</option>
		          
		      </select>
		    </div>
		    
		    <div class="col-md-4">
		      <label for="period_id">Periodo:</label>
		      <select id="age" name="period_id">
		        <option selected="selected" disabled="disabled" value="">Seleccionar</option>
		          
		            
		            <option value="" >Primer Semestre</option>
		            <option value="" >Segundo Semestre</option>
		          
		      </select>
		    </div>
		    <div class="col">
		      <label for="value">Valor:</label>
		       

		          <input type="text" name="value" id="durationForm" maxlength=8 pattern="^\s*\d+\s*(([hH]|horas?)?\s*((:)?\s*(?<=:)(\d{1,2}))?\s*(((?<!\d{1})\d)?((min)|(m))?)?)\s*$"
		      title="Cantidad de tiempo 00:00 (horas, minutos), 
		            puede escribirlo como 
		             &quot;00h 00m&quot; o &quot;00h: 00min&quot;."
		      placeholder="hh:mm" size=30 required>
		      
		        <!-- <input name="value" value="" type="text" required/> -->
		     
		    </div>
		  </div>
		  <div class="row marginb" id="final_report_option" style="display:none;">		    
		  </div>
		  
		  <div id="inform_div" >
		    <div>
		    	<div class="row">
		    		<div class="col">
		    			<label style="display: unset;" for="analysis">Análisis :</label>
					      <input type="text" name="inform_type" value="1" style="display: none;">
					      <select id="inform_class" name="inform_class"  style="width: auto;float: inherit;border: #357cbb;">
					       
					          
					            <option value="">Periodico</option>
					         
					            <option value="">Parcial</option>
					              
					      </select>
		    		</div>
		    		
		    	</div>
		      
		    </div>  
		    <textarea class="marginb" name="inform" rows="8" cols="50" required></textarea>
		    <div id="final_inform">

		    </div>
		  </div>
			

		  <!--   <div class="indi">
		      <label for="analysis_end">Análisis del año :</label>
		      <textarea name="analysis_end" rows="4" cols="50"></textarea>
		    </div> -->
		  <div class="row marginb">
		    <div class="col marginb">
		      <label for="support">Soporte:</label>
		      <input class="custom_file" type="file"  name="support" required >
		    </div>
		    <div class="col">
		      <label for="support">Segundo Soporte:</label>
		      <input class="custom_file" type="file"  name="support1">
		    </div>
		  </div>
			
			<input class="confirmp save" type="button" value="Guardar" />
		  <input style="display: none;" class="submit save" type="submit" value="Crear" />
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function () {

		$('.no_responsive div.responsive').removeClass("responsive");
		
		Highcharts.chart('container23', {

		    chart: {
		        type: 'column',
		        styledMode: true
		    },

		    title: {
		        text: 'Styling axes and columns'
		    },

		    yAxis: [{
		        className: 'highcharts-color-0',
		        title: {
		            text: 'Primary axis'
		        }
		    }, {
		        className: 'highcharts-color-1',
		        opposite: true,
		        title: {
		            text: 'Secondary axis'
		        }
		    }],

		    plotOptions: {
		        column: {
		            borderRadius: 5
		        }
		    },

		    series: [{
		        data: [1, 3, 2, 4]
		    }, {
		        data: [324, 124, 547, 221],
		        yAxis: 1
		    }]

		});
	})
</script>