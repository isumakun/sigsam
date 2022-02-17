<?php
	require 'core/libraries/PDF.php';

	data('form_id', $transformation_form['form_id']);

	class TBSPDF extends PDF
	{
		function Header()
		{
			$this->AliasNbPages();

			$form_id = get_data('form_id');

			$this->add_title('TBS III - CERTIFICADO DE INTEGRACIÓN');
			$this->add_row([
				['Usuario operador', 'ZONA FRANCA LAS AMÉRICAS S.A.S. - Nit: 900162578-4', 50],
				['FMM No.', '94333'.$form_id, 15, 'R'],
				['Acuerdo', 'N/A', 10],
				['Descargado', date('Y-m-d h:i:s'), 15],
				['Página', $this->PageNo().' de {nb}', 10],
			]);
		}
	}

	$pdf = new TBSPDF('P','mm','letter');

	$pdf->SetAutoPageBreak(false);
	$pdf->SetMargins(10, 10, 9.9);

	$pdf->AddPage();

	// FECHAS ---------------------------------------------------------
	$transformation_form['presented_at'] = ($transformation_form['presented_at'] == '0000-00-00 00:00:00' ? '' : $transformation_form['presented_at']);
	$transformation_form['approved_at'] = ($transformation_form['approved_at'] == '0000-00-00 00:00:00' ? '' : $transformation_form['approved_at']);

	$nit = substr($_SESSION['user']['company_schema'], 5);
	// INFORMACIÓN GENERAL ---------------------------------------------
	$pdf->add_subtitle('1. Información general');
	$pdf->add_row([
		['Usuario calificado', $_SESSION['user']['company_name'].' - Nit: '.$nit, 40],
		['Creado', $transformation_form['created_at'], 20],
		['Presentado', $transformation_form['presented_at'], 20],
		['Aprobado', $transformation_form['approved_at'], 20],
	]);

	// PRODUCTOS -------------------------------------------------------
	$pdf->add_title('2. Productos');

	$count = 1;
	foreach ($transformation_forms_products as $ifp)
	{

		$product_type = ($ifp['is_principal'] == 1 ? 'Principal' : 'Subproducto');

		if ($count == 1)
		{
			$pdf->add_row([
				['Producto', $ifp['product'], 35],
				['Tipo', 'Zona Franca', 15],
				['Subpartida', $ifp['code'], 10],
				['Valor FOB', '$ '.number_format($ifp['fob_value']), 15, 'R'],
				['Cantidad', number_format($ifp['quantity']).' '.$ifp['symbol'], 15, 'R'],
				['Clase', $product_type, 10],
			]);
		}
		else
		{
			$pdf->add_collapse_row([
				['Producto', $ifp['product'], 35],
				['Tipo', 'Zona Franca', 15],
				['Subpartida', $ifp['code'], 10],
				['Valor FOB', '$ '.number_format($ifp['fob_value']), 15, 'R'],
				['Cantidad', number_format($ifp['quantity']).' '.$ifp['symbol'], 15, 'R'],
				['Clase', $product_type, 10],
			]);
		}

		$count++;
	}

	// INSUMOS ---------------------------------------------------------
	$pdf->add_title('3. Insumos');

	$extranjero = 0;
	$nacional = 0;
	$con_acuerdo = 0;
	$nacionalizado = 0;
	$zona_franca = 0;
	$nacional_exportado = 0;
	$otros = 0;

	$count = 1;
	foreach ($transformation_forms_consumables as $tfc)
	{
		switch ($tfc['product_type_id'])
		{
			case 1: $extranjero += $tfc['unit_value'] * $tfc['quantity']; break;
			case 2: $nacional += $tfc['unit_value'] * $tfc['quantity']; break;
			case 3: $con_acuerdo += $tfc['unit_value'] * $tfc['quantity']; break;
			case 4: $nacionalizado += $tfc['unit_value'] * $tfc['quantity']; break;
			case 5: $zona_franca += $tfc['unit_value'] * $tfc['quantity']; break;
			case 6: $nacional_exportado += $tfc['unit_value'] * $tfc['quantity']; break;
			case 7: $otros += $tfc['unit_value'] * $tfc['quantity']; break;
		}

		$total += $tfc['unit_value'] * $tfc['quantity'];

		if ($count == 1)
		{
			$pdf->add_row([
				['Producto', $tfc['name'], 35],
				['Tipo', $tfc['product_type'], 15],
				['Subpartida', $tfc['code'], 10],
				['Valor FOB', '$ '.number_format($tfc['unit_value'] * $tfc['quantity']), 15, 'R'],
				['Cantidad', number_format($tfc['quantity']).' '.$tfc['symbol'], 15, 'R'],
				['Desperdicio', $tfc['product_waste'], 10, 'R'],
			]);
		}
		else
		{
			$pdf->add_collapse_row([
				['Producto', $tfc['name'], 35],
				['Tipo', $tfc['product_type'], 15],
				['Subpartida', $tfc['code'], 10],
				['Valor FOB', '$ '.number_format($tfc['unit_value'] * $tfc['quantity']), 15, 'R'],
				['Cantidad', number_format($tfc['quantity']).' '.$tfc['symbol'], 15, 'R'],
				['Desperdicio', $tfc['product_waste'], 10, 'R'],
			]);
		}

		$count++;
	}

	// PORCENTAJE DE PARTICIPACIÓN  ------------------------------------
	$pdf->add_subtitle('4. Demás componentes nacionales');
	$pdf->add_row([
		['Mano de obra', '$ '.number_format($transformation_form['man_power']), 33.33],
		['Utilidad', '$ '.number_format($transformation_form['utility']), 33.33],
		['Costos indirectos', '$ '.number_format($transformation_form['direct_cost']), 33.33],
	]);

	// PORCENTAJE DE PARTICIPACIÓN  ------------------------------------
	$pdf->add_subtitle('5. Porcentaje de participación');
	$pdf->add_row([
		['Nacionales', '$ '.number_format($nacional * 100 / $total, 2), 14.28, 'R'],
		['Extranjeros', '$ '.number_format($extranjero * 100 / $total, 2), 14.28, 'R'],
		['Zona Franca', '$ '.number_format($zona_francazona_franca * 100 / $total, 2), 14.28, 'R'],
		['Con acuerdo', '$ '.number_format($con_acuerdo * 100 / $total, 2), 14.28, 'R'],
		['Exportado', '$ '.number_format($nacional_exportado * 100 / $total, 2), 14.28, 'R'],
		['Nacionalizado', '$ '.number_format($nacionalizado * 100 / $total, 2), 14.28, 'R'],
		['Demás componentes', '$ '.number_format($otros * 100 / $total, 2), 14.28, 'R'],
	]);

	// SOPORTES --------------------------------------------------------
	$pdf->add_title('6. Soportes');

	$count = 1;
	foreach ($transformation_forms_supports as $supp)
	{
		if ($count == 1)
		{
			$pdf->add_row([
				['ID', $supp['supp_id'], 10],
				['Tipo', $supp['support_type'], 20],
				['Fecha', $supp['created_at'], 20],
				['Detalle', $supp['details'], 50],
			]);
		}
		else
		{
			$pdf->add_collapse_row([
				['ID', $supp['supp_id'], 10],
				['Tipo', $supp['support_type'], 20],
				['Fecha', $supp['created_at'], 20],
				['Detalle', $supp['details'], 50],
			]);
		}

		$count++;
	}

	// AJUSTES --------------------------------------------------------
	$pdf->add_title('4. AJUSTES');

	$count = 1;
	foreach ($forms_adjustments as $adjust) {
		if ($count == 1) {
			$pdf->add_row([
				['Campo', variable_to_name($adjust['field_name']), 20],
				['Valor Anterior', $adjust['old_value'], 20],
				['Nuevo Valor', $adjust['new_value'], 20],
				['Ajustado por', $adjust['created_by'], 20],
				['Ajustado el', $adjust['created_at'], 20],
			]);
		}else{
			$pdf->add_collapse_row([
				['Campo', variable_to_name($adjust['field_name']), 20],
				['Valor Anterior', $adjust['old_value'], 20],
				['Nuevo Valor', $adjust['new_value'], 20],
				['Ajustado por', $adjust['created_by'], 20],
				['Ajustado el', $adjust['created_at'], 20],
			]);
		}
		$count++;
	}

	// FIRMAS ----------------------------------------------------------
	$pdf->add_title('7. Firmas');
	$pdf->add_row([
		['Firmas', '
		El usuario calificado declara, bajo gravedad de juramento, que toda la información suministrada en este formuario es veraz. Se le autoriza al Ministerio de Comercio Exterior, utilizar la información contenida en este formulario con fines estadísticos.
		', 50, 'C'],
		['Firma del usuario operador', '', 25],
		['Firma del usuario calificado', '', 25],
	]);

	if ($transformation_form['approved_by_user']!='') {
		$pdf->Image(BASE_URL.'public/resources/users_signs/'.$transformation_form['approved_by_user'].'.png', $pdf->GetX() + 97, $pdf->GetY() - 18, 36);
		$pdf->Image(BASE_URL.'public/resources/users_signs/'.$transformation_form['created_by_user'].'.png', $pdf->GetX() + 147, $pdf->GetY() - 18, 36);
	}

	$pdf->Output();
