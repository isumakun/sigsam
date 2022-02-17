<h2>Productos a Inspeccionar</h2>
		<table>
			<thead>
					<th>Producto</th>
					<th>Categoria</th>
					<th>Cantidad</th>
					<th>Cantidad Comercial</th>
					<th>Peso Neto</th>
					<th>Peso Bruto</th>
					<th>Cantidad Bultos</th>
					<th>Embalaje</th>
					<th>Valor FOB</th>
					<th>Fletes</th>
					<th>Seguros</th>
					<th>Otros Gastos</th>
					<th>Bandera O.</th>
					<th class="stretch"></th>
			</thead>
			<tbody>
				<?php 
				foreach ($input_forms_products as $ifp) 
				{
					?>
					<tr>
						<td>
							<?=$ifp['product']?>
						</td>
						<td>
							<?=$ifp['category']?>
						</td>
						<td>
							<?=$ifp['quantity']?>
						</td>
						<td>
							<?=$ifp['commercial_quantity']?>
						</td>
						<td>
							<?=$ifp['net_weight']?>
							</td>
						<td>
							<?=$ifp['gross_weight']?>
						</td>
						<td>
							<?=$ifp['packages_quantity']?>
						</td>
						<td>
							<?=$ifp['packing']?>
						</td>
						<td>
							<?=$ifp['fob_value']?>
							</td>
						<td>
							<?=$ifp['freights']?>
						</td>
						<td>
							<?=$ifp['insurance']?>
						</td>
						<td>
							<?=$ifp['other_expenses']?>
						</td>
						<td>
							<?=$ifp['flag']?>
						</td>
						<td class="nowrap">
							<?php if ($ifp['is_verified']==0) {
								?>
								<a href="<?=BASE_URL?>tbs/input_forms_products/verify?id=<?=$ifp['ifp_id']?>&form_id=<?=$ifp['input_form_id']?>" class="button check"><span class="icon white checkmark"></span></a>
								<?php
							} ?>
						</td>
					</tr>
					<?php
				} ?>
			</tbody>
		</table>