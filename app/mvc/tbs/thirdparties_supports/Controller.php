<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['thirdparties_supports'] = $this->model('tbs/thirdparties_supports')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
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

				if ($id = $this->model('tbs/thirdparties_supports')->create($_POST))
				{
					if ($_FILES)
			        {
			        	$folder_name = $_SESSION['user']['company_schema'].$_POST['request_id'];
			        	
						$dir = "public/uploads/supports/thirdparty/$folder_name";
			            mkdir($dir, 0777);

			            $file_name = $id.'.'.$extension;
			            move_uploaded_file($_FILES['support']['tmp_name'], $dir.'/'.$file_name);
			        }

					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("tbs/thirdparties_requests/details?id=".$_POST['request_id']);
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		
		$data['thirdparties_requests'] = $this->model('tbs/thirdparties_requests')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['thirdparty_support'] = $this->model('tbs/thirdparties_supports')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("tbs/thirdparties_supports");
		}

		if ($_POST)
		{
			
				if ($this->model('tbs/thirdparties_supports')->update_by_id($_GET['id'], $_POST))
				{
					set_notification("Guardado");
					redirect("tbs/thirdparties_supports");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		
		$data['thirdparties_requests'] = $this->model('tbs/thirdparties_requests')->get_all();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	DELETE
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/thirdparties_supports')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect_back();
	}
}