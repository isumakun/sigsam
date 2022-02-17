<?php defined('UMVC') OR exit('No direct script access allowed');

class Controller extends ControllerBase {

/*----------------------------------------------------------------------
	JSON FOR DATAGRID
----------------------------------------------------------------------*/
	public function json_table_grid()
	{
		$model = $_POST['model'];
		$method = $_POST['method'];

		if ($_SESSION['user']['id'] AND isset($_POST['model']) AND isset($_POST['method']))
		{
			if ($_POST['params'])
			{
				$params = explode(',', $_POST['params']);
				switch (count($params))
				{
					case 1:
						$data = array("data" => $this->model($model)->$method(
							$params[0]
						));
						break;

					case 2:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1]
						));
						break;

					case 3:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1],
							$params[2]
						));
						break;

					case 4:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1],
							$params[2],
							$params[3]
						));
						break;

					case 5:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1],
							$params[2],
							$params[3],
							$params[4]
						));
						break;

					case 6:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1],
							$params[2],
							$params[3],
							$params[4],
							$params[5]
						));
						break;

				}
			}
			else
			{
				$data = array("data" => $this->model($model)->$method());
			}

			echo json_encode($data);
		}
		else
		{
			die('No direct access allowed');
		}
	}

/*----------------------------------------------------------------------
	JSON FOR DATAGRID
----------------------------------------------------------------------*/
	public function json_session()
	{
		$model = $_SESSION['umvc']['json']['model'];
		$method = $_SESSION['umvc']['json']['method'];
		$params = $_SESSION['umvc']['json']['params'];

		unset($_SESSION['umvc']['json']);

		if ($_SESSION['user']['id'] AND $model AND $method)
		{
			if ($params)
			{
				$params = explode(',', $params);
				switch (count($params))
				{
					case 1:
						$data = array("data" => $this->model($model)->$method(
							$params[0]
						));
						break;

					case 2:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1]
						));
						break;

					case 3:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1],
							$params[2]
						));
						break;

					case 4:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1],
							$params[2],
							$params[3]
						));
						break;

					case 5:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1],
							$params[2],
							$params[3],
							$params[4]
						));
						break;

					case 6:
						$data = array("data" => $this->model($model)->$method(
							$params[0],
							$params[1],
							$params[2],
							$params[3],
							$params[4],
							$params[5]
						));
						break;

				}
			}
			else
			{
				$data = array("data" => $this->model($model)->$method());
			}

			echo json_encode($data);
		}
		else
		{
			die('No direct access allowed');
		}
	}


/*----------------------------------------------------------------------
	COMMAND
	TEST:
		http://localhost/dhr4/umvc/tools/command?cmd=e.85154472

	TODO:
		Trazabilidad a un producto -> tp
		Trazabilidad a un FMM-I -> tfi
		Trazabilidad a un FMM-S -> tfs

----------------------------------------------------------------------*/
	public function command()
	{
		if ($_POST)
		{
			$cmd = explode('.', $_POST['cmd']);

			switch ($cmd[0])
			{
				// SALIDAS ---------------------------------------------
				//	> Abrir
				case 'i':
					redirect("tbs/input_forms/details?id={$cmd[1]}");
					break;

				//	> Imprimir
				case 'ii':
					redirect("tbs/input_forms/printout?id={$cmd[1]}");
					break;

				// FMM - SALIDAS ---------------------------------------
				//	> Abrir
				case 's':
					redirect("tbs/output_forms/details?id={$cmd[1]}");
					break;

				//	> Imprimir
				case 'is':
					redirect("tbs/output_forms/printout?id={$cmd[1]}");
					break;
			}
		}

		redirect_back('El comando ingresado no existe.', 'error');
	}
}
