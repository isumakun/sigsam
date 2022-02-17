<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			$_POST['transformation_form_id'] = $_GET['form_id'];
			
			if ($id = $this->model('tbs/transformation_forms_products')->create($_POST)) 
			{
				redirect("tbs/transformation_forms/details?id={$_GET['form_id']}");
			}
			else
			{
				redirect('Error', 'error');
			}
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_transformed();

		$this->view('create', $data);
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['transformation_form_product'] = $this->model('tbs/transformation_forms_products')->get_by_id($_GET['id']);
		$data['transformation_forms_verify'] = $this->model('tbs/transformation_forms_verify')->get_by_form_id($_GET['form_id']);

		if ($_POST)
		{
			$_POST['id'] = $_GET['id'];
			$_POST['transformation_form_id'] = $_GET['form_id'];
			
			if ($this->model('tbs/transformation_forms_products')->edit($_POST)) 
			{
				$form = $this->model('tbs/transformation_forms')->get_by_id($_GET['form_id']);
				$form_id = $_GET['form_id'];
				if ($form['form_state_id']==3 OR $form['form_state_id']==5) {
							if ($_SESSION['master_mode']==0) {
								foreach ($_POST as $key => $value) {
									foreach ($form as $key2 => $value2) {
										if ($key==$key2) {
											if ($value!=$value2) {

												$adjustment = array();
												$adjustment['form_type'] = 3; //Salida
												$adjustment['form_id'] = $form_id;
												$adjustment['field_type'] = 1; //Productos
												$adjustment['field_name'] = 'product_id';
												$adjustment['field_id'] = $_GET['id'];
												$adjustment['old_value'] = $value2;
												$adjustment['new_value'] = $value;

												//Guardo un ajuste de lo que se hizo
												$this->model('tbs/forms_adjustments')->create($adjustment);
											}
										}
									}
								}
							}
				}else{
					if (count($data['transformation_forms_verify'])!=0) {
						for ($i=0; $i < count($_POST['field_names']); $i++) {
							$this->model('tbs/transformation_forms_verify')->create($_GET['form_id'], 2, $_GET['id'], $_POST['field_names'][$i]);
						}
					}
				}
				
				redirect("tbs/transformation_forms/details?id={$_GET['form_id']}");
			}
			else
			{
				redirect( 'Error', 'error');
			}
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['products_categories'] = $this->model('tbs/products_categories')->get_all();
		$data['products'] = $this->model('tbs/products')->get_all();

		$this->view('edit', $data);
	}

/*----------------------------------------------------------------------
	DELETE
----------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('tbs/transformation_forms_products')->delete($_GET['id'])) {
			redirect_back('');
		}else{
			redirect_back('Error', 'Error');
		}
	}
}
