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
            <?php
                if ($s['support']) {
                    $route = $_SERVER['DOCUMENT_ROOT']."/indicator/public/uploads/".$s['id'].".".end(explode('.',$s['support']));
                    if(!file_exists($route)){
                    $route = "../../public/uploads/".$s['inform_id'].".".end(explode('.',$s['support']));
              }else{
                $route = "../../public/uploads/".$s['id'].".".end(explode('.',$s['support']));
              }
              
            ?>
            
                        <a data-toggle="tooltip" data-placement="bottom" title="Descargar" href="<?= $route?>"><i class="fas fa-file-download fa-2x"></i><?=$s['support']?>
                    </a>
                        <?php
                 } 
            ?>
                        </td>

            
            <td>
            <?php
                if ($s['support1']) {
              
            ?>
            <a data-toggle="tooltip" data-placement="bottom" title="Descargar" href="..\..\public\uploads\<?=$s['id']?>.<?=end(explode('.',$s['support1']))?>" download="<?=$s['support1']?>"><i class="fas fa-file-download fa-2x"></i><?=$s['support1']?></a>
            <?php
                 } 
            ?>
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