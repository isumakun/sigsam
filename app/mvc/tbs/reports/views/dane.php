<?php
header("Content-Type: text/plain"); 
header("Content-disposition: attachment; filename=dane.txt"); 
header("Content-Transfer-Encoding: binary"); 
header("Pragma: no-cache"); 
header("Expires: 0");

$content = "";
foreach ($inputs as $inner_inputs) {
	foreach ($inner_inputs as $input) {
		$date=date_create($input['approved_at']);
		$content .= str_pad(date_format($date, 'dmy'), 6);
		$content .= '943';
		$content .= '1';
		$content .= substr($input['transaction_id'], 0, 1);
		$content .= str_pad($input['nit'], 13);
		$content .= '2';
		$content .= str_pad($input['pais_destino'], 3);
		$content .= str_pad($input['pais_origen'], 3);
		$content .= str_pad($input['pais_compra'], 3);
		$content .= str_pad($input['pais_proce'], 3);
		$content .= str_pad($input['transport_type_id'], 2);
		$content .= str_pad($input['bandera'], 3);
		$content .= str_pad($input['transaction_id'], 3);
		$content .= str_pad($input['agreement_id'], 3);
		$content .= str_pad($input['tariff_heading_code'], 10);
		$content .= str_pad($input['tariff_heading_unit'], 3);
		$content .= str_pad(str_replace(',', '', number_format($input['quantity'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['gross_weight'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['net_weight'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['fob_value'], 2)), 15);
		$fob_cop = $input['exchange_rate']*$input['fob_value'];
		$content .= str_pad(str_replace(',', '', number_format($fob_cop, 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['freights'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['insurance'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['other_expenses'], 2)), 15);
		$cif_usd = $input['fob_value'] + $input['freights'] + $input['insurance'] + $input['other_expenses'];
		$content .= str_pad(str_replace(',', '', number_format($cif_usd, 2)), 15);
		$cif_cop = $cif_usd * $input['exchange_rate'];
		$content .= str_pad(str_replace(',', '', number_format($cif_cop, 2)), 17);
		$content .= str_pad(("94331".$input['input_form_id']), 10);
		$content .= str_pad($input['company_name'], 60);
		$content .= "\n";
	}
}

foreach ($outputs as $inner_inputs) {
	foreach ($inner_inputs as $input) {
		$date=date_create($input['approved_at']);
		$content .= str_pad(date_format($date, 'dmy'), 6);
		$content .= '943';
		$content .= '2';
		$content .= substr($input['transaction_id'], 0, 1);
		$content .= str_pad($input['nit'], 13);
		$content .= '2';
		$content .= str_pad($input['pais_destino'], 3);
		$content .= str_pad($input['pais_origen'], 3);
		$content .= str_pad($input['pais_compra'], 3);
		$content .= str_pad($input['pais_proce'], 3);
		$content .= str_pad($input['transport_type_id'], 2);
		$content .= str_pad($input['bandera'], 3);
		$content .= str_pad($input['transaction_id'], 3);
		$content .= str_pad('N/A', 3);
		$content .= str_pad($input['tariff_heading_code'], 10);
		$content .= str_pad($input['tariff_heading_unit'], 3);
		$content .= str_pad(str_replace(',', '', number_format($input['quantity'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['gross_weight'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['net_weight'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['fob_value'], 2)), 15);
		$fob_cop = $input['exchange_rate']*$input['fob_value'];
		$content .= str_pad(str_replace(',', '', number_format($fob_cop, 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['freights'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['insurance'], 2)), 15);
		$content .= str_pad(str_replace(',', '', number_format($input['other_expenses'], 2)), 15);
		$cif_usd = $input['fob_value'] + $input['freights'] + $input['insurance'] + $input['other_expenses'];
		$content .= str_pad(str_replace(',', '', number_format($cif_usd, 2)), 15);
		$cif_cop = $cif_usd * $input['exchange_rate'];
		$content .= str_pad(str_replace(',', '', number_format($cif_cop, 2)), 17);
		$content .= str_pad(("94332".$input['output_form_id']), 10);
		$content .= str_pad($input['company_name'], 60);
		$content .= "\n";
	}
}

echo htmlspecialchars($content);