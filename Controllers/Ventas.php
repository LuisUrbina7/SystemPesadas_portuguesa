<?php


require './ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;


class Ventas extends Controllers
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



	public function ventas()
	{

		$data['page_id'] = 1;
		$data['page_tag'] = "Ventas";
		$data['page_title'] = "Ventas";
		$data['page_name'] = "Ventas";
		$data['page_data'] = $this->model->getDocument();
		$data['page_functions_js'] = "functions_ventas.js";

		$this->views->getView($this, "ventas", $data);
	}


	public function details()
	{

		$id = !empty($_GET['id']) ? $_GET['id'] : NULL;
		$cl = !empty($_GET['cl']) ? $_GET['cl'] : NULL;


		$parametros = ($id and $cl);

		$data['page_id'] = 1;
		$data['page_tag'] = "Details";
		$data['page_title'] = "Details";
		$data['page_name'] = "Details";
		$data['page_data'] = $parametros ? $this->model->getDetailsImport($cl, $id, $_SESSION['userData']['OPE_AMC_PESADA']) : '';
		$data['page_pdc_numero'] = !isset($data['page_data'][0]['DCL_NUMERO']) ? 'S/R' : $data['page_data'][0]['DCL_NUMERO'];
		$data['page_pdc_status'] = !isset($data['page_data'][0]['DCL_ACTIVO']) ? '0' : $data['page_data'][0]['DCL_ACTIVO'];
		$data['page_clt_codigo'] = !isset($data['page_data'][0]['DCL_CLT_CODIGO']) ? 'S/R' : $data['page_data'][0]['DCL_CLT_CODIGO'];
		$data['page_canastas'] = $this->model->getCanasta();
		$data['page_correlative'] = $this->model->correlativePDA();
		$data['page_clients'] = $this->model->getClients();


		$data['page_functions_js'] = "functions_details_ventas.js";


		$this->views->getView($this, "details", $data);
	}


	public function getWeight()
	{
		//$archivo = 'C:\\Users\\SoporteAdn\\Desktop\\balanza\\log.txt';
		$archivo = 'C:\\xampp\\htdocs\\weight.txt';

		$contenido = file_get_contents($archivo);

		echo json_encode($contenido, JSON_UNESCAPED_UNICODE);
	}


	public function insertDetails()
	{


		if ($_POST) {

			$numero = $_POST['PDA_NUMERO'];

			$amc_origen = $_SESSION['userData']['OPE_AMC_PESADA'];
			//$amc_origen = $_POST['PDA_AMC_ORIGEN'];
			$amc_destino = $_POST['PDA_AMC_DESTINO'];
			$sucursal = $_POST['PDA_SCS_CODIGO'];
			$producto = $_POST['PDA_UPP_PDT_CODIGO'];
			$proveedor = $_POST['PDA_DET_CODIGO'];
			$und = $_POST['PDA_UPP_UND_ID'];
			$canxund = $_POST['PDA_CANXUND'];
			$cantidad = $_POST['PDA_CANTIDAD'];
			$tipoCanasta = $_POST['PDA_CANASTA_TIPO'];
			$canasta = $_POST['PDA_CANASTA'];
			$extra = $_POST['PDA_EXTRA'];
			$ubica = $_POST['PDA_UBICA'];
			$fecha = date('Y-m-d');

			$inicio = $_POST['PDA_FECHA_INICIO'];
			$fin = $_POST['PDA_FECHA_FIN'];
			$llegada = $_POST['PDA_LLEGADA'];

			$tk = $_POST['PDA_TK'];
			$ta = $_POST['PDA_TA'];




			try {


				/*if ($this->model->isTransactionActive()) {
					$this->model->commit();
				}

				$this->model->beginTransaction();*/

				foreach ($cantidad as $index => $data) {
					$insert = $this->model->insertCall($numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad[$index], $canasta[$index], $extra[$index], $ubica[$index], $fecha, $inicio[$index], $fin[$index], $llegada, $tk, $ta, $tipoCanasta[$index]);
				}


				//$this->model->commit();

				$arrResponse = array('status' => true, 'msg' => 'Registrado correctamente.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

				die();
			} catch (Exception $e) {


				//	$this->model->rollBack();
				if ($e->getCode() == 'HY000' && strpos($e->getMessage(), '1205 Lock wait timeout exceeded') !== false) {

					$arrResponse = array('status' => false, 'msg' => 'Procesos en Espera, cortar o esperar al servidor.');
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
					die();
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ' . $e->getMessage());
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
					die();
				}
			}
		} else {

			echo json_encode('Error', JSON_UNESCAPED_UNICODE);

			die();
		}
	}

	public function insertSkip()
	{




		if ($_POST) {

			$numero = $_POST['PDA_NUMERO'];
			$amc_origen = $_POST['PDA_AMC_ORIGEN'];
			$amc_destino = $_POST['PDA_AMC_DESTINO'];
			$sucursal = $_POST['PDA_SCS_CODIGO'];
			$producto = $_POST['PDA_UPP_PDT_CODIGO'];
			$proveedor = $_POST['PDA_DET_CODIGO'];
			$und = $_POST['PDA_UPP_UND_ID'];
			$canxund = $_POST['PDA_CANXUND'];
			$cantidad = $_POST['PDA_CANTIDAD'];

			$tipoCanasta = $_POST['PDA_CANASTA_TIPO'];
			$canasta = $_POST['PDA_CANASTA'];
			$extra = $_POST['PDA_EXTRA'];
			$ubica = $_POST['PDA_UBICA'];
			$fecha = date('Y-m-d');


			$inicio = $_POST['PDA_FECHA_INICIO'];
			$fin = $_POST['PDA_FECHA_FIN'];
			$llegada = $_POST['PDA_LLEGADA'];
			$tk = $_POST['PDA_TK'];
			$ta = $_POST['PDA_TA'];
			$motivo = $_POST['PDA_MOTIVO'];

			$correlative = $this->model->correlative();

			$insert = $this->model->insertSkip($numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $correlative, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta, $motivo);


			if ($insert != 0) {

				$canastaJson = json_decode($tipoCanasta);



				$insertBridge = $this->model->setHeavyBaskets($correlative, $canastaJson->codigo, $canastaJson->cantidad, $insert);
			}



			$arrResponse = array('status' => true, 'msg' => 'Excelente, por favor revisar los datos ');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			die();
		} else {

			echo json_encode('Error', JSON_UNESCAPED_UNICODE);

			die();
		}
	}

	public function content()
	{
		$numero = $_GET['id'];
		$cliente = $_GET['cl'];
		$sku = $_GET['pdt'];

		$contenido = $this->model->getPesadas($numero, $cliente, $sku);

		echo json_encode($contenido, JSON_UNESCAPED_UNICODE);


		die();
	}

	public function updateDetails()
	{


		if ($_POST) {

			$id = $_POST['PDA_ID'];
			$cantidad = $_POST['PDA_CANTIDAD'];


			try {

				$insert = $this->model->updateDetails($id, $cantidad);

				$arrResponse = array('status' => true, 'msg' => 'Registro actualizado correctamente.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

				die();
			} catch (Exception $e) {

				$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ' . $e);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

				die();
			}
		} else {

			echo json_encode('Error', JSON_UNESCAPED_UNICODE);

			die();
		}
	}


	public function delete()
	{

		$codigo = $_GET['id'];
		$cantidad = $_GET['amount'];


		try {
			$estado = $this->model->deletePesadas($codigo, $cantidad);
			$arrResponse = array('status' => true, 'msg' => 'Borrado correctamente.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		} catch (Exception $e) {

			$arrResponse = array('status' => false, 'msg' => 'Error.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	}

	public function getDetailsToEdit()
	{

		if ($_POST) {
			$numero = $_POST['NUMBER'];
			$client = $_POST['CLIENT'];
			$scs = '000001';

			try {

				$validate = $this->model->validateDocument($numero, $client);

				if ($validate) {

					$update = $this->model->updateClose($numero, $client, $scs);

					$arrResponse = array('status' => true, 'msg' => 'Cerrado correctamente.');

					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
					die();
				} else {


					$arrResponse = array('status' => false, 'msg' => 'Error, faltan elementos por pesar para cerrar guia.');

					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
					die();
				}
			} catch (Exception $e) {

				$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ' . $e);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

				die();
			}
		}
	}


	/*public function generatePdf()
	{
		require_once 'vendor/autoload.php';
		$dompdf = new Dompdf\Dompdf();


		$numero = $_GET['id'];
		$codigo = $_GET['pv'];
		$sucursal = $_GET['scs'];



		$data = $this->model->generatePdf($numero, $codigo, $sucursal);


		extract($data);

		ob_start();


		include './Views/Document/pdf.php';
		$html = ob_get_clean();

		$dompdf->loadHtml($html);


		$dompdf->render();

		$pdf_content = $dompdf->output();


		header('Content-Type: application/pdf');
		header('Content-Length: ' . strlen($pdf_content));
		echo $pdf_content;
	}*/

	public function setProducts()
	{

		$numero = $_POST['PMV_PDC_NUMERO'];
		$scs_codigo = $_POST['PMV_PDC_SCS_CODIGO'];
		$pda_det_codigo = $_POST['PMV_PDC_CLT_CODIGO'];
		$upp_pdt_codigo = $_POST['PMV_UPP_PDT_CODIGO'];
		$upp_und_id = $_POST['PMV_UPP_UND_ID'];
		$canxund = $_POST['PMV_CANXUND'];
		$cantidad = $_POST['PMV_CANTIDAD'];
		$tipodoc = $_POST['PMV_PDC_TDT_CODIGO'];


		try {
			$insert = $this->model->setProducts($numero, $scs_codigo, $tipodoc, $pda_det_codigo, $upp_pdt_codigo, $upp_und_id, $canxund, $cantidad);

			$arrResponse = array('status' => true, 'msg' => 'Agregado correctamente');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			die();
		} catch (Exception $e) {
			$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			die();
		}
	}

	public function setDocument()
	{
		$numero = $_GET['id'];
		$cliente = $_GET['cl'];


		try {
			$this->model->setDocument($numero, $cliente);
			$arrResponse = array('status' => true, 'msg' => 'Documento agregado correctamente.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		} catch (Exception $e) {
			$arrResponse = array('status' => false, 'msg' => 'Error, al agregar el documento.' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
	}

	public function cancelDocument()
	{
		$codigo = $_GET['id'];

		try {
			$this->model->cancelDocument($codigo);
			$arrResponse = array('status' => true, 'msg' => 'Documento eliminado correctamente.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		} catch (Exception $e) {
			$arrResponse = array('status' => false, 'msg' => 'Error, al cancelar el documento.' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
	}

	public function saveDocument()
	{
		$codigo = $_GET['id'];
		$cliente = $_GET['cl'];

		try {
			$this->model->updateDocument($codigo, $cliente);
			$arrResponse = array('status' => true, 'msg' => 'Documento guardado correctamente.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		} catch (Exception $e) {
			$arrResponse = array('status' => false, 'msg' => 'Error, al guardar el documento.' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
		}
	}


	public function import()
	{
		$idClient = $_GET['id'];

		try {
			$ped = $this->model->getDoc($idClient);



			echo json_encode($ped, JSON_UNESCAPED_UNICODE);
			die();
		} catch (Exception $e) {
			$arrResponse = array('status' => false, 'msg' => 'Error, al guardar el documento.' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			die();
		}
	}
	public function getdocumentImpor()
	{

		$idClient = $_GET['idClient'];
		$idNumber = $_GET['idNumber'];
		$tipodoc = $_GET['tipodoc'];

		try {
			$mov = $this->model->getDocDetails($idNumber, $tipodoc, $idClient);




			echo json_encode($mov, JSON_UNESCAPED_UNICODE);
			die();
		} catch (Exception $e) {
			$arrResponse = array('status' => false, 'msg' => 'Error, al guardar el documento.' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			die();
		}
	}

	public function insertDetailsImport()
	{

		if ($_POST) {

			$numero = $_POST["PDC_NUMERO"];
			$tipodoc = $_POST["PDC_TDT_CODIGO"];
			$scs = $_POST["PDC_SCS_CODIGO"];
			$clt = $_POST["PDC_CLT_CODIGO"];
			$vnd = $_POST["PDC_VEN_CODIGO"];
			$tdtOrigen = $_POST["PDC_TDT_ORIGEN"];
			$NumberOrigen = $_POST["PDC_NUMERO_ORIGEN"];


			$data = $_POST['PMV_DATA'];
			$fecha = date('Y-m-d');



			try {


				if (empty($data)) {
					$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ');
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

					die();
				}

				$insert = $this->model->insertCallImport($numero, $tipodoc, $scs, $vnd, $clt, $tdtOrigen, $NumberOrigen, $fecha, $data,'2',$_SESSION['userData']['OPE_AMC_PESADA']);

				echo json_encode($insert, JSON_UNESCAPED_UNICODE);

				die();
			} catch (Exception $e) {

				if ($e->getCode() == 'HY000' && strpos($e->getMessage(), '1205 Lock wait timeout exceeded') !== false) {

					$arrResponse = array('status' => false, 'msg' => 'Procesos en Espera, cortar o esperar al servidor.');
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
					die();
				} else {
					$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ' . $e->getMessage());
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
					die();
				}
			}
		} else {

			echo json_encode('Error', JSON_UNESCAPED_UNICODE);

			die();
		}
	}


	public function getProducts()
	{

		$products = $this->model->getProducts();


		echo json_encode($products, JSON_UNESCAPED_UNICODE);
	}

	public function insertDetailsNew()
	{

		if ($_POST) {


			$numero = $_POST["PDC_NUMERO"];
			$tipodoc = $_POST["PDC_TDT_CODIGO"];
			$scs = $_POST["PDC_SCS_CODIGO"];
			$clt = $_POST["PDC_CLT_CODIGO"];
			$vnd = $_POST["PDC_VEN_CODIGO"];



			$data = $_POST['PMV_DATA'];
			$fecha = date('Y-m-d');



			try {


				if (empty($data)) {
					$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ');
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

					die();
				}

				/*	if ($this->model->isTransactionActive()) {
					$this->model->commit();
				}

				$this->model->beginTransaction();*/

				$insert = $this->model->insertCallImport($numero, $tipodoc, $scs, $vnd, $clt, '', '', $fecha, $data, '1', $_SESSION['userData']['OPE_AMC_PESADA']);


				//$this->model->commit();


				echo json_encode($insert, JSON_UNESCAPED_UNICODE);

				die();
			} catch (Exception $e) {

				//	$this->model->rollBack();

				$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los daros ' . $e);
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

				die();
			}
		} else {

			echo json_encode('Error', JSON_UNESCAPED_UNICODE);

			die();
		}
	}

	public function deleteDocument()
	{

		$numero = $_GET['id'];
		$clt = $_GET['clt'];
		$scs = $_GET['scs'];


		try {
			$estado = $this->model->deleteDocument($numero, $clt, $scs);
			$arrResponse = array('status' => true, 'msg' => 'Borrado correctamente.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		} catch (Exception $e) {

			$arrResponse = array('status' => false, 'msg' => 'Error.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	}



	public function generatePdfGeneral()
	{
		require_once 'vendor/autoload.php';
		$dompdf = new Dompdf\Dompdf();

		$numero = $_GET['id'];
		$codigo = $_GET['clt'];
		$sucursal = $_GET['scs'];



		$data['page_data'] = $this->model->generatePdfGeneral($numero, $codigo, $sucursal);

		extract($data);

		ob_start();


		include './Views/Ventas/pdfGeneral.php';
		$html = ob_get_clean();


		$dompdf->loadHtml($html);

		$height = 258;
		$width = 78;
		$type = "portrait";
		$paperFormat = array(0, 0, ($width / 25.4) * 72, ($height / 25.4) * 72);

		$dompdf->setPaper($paperFormat, $type);
		$dompdf->render();

		$pdf_content = $dompdf->output();

		header('Content-Type: application/pdf');
		header('Content-Length: ' . strlen($pdf_content));
		echo $pdf_content;
	}

	public function viewPdf()
	{

		$numero = $_GET['id'];
		$codigo = $_GET['clt'];
		$sucursal = $_GET['scs'];

		$data['page_data'] = $this->model->generatePdf($numero, $codigo, $sucursal);

		$data['page_functions_js'] = "functions_document.js";

		$this->views->getView($this, "captura", $data);
	}

	public function generatePdf()
	{
		require_once 'vendor/autoload.php';
		$dompdf = new Dompdf\Dompdf();

		$numero = $_GET['id'];
		$codigo = $_GET['clt'];
		$sucursal = $_GET['scs'];
		$height = $_GET['height'];


		$data['page_data'] = $this->model->generatePdf($numero, $codigo, $sucursal);


		extract($data);

		ob_start();


		include './Views/Ventas/pdf.php';
		$html = ob_get_clean();


		$dompdf->loadHtml($html);

		$width = 78;
		$type = "portrait";
		$paperFormat = array(0, 0, ($width / 25.4) * 72, $height);

		$dompdf->setPaper($paperFormat, $type);
		$dompdf->render();

		$pdf_content = $dompdf->output();

		header('Content-Type: application/pdf');
		header('Content-Length: ' . strlen($pdf_content));
		echo $pdf_content;
	}

	function viewPdfDetailsPesada()
	{

		$numero = $_GET['id'];
		$codigo = $_GET['clt'];
		$producto = $_GET['pdt'];



		$data['page_data'] = $this->model->generatePdfDetallPesada($numero, $codigo, $producto);

		$data['page_functions_js'] = "functions_document.js";

		$this->views->getView($this, "capturaDetallPesada", $data);
	}




	public function generatePdfDetailsPesada()
	{
		require_once 'vendor/autoload.php';
		$dompdf = new Dompdf\Dompdf();

		$numero = $_GET['id'];
		$codigo = $_GET['clt'];
		$producto = $_GET['pdt'];
		$height = $_GET['height'];

		$data['page_data'] = $this->model->generatePdfDetallPesada($numero, $codigo, $producto);

		extract($data);

		ob_start();


		include './Views/Ventas/pdfDetallPesada.php';

		$html = ob_get_clean();


		$dompdf->loadHtml($html);


		$width = 78;
		$type = "portrait";
		$paperFormat = array(0, 0, ($width / 25.4) * 72, $height);

		$dompdf->setPaper($paperFormat, $type);
		$dompdf->render();

		$pdf_content = $dompdf->output();

		header('Content-Type: application/pdf');
		header('Content-Length: ' . strlen($pdf_content));
		echo $pdf_content;
	}


	function cut()
	{
		try {

			$Lotes = $this->model->cut();

			$arrResponse = array('status' => true, 'msg' => 'Excelente, procesos cortados.');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		} catch (Exception $e) {

			$arrResponse = array('status' => false, 'msg' => 'Error, procesos no cortados ' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			die();
		}
	}

	public function ticket()
	{
		$dclNumero = $_GET['id'];
		$cliente = $_GET['clt'];
		$sucursal = $_GET['scs'];

		$arrData = $this->model->generatePdf($dclNumero, $cliente, $sucursal);

		try {

			if (!empty($arrData)) {
				$nombre_impresora = RAIZ_IMPRESORA;
				$connector = new WindowsPrintConnector($nombre_impresora);
				$printer = new Printer($connector);

				/*Header and Company Information */
				$printer->initialize();
				$printer->setTextSize(1, 1);
				$printer->setLineSpacing(2);  // Adjust line spacing if needed
				$printer->setJustification(Printer::JUSTIFY_CENTER);


				$printer->text($arrData[0]['EMP_NOMBRE'] . "\n", "C");
				$printer->text($arrData[0]['EMP_RIF'] . "\n", "C");
				$printer->text($arrData[0]['EMP_DIRECCION1'] . "\n", "C");
				$printer->feed(1);

				$printer->text("_______________________________________________" . "\n", "C");
				$printer->setJustification(Printer::JUSTIFY_LEFT);
				$printer->text("Telefono: " . $arrData[0]['EMP_TELEFONO1'] . "\n", "C");
				$printer->text("Email: " . $arrData[0]['EMP_EMAIL'] . "\n", "C");
				$printer->text("Numero Pesada: " . $arrData[0]['PDA_NUMERO'] . "\n", "C");
				$printer->text("Cliente: " . $arrData[0]['CLT_NOMBRE'] . "\n", "C");
				$printer->text("Fecha: " . $arrData[0]['PDA_FECHA'] . "\n", "C");
				$printer->text("_______________________________________________" . "\n", "C");


				foreach ($arrData as $indice => $value) {

					$printer->text("_______________________________________________" . "\n", "C");
					$printer->text("Codigo producto: " . $value['PDA_UPP_PDT_CODIGO'] . "\n");
					$printer->text("_______________________________________________" . "\n", "C");
					$printer->text("Descripcion: " . $value['PDT_DESCRIPCION'] . "\n");
					$printer->text("UNIDAD:  " . $value['PDA_UPP_UND_ID'] . "\n");
					$printer->text("RECIBIDO:  " . $value['CAJAS'] . "\n");
					$printer->text("RECIBIDO (BRUTO):  " . $value['KG_UND'] . "\n");
					$printer->text("EXTRA:  " . $value['EXTRA'] . "\n");
					$printer->text("NETO:  " . $value['NETO_MENOS_EXTRA'] . "\n");

					$l = 1;
					$arrayCanastas = explode(',', $value['CANASTAS']);

					for ($i = 0; $i < count($arrayCanastas) - 3; $i += 3) {
						$printer->text("TARAS (L" . $l . "): " . str_replace("\n", "", $arrayCanastas[$i] . "," . $arrayCanastas[$i + 1] . "," . $arrayCanastas[$i + 2]) . "\n");
						$l++;
					}

					$printer->setJustification(Printer::JUSTIFY_LEFT);
					$printer->text("HORA INICIO:  " . $value['INICIO'] . "\n");
					$printer->text("HORA FIN: " . $value['FIN'] . "\n");
					$printer->text("DURACION:  " . $value['DURACION'] . "\n");
					$printer->text("_______________________________________________" . "\n", "C");
				}

				$printer->feed(2);

				$printer->cut();

				$printer->close();

				$arrResponse = array('status' => true, 'msg' => 'Se envio la impresion!');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No hay data para imprimir!');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}
		} catch (Exception $e) {
			$arrResponse = array('status' => false, 'msg' => 'No esta conectada la impresora o no se reconoce!');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	}


	public function ticketGeneral()
	{
		$dclNumero = $_GET['id'];
		$cliente = $_GET['clt'];
		$sucursal = $_GET['scs'];

		$arrData = $this->model->generatePdfGeneral($dclNumero, $cliente, $sucursal);

		try {

			if (!empty($arrData)) {
				$nombre_impresora = RAIZ_IMPRESORA;
				$connector = new WindowsPrintConnector($nombre_impresora);
				$printer = new Printer($connector);

				/*Header and Company Information */
				$printer->initialize();
				$printer->setTextSize(1, 1);
				$printer->setLineSpacing(2);  // Adjust line spacing if needed
				$printer->setJustification(Printer::JUSTIFY_CENTER);

				$printer->text($arrData[0]['EMP_NOMBRE'] . "\n", "C");
				$printer->text($arrData[0]['EMP_RIF'] . "\n", "C");
				$printer->text($arrData[0]['EMP_DIRECCION1'] . "\n", "C");
				$printer->feed(1);

				$printer->text("_______________________________________________" . "\n", "C");
				$printer->setJustification(Printer::JUSTIFY_LEFT);
				$printer->text("Telefono: " . $arrData[0]['EMP_TELEFONO1'] . "\n", "C");
				$printer->text("Email: " . $arrData[0]['EMP_EMAIL'] . "\n", "C");
				$printer->text("Numero Pesada: " . $arrData[0]['PDA_NUMERO'] . "\n", "C");
				$printer->text("Cliente: " . $arrData[0]['CLT_NOMBRE'] . "\n", "C");
				$printer->text("Fecha: " . $arrData[0]['PDA_FECHA'] . "\n", "C");
				$printer->text("_______________________________________________" . "\n", "C");

				$printer->text("TermoK:  " . $arrData[0]['PDA_TK'] . "\n");
				$printer->text("TermoP:  " . $arrData[0]['PDA_TA'] . "\n");


				foreach ($arrData as $value) {

					$printer->text("_______________________________________________" . "\n", "C");
					$printer->text("CAJAS:  " . $value['CAJAS'] . "\n");
					$printer->text("KG | UND (BRUTO):  " . $value['KG_UND'] . "\n");
					$printer->text("EXTRA: " . $value['EXTRA'] . "\n");
					$printer->text("TARAS: " . $value['TARAS'] . "\n");
					$printer->text("NETO:  " . $value['BRUTO'] . "\n");

					$printer->setJustification(Printer::JUSTIFY_LEFT);
					$printer->text("HORA INICIO:  " . $value['INICIO'] . "\n");
					$printer->text("HORA FIN: " . $value['FIN'] . "\n");
					$printer->text("DURACION:  " . $value['DURACION'] . "\n");
					$printer->text("_______________________________________________" . "\n", "C");
				}

				$printer->feed(2);

				$printer->cut();

				$printer->close();

				$arrResponse = array('status' => true, 'msg' => 'Se envio la impresion!');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No hay data para imprimir!');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}
		} catch (Exception $e) {
			$arrResponse = array('status' => false, 'msg' => 'No esta conectada la impresora o no se reconoce!');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	}



	public function ticketByHeavy()
	{
		$dclNumero = $_GET['id'];
		$cliente = $_GET['clt'];
		$producto = $_GET['pdt'];

		$arrData = $this->model->generatePdfDetallPesada($dclNumero, $cliente, $producto);

		try {

			if (!empty($arrData)) {
				$nombre_impresora = RAIZ_IMPRESORA;
				$connector = new WindowsPrintConnector($nombre_impresora);
				$printer = new Printer($connector);

				/*Header and Company Information */
				$printer->initialize();
				$printer->setTextSize(1, 1);
				$printer->setLineSpacing(2);  // Adjust line spacing if needed
				$printer->setJustification(Printer::JUSTIFY_CENTER);

				$printer->text($arrData[0]['EMP_NOMBRE'] . "\n", "C");
				$printer->text($arrData[0]['EMP_RIF'] . "\n", "C");
				$printer->text($arrData[0]['EMP_DIRECCION1'] . "\n", "C");
				$printer->feed(1);

				$printer->text("_______________________________________________" . "\n", "C");
				$printer->setJustification(Printer::JUSTIFY_LEFT);
				$printer->text("Telefono: " . $arrData[0]['EMP_TELEFONO1'] . "\n", "C");
				$printer->text("Email: " . $arrData[0]['EMP_EMAIL'] . "\n", "C");
				$printer->text("Cliente: " . $arrData[0]['CLT_NOMBRE'] . "\n", "C");
				$printer->text("Fecha: " . $arrData[0]['PDA_FECHA'] . "\n", "C");
				$printer->text("Operador: " . $arrData[0]['OPE_NOMBRE'] . "\n", "C");
				$printer->text("_______________________________________________" . "\n", "C");

				$printer->text("Termok:  " . $arrData[0]['PDA_TK'] . "\n");
				$printer->text("Termop:  " . $arrData[0]['PDA_TA'] . "\n");



				$printer->text("_______________________________________________" . "\n", "C");

				$printer->text("CODIGO PRODUCTO:  " . $arrData[0]['PDA_UPP_PDT_CODIGO'] . "\n");
				$printer->text("BRUTO: " . $arrData[0]['BRUTO'] . "\n");
				$printer->text("EXTRA: " . $arrData[0]['EXTRA'] . "\n");
				$printer->text("UNIDAD:  " . $arrData[0]['PDA_UPP_UND_ID'] . "\n");
				$printer->text("NETO:  " . $arrData[0]['NETO'] . "\n");

				$printer->text("_______________________________________________" . "\n", "C");
				foreach ($arrData as $value) {

					$printer->setJustification(Printer::JUSTIFY_LEFT);
					$printer->text("BRUTO:  " . $value['PDA_CANTIDAD'] . "\n");
					$printer->text("EXTRA:  " . $value['PDA_EXTRA'] . "\n");
					$printer->text("CAJAS:  " . $value['CAJAS'] . "\n");
					$printer->text("UND | KG (NETO):  " . $value['KG_UND'] . "\n");
					$printer->text("TARAS: " . $value['TARAS'] . "\n");
					$printer->text("HORA INICIO:  " . $value['PDA_INICIO'] . "\n");
					$printer->text("HORA FIN:  " . $value['PDA_FIN'] . "\n");

					$printer->text("_______________________________________________" . "\n", "C");
				}

				$printer->feed(2);

				$printer->cut();

				$printer->close();

				$arrResponse = array('status' => true, 'msg' => 'Se envio la impresion!');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			} else {
				$arrResponse = array('status' => false, 'msg' => 'No hay data para imprimir!');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}
		} catch (Exception $e) {
			$arrResponse = array('status' => false, 'msg' => 'No esta conectada la impresora o no se reconoce!');
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		}
	}
}
