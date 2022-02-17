<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

	public function index()
	{
		$this->view('Test', $data);
	}
}
