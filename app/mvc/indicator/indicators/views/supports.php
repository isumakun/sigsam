<div class="card">
<center><h2>Soportes</h2></center>
<table>
    <thead>
        <th><?=$indicator['name']?></th>
        <th></th>
    </thead>
    <tbody>
    <?php if ($support) {
     
     foreach ($support as $s) { ?>
        <tr>
        <?php
            if ($s['support']!='') {
        ?>
            <td>
            <?php if ($s['support']) {
                $route = "https://nx001.nexter.us-nyc1.upcloudobjects.com/indicator/uploads/".$s['id'].".".end(explode('.',$s['support']));
                $route2 = "https://nx001.nexter.us-nyc1.upcloudobjects.com/indicator/uploads/".$s['inform_id'].".".end(explode('.',$s['support']));
                $solution = $_SERVER['DOCUMENT_ROOT']."/indicator".substr($s['support'], 1);


                if(!file_exists($solution)){
                    if(file_exists($route2)){
                        $route = "../../public/uploads/".$s['inform_id'].".".end(explode('.',$s['support']));
                    }else{
                        $route = "../../public/uploads/".$s['id'].".".end(explode('.',$s['support']));
                    }
                }else{
                    $route = "../../".$s['support'];
                } ?>
        
                    <a data-toggle="tooltip" data-placement="bottom" title="Descargar" href="<?= $route?>" download="<?=basename($s['support'])?>"><i class="fas fa-file-download fa-2x" ></i><?= basename($s['support'])?>
                </a>
            <?php } ?>
                        </td>

            
            <td>
            <?php if ($s['support1']) {
                $rou = "https://nx001.nexter.us-nyc1.upcloudobjects.com/indicator/uploads/".$s['id'].".".end(explode('.',$s['support1']));
                $rou2 = "https://nx001.nexter.us-nyc1.upcloudobjects.com/indicator/uploads/".$s['inform_id'].".".end(explode('.',$s['support1']));
                $solution2 = $_SERVER['DOCUMENT_ROOT']."/indicator".$s['support1'];

                if(!file_exists($solution2)){
                    
                    if(file_exists($rou2)){
                        $rou = "../../public/uploads/".$s['inform_id'].".".end(explode('.',$s['support1']));
                    }else{
                        $rou = "../../public/uploads/".$s['id'].".".end(explode('.',$s['support1']));
                    }
                }else{
                    $rou = "../../".$s['support1'];
                } ?>
                <a data-toggle="tooltip" data-placement="bottom" title="Descargar" href="<?= $rou?>" download="<?=basename($s['support1'])?>"><i class="fas fa-file-download fa-2x" ></i><?= basename($s['support1'])?></a>
            <?php } ?>
            </td>
       <?php  
                    }
       ?>
        </tr>
    <?php } }else{?>
        <tr>
            <td>Este indicador no posee soportes.</td>
        </tr>
    <?php
    }
    ?>
    </tbody>
</table>
</div>