<h2>Solicitud de Ingreso de Terceros</h2>

<h3>Información general</h3>
<table>
	<th>Creado</th>
	<th>Creado por</th>
	<th>Presentado</th>
	<th>Presentado por</th>
	<th>Aprobado</th>
	<th>Aprobado por</th>
	<th>Rechazado</th>
	<th>Rechazado por</th>
	<th>Estado solicitud</th>
	<th>Estado permiso</th>
	<th></th>
	<th class=""></th>
	<tr>
		<td><?=$request['created_at']?></td>
		<td><?=$request['created_by']?></td>
		<td><?=$request['presented_at']?></td>
		<td><?=$request['presented_by']?></td>
		<td><?=$request['approved_at']?></td>
		<td><?=$request['approved_by']?></td>
		<td><?=$request['rejected_at']?></td>
		<td><?=$request['rejected_by']?></td>
		<td><?=$request['form_state']?></td>
		<td><?php if ($request['form_state_id']!=5) {
			if ($request['approved_at']!='0000-00-00 00:00:00') {
				$approved_date = date($request['approved_by']);

				if ((time()-(60*60*24)) <= strtotime($approved_date)) {
					echo "Abierta";
				}else{
					echo "Cerrada";
				}
			}else{
				echo "Abierta";
			}
		}else{
			echo "Cerrado";
		} ?></td>
		<td class="stretch">
			<?php if ($request['form_state_id']==1 OR $request['form_state_id']==4) {
				echo make_link('tbs/thirdparties_requests/present?id='.$_GET['id'], '<span class="icon open"></span> Presentar', 'button dark create');
			} ?>
			<?php if (has_role(7)) {
				if ($request['form_state_id']==2) {
					if (count($tools)==0) {
						?>
						<?= make_link('tbs/thirdparties_requests/verify?id='.$_GET['id'], '<span class="icon white checkmark"></span> Verificar', 'button create') ?>
						<a href="#reject" class="modal button delete"><span class="icon cancel"></span> Rechazar</a>
						<?php
					}else{
						?>
						<?= make_link('tbs/thirdparties_requests/approve?id='.$_GET['id'], '<span class="icon white checkmark"></span> Aprobar', 'button create') ?>
						<a href="#reject" class="modal button delete"><span class="icon cancel"></span> Rechazar</a>
						<?php
					}
					
				}
			}
			if (has_role(3)) {
				if ($request['form_state_id']==12) {
					?>
					<?= make_link('tbs/thirdparties_requests/approve?id='.$_GET['id'], '<span class="icon white checkmark"></span> Aprobar', 'button create') ?>
					<a href="#reject" class="modal button delete"><span class="icon cancel"></span> Rechazar</a>
					<?php
				}else{
					
				}
			} ?>
		</td>
	</tr>

</table>

<table>
	<th>Empresa</th>
	<th>Persona a Cargo</th>
	<th>Fecha Inicio</th>
	<th>Fecha Fin</th>
	<th>Télefono Contacto</th>
	<th>Acceso</th>
	<th>Tipos Trabajos</th>
	<th>Horario Trabajos</th>
	<th>Observaciones</th>
	<th class="strech"></th>
	<tr>
		<td><?=$request['company']?></td>
		<td><?=$request['person_in_charge']?></td>
		<td><?=$request['schedule_from']?></td>
		<td><?=$request['schedule_to']?></td>
		<td><?=$request['contact_phone']?></td>
		<td><?=$request['access']?></td>
		<td><?php
		$work_types = explode(',', $request['work_types']);
		foreach ($thirdparties_works_types as $work_type) {
			foreach ($work_types as $wt) {
				if ($wt == $work_type['id']) {
					echo '- '.$work_type['name'].'<br>';
				}
			}
		}
		?></td>
		<td><?=$request['working_hours']?></td>
		<td><?=$request['observations']?></td>
		<td>
			<?php if ($request['form_state_id']==1 OR $request['form_state_id']==4) {
				if (has_role(4)) {
				?>
				<?= make_link('tbs/thirdparties_requests/edit?id='.$request['id'], '<span class="icon edit"></span>', 'button edit') ?>
				<?php
				}
			} ?>
		</td>
	</tr>
</table>
<?php $disclaimer = 0; ?>
<h3>Personas</h3>
<table>
	<th>Cedula</th>
	<th>Nombre</th>
	<th>Categoría</th>
	<th>Placa Vehículo</th>
	<th>ARL</th>
	<th>EPS</th>
	<th>Fecha límite cobertura ARL</th>
	<th class="stretch">
		<?php if ($request['form_state_id']==1 OR $request['form_state_id']==4) {
			
			?>
			<?= make_link('tbs/thirdparties_workers/create?id='.$request['id'], '<span class="icon create"></span>', 'button dark') ?>
			<?php
			
		} ?>
	</th>
	<tbody>
		<?php foreach ($workers as $worker) {
			if ($worker['work_type_id'] != 5) {
				$disclaimer = 1;
			}

			$class = '';

			if ($worker['limit_date']!='0000-00-00') {
				$date1 = new DateTime($worker['limit_date']);
				$date2 = new DateTime($request['schedule_to']);
				
				if ($date1<$date2) {
					$class = 'style="background: #fc2828; color: white"';
				}
			}else{
				if ($worker['category_id']!=1) {
					$class = 'style="background: #fc2828; color: white"';
				}
			}
			
			?>
			<tr <?=$class?>>
				<td><?=$worker['citizen_id']?></td>
				<td><?=$worker['employee']?></td>
				<td><?=$worker['category']?></td>
				<td><?=$worker['vehicle_plate']?></td>
				<td><?=$worker['arl']?></td>
				<td><?=$worker['eps']?></td>
				<td><?php
					if ($worker['limit_date']!='0000-00-00') {
						echo $worker['limit_date'];
						if ($request['form_state_id']==2) {
						?>
						<a href="#limit_date" data-id="<?=$worker['id']?>" class="modal button limit_date_button"><span class="icon white edit"></span></a>
						<?php
						}
					}else{
						if ($request['form_state_id']==2) {
						?>
						<a href="#limit_date" data-id="<?=$worker['id']?>" class="modal button dark limit_date_button">Ingresar fecha límite</a>
						<?php
						}
					}
				?></td>
				<td class="nowrap">
					<?php if ($request['form_state_id']==1 OR $request['form_state_id']==4) {
						if (has_role(4)) {
							?>
							<?= make_link('tbs/thirdparties_workers/edit?id='.$worker['id'], '<span class="icon edit"></span>', 'button edit') ?>
							<?= make_link('tbs/thirdparties_workers/delete?id='.$worker['id'], '<span class="icon delete"></span>', 'button delete') ?>
							<?php
						}
					} ?>
				</td>
			</tr>
			<?php
		} ?>
	</tbody>
</table>

<h3>Materiales, Herramientas y Equipos</h3>
<table>
	<th>Detalle</th>
	<th>Cantidad</th>
	<th>Unidad</th>
	<th>Fecha de creación</th>
	<th>Ingresó?</th>
	<th class="stretch">
		<?php if ($request['form_state_id']==1 OR $request['form_state_id']==4) {
			?>
			<?= make_link('tbs/thirdparties_requests_tools/create?id='.$request['id'], '<span class="icon create"></span>', 'button dark') ?>
			<?php
		} ?>

		<?php if (has_role(1)) {
			?>
			<?= make_link('tbs/thirdparties_requests_tools/create?id='.$request['id'], '<span class="icon create"></span>', 'button dark') ?>
			<?php
		} ?>
	</th>
	<tbody>
		<?php foreach ($tools as $tool) {
			?>
			<tr>
				<td><?=$tool['tool']?></td>
				<td><?=$tool['quantity']?></td>
				<td><?=$tool['unit']?></td>
				<td><?=$tool['created_at']?></td>
				<td><?php if ($tool['entry']!='0000-00-00 00:00:00') {
					echo "Si [{$tool['entry']}]";
				}else{
					echo "No";
				}?></td>
				<td class="nowrap">
					<?php if ($tool['entry']=='0000-00-00 00:00:00') {
						?>
						<?= make_link('tbs/thirdparties_requests_tools/edit?id='.$tool['id'], '<span class="icon edit"></span>', 'button edit') ?>
						<?php
					} ?>
					<?php if ($request['form_state_id']==1 OR $request['form_state_id']==4) {
						if (has_role(4)) {
						?>
						<?= make_link('tbs/thirdparties_requests_tools/delete?id='.$tool['id'], '<span class="icon delete"></span>', 'button delete') ?>
						<?php
						}
					} ?>
				</td>
			</tr>
			<?php
		} ?>
	</tbody>
</table>

<h3>Soportes</h3>
<?php 
if ($disclaimer==1) {
	?>
	<p><b>Nota:</b> Las actividades diferentes a trabajos de bajo riesgo requieren la presentación de certificados de idoneidad</p>
	<?php
} ?>
<table>
	<th>Detalle</th>
	<th>Fecha</th>
	<th>Archivo</th>
	<th class="stretch">
		<?php if ($request['form_state_id']==1 OR $request['form_state_id']==4) {
			?>
			<?= make_link('tbs/thirdparties_supports/create?id='.$request['id'], '<span class="icon create"></span>', 'button dark') ?>
			<?php
		} ?>
	</th>
	<tbody>
		<?php foreach ($supports as $support) {
			?>
			<tr>
				<td><?=$support['details']?></td>
				<td><?=$support['created_at']?></td>
				<td><a href="<?=BASE_URL."public/uploads/supports/thirdparty/{$_SESSION['user']['company_schema']}{$_GET['id']}/{$support['id']}.{$support['file_extension']}"?>" class="button" target="_blank"> Ver adjunto</a></td>
				<td class="nowrap">
					<?php if ($request['form_state_id']==1 OR $request['form_state_id']==4) {
						if (has_role(4)) {
						?>
						<?= make_link('tbs/thirdparties_supports/delete?id='.$support['id'], '<span class="icon delete"></span>', 'button delete') ?>
						<?php
						}
					} ?>
				</td>
			</tr>
			<?php
		} ?>
	</tbody>
</table>

<div id="reject" class="modal">
	<form method="POST" action="reject">
		<h3>Rechazo</h3>
		<label>Por favor ingrese las razones del rechazo:</label>
		<textarea name="observations"></textarea>
		<input type="hidden" name="form_id" value="<?=$_GET['id']?>">
		<input type="submit" value="Enviar">
	</form>
</div>

<?php 
		$calendar = new Calendar();
		?>

<div id="limit_date" class="modal">
	<form method="POST" action="../thirdparties_workers/update_limit_date">
		<label>Fecha límite trabajador:</label>
		<?= $calendar->render('limit_date');?>
		<br><br>
		<input type="hidden" name="worker_id" id="worker_id">
		<input type="submit" value="Enviar">
	</form>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('.limit_date_button').on('click', function(){
			$('#worker_id').val($(this).attr('data-id'));
		})
	})
</script>