<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		$data['warehouses'] = $this->model('tbs/warehouses')->get_all();

		$this->view('', $data, 'fullwidth');
	}
}
