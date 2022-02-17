<a href="javascript:;" id="active" class="button pull-right">Activar Notificaciones</a>
<style type="text/css">
	.not_readed{
		background-color: #ecefef
	}
</style>
<center><h2>Notificaciones</h2></center>
<?php
		date_default_timezone_set('America/Bogota');
		foreach ($notifications as $notification) {
			$cl = "not_readed";
			if ($notification['was_readed']==1) {
				$cl = "";
			}
			$date = new DateTime($notification['created_at']);
			$current_date = date('d/m/Y', time());
			$noti_date =  $date->format('d/m/Y');
			if ($current_date == $noti_date) {
				$fecha = 'Hoy';
			}else{
				$fecha = $date->format('d/m/Y');
			}
			
			$fecha .= ' a las ';
			$fecha .= $date->format('H:i a');

			$a = $notification['description'];

			if (strpos($a, 'formulario de ingreso') !== false) {
			    $route = 'tbs/input_forms/details?id=';
			}else if (strpos($a, 'formulario de salida') !== false) {
				$route = 'tbs/output_forms/details?id=';
			}else if (strpos($a, 'pase de ingreso') !== false) {
				$route = 'tbs/transport_input_forms/details?id=';
			}else if (strpos($a, 'pase de salida') !== false) {
				$route = 'tbs/transport_output_forms/details?id=';
			}else if (strpos($a, 'solicitud de inspección') !== false) {
				$route = 'tbs/output_forms_inspections_products/';
			}else{
				$route = 'tbs/transformation_forms/details?id=';
			}

			$a = explode('#', $a);
			$a = explode(' ', $a[1]);
			$form_id = str_replace('</b>', '', $a[0]);

			?>
			<a href="<?=BASE_URL.$route.$form_id?>" target="_blank" style="color: black !important">
			<div class="noti <?=$cl?>">
				<div class="noti-image dark w25">
					<span class="icon white <?=$notification['icon']?>"></span>
				</div>
				<div class="w75">
				<p><?=$notification['description']?></p>
				<span class="noti-date"><?=$fecha?></span>
				<?php if ($notification['was_readed']==1) {
					?>
					<span class="icon readed"></span>
					<?php
				} ?>
			</div>
			</div>
			</a>
			<?php
		}
		?>

		<script type="text/javascript">
			$('#active').on('click',function(){
				Push.create("Bienvenido a TBS3!", {
				    body: "Ha habilitado las notificaciones correctamente",
				    icon: '<?=BASE_URL."public/assets/images/icons2/cube4.png"?>',
				    onClick: function () {
				    	location.href = "<?=BASE_URL.'tbs/notifications'?>";
				        window.focus();
				        this.close();
				   }
				})
			})
		</script>