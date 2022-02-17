<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		
		render();
	}

/*----------------------------------------------------------------------
	tariff_headings
----------------------------------------------------------------------*/
	public function tariff_headings()
	{
		
		render();
	}


/*----------------------------------------------------------------------
	GET_BY_VIN
----------------------------------------------------------------------*/
	public function get_by_vin()
	{
		if ($_POST)
		{			
			data('products', $this->model('tbs/output_forms_products')->get_by_name($_POST['vin']));
		}

		render();
	}


/*----------------------------------------------------------------------
	SUPPORT_SEARCH
----------------------------------------------------------------------*/
	public function support_search()
	{
		if ($_POST)
		{		
			switch ($_POST['type']) {
				case 1:
					$data['support'] = $this->model('tbs/input_forms_supports')->get_by_detail($_POST['detail']);
					$data['type'] = 1;
					break;

				case 2:
					$data['support'] = $this->model('tbs/output_forms_supports')->get_by_detail($_POST['detail']);
					$data['type'] = 2;
					break;

				case 3:
					$data['support'] = $this->model('tbs/transport_input_forms_supports')->get_by_detail($_POST['detail']);
					$data['type'] = 3;
					break;

				case 4:
					$data['support'] = $this->model('tbs/transport_output_forms_supports')->get_by_detail($_POST['detail']);
					$data['type'] = 4;
					break;

				default:
					$data['support'] = $this->model('tbs/input_forms_supports')->get_by_detail($_POST['detail']);
					$data['type'] = 1;
					break;
			}
		}

		$this->view('verify', $data);
	}


/*----------------------------------------------------------------------
	VIN SEARCH
----------------------------------------------------------------------*/
	public function vin_search()
	{
		if ($_POST) {
			$vins = preg_split('/\n/', $_POST['vins']);

			$true_vins = array();
			$false_vins = array();

			$blocks = explode(',', $_POST['block']);
			$new_block = array();
			foreach ($blocks as $bk) {
				if (strpos($bk, 'VIN:') !== false) {
					$bk = preg_replace( "/\r|\n/", "", $bk);
					$bk = str_replace("VIN:", "", $bk);
					$bk = str_replace(" ","", $bk);
					//echo '<pre>'.print_r($bk, TRUE).'</pre>';
					array_push($true_vins, $bk);
				}
			}

			foreach ($vins as $vin) {
				$temporal = '';
				foreach ($new_block as $bk) {
					die();
					if ($bk == $vin) {
					    $temporal = $vin;
					}
				}

				if ($temporal!='') {
					//array_push($true_vins, $vin);
				}else{
					//array_push($false_vins, $vin);
				}
			}

			data('true_vins', $true_vins);
			data('false_vins', $false_vins);
			data('results', TRUE);
		}
		render();
	}
}
