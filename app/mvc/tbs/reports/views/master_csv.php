<?php
header('Content-disposition: attachment; filename=master.xls');
header('Content-Type: application/vnd.ms-excel');

/*
	FECHA INICIO	APRONADO
	FECHA FIN		EXECUTED o NO EXCUTADO
*/

echo "Num.	Num. interfaz	Producto	Tipo	Categoria	Unidad	Virtual	Virtual reservado	Bloqueado	Inspeccionado	Almacen	Reservado	Aprobado	Inspeccionado salida	Reservado salida	Despachado	Desperdicio	Nacionalizado	Diferencia bascula	Proveedor*	Formulario	Transaccion*	Tipo de transporte	Cantidad de bultos	Subpartida	Cantidad	Cantidad comercial	Valor unitario	FOB	Peso neto	Peso bruto	Embalaje	Fletes	Seguros	Otros gastos	Origen	Compra	Destino	Procedencia	Bandera	Creado	Presentado	Aprobado	Ejecutado\n";

foreach($results AS $r)
{
	echo "{$r['warehouse_id']}	{$r['interface_code']}	{$r['product']}	{$r['product_type']}	{$r['product_category']}	{$r['physical_unit']}	{$r['virtual']}	{$r['virtual_reserved']}	{$r['locked']}	{$r['inspected_to_input']}	{$r['stock']}	{$r['reserved']}	{$r['approved']}	{$r['inspected_to_output']}	{$r['reserved_to_output']}	{$r['dispatched']}	{$r['waste']}	{$r['nationalized']}	{$r['scale_difference']}	{$r['supplier_id']}	{$r['form_id']}	{$r['transaction_id']}	{$r['transport_type_id']}	{$r['packages_quantity']}	{$r['tariff_heading_id']}	{$r['quantity']}	{$r['commercial_quantity']}	{$r['unit_value']}	{$r['fob_value']}	{$r['net_weight']}	{$r['gross_weight']}	{$r['packaging_id']}	{$r['freights']}	{$r['insurance']}	{$r['other_expenses']}	{$r['flag_id']}	{$r['flag_id_1']}	{$r['flag_id_2']}	{$r['flag_id_3']}	{$r['flag_id_4']}	{$r['created_at']}	{$r['presented_at']}	{$r['approved_at']}	{$r['executed_at']}\n";
}
