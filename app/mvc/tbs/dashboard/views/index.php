<div class="row">
	<div class="col-6 col-md-6 col-lg-3">
		<a href="<?=BASE_URL?>tbs/input_forms">
			<div class="brand-card">
				<div class="brand-card-header bg-facebook">
					<i class="fa fa-arrow-down"></i>
				</div>
				<div class="brand-card-body">
					<div>
						<div class="text-value upp"> Formularios de Ingreso </div>
					</div>
				</div>
				<div class="brand-card-body">
					<div>
						<div class="text-value"><?=$input_forms[0]['count']?></div>
						<div class="text-uppercase text-muted small">Presentados</div>
					</div>
					<div>
						<div class="text-value"><?=$input_forms[1]['count']?></div>
						<div class="text-uppercase text-muted small">Aprobados</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-6 col-md-6 col-lg-3">
		<a href="<?=BASE_URL?>tbs/transport_input_forms">
			<div class="brand-card">
				<div class="brand-card-header bg-light-blue">
					<i class="fa fa-truck"></i>
				</div>
				<div class="brand-card-body">
					<div>
						<div class="text-value upp"> Pases de Ingreso </div>
					</div>
				</div>
				<div class="brand-card-body">
					<div>
						<div class="text-value"><?=$transport_input_forms[0]['count']?></div>
						<div class="text-uppercase text-muted small">Presentados</div>
					</div>
					<div>
						<div class="text-value"><?=$transport_input_forms[1]['count']?></div>
						<div class="text-uppercase text-muted small">Aprobados</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-sm-6 col-lg-3">
		<a href="<?=BASE_URL?>tbs/output_forms">
			<div class="brand-card">
				<div class="brand-card-header purple">
					<i class="fa fa-arrow-up"></i>
				</div>
				<div class="brand-card-body">
					<div>
						<div class="text-value upp"> Formularios de Salida </div>
					</div>
				</div>
				<div class="brand-card-body">
					<div>
						<div class="text-value"><?=$output_forms[0]['count']?></div>
						<div class="text-uppercase text-muted small">Presentados</div>
					</div>
					<div>
						<div class="text-value"><?=$output_forms[1]['count']?></div>
						<div class="text-uppercase text-muted small">Aprobados</div>
					</div>
				</div>
			</div>
		</a>
	</div>
	<div class="col-sm-6 col-lg-3">
		<a href="<?=BASE_URL?>tbs/transport_output_forms">
			<div class="brand-card">
				<div class="brand-card-header bg-purple">
					<i class="fa fa-truck"></i>
				</div>
				<div class="brand-card-body">
					<div>
						<div class="text-value upp"> Pases de Salida </div>
					</div>
				</div>
				<div class="brand-card-body">
					<div>
						<div class="text-value"><?=$transport_output_forms[0]['count']?></div>
						<div class="text-uppercase text-muted small">Presentados</div>
					</div>
					<div>
						<div class="text-value"><?=$transport_output_forms[1]['count']?></div>
						<div class="text-uppercase text-muted small">Aprobados</div>
					</div>
				</div>
			</div>
		</a>
	</div>
</div>