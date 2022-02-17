<h2>Bot (scaffolding)</h2>

<form method="POST">

	<label>Tabla</label><br>
	<select name="table_name">
		<option></option>
<?php
		foreach($tables AS $table)
		{
?>
			<option><?=$table['TABLE_NAME']?></option>
<?php
		}
?>
	</select>

	<input type="submit" value="Generar MVC"/>

</form>

<?php
	if ($templates)
	{
?>
		<h3>Resultados</h3>

		<a href="#controller_template" class="button modal purple">Controlador</a>

		<a href="#model_template" class="button modal green">Modelo</a>

		<a href="#view_index_template" class="button modal orange">Vista > index</a>
		<a href="#view_create_template" class="button modal orange">Vista > create</a>
		<a href="#view_edit_template" class="button modal orange">Vista > edit</a>
		<a href="#view_delete_template" class="button modal orange">Vista > delete</a>

		<style>
			code {
				font-size: 0.9em;
			}
		</style>

		<div id="controller_template" class="modala">
			<h3>Controller</h3>
			<code>
				<pre>
					<?=$templates['controller']?>
				</pre>
			</code>
		</div>

		<div id="model_template" class="modal">
			<h3>Model</h3>
			<code>
				<pre>
					<?=$templates['model']?>
				</pre>
			</code>
		</div>

		<div id="view_index_template" class="modal">
			<h3>View > index</h3>
			<code>
				<pre>
					<?=$templates['views']['index']?>
				</pre>
			</code>
		</div>

		<div id="view_create_template" class="modal">
			<h3>View > create</h3>
			<code>
				<pre>
					<?=$templates['views']['create']?>
				</pre>
			</code>
		</div>

		<div id="view_edit_template" class="modal">
			<h3>View > edit</h3>
			<code>
				<pre>
					<?=$templates['views']['edit']?>
				</pre>
			</code>
		</div>

		<div id="view_delete_template" class="modal">
			<h3>View > delete</h3>
			<code>
				<pre>
					<?=$templates['views']['delete']?>
				</pre>
			</code>
		</div>
<?php
	}
?>
