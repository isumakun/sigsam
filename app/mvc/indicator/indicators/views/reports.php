<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.1/css/buttons.dataTables.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" />
<style>
    .card-body{
        padding-top: 0px !important;
        display: flex;
        flex-flow: column;
        position: relative !important;
    }
    /*#main_content {
        overflow:auto;
    }*/
    .responstable {
        margin: 1em 0;
        width: 100%;
/*        overflow: hidden;*/
        background: #FFF;
        color: #024457;
/*        border-radius: 10px;*/
/*        border: 1px solid #167F92;*/
    }
    .responstable tr {
        border: 1px solid #D9E4E6;
    }
    .responstable tr:nth-child(odd) {
        background-color: #EAF3F3;
    }
    .responstable th {
        display: none;
/*        border: 1px solid #FFF;*/
        background-color: #279db2;
        color: #FFF;
        padding: 2px !important;
        border-bottom: 1px solid #e5eff8 !important;
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
    #search_ind{
        margin-bottom: 0px !important;
        margin-left: 15px;
    }
    #cl1-lv2{
        margin-top: 27.5px;
        flex: 1 1 auto;
    }
    #cl1-lv1{
        border: 0;
        border-bottom: 1px solid rgb(82 24 24 / 20%);
        flex: 0 1 auto;
    }
    #cl2-lv1{
        height: 100%;
        overflow: auto;
    }
    #some-container button{
        padding: 0px 10px;
        margin-bottom: 0px;
    }
    /*.pdr0{
        padding-right: 0px !important;
    }*/
    .dt-buttons{
        float: right !important;
        height: 100%;
    }

    thead h5{
        margin: 0px !important;
        line-height: normal;
        float: right;
    }
    #table_resp{
        width: 100%;
        padding-right: 5px;
    }
    #table_resp thead{
        position: sticky;
        top: 0;
    }
    td{
        padding: 0px !important;
    }
    #example_paginate{
        position: absolute;
        bottom: 0;
        width: 100%;
        display: flex;
        justify-content: center;
        background-color: white;
        border-top: outset;
        padding: 8px !important;
    }
    .dataTables_wrapper, .norelative{
        position: unset !important;
    }
    #example{
        margin-bottom: 30px;
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
<div class="card h-100">
    <div class="card-body h-100">
        <div class="row" id="cl1-lv1">
            <div class="col-md-10">
                <div class="row" id="cl1-lv2">
                    <form id="search_ind">
                        <div class="row" >
                            <div class="pdr0 col-md-2">
                                <select class="browser-default custom-select" name="age" id="age">
                                    <option hidden selected disbled>Periodo</option>
                                    <?php foreach($periods as $p) { ?>
                                        <option value="<?=$p['age']?>" <?=($p['age'] == $year ? 'selected' : '')?>>
                                            <?=$p['age']?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="pdr0 col-md-2">
                                <select class="browser-default custom-select" name="category" id="category">
                                    <option hidden selected disabled>Categor&iacute;a</option>
                                    <?php foreach($categories as $c) { ?>
                                        <option value="<?=$c['name']?>"<?=($categories['id'] == $c['id'] ? 'selected' : '')?>>
                                            <?=$c['name']?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="pdr0 col-md-3">
                                <select class="browser-default custom-select" name="process" id="process">
                                    <option hidden selected disabled>Proceso</option>
                                    <?php foreach($processes as $ps) { ?>
                                        <option value="<?=$ps['name']?>"<?=($processes['id'] == $ps['id'] ? 'selected' : '')?>>
                                            <?=$ps['name']?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="pdr0 col-md-3">
                                <select class="browser-default custom-select" name="indicators" id="indicators">
                                    <option hidden selected disabled>Indicador</option>
                                    <?php foreach($indicators as $ins) { ?>
                                        <option data-process="<?=$ins['process']?>" value="<?=$ins['name']?>"<?=($processes['id'] == $ins['id'] ? 'selected' : '')?>>
                                            <?=$ins['name']?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="pdr0 col-md-2">
                                <div class="row h-100">
                                     <div class="col-md-6" style="padding: 2px 2px;">
                                        <button type="submit" class="button bluePr h-100 w-100" id="search_reports">Buscar</button>
                                    </div>
                                    <div class="col-md-6" style="padding: 2px 2px;">
                                        <button type="" class="button bluePr h-100 w-100" id="reset_filters">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-2">
                <div class="row">
                    <div class="col-md-12" style="display: flex; justify-content: space-evenly;">
                        <img class="test float-right" width="160" height="90" src="<?=BASE_URL?>/public/resources/users_signs/<?=$_SESSION['user']['company_name']?>.png">
                    </div>
                </div>
            </div>
        </div>
        <div class="row" id="cl2-lv1">
            <div class="col-md-12 norelative">
                <div class="row">
                    <div class="" id="table_resp">
                        <table id="example"  class="responstable" summary="Code page support in different versions of MS Windows." rules="groups" frame="hsides" border="2" style="width:100%">
                        <thead>
                            <tr>
                                <th colspan="23">
                                    <div id="" clas="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-6">
                                                <h5>MATRIZ DE INDICADORES</h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row h-100">
                                                    <div class="col-md-6 h-100" id="some-container"></div>
                                                        <div class="col-md-6">
                                                            <input type="text" id="search" style="padding:0px !important; height: 100%;" placeholder="Buscar..." autocomplete="off">
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            <tr>
                                <th>Proceso</th>
                                <th>Indicador</th>
                                <th>Fórmula</th>
                                <th>ud.</th>
                                <th>Frecuencia</th>
                                <th>Meta</th>
                                <th>LimInf</th>
                                <th>LimSup</th>
                                <th>Tipo</th>
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
                                <th>Prom</th>
                            </tr>
                        </thead>
                        <tbody id="table_filter">
                            <?php foreach ($report as $result) { $prom = null; ?>
                                <tr>
                                    <td class="text-center"><?= $result['process'] ?></td>
                                    <td class="text-center"><?= $result['indicator'] ?></td>
                                    <td class="text-center"><?= $result['formula'] ?></td>
                                    <td class="text-center"><?= $result['unit'] ?></td>
                                    <td class="text-center"><?= $result['frequency'] ?></td>
                                    <td class="text-center"><?= $result['goal'] ?></td>
                                    <td class="text-center"><?= $result['lower_limit'] ?></td>
                                    <td class="text-center"><?= $result['upper_limit'] ?></td>
                                    <td class="text-center"><?= $result['type'] ?></td>
                                    <td class="text-center"><?= $result['job_position'] ?></td>
                                    <?php foreach ($helper as $month => $value) {  ?>
                                        <td class="text-center">
                                            <?php if( ($key = array_search($value, array_column($result['value_result'], 'period'))) !== FALSE  ){ $prom += logchekElements($result['value_result'][$key]['value']); ?>
                                                    <?= $result['value_result'][$key]['value'] ?>
                                            <?php }else{ ?> 
                                                ---
                                            <?php } ?> 
                                        </td>
                                    <?php } ?>
                                    <td class="text-center">
                                        <?php if($prom){ ?>
                                            <?= number_format(($prom/count($result['value_result'])), 2, '.', ' ' ); ?>
                                        <?php }else{ ?> 
                                            ---
                                        <?php } ?> 
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script type="text/javascript">
    
    $(document).ready(function(){
        $('#process').change(function(e) {
            const process_id = process.value
            $('#indicators > option').each(function() {

                if ($(this).data("process") == process_id) $(this).show()
                else $(this).hide()
            });
        });
        $('#reset_filters').on('click', function(e){
            e.preventDefault();
            $('#age option').eq(0).prop('selected', true);
            $('#category option').eq(0).prop('selected', true);
            $('#process option').eq(0).prop('selected', true);
            $('#indicators option').eq(0).prop('selected', true);
        })
        var table = $('#example').DataTable({
            dom: 'Brtp',
            
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
            },
            initComplete: function () {
                this.api().buttons().container().appendTo( $('#some-container' ) );

            },
        });
        $('#table_resp #search').keyup(function() {
            table.search($(this).val()).draw();
        });

	    $('#search_ind').submit(function(event){
            const postData={
                category: $('#category').val(),
                process: $('#process').val(),
                indicators: $('#indicators').val(),
                age: $('#age').val(),
            }
            
            if(postData.age.match(/[0-9]\d*/g)){
                $.post('../indicators/reports',postData, function(answer){
                    let info= JSON.parse(answer);
                    let key=null;
                    var html = '';
                    table.rows().remove().draw();
                    for (const x in info.report) {
                        let prom = null;
                        html +=  `<tr>
                                    <td class="text-center">${info.report[x].process }</td>
                                    <td class="text-center">${info.report[x].indicator}</td>
                                    <td class="text-center">${info.report[x].formula}</td>
                                    <td class="text-center">${info.report[x].unit}</td>
                                    <td class="text-center">${info.report[x].frequency}</td>
                                    <td class="text-center">${info.report[x].goal}</td>
                                    <td class="text-center">${info.report[x].lower_limit}</td>
                                    <td class="text-center">${info.report[x].upper_limit}</td>
                                    <td class="text-center">${info.report[x].type}</td>
                                    <td class="text-center">${info.report[x].job_position}</td>
                                    ${info.helper.map(function (index, value) {
                                        let temp = null;
                                        key = info.report[x].value_result.findIndex(rept => rept.period == index);
                                        if(key > -1){
                                           temp = info.report[x].value_result[key].value;
                                           prom += (logchekElements(temp))*1;
                                        }else{
                                            temp = '---';
                                        }
                                        return `<td class="text-center">${temp}</td>`.trim();
                                    }).join('')}
                                   <td class="text-center">
                                        ${(prom)? (prom/info.report[x].value_result.length).toFixed(2) : '---'}
                                    </td>
                                </tr>`;
                    }
                    table.rows.add($(html)).draw();
                })
            }else{
                Swal.fire({
                    title: '<strong style="background-color: #eaeaea">Periodo no seleccionado</strong>',
                    icon: 'info',
                    html: `<span style="background-color: #eaeaea">El rango de b&uacute;squeda puede ser muy <b>alto</b><span/>, por favor selecciona un periodo`,
                    showCloseButton: true,
                    focusConfirm: false
                })
            }
            event.preventDefault();
        });
    });
</script>

