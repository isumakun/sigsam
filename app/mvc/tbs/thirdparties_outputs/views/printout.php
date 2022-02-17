<?php
	require 'core/libraries/PDF.php';
	data('output_id', $output['id']);
	class TBSPDF extends PDF
	{
		function Header()
		{
			$output_id = get_data('output_id');

			$this->AliasNbPages();

			$this->add_title('TBS3 - SALIDA DE TERCEROS');
			$this->add_row([
				['Usuario operador', 'ZONA FRANCA LAS AMÉRICAS S.A.S. - Nit: 900162578-4', 50],
				['Salida No.', "{$output_id}", 10, 'R'],
				['Descargado', date('Y-m-d h:i:s'), 30],
				['Página', $this->PageNo().' de {nb}', 10],
			]);
		}
	}

	$pdf = new TBSPDF('P','mm','letter');

	$pdf->SetAutoPageBreak(false);
	$pdf->SetMargins(10, 11, 9.9);

	$pdf->AddPage();

	// INFORMACIÓN GENERAL ---------------------------------------------
	$pdf->add_subtitle('Información general');
	$nit = substr($_SESSION['user']['company_schema'], 5);
	$pdf->add_row([
		['Usuario calificado', $_SESSION['user']['company_name'].' - Nit: '.$nit, 100],
	]);

	// FECHAS ---------------------------------------------------------
	$output['presented_at'] = ($output['presented_at'] == '0000-00-00 00:00:00' ? '' : $output['presented_at']);
	$output['approved_at'] = ($output['approved_at'] == '0000-00-00 00:00:00' ? '' : $output['approved_at']);

	$pdf->add_row([
		['Fecha', $output['created_at'], 20],
		['Solicitud de Ingreso', $output['request_id'], 20],
		['Empresa', $output['company'], 20],
		['Empleado', $output['employee'], 20],
		['Vehículo', $output['vehicle_plate'], 20],
	]);


	$work_types = explode(',', $output['work_types']);
	$string_wt = '';

	foreach ($thirdparties_works_types as $work_type) {
		foreach ($work_types as $wt) {
			if ($wt == $work_type['id']) {
				$string_wt .= $work_type['name'].'; ';
			}
		}
	}

	// HERRAMIENTAS --------------------------------------------------------
	$pdf->add_title('1. MATERIALES, HERRAMIENTAS y EQUIPOS');

	$count = 1;
	foreach ($tools as $tool) {
		if ($count == 1) {
			$pdf->add_row([
				['Detalle', $tool['tool'], 30],
				['Cantidad', $tool['quantity'], 25],
				['Fecha de creación', $tool['created_at'], 25],
				['Ingresó el', $tool['entry'], 20],
			]);
		}else{
			$pdf->add_collapse_row([
				['Detalle', $tool['tool'], 30],
				['Cantidad', $tool['quantity'], 25],
				['Fecha de creación', $tool['created_at'], 25],
				['Ingresó el', $tool['entry'], 20],
			]);
		}
		$count++;
	}

	// OBSERVACIONES ---------------------------------------------------
	$pdf->add_title('3. OBSERVACIONES');
	$pdf->add_row([
		['Observaciones', $output['observations'], 100],
	]);

	$pdf->Output();
