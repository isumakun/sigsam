<?php defined('UMVC') OR exit('No direct script access allowed');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
------------------------------------------------------------------------------*/
	public function index()
	{
		if(has_role(3)){
			$data['indicators'] = $this->model('indicator/indicators')->getall_by_rol($_SESSION['user']['company_id']);
		}else{
			$data['indicators'] = $this->model('indicator/indicators')->get_all($_SESSION['user']['company_id']);
		}
		
		$data['page_title'] = 'Indicadores';
		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	graphic_reports
------------------------------------------------------------------------------*/
	public function graphic_reports(){
		if($_POST){
			
			$data['indicators'] = $this->model('indicator/values')->get_test($_POST['id'], $_POST['age_id']."-01-01");
			foreach ($data['indicators'] as $key => $values) {
				$data['indicators'][$key]['name_support'] = basename($values['support']);
				$data['indicators'][$key]['name_support1'] = basename($values['support1']);
				$data['indicators'][$key]['support'] = an_route($values['id'], $values['indicator_id'], $values['support']);
				$data['indicators'][$key]['support1'] = an_route($values['id'], $values['indicator_id'], $values['support1']);
			}
			echo json_encode($data);
			die();
		}else{
			if (!$data['indicators'] = $this->model('indicator/values')->get_test($_GET['id'], date("Y-m-d"))){
				set_notification("No existe el registro", 'error');
				redirect("indicator/dashboard");
			}
			foreach ($data['indicators'] as $key => $values) {
				$data['indicators'][$key]['name_support'] = basename($values['support']);
				$data['indicators'][$key]['name_support1'] = basename($values['support1']);
				$data['indicators'][$key]['support'] = an_route($values['id'], $values['indicator_id'], $values['support']);
				$data['indicators'][$key]['support1'] = an_route($values['id'], $values['indicator_id'], $values['support1']);
			}
			$data['ages'] = $this->model('indicator/values')->get_age_id($_GET['id']);
			// $data['analysis'] = $this->model('indicator/values')->get_name($_GET['id']);

			$data['analysis'] = $this->model('indicator/values')->get_name($_GET['id'], date("Y-m-d"));

			$data['graph'] = $this->model('indicator/values')->get_graph_filter($_GET['id'], date("Y-m-d"));
			$data['page_title'] = 'Reporte Grafico';
			preg_match(
			    '/[0-9]\d*(\.\d+)?/',
			    $data['analysis'][0]['goal'],
			    $matches
			);
			$data['upper_l'] = null;
			$data['gl2'] = null;
			if(isset($matches[0])){$data['upper_l'] =  str_replace(',', '.', $matches[0]);}
			

			if(isset($data['upper_l'])){
				$data['lower_l'] = $data['upper_l'];
				$data['gl1'] = "Goal";
				$data['gl2'] = null;
			}
			if(isset($data['analysis'][0]['lower_limit']) && $data['analysis'][0]['lower_limit'] !=""  && isset($data['analysis'][0]['upper_limit']) && $data['analysis'][0]['upper_limit'] !=""){
				preg_match(
				    '/[0-9]\d*(\.\d+)?/',
				    $data['analysis'][0]['lower_limit'],
				    $matches
				);
				$data['lower_l'] =  str_replace(',', '.', $matches[0]) ;
				preg_match(
				    '/[0-9]\d*(\.\d+)?/',
				    $data['analysis'][0]['upper_limit'],
				    $matches
				);
				$data['upper_l'] =  str_replace(',', '.', $matches[0]) ;
				$data['gl1'] = "Linf";
				$data['gl2'] = "Lsup";
			}
		}
		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	pdf_manager
------------------------------------------------------------------------------*/

	public function pdf_manager(){

		$wich = explode('-', $_GET['idpdf_file'])[0];
		echo "esadasdasdsd".$wich;
		$inform_id= explode('-', $_GET['idpdf_file'])[1];
		$ind_id = explode('-', $_GET['idpdf_file'])[2];
		$result = $this->model('indicator/values')->get_supports_inform_by_id($inform_id);

		if($wich==='1'){

			$result = an_route($ind_id, $inform_id, $result['support']);
			echo filesize($result);
			echo $result;
			// header("Content-Disposition: attachment; filename=" . $result);   
			// header("Content-Type: application/download");
			// header("Content-Description: File Transfer");            
			// header("Content-Length: " . filesize($result));
		}
	}
/*------------------------------------------------------------------------------
	report_filter
------------------------------------------------------------------------------*/
	// public function  report_filter(){
	// 	if($_POST){
	// 		$data['filter_age'] = $this->model('indicator/values')->get_filter($_POST['id'], $_POST['get_id']);
	// 		echo json_encode($data);
	// 		die;
	// 	}
	// }
/*------------------------------------------------------------------------------
	report_graph_filter
------------------------------------------------------------------------------*/
	public function report_graph_filter(){
		if($_POST){
			if($_POST['frequency_id'] == '1'){
				$data['graph'] = $this->model('indicator/values')->get_graph($_POST['id'], $_POST['age_id']."-01-01");
			}else{
				$data['graph'] = $this->model('indicator/values')->get_graph_filter($_POST['id'], $_POST['age_id']."-01-01");
			}
			$data['analysis'] = $this->model('indicator/values')->get_name($_POST['id'], $_POST['age_id']."-01-01");
			preg_match(
			    '/[0-9]\d*(\.\d+)?/',
			    $data['analysis'][0]['goal'],
			    $matches
			);
			$data['upper_l'] = null;
			$data['gl2'] = null;
			if(isset($matches[0])){$data['upper_l'] =  str_replace(',', '.', $matches[0]);}
			

			if(isset($data['upper_l'])){
				$data['lower_l'] = $data['upper_l'];
				$data['gl1'] = "Goal";
				$data['gl2'] = null;
			}
			if(isset($data['analysis'][0]['lower_limit']) && $data['analysis'][0]['lower_limit'] !=""  && isset($data['analysis'][0]['upper_limit']) && $data['analysis'][0]['upper_limit'] !=""){
				preg_match(
				    '/[0-9]\d*(\.\d+)?/',
				    $data['analysis'][0]['lower_limit'],
				    $matches
				);
				$data['lower_l'] =  str_replace(',', '.', $matches[0]) ;
				preg_match(
				    '/[0-9]\d*(\.\d+)?/',
				    $data['analysis'][0]['upper_limit'],
				    $matches
				);
				$data['upper_l'] =  str_replace(',', '.', $matches[0]) ;
				$data['gl1'] = "Linf";
				$data['gl2'] = "Lsup";
			}
			echo json_encode($data);
			
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
	analysis_filter
------------------------------------------------------------------------------*/
	public function analysis_filter()
	{
		$data['categories'] = $this->model('indicator/indicators')->get_category();
		$data['indicators'] = $this->model('indicator/indicators')->get_all();
		$data['periods'] = $this->model('indicator/values')->get_age();
		$data['processes'] = $this->model('indicator/processes')->get_all($_SESSION['user']['company_id']);
		
		echo json_encode($data, 1);
	}

/*------------------------------------------------------------------------------
	analysis_filter_ajax
------------------------------------------------------------------------------*/
	public function analysis_filter_ajax(){
		if ($_POST['type']=='process') {
			$data['indicators'] = $this->model('indicator/indicators')->get_by_processid($_POST['id']);
		}
		if ($_POST['type']=='indicators') {
			$data['indinfo'] = $this->model('indicator/indicators')->get_by_indicatorid($_POST['id']);
		}
		echo json_encode($data, 1);
	}

/*------------------------------------------------------------------------------
	analysis_filter_results
------------------------------------------------------------------------------*/
	public function analysis_filter_results()
	{
		if($_POST){

			// $data['indicators'] = $this->model('indicator/values')->get_test($_POST['indicators']);
			
			// $data['ages'] = $this->model('indicator/values')->get_age_id($_POST['age']);
			// $data['analysis'] = $this->model('indicator/values')->get_name($_POST['indicators']);
			// $data['graph'] = $this->model('indicator/values')->get_graph($_POST['indicators']);

			$data['page_title'] = 'Analisis';


			$this->view('', $data, 'fullwidth');

		}
	}

/*------------------------------------------------------------------------------
	REPORTS
------------------------------------------------------------------------------*/
	public function general_report()
	{
		$data['categories'] = $this->model('indicator/indicators')->get_category();
		$data['indicators'] = $this->model('indicator/indicators')->get_all();
		$data['periods'] = $this->model('indicator/values')->get_age();
		$data['processes'] = $this->model('indicator/processes')->get_all($_SESSION['user']['company_id']);
		$data['page_title'] = 'Reporte General';

		
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
	public function create(){
		if ($_POST){
			if($_POST['metakind'] !== html_entity_decode("=")){
				$_POST['goal'] = $_POST['metakind'].' '.$_POST['goal'];
			}
			if ($id_indicator = $this->model('indicator/indicators')->create($_POST)){
				$this->model('indicator/indicators')->delete_in_charge_indicator($id_indicator, $_POST['charge_id']);
				$this->model('indicator/indicators')->insert_in_charge_indicator($id_indicator, $_POST['charge_id']);
				set_notification("Registro creado correctamente", 'success', TRUE);
				redirect("indicator/dashboard");
			}else{
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
	edit goals in indicator_goals table
------------------------------------------------------------------------------*/
public function edit_indicator_goals(){
	if($_POST){
		$prev = $this->model('indicator/indicators')->select_indicator_goal_byid($_POST['id']);
		$UpdatedColumns=array_diff_assoc($_POST,$prev[0]);
		if(!empty($UpdatedColumns)){
			if(!isset($_POST['upper_limit']) && $_POST['upper_limit'] == ""){
				$_POST['upper_limit'] = null;
			}
			if(!isset($_POST['lower_limit']) && $_POST['lower_limit'] == ""){
				$_POST['lower_limit'] = null;
			}
			if(!isset($_POST['goal']) && $_POST['goal'] == ""){
				$_POST['goal'] = null;
			}
			$previous = json_encode($prev[0]);
			$updated = json_encode($UpdatedColumns);
			if($_POST['upper_limit']==null && $_POST['lower_limit'] == null && $_POST['goal'] == null){
				$result = $this->model('indicator/indicators')->change_visibility_indicator_goals($_POST['id'], 0);
				$result = $this->model('indicator/indicators')->insert_indicator_goal_log($_POST['id'], $previous, '{"visibility":"0"}');
			}else{
				$result = $this->model('indicator/indicators')->edit_indicator_goals($_POST['id'], $_POST['goal'], $_POST['upper_limit'], $_POST['lower_limit']);
				$result = $this->model('indicator/indicators')->insert_indicator_goal_log($_POST['id'], $previous, $updated);
			}
		}
	}
}
/*------------------------------------------------------------------------------
	EDIT
------------------------------------------------------------------------------*/
	public function edit(){

		if (!$data['indicator'] = $this->model('indicator/indicators')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("indicator/dashboard");
		}

		if ($_POST){
			
			if($_POST['opc'] == 1){
				$_POST['goal'] = null;
			}
			if($_POST['opc'] == 2){
				$_POST['upper_limit'] = null;
				$_POST['lower_limit'] = null;

				if($_POST['metakind'] !== html_entity_decode("=")){
					$goal_toinsert = $_POST['metakind'].' '.$_POST['goal'];
				}
			}
			if($_POST['goal'] != "" && $_POST['goal'] != null){
				$id_goal_inserted = $this->model('indicator/indicators')->insert_in_indicator_goals($_GET['id'], $goal_toinsert, $_POST['upper_limit'], $_POST['lower_limit']);	
			}
			if($_POST['upper_limit'] != "" && $_POST['lower_limit'] != "" && $_POST['upper_limit'] != null  && $_POST['lower_limit'] != null){
				$id_goal_inserted = $this->model('indicator/indicators')->insert_in_indicator_goals($_GET['id'], $goal_toinsert, $_POST['upper_limit'], $_POST['lower_limit']);	
			}
			
			if ($this->model('indicator/indicators')->update_by_id($_GET['id'], $_POST))
			{
				$this->model('indicator/indicators')->delete_in_charge_indicator($_GET['id'], $_POST['charge_id']);
				$this->model('indicator/indicators')->insert_in_charge_indicator($_GET['id'], $_POST['charge_id']);
				set_notification("Guardado");
				redirect("indicator/dashboard");
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
			$data['charges_ind'][] = $key['user_id'];
		}
		$goals = $this->model('indicator/indicators')->get_all_goals_indicator($_GET['id']);
		$data['goals'] = $goals;
		foreach ($goals as $key => $value) {
			preg_match(
			    '/[0-9]\d*(\.\d+)?/',
			    $value['goal'],
			    $matches
			);
			
			$data['matches_goal'] = null;
			$data[$value['id']]['gl1'] = 0;
			if(isset($matches[0])){$data['matches_goal'][$value['id']] = $matches[0];}else{$data['matches_goal'][$value['id']] = $value['goal'];}
			if(isset($value['goal']['lower_limit']) && $value['goal']['lower_limit'] !=""  && isset($value['goal']['upper_limit']) && $value['goal']['upper_limit'] !=""){
				$data[$value['id']]['gl1'] = 1;
			}

			$data['year_goals'][$value['year']][$value['id']] = array(
				'id' => $value['id'],
				'indicator_id' => $value['indicator_id'],
				'goal' => $data['matches_goal'][$value['id']],
				'upper_limit' => $value['upper_limit'],
				'lower_limit' => $value['lower_limit'],
				'creation_date' => $value['creation_date']
			);
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

		redirect("indicator/dashboard");	
	}
}