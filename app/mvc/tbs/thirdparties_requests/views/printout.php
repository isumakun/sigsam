<?php
	require 'core/libraries/PDF.php';
	data('request_id', $request['id']);
	class TBSPDF extends PDF
	{
		function Header()
		{
			$request_id = get_data('request_id');

			$this->AliasNbPages();

			$this->add_title('TBS3 - SOLICITUD DE INGRESO DE TERCEROS');
			$this->add_row([
				['Usuario operador', 'ZONA FRANCA LAS AMÉRICAS S.A.S. - Nit: 900162578-4', 50],
				['Solicitud No.', "{$request_id}", 10, 'R'],
				['Descargado', date('Y-m-d h:i:s'), 30],
				['Página', $this->PageNo().' de {nb}', 10],
			]);
		}
	}

	$pdf = new TBSPDF('P','mm','letter');

	$pdf->SetAutoPageBreak(false);
	$pdf->SetMargins(10, 10, 9.9);

	$pdf->AddPage();

	// INFORMACIÓN GENERAL ---------------------------------------------
	$pdf->add_subtitle('Información general');
	$nit = substr($_SESSION['user']['company_schema'], 5);
	$pdf->add_row([
		['Usuario calificado', $_SESSION['user']['company_name'].' - Nit: '.$nit, 100],
	]);

	// FECHAS ---------------------------------------------------------
	$request['presented_at'] = ($request['presented_at'] == '0000-00-00 00:00:00' ? '' : $request['presented_at']);
	$request['approved_at'] = ($request['approved_at'] == '0000-00-00 00:00:00' ? '' : $request['approved_at']);

	$pdf->add_row([
		['Creado', $request['created_at'], 35],
		['Presentado', $request['presented_at'], 35],
		['Aprobado', $request['approved_at'], 30],
	]);

	$pdf->add_row([
		['Empresa', $request['company'], 30],
		['Persona a Cargo', $request['person_in_charge'], 30],
		['Fecha Inicio', $request['schedule_from'], 20, 'R'],
		['Fecha Fin', $request['schedule_to'], 20, 'R']
	]);

	$work_types = explode(',', $request['work_types']);
	$string_wt = '';

	foreach ($thirdparties_works_types as $work_type) {
		foreach ($work_types as $wt) {
			if ($wt == $work_type['id']) {
				$string_wt .= $work_type['name'].'; ';
			}
		}
	}

	$pdf->add_row([
		['Contacto', $request['contact_phone'], 25],
		['Acceso', $request['access'], 25],
		['Horario', $request['working_hours'], 25],
		['Tipos de Trabajos', $string_wt, 25],

	]);
	// HERRAMIENTAS --------------------------------------------------------
	$pdf->add_title('1. MATERIALES, HERRAMIENTAS y EQUIPOS');

	$count = 1;
	foreach ($tools as $tool) {
		if ($count == 1) {
			$pdf->add_row([
				['Detalle', $tool['tool'], 20],
				['Cantidad', $tool['quantity'], 20],
				['Unidad', $tool['unit'], 20],
				['Fecha de creación', $tool['created_at'], 20],
				['Ingresó el', $tool['entry'], 20],
			]);
		}else{
			$pdf->add_collapse_row([
				['Detalle', $tool['tool'], 20],
				['Cantidad', $tool['quantity'], 20],
				['Unidad', $tool['unit'], 20],
				['Fecha de creación', $tool['created_at'], 20],
				['Ingresó el', $tool['entry'], 20],
			]);
		}
		$count++;
	}

	// HERRAMIENTAS --------------------------------------------------------
	$pdf->add_title('2. PERSONAS');

	$count = 1;
	foreach ($workers as $worker) {
		if ($count == 1) {
			$pdf->add_row([
					['Nombre', $worker['employee'], 20],
					['Categoria', $worker['category'], 20],
					['Placa Vehículo', $worker['vehicle_plate'], 10],
					['ARL', $worker['arl'], 15],
					['EPS', $worker['eps'], 15],
					['Fecha límite cobertura ARL', $worker['limit_date'], 20],
				]);
		}else{
			$pdf->add_collapse_row([
					['Nombre', $worker['employee'], 20],
					['Categoria', $worker['category'], 20],
					['Placa Vehículo', $worker['vehicle_plate'], 10],
					['ARL', $worker['arl'], 15],
					['EPS', $worker['eps'], 15],
					['Fecha límite cobertura ARL', $worker['limit_date'], 20],
				]);
		}
		$count++;
	}

	// OBSERVACIONES ---------------------------------------------------
	$pdf->add_title('3. OBSERVACIONES');
	$pdf->add_row([
		['Observaciones', $request['observations'], 100],
	]);

	$pdf->Output();
