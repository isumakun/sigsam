<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		$data['indicators'] = $this->model('indicator/indicators')->get_all($_SESSION['user']['company_id']);
		$data['page_title'] = 'Indicadores';
		$this->view('', $data, 'fullwidth');
	}
/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function graphic_reports(){	
		if (!$data['indicators'] = $this->model('indicator/values')->get_test($_GET['id'])){
				set_notification("No existe el registro", 'error');
				redirect("indicator/indicators");
		}
		
		$data['ages'] = $this->model('indicator/values')->get_age_id($_GET['id']);
		$data['analysis'] = $this->model('indicator/values')->get_name($_GET['id']);
		$data['graph'] = $this->model('indicator/values')->get_graph($_GET['id']);
		$data['page_title'] = 'Reporte Grafico';


		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	report_filter
------------------------------------------------------------------------------*/
	public function  report_filter(){
		if($_GET){
			$data['filter_age'] = $this->model('indicator/values')->get_filter();
			echo json_encode($data);
			die;
		}
	}
/*------------------------------------------------------------------------------
	report_graph_filter
------------------------------------------------------------------------------*/
	public function  report_graph_filter(){
		if($_GET){
			$data['filter_graph'] = $this->model('indicator/values')->get_graph_filter();
			echo json_encode($data);
			die;
		}
	}
/*------------------------------------------------------------------------------
	REPORTS
------------------------------------------------------------------------------*/
	public function reports()
	{
		$data['categories'] = $this->model('indicator/indicators')->get_category();
		$data['indicators'] = $this->model('indicator/indicators')->get_all();
		$data['periods'] = $this->model('indicator/values')->get_age();
		$data['processes'] = $this->model('indicator/processes')->get_all($_SESSION['user']['company_id']);
		$data['page_title'] = 'Reportes';

		
		$this->view('', $data, 'fullwidth');
	}
/*------------------------------------------------------------------------------
	support
------------------------------------------------------------------------------*/
public function supports()
{
	$data['indicator'] = $this->model('indicator/indicators')->get_name($_GET['id']);
	$data['support'] = $this->model('indicator/indicators')->get_supports($_GET['id']);
	$data['page_title'] = 'Soportes';
	$this->view('', $data, 'fullwidth');
}
/*------------------------------------------------------------------------------
	REPORT_SEARCH
------------------------------------------------------------------------------*/
public function report_search(){
	$report="";
	if(isset($_POST)){

		
		// $var = 0;
		// $image = BASE_URL."public/resources/users_signs/".$_SESSION['user']['company_name'].".png";

		//  // Read image path, convert to base64 encoding
		//  $type = pathinfo($image, PATHINFO_EXTENSION);
		//  $data_img = file_get_contents($image);

		//  $imgData = base64_encode($data_img);

		//  // Format the image SRC:  data:{mime};base64,{data}; 
		//  $src = 'data:image/' . $type . ';base64,'.$imgData;
		//  echo $src;
		//  die();
		if($_POST['age']==''){
			set_notification("Por favor ingresa año de búsqueda", 'error');
		}else{
			error_reporting(E_ALL);
			ini_set('display_errors', true);

			$report= $this->model('indicator/indicators')->get_search_category($_POST['category'],$_POST['process'],$_POST['indicators']);
		}
			foreach ($report as $r) {

				$r['value_result'] = $this->model('indicator/values')->get_value_result($r['id'],$_POST['age']);
				$data['report'][]=$r;
				// if($var ===0){
				// 	$data['report'][] = $src;
				// 	$var =1;
				// }
			}

			
			 
	}else{
		set_notification("error en los datos", 'error');
	}
	$postData=json_encode($data,1);
	
	echo $postData;
	
}
/*------------------------------------------------------------------------------
	CREATE
------------------------------------------------------------------------------*/
	public function create()
	{	
		if ($_POST)
		{
			
			// foreach ($_POST['charge_id '] as $key => $val) {
			// 	echo $key." : ".$val."  ";
			// }
			// echo $_POST['charge_id'][0];
			// foreach($_POST['charge_id'] as $v){
			// 	echo $v."mento";
			// }
			// die();
				if ($id_indicator = $this->model('indicator/indicators')->create($_POST))
				{
					$this->model('indicator/indicators')->delete_in_charge_indicator($id_indicator, $_POST['charge_id']);
					$this->model('indicator/indicators')->insert_in_charge_indicator($id_indicator, $_POST['charge_id']);
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect("indicator/indicators");
				}
				else
				{
					set_notification("El registro no pudo ser creado", 'error');
				}
		}
		
		$data['types'] = $this->model('indicator/types')->get_all();
		$data['process'] = $this->model('indicator/processes')->get_all($_SESSION['user']['company_id']);
		$data['charges'] = $this->model('indicator/charges')->get_all($_SESSION['user']['company_id']);
		$data['frequency'] = $this->model('indicator/indicators')->get_frequency();
		$data['category'] = $this->model('indicator/indicators')->get_category();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit()
	{
		if (!$data['indicator'] = $this->model('indicator/indicators')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("indicator/indicators");
		}

		if ($_POST)
		{
			
				if ($this->model('indicator/indicators')->update_by_id($_GET['id'], $_POST))
				{
					$this->model('indicator/indicators')->delete_in_charge_indicator($_GET['id'], $_POST['charge_id']);
					$this->model('indicator/indicators')->insert_in_charge_indicator($_GET['id'], $_POST['charge_id']);
					set_notification("Guardado");
					redirect("indicator/indicators");
				}
				else
				{
					set_notification("El registro no pudo ser actualizado", 'error');
				}
		}
		$data['types'] = $this->model('indicator/types')->get_all();
		$data['process'] = $this->model('indicator/processes')->get_all($_SESSION['user']['company_id']);
		$data['charges'] = $this->model('indicator/charges')->get_all($_SESSION['user']['company_id']);
		$temp = $this->model('indicator/indicators')->get_charges_user($_GET['id']);
		foreach ($temp as $key) {
			echo	$data['charges_ind'][] = $key['user_id'];
		}
		$data['frequency'] = $this->model('indicator/indicators')->get_frequency();
		$data['category'] = $this->model('indicator/indicators')->get_category();

		$this->view('',$data);
	}

/*------------------------------------------------------------------------------
	turn_off_visibility
------------------------------------------------------------------------------*/
	public function delete()
	{
		if ($this->model('indicator/indicators')->turn_off_visibility($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("indicator/indicators");
	}
}