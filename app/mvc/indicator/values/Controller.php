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
				$prefix1 = rand(1, 10000);
				$dir1 = "/public/uploads/".$prefix1.'_'. $_FILES['support']['name'];
				$_POST['support'] = $dir1;
				upload_to_bucket($_FILES['support'], '', $prefix1.'_'. $_FILES['support']['name']);
			}
			
			if ($_FILES['support1']['size']!=0) {
				$prefix2 = rand(1, 10000);
				$dir2 = "/public/uploads/".$prefix2.'_'. $_FILES['support1']['name'];
				$_POST['support1'] = $dir2;
				upload_to_bucket($_FILES['support1'], '', $prefix2.'_'. $_FILES['support1']['name']);
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

			if ($_SESSION['user']['company_id']==1) {
				$email1 = 'kcabrera@daabon.com.co';
			}
			else if($_SESSION['user']['company_id']==3) {
				$email1 = 'lospino@daabon.com.co';
			}
			else if($_SESSION['user']['company_id']==2) {
				$email1 = 'kcabrera@daabon.com.co';
			}
			else if($_SESSION['user']['company_id']==4) {
				$email1 = 'hcotes@daabon.com.co';
			}
			else if($_SESSION['user']['company_id']==5) {
				$email1 = 'lospino@daabon.com.co';
			}
			else if($_SESSION['user']['company_id']==6) {
				$email1 = 'aamaya@daabon.com.co';
			}
			else if($_SESSION['user']['company_id']==7) {
				$email1 = 'hcotes@daabon.com.co';
			}
			else if($_SESSION['user']['company_id']==8) {
				$email1 = 'lcruz@daabon.com.co';
			}
		
		// Datos de la cuenta de correo utilizada para enviar vía SMTP
		$smtpHost = "smtp.office365.com";  // Dominio alternativo brindado en el email de alta 
		$smtpUsuario = "master@daabon.com.co";  // Mi cuenta de correo
		$smtpClave = "D@@b0n.0rg@n1c";  // Mi contraseña

		$mail = new \PHPMailer();

		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPAuth   = TRUE;
		$mail->SMTPSecure = 'tls';
		$mail->Port       = 587;

		// VALORES A MODIFICAR //
		$mail->Host = "smtp.office365.com"; 
		$mail->Username = "master@daabon.com.co"; 
		$mail->Password = "D@@b0n.0rg@n1c";
		$mail->IsHTML(true); // El correo se envía como HTML

		$mail->From = 'master@daabon.com.co';
		// $mail->addBCC('master@daabon.com.co');
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

				
				if($_FILES['support']['size'] > 500000){
					redirect_back('El archivo excede la capacidad máxima permitida (50 mb)', 'error');
				}
				$path = getcwd();
				
				if ($_FILES['support']['size']!=0) {
					$prefix1 = rand(1, 10000);
					$dir1 = "/public/uploads/".$prefix1.'_'.$_FILES['support']['name'];
					$_POST['support'] = $dir1;
					upload_to_bucket($_FILES['support'], '', $prefix1.'_'. $_FILES['support']['name']);
				}

				if ($_FILES['support1']['size']!=0) {
					$prefix2 = rand(1, 10000);
					$dir2 = "/public/uploads/".$prefix2.'_'. $_FILES['support1']['name'];
					$_POST['support1'] = $dir2;
					upload_to_bucket($_FILES['support1'], '', $prefix2.'_'. $_FILES['support1']['name']);
				}
			
			
			
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
		

		if ($this->model('indicator/values')->delete_by_id($_GET['id']))
		{
			set_notification("Eliminado", 'success', TRUE);
		}
		else
		{
			set_notification("No se pudo eliminar", 'Error');
		}

		redirect("indicator/indicators/graphic_reports?id=".$row_to_update[0]['indicator_id']);
	}
}