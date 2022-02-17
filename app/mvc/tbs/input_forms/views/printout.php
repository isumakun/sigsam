<?php
	require 'core/libraries/PDF.php';
	data('form_id', $input_form['form_id']);
	data('agreement', $input_form['agreement_id']);
	class TBSPDF extends PDF
	{
		function Header()
		{
			$form_id = get_data('form_id');
			$agreement = get_data('agreement');

			$this->AliasNbPages();

			$this->add_title('TBS3 - FORMULARIO DE INGRESO DE MERCANCÍAS');
			$this->add_row([
				['Usuario operador', 'ZONA FRANCA LAS AMÉRICAS S.A.S. - Nit: 900162578-4', 50],
				['FMM No.', "94331{$form_id}", 15, 'R'],
				['Acuerdo', "{$agreement}", 10],
				['Descargado', date('Y-m-d h:i:s'), 15],
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
		['Usuario calificado', $_SESSION['user']['company_name'].' - Nit: '.$nit, 50],
		['Proveedor', $input_form['supplier'].' - Nit: '.$input_form['supplier_nit'], 50]
	]);

	// FECHAS ---------------------------------------------------------
	$input_form['presented_at'] = ($input_form['presented_at'] == '0000-00-00 00:00:00' ? '' : $input_form['presented_at']);
	$input_form['approved_at'] = ($input_form['approved_at'] == '0000-00-00 00:00:00' ? '' : $input_form['approved_at']);
	$input_form['executed_at'] = ($input_form['executed_at'] == '0000-00-00 00:00:00' ? '' : $input_form['executed_at']);

	$pdf->add_row([
		['Creado', $input_form['created_at'], 20],
		['Presentado', $input_form['presented_at'], 20],
		['Aprobado', $input_form['approved_at'], 20],
		['Ejecutado', $input_form['executed_at'], 20],
		['Ajustado', '', 20],
	]);

	$sum_weight = 0;
	$sum_fob = 0;
	$sum_freights = 0;
	$sum_insurance = 0;
	$sum_other_expenses = 0;

	foreach ($input_forms_products as $ifp) {
		$sum_weight += $ifp['gross_weight'];
		$sum_fob += $ifp['fob_value'];
		$sum_freights += $ifp['freights'];
		$sum_insurance += $ifp['insurance'];
		$sum_other_expenses += $ifp['other_expenses'];
	}

	// Peso báscula = Peso entrada - Peso Salida; <-- Para esto se usan los putos comentarios. ¬.¬
	$total_scale = 0;


	foreach ($transports as $transport) {
		$total_scale += ($transport['starting_weight_value'] - $transport['ending_weight_value']);	
	}

	$pdf->add_row([
		['Transacción', $input_form['transaction_code'] .' - '. $input_form['transaction'], 60],
		['Transporte', $input_form['transport'], 20],
		['Núm. bultos', $input_form['packages_quantity'], 10, 'R'],
		['Peso báscula', number_format($total_scale, 2), 10, 'R']
	]);

	$pdf->add_row([
		['Bandera', $input_form['flag_id_4'].' - '.$input_form['flag_name_4'], 25],
		['País de destino', $input_form['flag_id_2'].' - '.$input_form['flag_name_2'], 25],
		['País de compra', $input_form['flag_id_1'].' - '.$input_form['flag_name_1'], 25],
		['País de procedencia', $input_form['flag_id_3'].' - '.$input_form['flag_name_3'], 25],

	]);

	$cif_usd = $sum_fob+$sum_freights+$sum_insurance+$sum_other_expenses;
	$cif_cop = ($cif_usd * $input_form['exchange_rate']);

	// FOB TOTAL -------------------------------------------------------
	$pdf->add_row([
		['Total FOB - USD', '$ '.number_format($sum_fob, 2), 15, 'R'],
		['Total fletes - USD', '$ '.number_format($sum_freights, 2), 15, 'R'],
		['Total seguros - USD', '$ '.number_format($sum_insurance, 2), 15, 'R'],
		['Otros gastos USD', '$ '.number_format($sum_other_expenses, 2), 15, 'R'],
		['Total CIF USD', '$ '.number_format($cif_usd, 2), 15, 'R'],
		['Total CIF COP', '$ '.number_format(round($cif_cop)), 15, 'R'],
		['TRM', '$ '.$input_form['exchange_rate'], 10, 'R'],
	]);

	// PRODUCTOS -------------------------------------------------------
	$pdf->add_title('2. PRODUCTOS');

	if ($input_form['form_state_id']==5) {

		$scale_diff_products = array();
		$count = 1;
		$tariff_heading = 0;

		foreach ($input_forms_products as $ifp)
		{
			if (($ifp['stock']+$ifp['reserved']+$ifp['approved']+$ifp['inspected_to_output']+$ifp['reserved_to_output']+$ifp['dispatched']+$ifp['nationalized'])>0) {
				if ($count==1) {
					$tariff_heading = $ifp['tariff_heading_id'];
					$pdf->add_subtitle('Subpartida');

					$pdf->add_row([
						['Descripción', $ifp['tariff_heading'], 85],
						['Unidad', $ifp['tariff_heading_unit'], 15, 'R'],
					]);

					$pdf->add_row([
							['Producto', html_entity_decode($ifp['product']), 25],
							['Tipo', $ifp['product_type'], 10],
							['Embalaje', $ifp['packing'], 10],
							['País de Origen', $ifp['flag_id'].' - '.$ifp['flag'], 10],
							['Peso bruto',  number_format($ifp['gross_weight'], 2), 10, 'R'],
							['Peso neto',  number_format($ifp['net_weight'], 2), 10, 'R'],
							['Valor FOB', '$ '.number_format($ifp['fob_value'], 2), 15, 'R'],
							['Cantidad', number_format($ifp['quantity'], 2).' '.$ifp['unit_symbol'], 10, 'R']
						]);
				}else{
					if ($tariff_heading!=$ifp['tariff_heading_id']) {
						$tariff_heading = $ifp['tariff_heading_id'];
						$pdf->add_subtitle('Subpartida');

						$pdf->add_row([
							['Descripción', $ifp['tariff_heading'], 85],
							['Unidad', $ifp['unit_symbol'], 15, 'R'],
						]);

						$pdf->add_row([
								['Producto', html_entity_decode($ifp['product']), 25],
								['Tipo', $ifp['product_type'], 10],
								['Embalaje', $ifp['packing'], 10],
								['Pais de origen', $ifp['flag_id'].' - '.$ifp['flag'], 10],
								['Peso bruto', number_format($ifp['gross_weight'], 2), 10, 'R'],
								['Peso neto', number_format($ifp['net_weight'], 2), 10, 'R'],
								['Valor FOB', '$ '.number_format($ifp['fob_value'], 2), 15, 'R'],
								['Cantidad', number_format($ifp['quantity'], 2).' '.$ifp['unit_symbol'], 10, 'R']
							]);
					}else{
						$pdf->add_collapse_row([
							['Producto', html_entity_decode($ifp['product']), 25],
							['Tipo', $ifp['product_type'], 10],
							['Embalaje', $ifp['packing'], 10],
							['Pais de origen', $ifp['flag_id'].' - '.$ifp['flag'], 10],
							['Peso bruto', number_format($ifp['gross_weight'], 2), 10, 'R'],
							['Peso neto', number_format($ifp['net_weight'], 2), 10, 'R'],
							['Valor FOB', '$ '.number_format($ifp['fob_value'], 2), 15, 'R'],
							['Cantidad', number_format($ifp['quantity'], 2).' '.$ifp['unit_symbol'], 10, 'R']
						]);
					}
				}
			}else{
				array_push($scale_diff_products, $ifp);
			}
			$count++;
		}

		if (count($scale_diff_products)>0) {
			$count = 1;
			$pdf->add_title('2.1. PRODUCTOS NO INGRESADOS');

			foreach ($scale_diff_products as $ifp) {
				if ($count==1) {
					$tariff_heading = $ifp['tariff_heading_id'];
					$pdf->add_subtitle('Subpartida');

					$pdf->add_row([
						['Descripción', $ifp['tariff_heading'], 85],
						['Unidad', $ifp['tariff_heading_unit'], 15, 'R'],
					]);

					$pdf->add_row([
							['Producto', html_entity_decode($ifp['product']), 25],
							['Tipo', $ifp['product_type'], 10],
							['Embalaje', $ifp['packing'], 10],
							['País de Origen', $ifp['flag_id'].' - '.$ifp['flag'], 10],
							['Peso bruto',  number_format($ifp['gross_weight'], 2), 10, 'R'],
							['Peso neto',  number_format($ifp['net_weight'], 2), 10, 'R'],
							['Valor FOB', '$ '.number_format($ifp['fob_value'], 2), 15, 'R'],
							['Cantidad', number_format($ifp['quantity'], 2).' '.$ifp['tariff_heading_unit'], 10, 'R']
						]);
				}else{
					if ($tariff_heading!=$ifp['tariff_heading_id']) {
						$tariff_heading = $ifp['tariff_heading_id'];
						$pdf->add_subtitle('Subpartida');

						$pdf->add_row([
							['Descripción', $ifp['tariff_heading'], 85],
							['Unidad', $ifp['tariff_heading_unit'], 15, 'R'],
						]);

						$pdf->add_row([
								['Producto', html_entity_decode($ifp['product']), 25],
								['Tipo', $ifp['product_type'], 10],
								['Embalaje', $ifp['packing'], 10],
								['Pais de origen', $ifp['flag_id'].' - '.$ifp['flag'], 10],
								['Peso bruto', number_format($ifp['gross_weight'], 2), 10, 'R'],
								['Peso neto', number_format($ifp['net_weight'], 2), 10, 'R'],
								['Valor FOB', '$ '.number_format($ifp['fob_value'], 2), 15, 'R'],
								['Cantidad', number_format($ifp['quantity'], 2).' '.$ifp['tariff_heading_unit'], 10, 'R']
							]);
					}else{
						$pdf->add_collapse_row([
							['Producto', html_entity_decode($ifp['product']), 25],
							['Tipo', $ifp['product_type'], 10],
							['Embalaje', $ifp['packing'], 10],
							['Pais de origen', $ifp['flag_id'].' - '.$ifp['flag'], 10],
							['Peso bruto', number_format($ifp['gross_weight'], 2), 10, 'R'],
							['Peso neto', number_format($ifp['net_weight'], 2), 10, 'R'],
							['Valor FOB', '$ '.number_format($ifp['fob_value'], 2), 15, 'R'],
							['Cantidad', number_format($ifp['quantity'], 2).' '.$ifp['tariff_heading_unit'], 10, 'R']
						]);
					}
				}
			}
			$count++;
		}
	}else{
		$count = 1;
		$tariff_heading = 0;

		foreach ($input_forms_products as $ifp)
		{
			if ($count==1) {
				$tariff_heading = $ifp['tariff_heading_id'];
				$pdf->add_subtitle('Subpartida');

				$pdf->add_row([
					['Descripción', $ifp['tariff_heading'], 85],
					['Unidad', $ifp['tariff_heading_unit'], 15, 'R'],
				]);

				$pdf->add_row([
						['Producto', html_entity_decode($ifp['product']), 25],
						['Tipo', $ifp['product_type'], 10],
						['Embalaje', $ifp['packing'], 10],
						['País de Origen', $ifp['flag_id'].' - '.$ifp['flag'], 10],
						['Peso bruto',  number_format($ifp['gross_weight'], 2), 10, 'R'],
						['Peso neto',  number_format($ifp['net_weight'], 2), 10, 'R'],
						['Valor FOB', '$ '.number_format($ifp['fob_value'], 2), 15, 'R'],
						['Cantidad', number_format($ifp['quantity'], 2).' '.$ifp['unit_symbol'], 10, 'R']
					]);
			}else{
				if ($tariff_heading!=$ifp['tariff_heading_id']) {
					$tariff_heading = $ifp['tariff_heading_id'];
					$pdf->add_subtitle('Subpartida');

					$pdf->add_row([
						['Descripción', $ifp['tariff_heading'], 85],
						['Unidad', $ifp['tariff_heading_unit'], 15, 'R'],
					]);

					$pdf->add_row([
							['Producto', html_entity_decode($ifp['product']), 25],
							['Tipo', $ifp['product_type'], 10],
							['Embalaje', $ifp['packing'], 10],
							['Pais de origen', $ifp['flag_id'].' - '.$ifp['flag'], 10],
							['Peso bruto', number_format($ifp['gross_weight'], 2), 10, 'R'],
							['Peso neto', number_format($ifp['net_weight'], 2), 10, 'R'],
							['Valor FOB', '$ '.number_format($ifp['fob_value'], 2), 15, 'R'],
							['Cantidad', number_format($ifp['quantity'], 2).' '.$ifp['unit_symbol'], 10, 'R']
						]);
				}else{
					$pdf->add_collapse_row([
						['Producto', html_entity_decode($ifp['product']), 25],
						['Tipo', $ifp['product_type'], 10],
						['Embalaje', $ifp['packing'], 10],
						['Pais de origen', $ifp['flag_id'].' - '.$ifp['flag'], 10],
						['Peso bruto', number_format($ifp['gross_weight'], 2), 10, 'R'],
						['Peso neto', number_format($ifp['net_weight'], 2), 10, 'R'],
						['Valor FOB', '$ '.number_format($ifp['fob_value'], 2), 15, 'R'],
						['Cantidad', number_format($ifp['quantity'], 2).' '.$ifp['unit_symbol'], 10, 'R']
					]);
				}
			}
			$count++;
		}
	}

	// SOPORTES --------------------------------------------------------
	$pdf->add_title('3. SOPORTES');

	$count = 1;
	foreach ($input_forms_supports as $supp) {
		if ($count == 1) {
			$pdf->add_row([
				['ID', $supp['supp_id'], 10, 'R'],
				['Tipo', $supp['support_type'], 20],
				['Fecha', $supp['created_at'], 20],
				['Detalle', $supp['details'], 50],
			]);
		}else{
			$pdf->add_collapse_row([
				['ID', $supp['supp_id'], 10, 'R'],
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

	// OBSERVACIONES ---------------------------------------------------
	$pdf->add_title('5. OBSERVACIONES');
	$pdf->add_row([
		['Observaciones', $input_form['observations'], 100],
	]);

	// FIRMAS ----------------------------------------------------------
	$pdf->add_row([
		['Firmas', '
		El usuario calificado declara, bajo gravedad de juramento, que toda la información suministrada en este formuario es veraz. Se le autoriza al Ministerio de Comercio Exterior, utilizar la información contenida en este formulario con fines estadísticos.
		', 50, 'C'],
		['Firma del usuario operador', '', 25],
		['Firma del usuario calificado', '', 25],
	]);

	if ($input_form['approved_by_user']!='') {
		$pdf->Image(BASE_URL.'public/resources/users_signs/'.$input_form['approved_by_user'].'.png', $pdf->GetX() + 97, $pdf->GetY() - 18, 36);
		$pdf->Image(BASE_URL.'public/resources/users_signs/'.$input_form['created_by_user'].'.png', $pdf->GetX() + 147, $pdf->GetY() - 18, 36);
	}

	$pdf->Output();
