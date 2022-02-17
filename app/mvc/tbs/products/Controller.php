<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['products'] = $this->model('tbs/products')->get_all();

		$this->view('Inicio', $data, 'fullwidth');
	}

/*----------------------------------------------------------------------
	CREATE
----------------------------------------------------------------------*/
	public function create()
	{
		if ($_POST)
		{
			if ($id = $this->model('tbs/products')->create($_POST))
			{
				$product = $this->model('tbs/products')->get_by_id($id);
				
				set_message([$product['pid'], $product['product'], $product['tariff_heading'], $product['physical_unit']]);
				set_notification('Se creó el producto.');
			}
			else
			{
				set_notification('Se creó mal.', 'error');
			}

			redirect_back();
		}

		$current_schema = $_SESSION['user']['company_schema'];

		if ($current_schema=='tbs3_900324176') {
			if (has_role(1)) {
				
			}else{
				set_notification('Bloqueado', 'error');
				redirect_back();
			}
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();

		$this->view('Inicio', $data);
	}

/*----------------------------------------------------------------------
	create_transformed
----------------------------------------------------------------------*/
	public function create_transformed()
	{
		if ($_POST)
		{

			if ($id = $this->model('tbs/products')->create_transformed($_POST))
			{
				$product = $this->model('tbs/products')->get_by_id($id);
				
				$warehouse_id = $this->model('tbs/warehouses')->create_empty($id, 3);

				set_message([$warehouse_id, $product['product'], $product['tariff_heading'], $product['physical_unit']]);
				//set_notification('Se creó bien.');
			}
			else
			{
				set_notification('Se creó mal.', 'error');
			}

			redirect_back();
		}

		$current_schema = $_SESSION['user']['company_schema'];

		if ($current_schema=='tbs3_900324176') {
			if (has_role(1)) {
				
			}else{
				set_notification('Bloqueado', 'error');
				redirect_back();
			}
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();

		$this->view('create_transformed', $data);
	}

/*----------------------------------------------------------------------
	EDIT
----------------------------------------------------------------------*/
	public function edit()
	{
		$data['product'] = $this->model('tbs/products')->get_by_id($_GET['id']);

		if ($_POST)
		{
			if ($this->model('tbs/products')->edit($_POST))
			{
				set_notification('Se editó bien.');
			}
			else
			{
				set_notification('Se editó mal.', 'error');
			}

			redirect('tbs/products');
		}

		$data['products_types'] = $this->model('tbs/products_types')->get_all();
		$data['tariff_headings'] = $this->model('tbs/tariff_headings')->get_all();
		$data['physical_units'] = $this->model('tbs/physical_units')->get_all();

		$this->view('edit', $data);
	}
}
