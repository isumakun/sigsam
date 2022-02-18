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

function upload_to_bucket($posted_file, $folder, $filename){
	
	if ($posted_file['size'] == 0 OR !isset($posted_file) OR !$posted_file)
	{
		\JJ\Flash::instance()->set_message('No se encontró ningún archivo para adjuntar', 'error');
		return FALSE;
	}

	$dir = "/var/www/html/indicator/public/uploads/";
	if($folder!=""){
		$dir = "/var/www/html/indicator/public/uploads/$folder";
		$folder = $folder.'/';
	}

	//echo '<pre>'.print_r($filename, TRUE).'</pre>';

	/* echo '<pre>'.print_r($dir, TRUE).'</pre>';
	echo '<pre>'.print_r($filename, TRUE).'</pre>';
	echo '<pre>'.print_r($posted_file, TRUE).'</pre>';
	echo '<pre>'.print_r("{$dir}{$filename}", TRUE).'</pre>'; */
	
	 /* Verifico si YA existen para eliminarlos */
	$files = glob($dir.$filename);
	if (count($files) > 0)
	{
		foreach ($files AS $file)
		{
			unlink($file);
		}
	}

	if(move_uploaded_file($posted_file['tmp_name'], "{$dir}{$filename}")){
		//echo "ok";
	}
	
	chmod("{$dir}{$filename}", 0777);
	chown("{$dir}{$filename}", "devops");
	exec("chgrp -R devops {$dir}{$filename}");
	
	// Acá hago el PUT
	exec("s3cmd -c /home/dl21hex/.s3cfg put {$dir}{$filename} s3://nx001/indicator/{$folder}{$filename}", $output, $return);

	// Return will return non-zero upon an error
	if (!$return) {
		return TRUE;
	}

	
	//echo '<pre>'.print_r("s3cmd -c /home/dl21hex/.s3cfg put {$dir}{$filename} s3://nx001/indicator/{$folder}{$filename}", TRUE).'</pre>'; 
	
	// Acá debo intentar eliminarlo sin validar nada...
	//exec("s3cmd -c /home/dl21hex/.s3cfg del s3://nx001/{$folder}{$filename}");

	
	unlink("{$dir}{$filename}");

	return FALSE;
}