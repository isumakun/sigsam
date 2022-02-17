<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			$_POST['form_id'] = $_GET['form_id'];

			$extension = '';
			if ($_FILES)
		    {
		        if($_FILES['file_upload']['size'] > 500000)
		            {
		                redirect_back('El archivo excede la capacidad máxima permitida (50 mb)', 'error');
		            }

		        $extension = explode('.', $_FILES['support']['name']);
		        $extension = end($extension);
		        $_POST['file_extension'] = $extension;
		    }

			if ($id = $this->model('tbs/transport_output_forms_supports')->create($_POST)) 
			{
				if ($_FILES)
		        {
		        	$folder_name = $_SESSION['user']['company_schema'].$_GET['form_id'];
					$dir = "public/uploads/supports/transport_output/$folder_name";
		            mkdir($dir, 0777);

		            $file_name = $id.'.'.$extension;
		            move_uploaded_file($_FILES['support']['tmp_name'], $dir.'/'.$file_name);
		        }

				redirect("tbs/transport_output_forms/details?id={$_GET['form_id']}");
			}
			else
			{
				set_notification('No se pudo crear el registro', 'error');
			}
		}

		$data['output_forms_supports_types'] = $this->model('tbs/output_forms_supports_types')->get_all();

		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['transport_output_form_support'] = $this->model('tbs/transport_output_forms_supports')->get_by_id($_GET['id']);
		$data['transport_output_forms_verify'] = $this->model('tbs/transport_output_forms_verify')->get_by_form_id($_GET['form_id']);
		
		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			$_POST['output_form_id'] = $_GET['form_id'];
			
			$support = $data['support'];

			$extension = $data['transport_output_form_support']['file_extension'];
			
			if ($_FILES)
		    {
		        if($_FILES['file_upload']['size'] > 500000)
		            {
		                redirect_back('El archivo excede la capacidad máxima permitida (50 mb)', 'error');
		            }

		        $extension = explode('.', $_FILES['support']['name']);
		        $extension = end($extension);
		    }

		    $_POST['file_extension'] = $extension;

			if ($this->model('tbs/transport_output_forms_supports')->edit($_POST)) 
			{
				if (count($data['transport_output_forms_verify'])!=0) {
					for ($i=0; $i < count($_POST['field_names']); $i++) {
						$this->model('tbs/transport_output_forms_verify')->create($_GET['form_id'], 3, $_GET['id'], $_POST['field_names'][$i]);
					}
				}

				if ($_FILES)
		        {
		        	$dir = "public/uploads/supports/transport_output/{$_GET['form_id']}";

					unlink("public/uploads/supports/transport_output/{$_GET['form_id']}/{$_GET['id']}.{$support['file_extension']}");

		            $file_name = $_GET['id'].'.'.$extension;
		            move_uploaded_file($_FILES['support']['tmp_name'], $dir.'/'.$file_name);
		        }
				
				redirect("tbs/transport_output_forms/verify?id={$_GET['form_id']}");
			}
			else
			{
				set_notification('No se pudo editar el registro', 'error');
			}
		}

		$data['output_forms_supports_types'] = $this->model('tbs/output_forms_supports_types')->get_all();

		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	DELETE
----------------------------------------------------------------------*/
	public function delete()
	{
		$support = $this->model('tbs/transport_output_forms_supports')->get_by_id($_GET['id']);
		
		if ($this->model('tbs/transport_output_forms_supports')->delete($_GET['id'])) {
			unlink("public/uploads/supports/transport_output/{$_GET['form_id']}/{$_GET['id']}.{$support['file_extension']}");
			redirect_back('Soporte Borrado');
		}else{
			redirect_back('No se pudo borrar el reporte', 'error');
		}
	}
}
