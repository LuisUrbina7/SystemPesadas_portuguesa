<?php


class Canastas extends Controllers
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

	public function canastas()
	{

		$data['page_id'] = 1;
		$data['page_tag'] = "Canastas";
		$data['page_title'] = "CRUD de canastas!";
		$data['page_name'] = "Canastas";
        $data['page_data'] = $this->model->get_canastas();
		$data['page_functions_js'] = "functions_canastas.js";
		$this->views->getView($this, "canastas", $data);
	}


    public function view_create_canasta()
	{
		$coorelativo = strval(!empty($this->model->get_coorelativo()['COORELATIVO']) ? $this->model->get_coorelativo()['COORELATIVO'] : '0001');
		$data['page_id'] = 1;
		$data['page_tag'] = "Crear Canastas";
		$data['page_title'] = "Crear canastas!";
		$data['page_name'] = "Crear Canastas";
        $data['page_data'] = ['COORELATIVO' => $coorelativo];
		$data['page_functions_js'] = "functions_canastas.js";
		$this->views->getView($this, "create_canastas", $data);
		
	}


	public function insert_canasta()
	{

		if($_POST){
			$codigo = $_POST['CTA_CODIGO'];
			$descripcion = $_POST['CTA_DESCRIPCION'];
			$equivalencia = $_POST['CTA_EQUIVALENCIA'];

			try{
				$response = $this->model->create_canasta($codigo, $descripcion, $equivalencia); 
				$arrResponse = array('status' => true, 'msg' => 'Correcto.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			} catch (Exception $e){
				$arrResponse = array('status' => false, 'msg' => 'Hubo un error.'.$e);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}

			
		}
		
	}

    public function view_update_canasta()
	{
		$canasta = !empty($_GET['canasta']) ? $_GET['canasta'] : '';
		$data['page_id'] = 1;
		$data['page_tag'] = "Editar Canastas";
		$data['page_title'] = "Editar canastas!";
		$data['page_name'] = "Editar Canastas";
        $data['page_data'] = $this->model->get_one_canasta($canasta);
		$data['page_functions_js'] = "functions_canastas.js";
		$this->views->getView($this, "update_canastas", $data);
		
	}


	public function update_canastas()
	{
	
		
		if($_POST){
			$codigo = $_POST['CTA_CODIGO'];
			$descripcion = $_POST['CTA_DESCRIPCION'];
			$equivalencia = $_POST['CTA_EQUIVALENCIA'];
			$activo = $_POST['CTA_ACTIVO'];
			
			try{
				$response = $this->model->update_canasta($codigo, $descripcion, $equivalencia, $activo); 
				$arrResponse = array('status' => true, 'msg' => 'Correcto.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			} catch (Exception $e){
				$arrResponse = array('status' => false, 'msg' => 'Hubo un error.'.$e);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}

			
		}
	
		
	}

    public function delete_canasta()
	{
		if($_POST){
			$codigo = $_POST['CTA_CODIGO'];

			try{
				$response = $this->model->delete_canasta($codigo); 
				$arrResponse = array('status' => true, 'msg' => 'Elimino correctamente.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			} catch (Exception $e){
				$arrResponse = array('status' => false, 'msg' => 'No funciono.'.$e);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}

			
		}
		
	}

}
