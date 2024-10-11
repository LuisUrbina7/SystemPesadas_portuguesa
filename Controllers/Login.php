<?php

require_once('Models/RegisterModel.php');

class Login extends Controllers
{
	public function __construct()
	{
		if (isset($_SESSION['login'])) {
			header('Location: ' . base_url() . '/home');
		}
		parent::__construct();
	}

	public function login()
	{
		$data['page_tag'] = "Login";
		$data['page_title'] = "Login";
		$data['page_name'] = "login";
		$data['page_functions_js'] = "functions_login.js";
		$this->views->getView($this, "login", $data);
	}


	public function forgot_password()
	{
		$data['page_tag'] = "Login ADNmovil";
		$data['page_title'] = "Login ADNmovil";
		$data['page_name'] = "login";
		$data['page_functions_js'] = "functions_login.js";
		$this->views->getView($this, "forgot_password", $data);
	}


	public function reset_password(string $params)
	{

		if (empty($params)) {
			header('Location:' . base_url());
		} else {
			$arrParams = explode(',', $params);
			$email = strClean($arrParams[0]);
			$token = strClean($arrParams[1]);

			$arrResponse = $this->model->getUsuarioByToken($email, $token);

			//dep($arrResponse);die();

			if (empty($arrResponse)) {
				header('Location:' . base_url());
			} else {

				$data['page_tag'] = "Login ADNmovil";
				$data['page_title'] = "Login ADNmovil";
				$data['page_name'] = "login";
				$data['page_functions_js'] = "functions_login.js";
				$data['idUser'] = $arrResponse['id'];
				$data['token'] = $token;
				$data['email'] = $email;
				$this->views->getView($this, "reset_password", $data);
			}
		}
		die();
	}

	public function loginUser()
	{


		if ($_POST) {

			if (empty($_POST['email']) || empty($_POST['password'])) {
				$arrResponse = array('status' => false, 'msg' => 'Usuario o Contraseña requerido.');
			} else {
				$email  =  strtolower(strClean($_POST['email']));
				//$password = hash('SHA256', $_POST['password']);
				$password = $_POST['password'];
				$requestUser = $this->model->loginUser($email, $password);


				


				if (!empty($requestUser) &&  $requestUser != 'errorPassword') {
					
					$_SESSION['idUser'] = $requestUser['OPE_NUMERO'];
					$_SESSION['login'] = true;
					$arrData = $this->model->sessionLogin($_SESSION['idUser']);
					

					
					
					$arrResponse = array('status' => true, 'msg' => 'Logueado correctamente.');
				//	$output = shell_exec('cmd /c "C:\xampp\htdocs\SystemPesadas\Balanza.bat"');
					
				} else {


					$arrResponse = array('status' => false, 'msg' => 'Error en contraseña.');
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}

	public function resetPass()
	{

		error_reporting(0);

		if ($_POST) {

			if (empty($_POST['emailReset'])) {
				$arrResponse = array('status' => false, 'msg' => 'Error de datos');
			} else {
				$token = token();
				$strEmail  =  strtolower(strClean($_POST['emailReset']));
				//$arrData = $this->model->getUserEmail($strEmail);



				$arrData = $this->model->getEmail($strEmail);

				if (empty($arrData)) {


					$arrResponse = array('status' => false, 'msg' => 'Usuario no existente.');
				} else {

					$json = $this->getUserWispshub();
					$data = json_decode($json);
					$result = $data->results;
					$user = NULL;
					$newEmail = NULL;

					foreach ($result as $resuls) {
						if ($resuls->cedula == $strEmail || $resuls->email == $strEmail) {

							$newEmail = $resuls->email == '' ? 'example@gmail.com' : $resuls->email;
							$user = $resuls->cedula;
							break;
						}
					}
					$register = new RegisterModel();

					$arrData = $register->updateUserEmail($user, $newEmail);

					$id = $arrData['id'];
					$nombreUsuario = $arrData['name'];
					$strEmail = $arrData['email'];

					$url_recovery = base_url() . '/login/reset_password/' . $strEmail . '/' . $token;
					$requestUpdate = $this->model->setTokenUser($id, $token);

					//dep($requestUpdate);die();

					if ($strEmail == '' || $strEmail == null) {

						$arrResponse = array('status' => false, 'msg' => 'Usuario sin Email');

						echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

						die();
					}

					$dataUsuario = array(
						'nombreUsuario' => $nombreUsuario,
						'email' => $strEmail,
						'asunto' => 'Recuperar cuenta - ' . NOMBRE_REMITENTE,
						'url_recovery' => $url_recovery
					);

					if ($requestUpdate) {
						$sendEmail = sendEmail($dataUsuario, 'email_cambioPassword');

						if ($sendEmail) {
							$arrResponse = array(
								'status' => true,
								'msg' => 'Se ha enviado un email a tu cuenta de correo para cambiar tu contraseña.'
							);
						} else {
							$arrResponse = array(
								'status' => false,
								'msg' => 'No es posible realizar el proceso, intenta más tarde.'
							);
						}
					} else {
						$arrResponse = array(
							'status' => false,
							'msg' => 'No es posible realizar el proceso, intenta más tarde.'
						);
					}
				}
			}
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
		die();
	}



	public function setPassword()
	{

		//dep($_POST);die();

		if (empty($_POST['idUser']) || empty($_POST['newPassword']) || empty($_POST['token']) || empty($_POST['confirmPassword'])) {

			$arrResponse = array(
				'status' => false,
				'msg' => 'Error de datos'
			);
		} else {
			$intIdpersona = intval($_POST['idUser']);
			$strPassword = $_POST['newPassword'];
			$strPasswordConfirm = $_POST['confirmPassword'];
			$strEmail = strClean($_POST['email']);
			$strToken = strClean($_POST['token']);

			if ($strPassword != $strPasswordConfirm) {
				$arrResponse = array(
					'status' => false,
					'msg' => 'Las contraseñas no son iguales.'
				);
			} else {
				$arrResponseUser = $this->model->getUsuarioByToken($strEmail, $strToken);
				if (empty($arrResponseUser)) {
					$arrResponse = array(
						'status' => false,
						'msg' => 'Erro de datos.'
					);
				} else {
					$strPassword = hash("SHA256", $strPassword);
					$requestPass = $this->model->updatePassword($intIdpersona, $strPassword);

					if ($requestPass) {
						$arrResponse = array(
							'status' => true,
							'msg' => 'Contraseña actualizada con éxito.'
						);
					} else {
						$arrResponse = array(
							'status' => false,
							'msg' => 'No es posible realizar el proceso, intente más tarde.'
						);
					}
				}
			}
		}
		echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		die();
	}




}
