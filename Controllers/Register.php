<?php 

session_start();

class Register extends Controllers{
	public function __construct()
	{
		if(isset($_SESSION['login']))
		{
			header('Location: '.base_url().'/Home');
		}
		parent::__construct();
	}

	public function register()
	{
		$data['page_tag'] = "Register ANP";
		$data['page_title'] = "Register ANP";
		$data['page_name'] = "register";
		$data['page_functions_js'] = "functions_register.js";
		$this->views->getView($this,"register",$data);
	}

	public function registerUser(){
		
		//dep($_POST);die();
		
		if($_POST){	

				if(empty($_POST['firstName']) || empty($_POST['lastName']) ||  empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password']) )
				{
					$arrResponse = array("status" => false, "msg" => 'All fiels are required.');
				}else{ 
					
					$firstName = strClean($_POST['firstName']);
					$lastName = strClean($_POST['lastName']);
					$email = strClean($_POST['email']);
					$username = strClean($_POST['username']);


					$strPassword =  empty($_POST['password']) ? hash("SHA256",passGenerator()) : hash("SHA256",$_POST['password']);

					$request_user = $this->model->insertUser($firstName,
															 $lastName, 
															 $email,
															 $username,
															 $strPassword);
					
					//dep($request_user);die();

					if(!empty($request_user) && $request_user != 'exist') 
					{
						$arrResponse = array('status' => true, 'msg' => 'ok');

					}else if($request_user == 'exist'){
						$arrResponse = array('status' => false, 'msg' => 'Attention! the email or username already exists.');		
					}else{
						$arrResponse = array("status" => false, "msg" => 'It is not possible to store the data.');
					}
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();

	}

}
?>