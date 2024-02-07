<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	INDEX
----------------------------------------------------------------------*/
	public function index()
	{
		
		$data['indicators'] = $this->model('indicator/deleted_records')->get_all();
		
		$data['page_title'] = 'Indicadores Eliminados';
		$this->view('', $data, 'fullwidth');
	}


/*------------------------------------------------------------------------------
	graphic_reports
------------------------------------------------------------------------------*/
	public function graphic_reports(){
		if($_POST){
			
			$data['indicators'] = $this->model('indicator/values')->get_test_by_year($_POST['id'], $_POST['age_id']."-01-01", $_POST['type'], 0);
			if(isset($data['indicators'])){
				foreach ($data['indicators'] as $key => $values) {
					$data['indicators'][$key]['name_support'] = basename($values['support']);
					$data['indicators'][$key]['name_support1'] = basename($values['support1']);
					// $data['indicators'][$key]['support'] = an_route($values['id'], $values['indicator_id'], $values['support']);
					// $data['indicators'][$key]['support1'] = an_route($values['id'], $values['indicator_id'], $values['support1']);
				}
			}
			echo json_encode($data);
			die();
		}else{
			if (!$data['indicators'] = $this->model('indicator/values')->get_test($_GET['id'], date("Y-m-d"), 1, 0)){
				if (!$data['indicators'] = $this->model('indicator/values')->get_test($_GET['id'], date("Y-m-d"), 3, 0)){
					set_notification("No existe el registro", 'error');
					redirect("indicator/deleted_records");
				}
			}
			// if($_SESSION['user']['id'] == 107){
			// 	die($sql);
			// }
			foreach ($data['indicators'] as $key => $values) {
				$data['indicators'][$key]['name_support'] = basename($values['support']);
				$data['indicators'][$key]['name_support1'] = basename($values['support1']);
			}
			//Lista de todos los años con registros de indicadores para el filtro años
			$data['ages'] = $this->model('indicator/values')->get_age_id($_GET['id'], 1);
			// $data['analysis'] = $this->model('indicator/values')->get_name($_GET['id']);

			//obtain indicator goal for the year in course
			$data['analysis'] = $this->model('indicator/values')->get_name($_GET['id'], date("Y-m-d"), 0);

			//obtain values for graph
			if($data['indicators'][0]['frequency_id']=='1'){
				$data['graph'] = $this->model('indicator/values')->get_graph_filter_anual($_GET['id'], date("Y-m-d"), 1, 0);
			}else{
				$data['graph'] = $this->model('indicator/values')->get_graph_filter($_GET['id'], date("Y-m-d"), 1, 0);
			}
			if(empty($data['graph'][0]['value'])){
				$data['graph'] = $this->model('indicator/values')->get_graph_filter($_GET['id'], date("Y-m-d"), 3, 0);
			}
			// if($_SESSION['user']['id'] == 107){
				
			// 	if(empty($data['graph'][0]['value'])){
			// 		die("is null");
			// 	}
			// }
			
			$data['page_title'] = 'Reporte Grafico';
			$matches = logchekElements($data['analysis'][0]['goal']);
			// echo '<pre>';print_r($matches); echo '</pre>';
			// die();
			$data['upper_l'] = null;
			$data['gl2'] = null;

			if(isset($matches)){$data['upper_l'] =  str_replace(',', '.', $matches);}
			if(isset($data['upper_l'])){
				$data['lower_l'] = $data['upper_l'];
				$data['gl1'] = "Goal";
				$data['gl2'] = null;
			}
			if(isset($data['analysis'][0]['lower_limit']) && $data['analysis'][0]['lower_limit'] !=""  && isset($data['analysis'][0]['upper_limit']) && $data['analysis'][0]['upper_limit'] !=""){
				
				$matches = logchekElements($data['analysis'][0]['lower_limit']);
				$data['lower_l'] =  str_replace(',', '.', $matches) ;
				$matches = logchekElements($data['analysis'][0]['upper_limit']);
				$data['upper_l'] =  str_replace(',', '.', $matches) ;
				$data['gl1'] = "Linf";
				$data['gl2'] = "Lsup";
			}
		}
		$this->view('', $data, 'fullwidth');
	}

	/*------------------------------------------------------------------------------
	report_graph_filter
	------------------------------------------------------------------------------*/
	public function report_graph_filter(){
		if($_POST){
			
			if($_POST['frequency_id'] == '1'){
				$data['graph'] = $this->model('indicator/values')->get_graph_anual($_POST['id'], $_POST['age_id']."-01-01", $_POST['type'], 0);
			}else{
				$data['graph'] = $this->model('indicator/values')->get_graph_monthly($_POST['id'], $_POST['age_id']."-01-01", $_POST['type'], 0);
			}
			$data['analysis'] = $this->model('indicator/values')->get_name($_POST['id'], $_POST['age_id']."-01-01", 0);
			

			$matches = logchekElements($data['analysis'][0]['goal']);
			// echo '<pre>';print_r($matches); echo '</pre>';
			// die();
			$data['upper_l'] = null;
			$data['gl2'] = null;

			if(isset($matches)){$data['upper_l'] =  str_replace(',', '.', $matches);}
			

			if(isset($data['upper_l'])){
				$data['lower_l'] = $data['upper_l'];
				$data['gl1'] = "Goal";
				$data['gl2'] = null;
			}
			if(isset($data['analysis'][0]['lower_limit']) && $data['analysis'][0]['lower_limit'] !=""  && isset($data['analysis'][0]['upper_limit']) && $data['analysis'][0]['upper_limit'] !=""){
				$matches = logchekElements($data['analysis'][0]['lower_limit']);
				$data['lower_l'] =  str_replace(',', '.', $matches) ;
				$matches = logchekElements($data['analysis'][0]['upper_limit']);
				$data['upper_l'] =  str_replace(',', '.', $matches) ;
				$data['gl1'] = "Linf";
				$data['gl2'] = "Lsup";
			}
			echo json_encode($data);
			
		}
	}

	/*------------------------------------------------------------------------------
	restore indicator
	------------------------------------------------------------------------------*/
	public function restore()
	{
		if ($this->model('indicator/indicators')->turn_offon_visibility($_GET['id'], 1))
		{
			$result = $this->model('indicator/indicators')->insert_indicator_modification_log($_GET['id'], NULL, '{"visibility":"1"}');
			set_notification("Restaurado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo restaurar", 'Error');
		}
		redirect("indicator/deleted_records");
	}
	
}
