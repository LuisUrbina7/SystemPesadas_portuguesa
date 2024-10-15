<?php

require './ticket/autoload.php'; //Nota: si renombraste la carpeta a algo diferente de "ticket" cambia el nombre en esta línea
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class PedidosPollo extends Controllers
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



	public function document()
	{

		$data['page_id'] = 1;
		$data['page_tag'] = "Document";
		$data['page_title'] = "Document";
		$data['page_name'] = "Document";
		$data['page_data'] = $this->model->getDocument();

		$data['page_functions_js'] = "functions_pedidos_pollo.js";
		
	
		
		$this->views->getView($this, "document", $data);
	}

	public function details()
	{


		
		$data['page_id'] = 1;
		$data['page_tag'] = "Details";
		$data['page_title'] = "Details";
		$data['page_name'] = "Details";
		$data['page_data'] = $this->model->getDetails($_GET['id'], $_GET['vd'], $_SESSION['userData']['OPE_AMC_PESADA']);

		$data['page_dcl_numero'] = !isset($_GET['id']) ? 'S/R' : $_GET['id'];
		$data['page_ven_codigo'] = !isset($_GET['vd']) ? 'S/R' : $_GET['vd'];
		$data['page_ind'] = !isset($_GET['ind']) ? '0' : $_GET['ind'];
		$data['page_canastas'] = $this->model->getCanasta();
		$data['page_amc'] = $this->model->getAmc();


		$data['page_functions_js'] = "functions_details_pedidos_pollo.js";


		$this->views->getView($this, "details", $data);
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




				foreach ($cantidad as $index => $data) {

					$insert = $this->model->insertCall($numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad[$index], $canasta[$index], $extra[$index], $ubica[$index], $fecha, $inicio[$index], $fin[$index], $llegada, $tk, $ta, $tipoCanasta[$index]);
				}


				$arrResponse = array('status' => true, 'msg' => 'Registrado correctamente.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

				die();
			} catch (Exception $e) {

				// $this->model->rollBack();

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
		$proveedor = $_GET['vd'];
		$sku = $_GET['pdt'];


		$contenido = $this->model->getPesadas($numero, $proveedor, $sku);

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




		try {
			$estado = $this->model->deletePesadas($codigo);
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
			$transportista = $_POST['PROVIDER'];

			try {

				$validate = $this->model->validateDocumento($numero, $transportista);

				if ($validate) {

					$update = $this->model->updateGuide($numero, $transportista);

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



	public function activeTrans()
	{

		$numero = $_GET['id'];
		$trans = $_GET['vd'];


		try {

			$search = $this->model->searchPesada($numero, $trans);

			if (isset($search['PDA_AMC_ORIGEN'])) {


				$origen_amc  = $search['PDA_AMC_ORIGEN'];
				$destino_amc  = $search['PDA_AMC_DESTINO'];
				$sucursal  = $search['PDA_SCS_CODIGO'];

				try {

					if ($trans == '052') {

						$trans = $this->model->callSpecialImport($trans, $numero, $sucursal);

						$arrResponse = array('status' => true, 'msg' => 'Importación realizada con Éxito.');

						echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
						die();
					} else {

						$trans = $this->model->callTrans($numero, $trans, $origen_amc, $destino_amc, $sucursal);

						//$output = exec('C:\\ADN Software\\ADN.exe SINCRO-4-0-adn-1');

						//$output = shell_exec('cmd /c "C:\\xampp\\htdocs\\SystemPesadas\\Productos.bat"');

						//$output = shell_exec('start /B C:\\ADN Software\\ADN.exe SINCRO-4-0-adn-1 > NUL');

						$arrResponse = array('status' => true, 'msg' => 'Transferido correctamente.');

						echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
						die();
					}
				} catch (Exception $e) {

					$arrResponse = array('status' => false, 'msg' => 'Error en el procedimiento.');
					echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
					die();
				}
			} else {

				$arrResponse = array('status' => false, 'msg' => 'No posee pesadas.');
				echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
				die();
			}
		} catch (Exception $e) {

			$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			die();
		}
	}

	public function viewPdf()
	{

		$numero = $_GET['id'];
		$codigo = $_GET['pv'];
		$sucursal = $_GET['scs'];

		$data['page_data'] = $this->model->generatePdf($numero, $codigo);

		$data['page_functions_js'] = "functions_document.js";

		$this->views->getView($this, "captura", $data);
	}


	public function generatePdf()
	{
		require_once 'vendor/autoload.php';
		$dompdf = new Dompdf\Dompdf();


		$numero = $_GET['id'];
		$codigo = $_GET['pv'];
		$height = $_GET['height'];



		$data['page_data'] = $this->model->generatePdf($numero, $codigo);


		extract($data);

		ob_start();


		include './Views/DocumentGuia/pdf.php';
		$html = ob_get_clean();

		$dompdf->loadHtml($html);


		$width = 80;

		$type = "portrait";
		//dep($height);
		$width_mm = 75; // ancho en milímetros
		$height_mm = 400; // altura en milímetros

		$width_points = ($width_mm / 25.4) * 72; // conversión a puntos
		$height_points = ($height_mm / 25.4) * 72; // conversión a puntos

		$paperFormat = array(0, 0, $width_points, $height_points);

		$dompdf->setPaper($paperFormat, $type);



		$dompdf->render();

		$pdf_content = $dompdf->output();


		header('Content-Type: application/pdf');
		header('Content-Length: ' . strlen($pdf_content));
		echo $pdf_content;
	}

	public function generatePdfGeneral()
	{
		require_once 'vendor/autoload.php';
		$dompdf = new Dompdf\Dompdf();

		$numero = $_GET['id'];
		$codigo = $_GET['pv'];
		$sucursal = $_GET['scs'];



		$data['page_data'] = $this->model->generatePdfGeneral($numero, $codigo, $sucursal);

		extract($data);

		ob_start();


		include './Views/DocumentGuia/pdfGeneral.php';
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

	public function sincroGuia()
	{
		$numero = $_GET['id'];
		$trans = $_GET['vd'];
		//	$sucursal;
		try {
			$this->model->updatePdtSincro($numero, $trans);


			$output = shell_exec('cmd /c "C:\\xampp\\htdocs\\SystemPesadas\\Guias.bat"');


			$output = shell_exec('cmd /c "C:\\xampp\\htdocs\\SystemPesadas\\Productos.bat"');


			//$this->model->callPryviySincro($numero);

			//$output = exec('C:\\ADN Software\\ADN.exe SINCRO-29-0-adn-1');

			//$output = shell_exec('start /B C:\\ADN Software\\ADN.exe SINCRO-29-0-adn-1 > NUL');

			$arrResponse = array('status' => true, 'msg' => 'Excelente, procesado correctamente ');

			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);
			die();
		} catch (Exception $e) {

			$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			die();
		}
	}


	public function seeLots()
	{

		$pdtCode = $_GET['pdt'];
		$pdtUnd = $_GET['und'];
		$amc =  $_SESSION['userData']['OPE_AMC_PESADA'];


		try {

			$Lotes = $this->model->seeLots($pdtCode, $pdtUnd, $amc);

			echo json_encode($Lotes, JSON_UNESCAPED_UNICODE);
			die();
		} catch (Exception $e) {

			$arrResponse = array('status' => false, 'msg' => 'Error, por favor revisar los datos ' . $e);
			echo json_encode($arrResponse, JSON_UNESCAPED_UNICODE);

			die();
		}
	}


	public function viewPdfDetailsPesada()
	{

		$numero = $_GET['id'];
		$codigo = $_GET['vd'];
		$producto = $_GET['pdt'];


		$data['page_data'] = $this->model->generatePdfDetallPesada($numero, $codigo, $producto);

		$data['page_functions_js'] = "functions_document_guia.js";

		$this->views->getView($this, "capturaDetallPesada", $data);
	}


	public function generatePdfDetailsPesada()
	{
		require_once 'vendor/autoload.php';
		$dompdf = new Dompdf\Dompdf();

		$numero = $_GET['id'];
		$codigo = $_GET['vd'];
		$producto = $_GET['pdt'];
		$height = $_GET['height'];

		$data['page_data'] = $this->model->generatePdfDetallPesada($numero, $codigo, $producto);

		extract($data);

		ob_start();


		include './Views/DocumentGuia/pdfDetallPesada.php';
		$html = ob_get_clean();


		$dompdf->loadHtml($html);


		$width = 78;
		$type = "portrait";
		$width_mm = 75; // ancho en milímetros
		$height_mm = 400; // altura en milímetros

		$width_points = ($width_mm / 25.4) * 72; // conversión a puntos
		$height_points = ($height_mm / 25.4) * 72; // conversión a puntos

		$paperFormat = array(0, 0, $width_points, $height_points);

		$dompdf->setPaper($paperFormat, $type);
		$dompdf->render();

		$pdf_content = $dompdf->output();

		header('Content-Type: application/pdf');
		header('Content-Length: ' . strlen($pdf_content));
		echo $pdf_content;
	}
	/*
	public function ticket()
	{
	

		$arrData = $this->model->generatePdf('0000000003', '027');

		try {

			if (!empty($arrData)) {
			
				$nombre_impresora = "smb://Cava1:123456@DESKTOP-BIBMBC6/POS";
				$connector = new WindowsPrintConnector($nombre_impresora);
				$printer = new Printer($connector);

				
				$printer->initialize();
				$printer->setTextSize(1, 1);
				$printer->setLineSpacing(2);  // Adjust line spacing if needed
				$printer->setJustification(Printer::JUSTIFY_CENTER);


				$printer->text($arrData[0]['EMP_NOMBRE'] . "\n", "C");


				$printer->text($arrData[0]['EMP_RIF'] . "\n", "C");
				$printer->text($arrData[0]['EMP_DIRECCION1'] . "\n", "C");
				$printer->feed(2);

				$printer->text("_______________________________________________" . "\n", "C");
				$printer->setJustification(Printer::JUSTIFY_LEFT);
				$printer->text("Telefono: " . $arrData[0]['EMP_TELEFONO1'] . "\n", "C");
				$printer->text("Email: " . $arrData[0]['EMP_EMAIL'] . "\n", "C");
				$printer->text("Numero guia: " . $arrData[0]['PDA_NUMERO'] . "\n", "C");
				$printer->text("Transportista: " . $arrData[0]['TRA_NOMBRE'] . "\n", "C");
				$printer->text("Fecha: " . $arrData[0]['PDA_FECHA'] . "\n", "C");
				$printer->text("_______________________________________________" . "\n", "C");


				$printer->text("Placa:  " . $arrData[0]['DCG_VEH_PLACA'] . "\n");
				$printer->text("Estacion:  " . $arrData[0]['DCG_ESTACION'] . "\n");
				$printer->text("Ruta:  " . $arrData[0]['DCG_RUTA'] . "\n");

				foreach ($arrData as $indice => $value) {

					$printer->text("_______________________________________________" . "\n", "C");
					$printer->text("Codigo producto: " . $value['PDA_UPP_PDT_CODIGO'] . "\n");
					$printer->text("_______________________________________________" . "\n", "C");
					$printer->text("Descripcion: " . $value['PDT_DESCRIPCION'] . "\n");
					$printer->text("UNIDAD:  " . $value['PDA_UPP_UND_ID'] . "\n");
					$printer->text("RECIBIDO:  " . $value['CAJAS'] . "\n");
					$printer->text("EXTRA:  " . $value['EXTRA'] . "\n");
					$printer->text("BRUTO:  " . $value['NETO_MENOS_EXTRA'] . "\n");
					$printer->text("CANASTAS:  " . $value['CANASTAS'] . "\n");
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
*/

	function cut()
	{
		try {

			$Lotes = $this->model->cut();
			$output = shell_exec('cmd /c "C:\\xampp\\htdocs\\SystemPesadas\\kill_pesadas.bat"');

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
		$dcgNumero = $_GET['id'];
		$transportista = $_GET['vd'];

		$arrData = $this->model->generatePdf($dcgNumero, $transportista);

		try {

			if (!empty($arrData)) {
				$nombre_impresora = "smb://Cava1:123456@DESKTOP-BIBMBC6/POS";
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
				$printer->text("Numero guia: " . $arrData[0]['PDA_NUMERO'] . "\n", "C");
				$printer->text("Transportista: " . $arrData[0]['TRA_NOMBRE'] . "\n", "C");
				$printer->text("Fecha: " . $arrData[0]['PDA_FECHA'] . "\n", "C");
				$printer->text("_______________________________________________" . "\n", "C");

				$printer->text("Placa:  " . $arrData[0]['DCG_VEH_PLACA'] . "\n");
				$printer->text("Estacion:  " . $arrData[0]['DCG_ESTACION'] . "\n");
				$printer->text("Ruta:  " . $arrData[0]['DCG_RUTA'] . "\n");

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
		$dcgNumero = $_GET['id'];
		$transportista = $_GET['vd'];
		$sucursal = $_GET['scs'];

		$arrData = $this->model->generatePdfGeneral($dcgNumero, $transportista, $sucursal);

		try {

			if (!empty($arrData)) {
				$nombre_impresora = "smb://Cava1:123456@DESKTOP-BIBMBC6/POS";
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
				$printer->text("Numero guia: " . $arrData[0]['PDA_NUMERO'] . "\n", "C");
				$printer->text("Transportista: " . $arrData[0]['TRA_NOMBRE'] . "\n", "C");
				$printer->text("Fecha: " . $arrData[0]['PDA_FECHA'] . "\n", "C");
				$printer->text("_______________________________________________" . "\n", "C");

				$printer->text("Placa:  " . $arrData[0]['DCG_VEH_PLACA'] . "\n");
				$printer->text("Estacion:  " . $arrData[0]['DCG_ESTACION'] . "\n");
				$printer->text("Ruta:  " . $arrData[0]['DCG_RUTA'] . "\n");

				foreach ($arrData as $value) {

					$printer->text("_______________________________________________" . "\n", "C");
					$printer->text("CAJAS:  " . $value['CAJAS'] . "\n");
					$printer->text("KG|UND (BRUTO):  " . $value['KG_UND'] . "\n");
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
		$dcgNumero = $_GET['id'];
		$transportista = $_GET['vd'];
		$producto = $_GET['pdt'];

		$arrData = $this->model->generatePdfDetallPesada($dcgNumero, $transportista, $producto);

		try {

			if (!empty($arrData)) {
				$nombre_impresora = "smb://Cava1:123456@DESKTOP-BIBMBC6/POS";
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
				$printer->text("Numero guia: " . $arrData[0]['PDA_NUMERO'] . "\n", "C");
				$printer->text("Transportista: " . $arrData[0]['TRA_NOMBRE'] . "\n", "C");
				$printer->text("Fecha: " . $arrData[0]['PDA_FECHA'] . "\n", "C");
				$printer->text("Operador: " . $arrData[0]['OPE_NOMBRE'] . "\n", "C");
				$printer->text("_______________________________________________" . "\n", "C");

				$printer->text("Placa:  " . $arrData[0]['DCG_VEH_PLACA'] . "\n");
				$printer->text("Estacion:  " . $arrData[0]['DCG_ESTACION'] . "\n");
				$printer->text("Ruta:  " . $arrData[0]['DCG_RUTA'] . "\n");


				$printer->text("_______________________________________________" . "\n", "C");

				$printer->text("CODIGO PRODUCTO:  " . $arrData[0]['PDA_UPP_PDT_CODIGO'] . "\n");
				$printer->text("BRUTO: " . $arrData[0]['BRUTO'] . "\n");
				$printer->text("EXTRA: " . $arrData[0]['EXTRA'] . "\n");
				$printer->text("NETO:  " . $arrData[0]['NETO'] . "\n");
				$printer->text("UNIDAD:  " . $arrData[0]['PDA_UPP_UND_ID'] . "\n");

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
