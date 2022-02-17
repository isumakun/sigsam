
<style type="text/css">
	.main_link{
		color: black !important;
	}

	.card{
		margin: 15px !important;
		display: flex !important;
   		align-items:center;
		height: 100px;
		line-height: 80px;
	}

	.card>h4{
		padding-left: 15px
	}
</style>
<div class="">
	
	<div class="col-md-10 offset-md-1 row">
		<a href="<?=BASE_URL?>indicator/indicators" class="main_link col-xs-6 col-md-3">
			<div class="card main-card">
				<img src="<?=BASE_URL?>public/assets/images/indy_icons/check.png" height="50">
				<h4>Indicadores</h4>
			</div>
		</a>

		<a href="<?=BASE_URL?>indicator/indicators/reports" class="main_link col-xs-6 col-md-3">
			<div class="card main-card">
				<img src="<?=BASE_URL?>public/assets/images/indy_icons/pie_graph.png" height="50">
				<h4>Reportes</h4>
			</div>
		</a>

		<a href="#" class="main_link col-xs-6 col-md-3">
			<div class="card main-card">
				<img src="<?=BASE_URL?>public/assets/images/indy_icons/team.png" height="50">
				<h4>Usuarios</h4>
			</div>
		</a>

		<a href="#" class="main_link col-xs-6 col-md-3">
			<div class="card main-card">
				<img src="<?=BASE_URL?>public/assets/images/indy_icons/gear.png" height="50">
				<h4>Configuración</h4>
			</div>
		</a>
	</div>
</div>