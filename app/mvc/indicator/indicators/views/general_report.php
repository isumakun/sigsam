
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
<style>
    #main_content{
        overflow: auto;
    }
    .responstable {
  margin: 1em 0;
  width: 100%;
  overflow: hidden;
  background: #FFF;
  color: #024457;
  border-radius: 10px;
  border: 1px solid #167F92;
}
.responstable tr {
  border: 1px solid #D9E4E6;
}
.responstable tr:nth-child(odd) {
  background-color: #EAF3F3;
}
.responstable th {
  display: none;
  border: 1px solid #FFF;
  background-color: #167F92;
  color: #FFF;
  padding: 1em;
}
.responstable th:first-child {
  display: table-cell;
  text-align: center;
}
.responstable th:nth-child(2) {
  display: table-cell;
}
.responstable th:nth-child(2) span {
  display: none;
}
.responstable th:nth-child(2):after {
  content: attr(data-th);
}
@media (min-width: 480px) {
  .responstable th:nth-child(2) span {
    display: block;
  }
  .responstable th:nth-child(2):after {
    display: none;
  }
}
.responstable td {
  display: block;
  word-wrap: break-word;
  max-width: 7em;
}
.responstable td:first-child {
  display: table-cell;
  text-align: center;
  border-right: 1px solid #D9E4E6;
}
@media (min-width: 480px) {
  .responstable td {
    border: 1px solid #D9E4E6;
  }
}
.responstable th, .responstable td {
  text-align: left;
  margin: .5em 1em;
}
@media (min-width: 480px) {
  .responstable th, .responstable td {
    display: table-cell;
    padding: 1em;
  }
}


</style>
<script src="https://code.jquery.com/jquery-3.3.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js" type="text/javascript">
</script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript">
</script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js" type="text/javascript"></script>

<div class="col-md-12">
    <div class="row">
        <div class="table-responsive" id="table_resp" >
            
        </div>
    </div>
</div>



        
<script type="text/javascript">
function check_value(string_val){
    val_to_return = (string_val)? String(string_val).match(/.*\S.*/g) : null ;
    if(!val_to_return){
        val_to_return = "---"
        // val_to_return = "<span style='color:#FF9881;'>---</span>"
    }
    return val_to_return;
}    

    $('#process').change(function(e) {
        const process_id = process.value
        $('#indicators > option').each(function() {

            if ($(this).data("process") == process_id) $(this).show()
            else $(this).hide()
        });
    });

    function exportTableToExcel(tableid, filename = ''){
	    var tab_text = "<table border='2px'><tr bgcolor='#87AFC6'>";
        var textRange; var j = 0;
        tab = document.getElementById(tableid);//.getElementsByTagName('table'); // id of table
        if (tab==null) {
            return false;
        }
        if (tab.rows.length == 0) {
            return false;
        }

        for (j = 0 ; j < tab.rows.length ; j++) {
            tab_text = tab_text + tab.rows[j].innerHTML + "</tr>";
            tab_text=tab_text+"</tr>";
        }

        tab_text = tab_text + "</table>";
        tab_text = tab_text.replace(/<A[^>]*>|<\/A>/g, "");//remove if u want links in your table
        tab_text = tab_text.replace(/<input[^>]*>|<\/input>/gi, ""); // reomves input params

        var ua = window.navigator.userAgent;
        var msie = ua.indexOf("MSIE ");
        // If Internet Explorer

        if (msie > 0 || !!navigator.userAgent.match(/Trident.*rv\:11\./)){
            txtArea1.document.open("txt/html", "replace");
            txtArea1.document.write(tab_text);
            txtArea1.document.close();
            txtArea1.focus();
            sa = txtArea1.document.execCommand("SaveAs", true, "SAM.xls");
        }else{                
            //other browser not tested on IE 11
            //sa = window.open('data:application/vnd.ms-excel,' + encodeURIComponent(tab_text));
            try {
            	var header = '<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">';
                var blob = new Blob([header+tab_text], { type: "application/vnd.ms-excel" });
                window.URL = window.URL || window.webkitURL;
                link = window.URL.createObjectURL(blob);
                a = document.createElement("a");
                if (document.getElementById("caption")!=null) {
                    a.download=document.getElementById("caption").innerText;
                }else{
                    a.download = 'SAM.xls';
                }

                a.href = link;

                document.body.appendChild(a);

                a.click();

                document.body.removeChild(a);
            }catch (e){

            }


            return false;
            //return (sa);			
		}
    }
    $(document).ready(function(){      

	    
            const postData={
                category: '',
                process: '',
                indicators: '',
                age: '2021',
            };
            $.post('../indicators/report_search',postData, function(respuesta){
                let info= JSON.parse(respuesta);
                
                let dato='';
                document.getElementById("table_resp").innerHTML=`
                    <table id="example"  class="responstable" summary="Code page support in different versions of MS Windows." rules="groups" frame="hsides" border="2" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="23"><h1>MATRIZ DE INDICADORES</h1><img class="test" width="200" height="100" src="<?=BASE_URL?>/public/resources/users_signs/<?=$_SESSION['user']['company_name']?>.png">
                                    <div id="some-container">
                                        <div class="dt-buttons"> <button class="dt-button buttons-copy buttons-html5" tabindex="0" aria-controls="example" type="button"><span>Copiar</span></button> <button class="dt-button buttons-excel buttons-html5" tabindex="0" aria-controls="example" type="button"><span>excel</span></button> </div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>Proceso</th>
                                <th>Nombre Indicador</th>
                                <th>Fórmula</th>
                                <th>Unidad</th>
                                <th>Frecuencia</th>
                                <th>Meta</th>
                                <th>Lim Inf</th>
                                <th>Lim Sup</th>
                                <th>Tipo de Indicador</th>
                                <th>Responsable</th>
                                <th>Ene</th>
                                <th>Feb</th>
                                <th>Mar</th>
                                <th>Abr</th>
                                <th>May</th>
                                <th>Jun</th>
                                <th>Jul</th>
                                <th>Ago</th>
                                <th>Sep</th>
                                <th>Oct</th>
                                <th>Nov</th>
                                <th>Dic</th>
                                <th>Promedio</th>
                            </tr>
                        </thead>
                        <tbody id="table_filter">`
                        
                            if(info != null){
                                for (const x in info.report) {
                                    let january=''
                                    let february=''
                                    let march=''
                                    let april=''
                                    let may=''
                                    let june=''
                                    let july=''
                                    let august=''
                                    let september=''
                                    let october=''
                                    let november=''
                                    let december=''
                                    let periods=""
                                    let goal = ''
                                    let count = 0
                                    let add = 0
                                    let prom = 0

                                    lower_limit = (info.report[x].lower_limit)? info.report[x].lower_limit.match(/.*\S.*/g) : null ;
                                    upper_limit = (info.report[x].upper_limit)? info.report[x].upper_limit.match(/.*\S.*/g) : null ;
                                    goal = (info.report[x].goal)? info.report[x].goal.match(/.*\S.*/g) : null ;
                                    type = (info.report[x].type)? info.report[x].type.match(/.*\S.*/g) : null ;
                                    if(!lower_limit){
                                        lower_limit = "N/A"
                                    }

                                    if(!upper_limit || upper_limit== 0){
                                        upper_limit = "N/A"
                                    }

                                    if(!goal){
                                        goal = "N/A"
                                    }
                                    if(!type || type == 0){
                                        // type = "<span style='color:#FF9881;'>----</span>"
                                        type = "---"
                                    }
                                    
                                    // type=info.report[x].type==null?" ":info.report[x].type;
                                    // lower_limit = info.report[x].lower_limit.replace("/[[:space:]]/", "", "gi");
                                    // goal=(info.report[x].goal =="0")? "N/A" : (info.report[x].goal === "")? "N/A" :info.report[x].goal;
                                    // lower_limit=info.report[x].lower_limit=="0"?"N/A":info.report[x].lower_limit;
                                    // upper_limit=info.report[x].upper_limit=="0"?"N/A":info.report[x].upper_limit;
                                    info.report[x].value_result.forEach(function(vr,index) {

                                        if( vr.period != null && vr.value!=null && vr.value!='0' ){

                                            add = logchekElements(vr.value) + add;
                                            count++;
                                            var vc = '';
                                            switch (vr.frequency_id) {
                                                case 6:
                                                    if (vr.period=='Primer Bimestre') {
                                                        february =check_value(vr.value);
                                                    }
                                                    if (vr.period=='Segundo Bimestre') {
                                                        april =check_value(vr.value);
                                                        // august =vr.value
                                                    }
                                                    if (vr.period=='Tercer Bimestre') {

                                                        june =check_value(vr.value);
                                                        // december=vr.value
                                                    }; 
                                                    if (vr.period=='Cuarto Bimestre') {

                                                        august =check_value(vr.value);
                                                        // december=vr.value
                                                    }; 
                                                    if (vr.period=='Quinto Bimestre') {

                                                        october =check_value(vr.value);
                                                        // december=vr.value
                                                    }; 
                                                    if (vr.period=='Sexto Bimestre') {

                                                        december =check_value(vr.value);
                                                        // december=vr.value
                                                    }; 
                                                break;
                                                
                                                case 5:
                                                    if (vr.period=='Primer Cuatrimestre') {
                                                        april =check_value(vr.value);
                                                    }
                                                    if (vr.period=='Segundo Cuatrimestre') {
                                                        august =check_value(vr.value);
                                                        // august =vr.value
                                                    }
                                                    if (vr.period=='Tercer Cuatrimestre') {

                                                        december =check_value(vr.value);
                                                        // december=vr.value
                                                    } ;  
                                                break;

                                                case 4:
                                                    if (vr.period=='Primer Semestre') {
                                                        june =check_value(vr.value);
                                                        // june =vr.value
                                                    }
                                                    if (vr.period=='Segundo Semestre') {
                                                        december =check_value(vr.value);
                                                        // december =vr.value
                                                    }
                                                break; 

                                                case 3:
                                                    if (vr.period=='Primer Trimestre') {

                                                        march =check_value(vr.value);
                                                        // march =vr.value
                                                    }
                                                    if (vr.period=='Segundo Trimestre') {

                                                        june =check_value(vr.value);
                                                        // june =vr.value
                                                    }
                                                    if (vr.period=='Tercer Trimestre') {

                                                        september =check_value(vr.value);
                                                        // september =vr.value
                                                    }
                                                    if (vr.period=='Cuarto Trimestre') {

                                                        december =check_value(vr.value);
                                                        // december =vr.value
                                                    } 
                                                break;

                                                case 2:
                                                    if (vr.period=='ENERO') {

                                                        january =check_value(vr.value);                        
                                                        // january=vr.value
                                                    }
                                                    if (vr.period=='FEBRERO') {

                                                        february =check_value(vr.value);
                                                        // february = vr.value
                                                    }
                                                    if (vr.period=='MARZO') {

                                                        march =check_value(vr.value);       
                                                        // march =vr.value
                                                    }
                                                    if (vr.period=='ABRIL') {

                                                        april =check_value(vr.value);
                                                        // april = vr.value
                                                    }

                                                    if (vr.period=='MAYO') {

                                                        may =check_value(vr.value);

                                                        // may=vr.value

                                                    }
                                                    if (vr.period=='JUNIO') {

                                                        june =check_value(vr.value);

                                                        // june=vr.value

                                                    }
                                                    if (vr.period=='JULIO') {

                                                        july =check_value(vr.value);

                                                        // july =vr.value

                                                    }
                                                    if (vr.period=='AGOSTO') {

                                                        august =check_value(vr.value);

                                                        // august =vr.value

                                                    }
                                                    if (vr.period=='SEPTIEMBRE') {

                                                        september =check_value(vr.value);

                                                        // september =vr.value

                                                    }
                                                    if (vr.period=='OCTUBRE') {

                                                        october =check_value(vr.value);


                                                        // october=vr.value

                                                    }
                                                    if (vr.period=='NOVIEMBRE') {

                                                        november =check_value(vr.value);

                                                        // november =vr.value
                                                    }

                                                    if (vr.period=='DICIEMBRE') {

                                                        december =check_value(vr.value);
                                                        // december=vr.value
                                                    }
                                                break;

                                                case 1:
                                                    december =check_value(vr.value);
                                                    // december=vr.value;  
                                                break;

                                                default:
                                                    periods +=`<td class="text-center"></td>`;  
                                                break;
                                            }
                                                            
                                        }
                                        
                                    });
                                    if(add){
                                        prom = add/count;
                                        prom = prom.toFixed(2)
                                    }else{
                                        prom = '---'
                                    }
                                    
                                    
                                    periods +=`<td class="text-center"> `+check_value(january)+` </td>`
                                    periods +=`<td class="text-center"> `+check_value(february) +` </td>`
                                    periods +=`<td class="text-center"> `+check_value(march) +` </td>`
                                    periods +=`<td class="text-center"> `+check_value(april)+` </td>`
                                    periods +=`<td class="text-center"> `+ check_value(may) +` </td>`
                                    periods +=`<td class="text-center"> `+check_value(june) +` </td>`
                                    periods +=`<td class="text-center"> `+ check_value(july) +` </td>`
                                    periods +=`<td class="text-center"> `+ check_value(august) +` </td>`
                                    periods +=`<td class="text-center"> `+ check_value(september) +` </td>`
                                    periods +=`<td class="text-center"> `+ check_value(october) +` </td>`
                                    periods +=`<td class="text-center"> `+ check_value(november) +` </td>`
                                    periods +=`<td class="text-center"> `+ check_value(december) +` </td>`

                                    if (periods) {
                                        dato += `<tr>
                                       <td class="text-center">`+ info.report[x].process +`</td>
                                       <td class="text-center">`+ info.report[x].indicator +`</td>
                                       <td class="text-center">`+ info.report[x].formula +`</td>
                                       <td class="text-center">`+ info.report[x].unit +`</td>
                                       <td class="text-center">`+ info.report[x].frequency +`</td>
                                       <td class="text-center">`+ goal +`</td>
                                       <td class="text-center">`+ lower_limit +`</td>
                                       <td class="text-center">`+ upper_limit+`</td>
                                       <td class="text-center">`+type+`</td>
                                       <td class="text-center">`+ info.report[x].job_position+`</td>
                                         `+periods+`
                                       <td class="text-center">`+prom+`</td>
                                       </tr>   
                                       `;
                                    }else{

                                        var emp='';
                                        dato += `<tr>
                                        <td class="text-center">`+ info.report[x].process +`</td>
                                        <td class="text-center">`+ info.report[x].indicator +`</td>
                                        <td class="text-center">`+ info.report[x].formula +`</td>
                                        <td class="text-center">`+ info.report[x].unit +`</td>
                                        <td class="text-center">`+ info.report[x].frequency +`</td>
                                        <td class="text-center">`+ goal +`</td>
                                        <td class="text-center">`+ lower_limit +`</td>
                                        <td class="text-center">`+ upper_limit+`</td>
                                        <td class="text-center">`+type+`</td>
                                        <td class="text-center">`+ info.report[x].job_position+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+emp+`</td>
                                        <td class="text-center">`+prom+`</td>
                                        </tr>   
                                        `;
                                    }       
                                }
                            }
                            if(dato != ''){
                                document.getElementById("table_filter").innerHTML=dato;                                
                            }else{
                                $("#example").remove();
                                alert("no se ha encontrado información de la busqueda");
                            }
                        `</tbody>

                    </table>`;    
           
                    // $('#filtro').trigger('reset');
        
                $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy',  {
                            extend: 'excelHtml5',
                            text: 'excel',
                            exportOptions: {
                                stripHtml: false
                            }
                        },
                    ],
                    "language": {

                        "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                    }
                });

                // $('#example').dataTable().fnDestroy();
                // $('#example').dataTable();
               
            });
            
            
    });
   
    
    
</script>

