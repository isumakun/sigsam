<?php defined('UMVC') OR exit('No direct script access allowed');

function checkError($field, $errors, $id=0, $date=0)
{
	if ($id==0) {
		foreach ($errors as $error) {
			if ($field==$error['field_name'])
			{
				if ($error['state_id']==1) {
					if ($date!=0) {
						return 'red';
					}else{
						return 'class="red"';
					}
				}else{
					if ($date!=0) {
						return 'yellow';
					}else{
						return 'class="yellow"';
					}
				}
			}
		}
	}else{
		foreach ($errors as $error) {
			if ($field==$error['field_name'])
			{
				if ($id==$error['field_type_group_id']) {
					if ($error['state_id']==1) {
						if ($date!=0) {
							return 'red';
						}else{
							return 'class="red"';
						}
					}else{
						if ($date!=0) {
							return 'yellow';
						}else{
							return 'class="yellow"';
						}
					}
				}
			}
		}
	}

	return '';
}

function variable_to_name($variable){
	$variables =[
		'packages_quantity' => 'Cantidad de bultos',
		'supplier_id' => 'Proveedor/Cliente',
		'exchange_rate' => 'TRM',
		'transaction_id' => 'Transacción',
		'transport_type_id' => 'Tipo Transporte',
		'refundable' => 'Reembolsable',
		'flag_id_1' => 'País Compra',
		'flag_id_2' => 'País Destino',
		'flag_id_3' => 'País Procedencia',
		'flag_id_4' => 'País Bandera',
		'product_id' => 'Producto',
		'product_category_id' => 'Categoria Producto',
		'tariff_heading_id' => 'Subpartida',
		'commercial_quantity' => 'Cantidad Comercial',
		'physical_unit_id' => 'Unidad Física',
		'quantity' => 'Cantidad',
		'net_weight' => 'Peso Neto',
		'gross_weight' => 'Peso Bruto',
		'packaging_id' => 'Embalaje',
		'unit_value' => 'Valor unitario',
		'fob_value' => 'Valor FOB',
		'freights' => 'Fletes',
		'insurance' => 'Seguro',
		'other_expenses' => 'Otros gastos',
		'flag_id' => 'País Origen',
		'input_form_support_type_id' => 'Tipo Soporte',
		'details' => 'Detalles',
		'support_id' => 'Soporte',

	];

	foreach ($variables as $key => $value) {
		if ($variable == $key) {
			return $value;
		}
	}
}


function esc_commas($value){
	return str_replace(",",".",$value);
}
