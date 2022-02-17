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
				foreach ($output_forms_products as $ofp) 
				{
					?>
					<tr>
						<td>
							<?=$ofp['product']?>
						</td>
						<td>
							<?=$ofp['category']?>
						</td>
						<td>
							<?=$ofp['quantity']?>
						</td>
						<td>
							<?=$ofp['commercial_quantity']?>
						</td>
						<td>
							<?=$ofp['net_weight']?>
							</td>
						<td>
							<?=$ofp['gross_weight']?>
						</td>
						<td>
							<?=$ofp['packages_quantity']?>
						</td>
						<td>
							<?=$ofp['packing']?>
						</td>
						<td>
							<?=$ofp['fob_value']?>
							</td>
						<td>
							<?=$ofp['freights']?>
						</td>
						<td>
							<?=$ofp['insurance']?>
						</td>
						<td>
							<?=$ofp['other_expenses']?>
						</td>
						<td>
							<?=$ofp['flag']?>
						</td>
						<td class="nowrap">
							<?php if ($ofp['is_verified']==0) {
								?>
								<a href="<?=BASE_URL?>tbs/output_forms_products/verify?id=<?=$ofp['ofp_id']?>&form_id=<?=$ofp['output_form_id']?>" class="button check"><span class="icon white checkmark"></span></a>
								<?php
							} ?>
						</td>
					</tr>
					<?php
				} ?>
			</tbody>
		</table>