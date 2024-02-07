<?php defined('UMVC') OR exit('No direct script access allowed');
include('phpMailer/PHPMailerAutoload.php');

Class Controller extends ControllerBase {

/*------------------------------------------------------------------------------
	INDEX
	------------------------------------------------------------------------------*/
	public function index()
	{
		$data['values'] = $this->model('indicator/values')->get_all();

		$this->view('', $data, 'fullwidth');
	}

/*------------------------------------------------------------------------------
	CREATE
	------------------------------------------------------------------------------*/
	public function create()
	{
		
		if ($_POST)
		{
			$_POST['created_by'] = $_SESSION['user']['id'];
			$extension = '';
			// if ($_FILES){

				// if($_FILES['file_upload']['size'] > 500000)
				// {
				// 	redirect_back('El archivo excede la capacidad máxima permitida (50 mb)', 'error');
				// }

				// $extension = explode('.', $_FILES['support']['name']);

				// $extension = end($extension);
				// $_POST['file_extension'] = $extension;
				// $extension1 = explode('.', $_FILES['support1']['name']);
				// $extension1 = end($extension1);
				// $_POST['file_extension1'] = $extension1;

			// }

			if ($_FILES['support']['size']!=0) {
				$prefix = date("Ymd_His");				
				$new_str = preg_replace('/\s+/', '', $_FILES['support']['name']);
				
				$support_name = $prefix.'_'.$new_str;
				$_POST['support'] = $support_name;
				upload_to_bucket($_FILES['support'], '', $support_name);
			}
			
			if ($_FILES['support1']['size']!=0) {
				$prefix = date("Ymd_His");
				$new_str2 = preg_replace('/\s+/', '', $_FILES['support1']['name']);

				$support_name2 = $prefix.'_'.$new_str2;
				$_POST['support1'] = $support_name2;
				upload_to_bucket($_FILES['support1'], '', $support_name2);
			}		
			
			if ($id_inform = $this->model('indicator/values')->create($_POST)){
				
				set_notification("Registro creado correctamente", 'success', TRUE);
				
			}else{
				set_notification("El registro no pudo ser creado", 'error');
			}
			
			if($_POST['final_report'] == 1){
				$this->model('indicator/values')->create_final_report($_POST);
			}

			// $indicator=$this->model('indicator/values')->get_by_id($_GET['id']);
			$user=$this->model('indicator/values')->get_by_id($id_inform);
			$company = $_SESSION['user']['company_name'];

			$fisrname = $user['first_name'];
			$lastname = $user['last_name'];
			$indname =  $user['indicator'];
			// $email1 = 'mzarate@daabon.com.co';
			// Caribbean
			if ($_SESSION['user']['company_id']==1) {
				$email1 = 'ccastro@c-ecosoaps.com';
			}//tequendama
			else if($_SESSION['user']['company_id']==2) {
				$email1 = 'cmorales@daabon.com.co';
			}//terlica
			else if($_SESSION['user']['company_id']==3) {
				$email1 = 'lospino@daabon.com.co';
			}//superportuaria
			else if($_SESSION['user']['company_id']==4) {
				$email1 = 'tvergara@daabon.com.co';
			}//ZFA
			else if($_SESSION['user']['company_id']==5) {
				$email1 = 'macarranza@zonafrancalasamericas.com';
			}//elogia
			else if($_SESSION['user']['company_id']==6) {
				$email1 = 'aamaya@daabon.com.co';
			}//bios
			else if($_SESSION['user']['company_id']==7) {
				$email1 = 'hcotes@daabon.com.co';
			}//samaria
			else if($_SESSION['user']['company_id']==8) {
				$email1 = 'lcruz@daabon.com.co ';
			}//ZFT
			else if($_SESSION['user']['company_id']==9) {
				$email1 = 'ssta@zonafrancatayrona.com';
			}//tequendama
			else if($_SESSION['user']['company_id']==10) {
				$email1 = 'hcotes@daabon.com.co';
			}//palma y trabajo
			else if($_SESSION['user']['company_id']==11) {
				$email1 = 'srodriguez@palmatra.com';
			}//grupalma
			else if($_SESSION['user']['company_id']==12) {
				$email1 = 'srodriguez@palmatra.com';
			}//superlogistic
			else if($_SESSION['user']['company_id']==13) {
				$email1 = 'tvergara@daabon.com.co';
			}//trading service
			else if($_SESSION['user']['company_id']==14) {
				$email1 = 'macarranza@zonafrancalasamericas.com';
			}//Derivados y fracciones de palma
			else if($_SESSION['user']['company_id']==15) {
				$email1 = 'cmorales@daabon.com.co';
			}
		
		// Datos de la cuenta de correo utilizada para enviar vía SMTP
		$smtpHost = "smtp.office365.com";  // Dominio alternativo brindado en el email de alta 
		$smtpUsuario = "noreply-a01b20tq@daabon.com.co";  // Mi cuenta de correo
		$smtpClave = '9FokqRNtG!5U$04jT$OiD@b0n.0rg@n1c';  // Mi contraseña

		$mail = new \PHPMailer();

		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPAuth   = TRUE;
		$mail->SMTPSecure = 'tls';
		$mail->Port       = 587;

		// VALORES A MODIFICAR //
		$mail->Host = "smtp.office365.com"; 
		$mail->Username = "noreply-a01b20tq@daabon.com.co"; 
		$mail->Password = '9FokqRNtG!5U$04jT$OiD@';
		$mail->IsHTML(true); // El correo se envía como HTML

		$mail->From = 'noreply-a01b20tq@daabon.com.co';
		// $mail->addBCC('noreply-a01b20tq@daabon.com.co');
		$mail->FromName = 'SAM';
		$mail->AddAddress($email1); // Esta es la dirección a donde enviamos los datos del formulario
		 // Esta es la dirección a donde enviamos los datos del formulario
		$mail->Subject = "Informe de Indicador SAM"; // Este es el titulo del email.
		$mail->Body = "
		<html> 
		<body> 
		<p>
		<p> Estimado/a.</p>
		<h4>Les estamos informando lo siguiente :</h4>

		<p>El Usuario <b>$fisrname</b>  <b>$lastname</b> ha registrado los datos del indicador <b>$indname</b>, de la empresa <b>$company</b></P>

		<p>Cordialmente,</p>

		<p></p>

		</p>
		</body> 
			</html>"; // Texto del email en formato HTML

		$mail->AltBody = "{} \n\n "; // Texto sin formato HTML
		// FIN - VALORES A MODIFICAR //

		// $mail->SMTPOptions = array(
		// 	'ssl' => array(
		// 		'verify_peer' => false,
		// 		'verify_peer_name' => false,
		// 		'allow_self_signed' => true
		// 	)
		// );
		$sendstate = $mail->Send();
		$mail->clearAllRecipients();

		// $id=$_GET['id'];
		redirect("indicator/");
		
	}


	$data['indicators'] = $this->model('indicator/indicators')->get_by_id($_GET['id']);
	$data['values'] = $this->model('indicator/values')->get_value_period_by_id($_GET['id']);
	$data['period'] = $this->model('indicator/values')->get_period_by_indicator($_GET['id']);
	$data['frequencies'] = $this->model('indicator/values')->get_by_frequency($_GET['id']);
	$data['inform_class'] = $this->model('indicator/values')->get_inform_class();
	$data['age'] = $this->model('indicator/values')->get_age();

	$this->view('',$data);
}

/*------------------------------------------------------------------------------
	EDIT
	------------------------------------------------------------------------------*/
	public function edit()
	{
		
		$data['indicators'] = $this->model('indicator/values')->get_all_edit($_GET['id']);

		if (!$data['value'] = $this->model('indicator/values')->get_by_id($_GET['id']))
		{
			set_notification("No existe el registro", 'error');
			redirect("indicator/values");
		}

		if ($_POST){
			
			// if ($_FILES){

				$row_to_update = $this->model('indicator/values')->obtain_row($_GET['id']);
				
				
				// if($_FILES['support']['size'] > 500000){
				// 	redirect_back('El archivo excede la capacidad máxima permitida (50 mb)', 'error');
				// }
				// $path = getcwd();
				
				if ($_FILES['support']['size']!=0) {
					$prefix = date("Ymd_His");				
					$new_str = preg_replace('/\s+/', '', $_FILES['support']['name']);
					
					$support_name = $prefix.'_'.$new_str;
					$_POST['support'] = $support_name;
					upload_to_bucket($_FILES['support'], '', $support_name);
				}
				
				if ($_FILES['support1']['size']!=0) {
					$prefix = date("Ymd_His");
					$new_str2 = preg_replace('/\s+/', '', $_FILES['support1']['name']);
	
					$support_name2 = $prefix.'_'.$new_str2;
					$_POST['support1'] = $support_name2;
					upload_to_bucket($_FILES['support1'], '', $support_name2);
				}

				$UpdatedColumns=array_diff_assoc($_POST,$row_to_update[0]);
				
				if(!empty($UpdatedColumns)){
					$previous = json_encode($row_to_update[0]);
					$updated = json_encode($UpdatedColumns);
					

					$result = $this->model('indicator/values')->insert_indicator_informs_log($_GET['id'], $previous, $updated);
				}
				
				// if($_SESSION['user']['id'] == 107){
				// 	echo "POST---------------";
				// 	echo '<pre>'.print_r($_POST).'</pre>';
				// 	echo "row to update---------------";
				// 	echo '<pre>'.print_r($row_to_update).'</pre>';

					
				// 	echo '<pre>'.print_r($UpdatedColumns).'</pre>';
				// 	die();
				// }
			
				if ($this->model('indicator/values')->update_by_id($_GET['id'], $_POST)){
					set_notification("Registro creado correctamente", 'success', TRUE);
					redirect('indicator/indicators/graphic_reports?id='.$data['indicators']['id']);	
										
				}
			
			// }

		}
			
		
	
	$data['values'] = $this->model('indicator/values')->get_value_period();
	$data['period'] = $this->model('indicator/values')->get_period();
	// $data['frequencies'] = $this->model('indicator/values')->get_by_frequency($_GET['id']);
	$data['inform_class'] = $this->model('indicator/values')->get_inform_class();
	$data['age'] = $this->model('indicator/values')->get_age();

	$this->view('',$data);
}

/*------------------------------------------------------------------------------
	DELETE
	------------------------------------------------------------------------------*/
	public function delete(){
		$row_to_update = $this->model('indicator/values')->obtain_row($_GET['id']);
		$path = getcwd();
		if($row_to_update[0]['support'] != ''){

			$file_to_delete = $path.substr($row_to_update[0]['support'], 1);
			// $file_to_delete2 = $path."/public/uploads/".$_GET['id'].".*";
			
			if(file_exists($file_to_delete)){
				unlink($file_to_delete);
			}
			// array_map( "unlink", glob( $file_to_delete2 ) );
			
			
		}

		if($row_to_update[0]['support1'] != ''){
			
			$file_to_delete = $path.substr($row_to_update[0]['support1'], 1);
			// $file_to_delete2 = $path."/public/uploads/".$_GET['id'].".*";


			if(file_exists($file_to_delete)){
				unlink($file_to_delete);
			}
			// array_map( "unlink", glob( $file_to_delete2 ) );
			
			
		}
		

		if ($this->model('indicator/values')->turn_off_visibility($_GET['id']))
		{
			$result = $this->model('indicator/values')->insert_indicator_informs_log($_GET['id'], NULL, '{"visibility":"0"}');
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("indicator/indicators/graphic_reports?id=".$row_to_update[0]['indicator_id']);
	}
}
