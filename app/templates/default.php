<?php defined('UMVC') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="">
	<meta name="author" content="">

	<title>SAM - Indicadores SIG</title>

	<!-- UMVC CSS -->
	<link href="<?=BASE_URL?>public/assets/css/umvc002.css" rel="stylesheet">
	<link href="<?=BASE_URL?>public/assets/css/project.css" rel="stylesheet">
	<link href="<?=BASE_URL?>public/assets/images/dhr.png" rel="shortcut icon" type="image/png">
	<link href="<?=BASE_URL.'public/vendors/select2-4.0.3/dist/css/select2.css'?>" rel="stylesheet">
	<link rel="stylesheet" href="<?=BASE_URL?>public/assets/css/fontawesome/css/all.css">

	<!-- ADMIN CSS -->
	<!-- Icons-->
    <link href="<?=BASE_URL?>public/assets/admin/vendors/coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
	<link href="<?=BASE_URL?>public/assets/admin/vendors/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
	<link href="<?=BASE_URL?>public/assets/admin/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
	<link href="<?=BASE_URL?>public/assets/admin/vendors/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

	<link href="<?=BASE_URL?>public/assets/admin/css/style.css" rel="stylesheet">
	
	<link href="<?=BASE_URL?>public/assets/admin/vendors/pace-progress/css/pace.min.css" rel="stylesheet">

	<!-- UMVC JS -->
	<script src="<?=BASE_URL?>public/assets/js/umvc002.js"></script>
	<script src="<?=BASE_URL?>public/assets/js/project.js"></script>
	<script src="<?=BASE_URL?>public/assets/js/respond.min.js"></script>
	<script src="<?=BASE_URL.'public/vendors/select2-4.0.3/dist/js/select2.min.js'?>"></script>
	<script src="<?=BASE_URL.'public/vendors/push/serviceWorker.min.js'?>"></script>
	<script src="<?=BASE_URL.'public/vendors/push/push.min.js'?>"></script>

	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

	

</head>
<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
<?php require 'header.php'; ?>

<main class="main">
	<div class="container-fluid w60 container_adept">
		<div id="main_content" class="content shadow-6">
			<div class="card card-default">
				<div class="card-body">
					<?php require 'app/mvc/'.$_SESSION['prefix'].'/'.strtolower($_SESSION['controller']).'/views/'.strtolower($_SESSION['method']).'.php'; ?>
				</div>
			</div>
		</div>
	</div>
</main>
     <?php require 'right_panel.php' ?>
</body>

	<script src="<?=BASE_URL?>public/assets/admin/vendors/popper.js/js/popper.min.js"></script>
	<script src="<?=BASE_URL?>public/assets/admin/vendors/bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=BASE_URL?>public/assets/admin/vendors/pace-progress/js/pace.min.js"></script>
	<script src="<?=BASE_URL?>public/assets/admin/vendors/perfect-scrollbar/js/perfect-scrollbar.min.js"></script>
	<script src="<?=BASE_URL?>public/assets/admin/vendors/coreui/coreui-pro/js/coreui.min.js"></script>


<?php require 'main_scripts.php' ?>
<?php
	$_SESSION['notifications'] = array();
 ?>
</html>