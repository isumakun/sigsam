<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

	private $i;

	private $table_fields;

	private $_validations_rules;

	private $_form_rows;
	private $_table_heading;
	private $_table_rows;

	private $_form_set_values;

	private $_inner_join_maker;

	private $information_schema;

	private $_alias_table_name;

	private $_inputs_posts;
	private $_create_params;
	private $_update_params;
	private $_create_values;
	private $_create_fields;
	private $_set_values;
	private $_update_set_values;

	public $file_name;
	public $table_name;
	public $alias_table_name;
	public $class_name;

	public $upper_class_name;
	public $model_name;
	public $class_singular_name;
	public $fields_table;

	public $subfolder;
	public $capital_subfolder;
	public $subfolder_without_slash;

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['tables'] = $this->model('umvc/bot')->get_tables();

		if ($_POST)
		{
			$this->make_mvc_crud($_POST['table_name']);

			$data['templates']['controller'] 	= $this->make_controller();
			$data['templates']['model'] 		= $this->make_model();
			$data['templates']['views']			= $this->make_views();

			if ($data['templates']['controller'] AND $data['templates']['model'])
			{
				set_notification('CRUD generado correctamente');
			}
			else
			{
				set_notification('Ocurrió un error al generar el CRUD', 'error');
			}
		}

		$this->view('Inicio', $data);
	}


/*------------------------------------------------------------------------------
    GET TABLES
------------------------------------------------------------------------------*/
	public function get_tables()
	{
		return $this->model('umvc/bot')->get_tables();
	}

/*------------------------------------------------------------------------------
    GET COLUMNS
------------------------------------------------------------------------------*/
	public function get_columns($table_name)
	{
		return $this->model('umvc/bot')->get_columns($table_name);
	}

/*------------------------------------------------------------------------------
    GET REFERENCED TABLE
------------------------------------------------------------------------------*/
	public function get_referenced_table($table_name, $column_name)
	{
		return $this->model('umvc/bot')->get_referenced_table($table_name, $column_name);
	}

/*------------------------------------------------------------------------------
    MAKE MVC CRUD
------------------------------------------------------------------------------*/
	public function make_mvc_crud($table_name)
	{
		$class_name = $table_name;
		$class_singular_name = $table_name;

		$this->i = 1;

		$this->table_name			= $table_name;
		$this->alias_table_name		= $this->alias_table_name($table_name);

		$table_prefix = explode('_', $table_name);
		$table_prefix = $table_prefix[0];

		$this->subfolder				= '';
		$this->subfolder_without_slash	= '';

		$subfolder						= explode('_', $table_name);
		$this->subfolder				= "{$subfolder[0]}/";
		$this->subfolder_without_slash	= "{$subfolder[0]}";
		$this->capital_subfolder		= ucwords($subfolder[0]);

		// Class names (plural) variants
		$this->class_name					= strtolower($class_name);
		$this->upper_class_name				= strtoupper($class_name);
		$this->capital_class_name			= ucfirst($class_name);

		// Class singular name variants
		$this->class_singular_name						= $class_singular_name;
		$this->upper_class_singular_name				= strtoupper($class_singular_name);
		$this->capital_class_singular_name				= ucfirst($class_singular_name);

		$this->model_name	= $this->class_name.'_model';

		$this->fields_table	= $this->get_columns($table_name);
		$this->table_fields	= $this->get_columns($table_name);

		// Fill the FULL "Table Fields" array
		$i = 0;
		foreach ($this->table_fields AS $tf)
		{
			$this->table_fields[$i]['name'] 							= $tf['COLUMN_NAME'];
			$this->table_fields[$i]['type'] 							= $tf['DATA_TYPE'];
			$this->table_fields[$i]['max_length'] 						= $tf['NUMERIC_PRECISION'];
			$this->table_fields[$i]['referenced_table_name'] 			= FALSE;
			$this->table_fields[$i]['aliased_referenced_table_name'] 	= FALSE;
			$this->table_fields[$i]['referenced_column_name'] 			= FALSE;
			$this->table_fields[$i]['referenced_column_used'] 			= FALSE;
			$this->table_fields[$i]['aliased_referenced_column_used'] 	= FALSE;
			$this->table_fields[$i]['referenced_model_name']		 	= FALSE;

			if ($referenced_table_field = $this->get_referenced_table($table_name, $tf['COLUMN_NAME']))
			{
				$this->table_fields[$i]['referenced_table_name'] 			= $referenced_table_field['referenced_table_name'];
				$this->table_fields[$i]['aliased_referenced_table_name'] 	= $this->alias_table_name($referenced_table_field['referenced_table_name']);
				$this->table_fields[$i]['referenced_column_name'] 			= $referenced_table_field['referenced_column_name'];

				$referenced_table_fields = $this->get_columns($referenced_table_field['referenced_table_name']);

				$this->table_fields[$i]['referenced_column_used'] 			= $referenced_table_fields[1]['COLUMN_NAME'];
				$this->table_fields[$i]['aliased_referenced_column_used'] 	= rtrim($tf['COLUMN_NAME'], '_id');

				$referenced_model_name_prefix = explode('_', $referenced_table_field['referenced_table_name']);
				$this->table_fields[$i]['prefix_referenced_model_name']	= $referenced_model_name_prefix[0];
				$this->table_fields[$i]['referenced_model_name']		 	= substr($referenced_table_field['referenced_table_name'], (strlen($referenced_table_field['referenced_table_name']) - strlen($referenced_model_name_prefix[0].'_')) * -1);
			}

			$i++;
		}

		return TRUE;
	}

/*------------------------------------------------------------------------------
    MAKE CONTROLLER
------------------------------------------------------------------------------*/
	function make_controller()
	{
		$referenced_models_get_all_method = "\n";

		foreach ($this->table_fields as $tf)
		{
			if ($tf['name'] != 'id')
			{
				$prefix_referenced_capital_model_name = $tf['prefix_referenced_model_name'];
				$referenced_capital_model_name = $tf['referenced_model_name'];

				if ($tf['referenced_table_name'])
				{
					$referenced_models_get_all_method .= "\t\t\$data['{$tf['referenced_model_name']}'] = \$this->model('{$prefix_referenced_capital_model_name}_{$referenced_capital_model_name}')->get_all();\n";
				}
			}
		}

		$redirect = "/{$this->subfolder}{$this->class_name}";

		return <<<CODE

<&#63php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		\$data['{$this->table_name}'] = \$this->model('{$this->subfolder}/{$this->table_name}')->get_all();
		\$this->view('Inicio', \$data);
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if (\$_POST)
		{
			if (\$this->model('{$this->table_name}')->create(\$_POST))
			{
				redirect('{$redirect}', 'Registro creado satisfactoriamente');
			}
			else
			{
				set_notification("El registro no pudo ser creado", 'error');
			}
		}
		{$referenced_models_get_all_method}
		\$this->view('Nuevo', \$data);
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		if (\$_POST)
		{
			if (\$this->model('{$this->table_name}')->update_by_id(\$_POST))
			{
				redirect('{$redirect}', 'Registro actualizado satisfactoriamente');
			}
			else
			{
				set_notification('No se pudo editar el registro', 'error');
			}
		}
		{$referenced_models_get_all_method}
		\$this->view('Editar', \$data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if (\$this->model('{$this->table_name}')->delete_by_id(global_get('id')))
		{
			set_notification('Registro eliminado');
		}
		else
		{
			set_notification('Ocurrió un error al intentar eliminar el producto', 'error');
		}

		redirect('{$redirect}');
	}
}
CODE;

	}

	function _make_controller()
	{
		return <<<CODE

<&#63php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$this->view('Inicio');
	}
}
CODE;

/*
		$controller_template = APPPATH."/thirdparty/jjbot/templates/classes/controller.php";
		include_once($controller_template);
		$data = ':)';

		$path = APPPATH."/mvc/bot_test/test";

		if (!file_exists($path))
		{
			mkdir($path, 0655, TRUE);
		}

		$file = "{$path}/Controller.php";

		if (!file_exists($file) OR $this->force_overwrite == 1)
		{
			$controller_file = fopen($file, "w");
			fwrite($controller_file, $data);
			return fclose($controller_file);
		}

		return FALSE;
*/
	}

/*------------------------------------------------------------------------------
    MAKE MODEL
------------------------------------------------------------------------------*/
	function make_model()
	{
		return <<<CODE

<&#63php

namespace TABLE_NAME;

class Model extends \ModelBase {

/*----------------------------------------------------------------------
	GET ALL
 ---------------------------------------------------------------------*/
	public function get_all()
	{
		return \$this->db->query("

			-- QUERY HERE

		")->fetchAll();
	}
}

CODE;

		$model_template = APPPATH."/thirdparty/jjbot/templates/classes/model.php";

		include_once($model_template);

		$file = APPPATH."/mvc/models/{$this->class_name}.php";

		if ($this->subfolder != '')
		{
			$path = APPPATH."/mvc/models/modules/{$this->subfolder}";
			if (!file_exists($path)) mkdir($path, 0655, TRUE);

			$file = "{$path}/{$this->class_name}.php";
		}

		if (!file_exists($file) OR $this->force_overwrite == 1)
		{
			$model_file = fopen($file, "w");
			fwrite($model_file, $data);
			return fclose($model_file);
		}

		return FALSE;
	}

/*------------------------------------------------------------------------------
    MAKE VIEWS
------------------------------------------------------------------------------*/
	function make_views()
	{
		$views['index']		= 'Index...';
		$views['create']	= 'Create...';
		$views['edit']		= 'Edit...';
		$views['delete']	= 'Delete...';

		return $views;


		$views_template = APPPATH."/thirdparty/jjbot/templates/views";

		$views_templates = array(

			'index'		=>	"{$views_template}/index.php",
			'view'		=>	"{$views_template}/view.php",
			'create'	=>	"{$views_template}/create.php",
			'edit'		=>	"{$views_template}/edit.php"

		);

		$file = APPPATH."/mvc/views/{$this->class_name}.php";

		if ($this->subfolder != '')
		{
			$path = APPPATH."/mvc/views/modules/{$this->subfolder}";
			if (!file_exists($path)) mkdir($path, 0655, TRUE);

			$file = "{$path}/{$this->class_name}";
		}
		else
		{
			$path = APPPATH."/mvc/views/{$this->subfolder}";
			if (!file_exists($path)) mkdir($path, 0655, TRUE);

			$file = "{$path}/{$this->class_name}";
		}


		if (!file_exists($file) OR $this->force_overwrite == 1)
		{
			if (!file_exists($file)) mkdir($file, 0777, TRUE);

			foreach ($views_templates as $view_name => $template_path)
			{
				$data = '';
				include_once($template_path);

				$view_file = fopen("{$file}/{$view_name}.php", "w");
				fwrite($view_file, $data);
				fclose($view_file);
			}

			return TRUE;
		}

		return FALSE;
	}

/*------------------------------------------------------------------------------
    ALIAS TABLE NAME
------------------------------------------------------------------------------*/
	public function alias_table_name($table_name)
	{
		$table_name = explode('_', $table_name);
		$alias = '';

		foreach (array_slice($table_name, 1) as $tn)
		{
			$alias .= $tn[0];
		}

		// Verifico si es único
		if ($this->alias_table_name == $alias)
		{
			$alias .= $this->i++;
			return $alias;
		}

		if (count($this->table_fields) > 0) foreach ($this->table_fields AS $tf)
		{
			if ($tf['aliased_referenced_table_name'] == $alias)
			{
				$alias .= $this->i++;
				return $alias;
			}
		}

		return $alias;
	}


/*------------------------------------------------------------------------------
    FIELD TYPE
------------------------------------------------------------------------------*/
	public function rule_by_field($field_type, $field_max_length)
	{
		switch ($field_type)
		{
			// NUMBERS (INTEGER)
			case 'tinyint':
			case 'smallint':
			case 'mediumint':
			case 'integer':
			case 'bigint':
			case 'int':		$rule_by_field = "required|integer|max_length[{$field_max_length}]"; break;

			// NUMBERS (DECIMAL)
			case 'decimal':
			case 'double':
			case 'float':	$rule_by_field = "required|decimal|max_length[{$field_max_length}]"; break;

			// DEFAULT
			default:		$rule_by_field = "required"; break;
		}

		return $rule_by_field;
	}


/*------------------------------------------------------------------------------
    FORM ROWS
------------------------------------------------------------------------------*/
	public function _form_rows()
	{
		$data = '';
		foreach ($this->fields_table as $ft)
		{
			if ($ft->name != 'id')
			{
				$data .= "\n\t\t\t<label for=\"$ft->name\">$ft->name:</label>\n\t\t\t<input name=\"$ft->name\" value=\"<?=\${$this->class_singular_name}->$ft->name?>\" type=\"text\"/>\n";
			}
		}

		return $data;
	}

/*------------------------------------------------------------------------------
    FORM SET VALUES
------------------------------------------------------------------------------*/
	public function _form_set_values()
	{
		$data = '';
		foreach ($this->fields_table as $ft)
		{
			if ($ft->name != 'id')
			{
				$data .= "\n\t\t\t<label for=\"$ft->name\">$ft->name:</label>\n\t\t\t<input name=\"$ft->name\" value=\"<?=set_value('{$ft->name}')?>\" type=\"text\"/>\n";
			}
		}

		return $data;
	}

/*------------------------------------------------------------------------------
    VALIDATIONS RULES
------------------------------------------------------------------------------*/
	public function _validations_rules()
	{
		$data = '';
		foreach ($this->fields_table as $ft)
		{
			if ($ft['COLUMN_NAME'] != 'id')
			{
				$_validations_rules .= 'validation'; //"\n\t\t\t\$this->form_validation->set_rules("{$ft['COLUMN_NAME']}", "{$ft['COLUMN_NAME']}", "{\$this->rule_by_field($ft['DATA_TYPE']}, {$ft['NUMERIC_PRECISION']}");";
			}
		}

		return $data;
	}

/*------------------------------------------------------------------------------
    CREATE PARAMS
------------------------------------------------------------------------------*/
	public function _create_params()
	{
		$data = '';
		foreach ($this->fields_table as $ft)
		{
			if ($ft['COLUMN_NAME'] != 'id')
			{
				if ($ft['COLUMN_NAME'] == 'create_date' AND $ft['DATA_TYPE'] == 'datetime')
				{
					$data .= "\${$ft['COLUMN_NAME']}, ";
				}
				else if ($ft['COLUMN_NAME'] == 'update_date' AND $ft['DATA_TYPE'] == 'datetime')
				{

				}
				else
				{
					$data .= "\${$ft['COLUMN_NAME']}, ";
				}
			}
		}

		$data = substr($data, 0, strlen($data)-2);
		return $data;
	}

/*------------------------------------------------------------------------------
    CREATE FIELDS
------------------------------------------------------------------------------*/
	public function _create_fields()
	{
		$data = '';
		foreach ($this->fields_table as $ft)
		{
			if ($ft['COLUMN_NAME'] != 'id')
			{
				if ($ft['COLUMN_NAME'] == 'create_date' AND $ft['DATA_TYPE'] == 'datetime')
				{
					$data .= "`{$ft['COLUMN_NAME']}`, ";
				}
				else if ($ft['COLUMN_NAME'] == 'update_date' AND $ft['DATA_TYPE'] == 'datetime')
				{

				}
				else
				{
					$data .= "`{$ft['COLUMN_NAME']}`, ";
				}
			}
		}

		$data = substr($data, 0, strlen($data)-2);
		return $data;
	}

/*------------------------------------------------------------------------------
    CREATE VALUES
------------------------------------------------------------------------------*/
	public function _create_values()
	{
		$data = '';
		foreach ($this->fields_table as $ft)
		{
			if ($ft['COLUMN_NAME'] != 'id')
			{
				if ($ft['COLUMN_NAME'] == 'create_date' AND $ft['DATA_TYPE'] == 'datetime')
				{
					$data .= "'\${$ft['COLUMN_NAME']}', ";
				}
				else if ($ft['COLUMN_NAME'] == 'update_date' AND $ft['DATA_TYPE'] == 'datetime')
				{

				}
				else
				{
					$data .= "'\${$ft['COLUMN_NAME']}', ";
				}
			}
		}

		$data = substr($data, 0, strlen($data)-2);
		return $data;
	}

/*------------------------------------------------------------------------------
    SET VALUES
------------------------------------------------------------------------------*/
	public function _set_values()
	{
		$data = '';
		foreach ($this->fields_table as $ft)
		{
			if ($ft['COLUMN_NAME'] != 'id')
			{
				if ($ft['COLUMN_NAME'] == 'create_date' AND $ft['DATA_TYPE'] == 'datetime')
				{
					$data .= "`{$ft['COLUMN_NAME']}` = '\${$ft['COLUMN_NAME']}',\n\t\t\t\t\t\t";
				}
				else if ($ft['COLUMN_NAME'] == 'update_date' AND $ft['DATA_TYPE'] == 'datetime')
				{

				}
				else
				{
					$data .= "`{$ft['COLUMN_NAME']}` = '\${$ft['COLUMN_NAME']}',\n\t\t\t\t\t\t";
				}
			}
		}

		$data = substr($data, 0, strlen($data)-8);
		return $data;
	}

/*------------------------------------------------------------------------------
    SET VALUES
------------------------------------------------------------------------------*/
	public function _update_set_values()
	{
		$data = '';
		foreach ($this->fields_table as $ft)
		{
			if ($ft['COLUMN_NAME'] != 'id')
			{
				if ($ft['COLUMN_NAME'] == 'create_date' AND $ft['DATA_TYPE'] == 'datetime')
				{

				}
				else if ($ft['COLUMN_NAME'] == 'update_date' AND $ft['DATA_TYPE'] == 'datetime')
				{
					$data .= "`{$ft['COLUMN_NAME']}` = '\${$ft['COLUMN_NAME']}',\n\t\t\t\t\t\t";
				}
				else
				{
					$data .= "`{$ft['COLUMN_NAME']}` = '\${$ft['COLUMN_NAME']}',\n\t\t\t\t\t\t";
				}
			}
		}

		$data = substr($data, 0, strlen($data)-8);
		return $data;
	}

/*------------------------------------------------------------------------------
    UPDATE PARAMS
------------------------------------------------------------------------------*/
	public function _update_params()
	{
		$data = '';
		foreach ($this->fields_table as $ft)
		{
			if ($ft['COLUMN_NAME'] == 'create_date' AND $ft['DATA_TYPE'] == 'datetime')
			{

			}
			else if ($ft['COLUMN_NAME'] == 'update_date' AND $ft['DATA_TYPE'] == 'datetime')
			{
				$data .= "\${$ft['COLUMN_NAME']}, ";
			}
			else
			{
				$data .= "\${$ft['COLUMN_NAME']}, ";
			}
		}

		$data = substr($data, 0, strlen($data)-2);
		return $data;
	}

/*------------------------------------------------------------------------------
    INPUTS POSTS
------------------------------------------------------------------------------*/
	public function _inputs_posts()
	{
		$data = "";

		// INPUT POST
		foreach ($this->fields_table as $ft)
		{
			if ($ft->name != 'id')
			{
				$data .= "\${$ft['COLUMN_NAME']} = \$this->input->post('{$ft['COLUMN_NAME']}');\n\t\t\t\t";
			}
		}

		return $data;
	}


}
