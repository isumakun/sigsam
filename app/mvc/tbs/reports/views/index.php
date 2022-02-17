<center><h3>Reportes</h3></center>

<div class="row" style="margin-top: 20px">
	<div class="col-6 col-lg-4">
		<a href="#trazeability" class="modal">
			<div class="card">
				<div class="card-body p-0 d-flex align-items-center">
					<i class="fa fa-line-chart dark p-4 font-2xl mr-3"></i>
					<div>
						<div class="text-value-sm text-info">Trazabilidad</div>
						<div class="text-muted text-uppercase small">Trazabilidad de un producto</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-6 col-lg-4">
		<a href="<?=BASE_URL?>tbs/reports/transports_by_form" class="modal">
			<div class="card">
				<div class="card-body p-0 d-flex align-items-center">
					<i class="fa fa-truck purple p-4 font-2xl mr-3"></i>
					<div>
						<div class="text-value-sm text-info">Pases por formulario</div>
						<div class="text-muted text-uppercase small">Lista de pases de un formulario</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-6 col-lg-4">
		<a href="<?=BASE_URL?>tbs/reports/re_entry" class="modal">
			<div class="card">
				<div class="card-body p-0 d-flex align-items-center">
					<i class="fa fa-car blue p-4 font-2xl mr-3"></i>
					<div>
						<div class="text-value-sm text-info">Masivo para reingreso</div>
						<div class="text-muted text-uppercase small">Reingreso de carros en un pase de salida</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-6 col-lg-4">
		<a href="<?=BASE_URL?>tbs/reports/warehouse" class="modal">
			<div class="card">
				<div class="card-body p-0 d-flex align-items-center">
					<i class="fas fa-coins purple p-4 font-2xl mr-3"></i>
					<div>
						<div class="text-value-sm text-info">Saldos a la fecha</div>
						<div class="text-muted text-uppercase small">Reporte de saldos a la fecha</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-6 col-lg-4">
		<a href="<?=BASE_URL?>tbs/reports/dane_menu" class="modal">
			<div class="card">
				<div class="card-body p-0 d-flex align-items-center">
					<i class="fas fa-file-excel dark p-4 font-2xl mr-3"></i>
					<div>
						<div class="text-value-sm text-info">Reporte DANE</div>
						<div class="text-muted text-uppercase small">Reporte con formato DANE</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-6 col-lg-4">
		<a href="<?=BASE_URL?>tbs/reports/transformations_products" class="modal">
			<div class="card">
				<div class="card-body p-0 d-flex align-items-center">
					<i class="fas fa-retweet blue p-4 font-2xl mr-3"></i>
					<div>
						<div class="text-value-sm text-info">Producto en Transformación</div>
						<div class="text-muted text-uppercase small">Uso de producto en transformaciones</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-6 col-lg-4">
		<a href="<?=BASE_URL?>tbs/reports/thirdparties_validity" class="modal">
			<div class="card">
				<div class="card-body p-0 d-flex align-items-center">
					<i class="fas fa-users blue p-4 font-2xl mr-3"></i>
					<div>
						<div class="text-value-sm text-info">Terceros Verificados</div>
						<div class="text-muted text-uppercase small">Lista de terceros verificados</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<?php if (has_role(1)) {?>
		<div class="col-6 col-lg-4">
			<a href="<?=BASE_URL?>tbs/reports/fob_value" class="modal">
				<div class="card">
					<div class="card-body p-0 d-flex align-items-center">
						<i class="fas fa-dollar-sign dark p-4 font-2xl mr-3"></i>
						<div>
							<div class="text-value-sm text-info">FOB Value</div>
							<div class="text-muted text-uppercase small">Reporte de FOB por años</div>
						</div>
					</div>
				</div>
			</a>
		</div>
		<div class="col-6 col-lg-4">
			<a href="<?=BASE_URL?>tbs/reports/approbation_datetime" class="modal">
				<div class="card">
					<div class="card-body p-0 d-flex align-items-center">
						<i class="fas fa-check purple p-4 font-2xl mr-3"></i>
						<div>
							<div class="text-value-sm text-info">Tiempos de aprobación</div>
							<div class="text-muted text-uppercase small">Reporte de tiempo de aprobación por año</div>
						</div>
					</div>
				</div>
			</a>
		</div>
	<?php
	}
	?>
</div>

<div id="trazeability" class="modal">
	<h3>Trazabilidad</h3>
	<form method='POST' action="reports/trace">

		<label>Tipo de trazbilidad</label>
		<select name="report_type">
			<option value="1">Por producto</option>
		</select>

		<label>ID de almacen</label>
		<input name="product_id" required />

		<label></label>
		<input type="submit"/>

	</form>
</div>
