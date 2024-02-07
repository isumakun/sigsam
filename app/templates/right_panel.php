<aside class="aside-menu">
	<ul class="nav nav-tabs" role="tablist">
		<li class="nav-item">
			<a class="nav-link active" data-toggle="tab" href="#messages" role="tab">
				<i class="icon-speech"></i>
			</a>
		</li>
		<li class="nav-item">
			<a href="<?=BASE_URL?>indicator/notifications" class="btn btn-default">Ver todas las notificaciones</a>
		</li>
	</ul>

	<div class="tab-content">
		<div class="tab-pane active p-3" id="notification_panel" role="tabpanel">
			<?php if(isset($_SESSION['panel_notifications'])){ ?> 
			<?php foreach ($_SESSION['panel_notifications'] as $noti) {
		            $date = new DateTime($noti['created_at']);
		            $current_date = date('d/m/Y', time());
		            $noti_date =  $date->format('d/m/Y');
		            if ($current_date == $noti_date) {
		              $fecha = 'Hoy';
		            }else{
		              $fecha = $date->format('d/m/Y');
		            }

		            $fecha .= ' a las ';
		            $fecha .= $date->format('h:i a');
		            ?>
		            <div class="message">
						<div class="py-3 pb-5 mr-3 float-left">
							<div style="padding: 5px;" class="dark">
								<span class="icon white <?=$noti['icon']?>"></span>
							</div>
						</div>
						<div>
							<small class="text-muted mt-1"><?=$fecha?></small>
						</div>
						<p class="" style="text-align: justify;"><?=$noti['description']?></p>
					</div>
					<hr>

		            <?php
		          } ?>
		          <?php }?>
		</div>
	</div>
</aside>