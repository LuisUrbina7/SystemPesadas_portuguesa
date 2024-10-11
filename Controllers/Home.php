<?php


class Home extends Controllers
{
	public function __construct()
	{
		parent::__construct();
		//session_regenerate_id(true);
		if (empty($_SESSION['login'])) {
			header('Location: ' . base_url() . '/login');
		}

		getPermisos(1);

		
	}

	public function home()
	{

		$data['page_id'] = 1;
		$data['page_tag'] = "Home";
		$data['page_title'] = "Main Page";
		$data['page_name'] = "home";
		//$data['rate'] = show_rate();
		$data['page_functions_js'] = "functions_home.js";
		$data['page_data_total'] = $this->getInfo();
		$data['page_data_byTransfer'] = $this->byTransfer();

		$this->views->getView($this, "home", $data);
	}


	public function getInfo()
	{

		return $this->model->getInfo();
	}

	public function byTransfer()
	{

		return $this->model->byTransfer();
	}
	public function graph()
	{

		$data = $this->model->graph();

		echo json_encode($data,JSON_UNESCAPED_UNICODE);
	}
}
