<?php 
$calendar = new Calendar();
?>
	<h2>Editar Registro</h2>
	<form method="POST" enctype="multipart/form-data">
		
		<label for="request_id">Request:</label>
		<select disabled name="request_id">
<?php
				foreach($thirdparties_requests AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($thirdparty_output['request_id'] == $t['id'] ? 'selected' : '')?>><?=$t['company_id']?></option>
<?php
				}
?>
		</select>

		<label for="company_id">Company:</label>
		<select disabled name="company_id">
<?php
				foreach($thirdparties_companies AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($thirdparty_output['company_id'] == $t['id'] ? 'selected' : '')?>><?=$t['nit']?></option>
<?php
				}
?>
		</select>

		<label for="employee_id">Employee:</label>
		<select disabled name="employee_id">
<?php
				foreach($thirdparties_employees AS $t)
				{
?>
			<option value="<?=$t['id']?>" <?=($thirdparty_output['employee_id'] == $t['id'] ? 'selected' : '')?>><?=$t['citizen_id']?></option>
<?php
				}
?>
		</select>

		<label for="vehicle_plate">Vehicle_plate:</label>
		<input disabled name="vehicle_plate" value="<?=$thirdparty_output['vehicle_plate']?>" type="text"/>

		<label for="created_by">Created_by:</label>
		<input disabled name="created_by" value="<?=$thirdparty_output['created_by']?>" type="text"/>

	</form>