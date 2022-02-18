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

}

?>