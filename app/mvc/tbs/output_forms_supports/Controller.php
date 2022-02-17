<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			$_POST['output_form_id'] = $_GET['form_id'];

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

			if ($id = $this->model('tbs/output_forms_supports')->create($_POST)) 
			{
				if ($_FILES)
		        {
		        	$folder_name = $_SESSION['user']['company_schema'].$_GET['form_id'];
					$dir = "public/uploads/supports/output/$folder_name";
		            mkdir($dir, 0777);

		            $file_name = $id.'.'.$extension;
		            move_uploaded_file($_FILES['support']['tmp_name'], $dir.'/'.$file_name);
		        }

		        $form = $this->model('tbs/output_forms')->get_by_id($_GET['form_id']);
				$form_id = $_GET['form_id'];
				if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
					if ($_SESSION['master_mode']==0) {
							$adjustment = array();
							$adjustment['form_type'] = 2; //SALIDA
							$adjustment['form_id'] = $form_id;
							$adjustment['field_type'] = 2; //Soportes
							$adjustment['field_name'] = 'support_id'; 
							$adjustment['field_id'] = $id;
							$adjustment['old_value'] = '';
							$adjustment['new_value'] = 'Nuevo soporte - '.$_POST['details'];

							//Guardo un ajuste de lo que se hizo
							$this->model('tbs/forms_adjustments')->create($adjustment);
					}
				}

				redirect("tbs/output_forms/details?id={$_GET['form_id']}");
			}
			else
			{
				redirect('', 'Ocurrió un error', 'error');
			}
		}

		$data['tbs_output_forms_supports_types'] = $this->model('tbs/output_forms_supports_types')->get_all();

		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['output_form_support'] = $this->model('tbs/output_forms_supports')->get_by_id($_GET['id']);
		$data['output_forms_verify'] = $this->model('tbs/output_forms_verify')->get_by_form_id($_GET['form_id']);
		
		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			$_POST['output_form_id'] = $_GET['form_id'];
			
			$support = $data['output_form_support'];

			$extension = $data['output_form_support']['file_extension'];
			
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


			if ($this->model('tbs/output_forms_supports')->edit($_POST)) 
			{
				if (count($data['output_forms_verify'])!=0) {
					for ($i=0; $i < count($_POST['field_names']); $i++) {
						$this->model('tbs/output_forms_verify')->create($_GET['form_id'], 3, $_GET['id'], $_POST['field_names'][$i]);
					}
				}

				if ($_FILES)
		        {
		        	$dir = "public/uploads/supports/output/{$_SESSION['user']['company_schema']}{$_GET['form_id']}";

		            $file_name = $_GET['id'].'.'.$extension;
		            move_uploaded_file($_FILES['support']['tmp_name'], $dir.'/'.$file_name);
		        }
				
				redirect("tbs/output_forms/details?id={$_GET['form_id']}");
			}
			else
			{
				set_notification('Ocurrió un error', 'error');
			}
		}

		$data['tbs_output_forms_supports_types'] = $this->model('tbs/output_forms_supports_types')->get_all();

		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	DELETE
----------------------------------------------------------------------*/
	public function delete()
	{
		$supp = $this->model('tbs/output_forms_supports')->get_by_id($_GET['id']);

		if ($this->model('tbs/output_forms_supports')->delete($_GET['id'])) {

			$form = $this->model('tbs/output_forms')->get_by_id($_GET['form_id']);
			$form_id = $_GET['form_id'];
			if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
				if ($_SESSION['master_mode']==0) {
						$adjustment = array();
						$adjustment['form_type'] = 2; //Salida
						$adjustment['form_id'] = $form_id;
						$adjustment['field_type'] = 2; //Soportes
						$adjustment['field_name'] = 'support_id'; 
						$adjustment['field_id'] = $_GET['id'];
						$adjustment['old_value'] = $supp['details'];
						$adjustment['new_value'] = 'Soporte Eliminado';

						//Guardo un ajuste de lo que se hizo
						$this->model('tbs/forms_adjustments')->create($adjustment);
				}
			}

			unlink("public/uploads/supports/output/{$_GET['form_id']}/{$_GET['id']}.{$supp['file_extension']}");
			redirect_back('Soporte Borrado');
		}else{
			redirect_back('Ocurrió un error', 'Error');
		}
	}
}
