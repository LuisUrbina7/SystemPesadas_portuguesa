<?php

class PedidosPolloModel extends Mysql
{

	public function __construct()
	{
		parent::__construct();
	}


	public function getDocument()
	{
		$document = "SELECT STRAIGHT_JOIN
							DCL_NUMERO, 
							DCL_CLT_CODIGO ,  
							DCL_VEN_CODIGO ,  
							VEN_NOMBRE,  
							ROUND(SUM(MOV.PESO),2) AS DCG_PESO,  
							DCL_FECHA,  
							0 AS DCG_ESTADO,  
							IF(DCL_COMEN2 LIKE '%:P:%',1,0) AS DCL_CERRADO, 
							IFNULL(PDA_TRANF_ID,0) AS PDA_TRANF_ID,  
							0 AS DCG_SINCRO, 
							CONCAT(DCL_NUMERO,':',DCL_CLT_CODIGO,':',DCL_VEN_CODIGO,':',DCL_FECHA) AS INDICE, 
							IF(DCL_TDT_CODIGO IN ('PED','PEDW','PEDW2'), 0,0) AS INDICADOR,
							IFNULL(INICIO,'00:00:00') AS INICIO,
							IFNULL(FIN,'00:00:00') AS FIN,
							IFNULL(DURACION,'0 MIN') AS DURACION,
							'' AS DCG_IMPORT   
							FROM ADN_DOCCLI   
								JOIN ADN_VENDEDORES ON DCL_VEN_CODIGO = VEN_CODIGO
							-- INNER JOIN ADN_DOCCLIGUIA ON DCG_NUMERO = DCL_NUMGUIA 
							-- AND DCG_ESTADO = 0 
							 AND DCL_FECHA >= CURDATE() - INTERVAL 30 DAY
							-- AND DCL_REC_NUMERO = '' 
							 AND DCL_TIPTRA = 'D' 
							 AND DCL_NUMGUIA = ''  
							 AND DCL_TDT_CODIGO = 'PEDW'
							-- INNER JOIN ADN_TRANSPORTISTAS ON DCG_TRA_CODIGO = TRA_CODIGO  
							INNER JOIN (
							SELECT 
							MCL_DCL_TDT_CODIGO AS TIPO, 
							MCL_DCL_NUMERO AS DOC, 
							(SUM(UGR_PESO*MCL_CANTIDAD*MCL_CANTXUND*MCL_ACTIVO) / 1000) AS PESO 
							FROM ADN_DOCCLI
							INNER JOIN ADN_MOVCLI ON MCL_DCL_NUMERO = DCL_NUMERO
							AND MCL_DCL_TDT_CODIGO = DCL_TDT_CODIGO 
							AND MCL_ACTIVO = DCL_ACTIVO 
							INNER JOIN ADN_UNDAGRU ON UGR_PDT_CODIGO = MCL_UPP_PDT_CODIGO 
							AND UGR_UND_ID = MCL_UPP_UND_ID
							WHERE MCL_ACTIVO = 1
							GROUP BY DOC, TIPO) AS MOV
							ON MOV.DOC = DCL_NUMERO
							AND MOV.TIPO = DCL_TDT_CODIGO
							LEFT JOIN ( 
							SELECT  
							PDA_NUMERO,  
							PDA_SCS_CODIGO,  
							PDA_DET_CODIGO,  
							MAX(PDA_TRANF_ID) AS PDA_TRANF_ID,
							MIN(PDA_INICIO) AS INICIO, 
							MAX(PDA_FIN) AS FIN,
							CONCAT(ROUND(TIME_TO_SEC(TIMEDIFF(MAX(PDA_FIN),MIN(PDA_INICIO)))/60,2), ' MIN') AS DURACION  
							FROM ADN_PESADAS WHERE PDA_TIPO = '4'  
							AND PDA_INICIO <> '00:00:00' 
							GROUP BY PDA_NUMERO,PDA_SCS_CODIGO, PDA_DET_CODIGO) AS PESADAS ON DCL_NUMERO = PDA_NUMERO 
							AND DCL_VEN_CODIGO = PDA_DET_CODIGO 
							AND DCL_SCS_CODIGO = PDA_SCS_CODIGO 
							WHERE DCL_REC_NUMERO = '' 
							AND DCL_TIPTRA = 'D' 
							 GROUP BY INDICE  
							ORDER BY DCL_FECHAHORA DESC;";

		$select = $this->select_all($document);

		return $select;
	}

	public function getDetails($number, $vnd, $amc)
	{
		$userAmc = substr($amc, -1);

		$details = "SELECT STRAIGHT_JOIN
						PDT_PESO_BALANZA,
						DCL_NUMERO,
						DCL_VEN_CODIGO,
						VEN_NOMBRE,
						MCL_UPP_PDT_CODIGO,
						MCL_UPP_UND_ID,
						MCL_DESCRI,
						IF(
						ROUND(IF(PDT_PESO_BALANZA=1 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(SUM(MCL_PIEZAS/PDT_LICLTSCAJA)),
						IF(PDT_PESO_BALANZA=0 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(SUM(MCL_CANTIDAD/PDT_LICLTSCAJA)),0 )),2) >
						ROUND(IF(PDT_PESO_BALANZA=0 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(UGR_EX$userAmc/PDT_LICLTSCAJA),
						IF(PDT_PESO_BALANZA=1 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(UGR_EX$userAmc/PDT_LICLTSCAJA),0 )),2),
						ROUND(IF(PDT_PESO_BALANZA=0 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(UGR_EX$userAmc/PDT_LICLTSCAJA),
						IF(PDT_PESO_BALANZA=1 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(UGR_EX$userAmc/PDT_LICLTSCAJA),0 )),2) ,
						ROUND(IF(PDT_PESO_BALANZA=0 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(SUM(MCL_CANTIDAD/PDT_LICLTSCAJA)),
						IF(PDT_PESO_BALANZA=1 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(SUM(MCL_PIEZAS/PDT_LICLTSCAJA)),0 )),2)
						) AS CAJA,
						ROUND(IFNULL(CASE  
						WHEN PDT_LICLTSCAJA =0 AND UGR_UND_ID = 'UND' THEN 
						IF(SUM(MCL_CANTIDAD) > UGR_EX$userAmc, UGR_EX$userAmc, SUM(MCL_CANTIDAD))
						WHEN PDT_LICLTSCAJA >= 0 AND UGR_UND_ID = 'KG' THEN 
						IF(SUM(MCL_CANTIDAD) > UGR_EX$userAmc, UGR_EX$userAmc, SUM(MCL_CANTIDAD))
						END,0),2) AS UND_KG,
						IFNULL(PESADO.PESADO,0) AS PESADO,
						IF(DCL_COMEN2 LIKE '%:P:%',1,0) AS DCL_CERRADO, 
						PDT_LICLTSCAJA,
						UGR_UND_ID,
						SUM(MCL_PIEZAS) AS PIEZAS
							FROM ADN_DOCCLI 
							INNER JOIN ADN_VENDEDORES ON DCL_VEN_CODIGO = VEN_CODIGO
							INNER JOIN (
								SELECT STRAIGHT_JOIN
								MCL_DCL_NUMERO AS DOC, 
								MCL_DCL_TDT_CODIGO AS TIPO, 
								MCL_UPP_PDT_CODIGO,
								MCL_UPP_UND_ID,
								MCL_DESCRI,
								MCL_PIEZAS, 
								MCL_CANTIDAD, 
								PDT_LICLTSCAJA, 
								UGR_UND_ID, 
								PDT_PESO_BALANZA, 
								UGR_EX$userAmc
								FROM (SELECT 
								DCL_NUMERO AS DOC, 
								DCL_TDT_CODIGO AS TIPO
								FROM ADN_DOCCLI 
								WHERE DCL_TIPTRA = 'D'
								AND DCL_NUMERO = '$number') AS DOC
								INNER JOIN ADN_MOVCLI ON DOC.DOC = MCL_DCL_NUMERO
								AND DOC.TIPO = MCL_DCL_TDT_CODIGO
								INNER JOIN ADN_PRODUCTOS ON PDT_CODIGO = MCL_UPP_PDT_CODIGO 
								INNER JOIN ADN_UNDAGRU ON MCL_UPP_PDT_CODIGO = UGR_PDT_CODIGO 
								AND MCL_UPP_UND_ID = UGR_UND_ID) AS MOV
									ON MOV.DOC = DCL_NUMERO
									AND MOV.TIPO = DCL_TDT_CODIGO
							LEFT JOIN (
								SELECT 
								PDA_NUMERO, 
								PDA_DET_CODIGO, 
								PDA_UPP_PDT_CODIGO, 
								PDA_UPP_UND_ID, 
								IFNULL(ROUND(SUM( IF(PDA_CANXUND >= 1 AND PDA_UPP_UND_ID = 'UND', (PDA_CANTIDAD-PDA_EXTRA)/PDA_CANXUND, PDA_CANTIDAD-PDA_EXTRA)),2),0) AS PESADO 
								FROM ADN_PESADAS 
								WHERE PDA_NUMERO = '$number' 
								AND PDA_DET_CODIGO = '$vnd' 
								AND PDA_TIPO = '4'
								GROUP BY PDA_UPP_PDT_CODIGO, PDA_UPP_UND_ID) AS PESADO ON PESADO.PDA_NUMERO = DCL_NUMERO 
									AND PESADO.PDA_DET_CODIGO = DCL_VEN_CODIGO 
									AND PESADO.PDA_UPP_PDT_CODIGO = MCL_UPP_PDT_CODIGO 
									AND PESADO.PDA_UPP_UND_ID = MCL_UPP_UND_ID
							WHERE DCL_TIPTRA = 'D'
							AND DCL_TDT_CODIGO = 'PEDW'
						GROUP BY MCL_UPP_PDT_CODIGO;";




		$select = $this->select_all($details);


		return $select;
	}



	public function insertDetails($numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $correlative, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta)
	{
		$user = !isset($_SESSION['userData']['OPE_NUMERO']) ? '1' : $_SESSION['userData']['OPE_NUMERO'];
		$insert = "INSERT IGNORE INTO `adn_pesadas` (`ID`, `PDA_NUMERO`, `PDA_AMC_ORIGEN`,PDA_AMC_DESTINO, `PDA_SCS_CODIGO`, `PDA_UPP_PDT_CODIGO`, `PDA_DET_CODIGO`, `PDA_UPP_UND_ID`,`PDA_CANXUND`, `PDA_CANTIDAD`, PDA_CANASTA_TIPO,`PDA_CANASTA`, `PDA_EXTRA`, `PDA_UBICA`, PDA_FECHA, `PDA_INICIO`, `PDA_FIN`, PDA_LLEGADA , PDA_TK , PDA_TA ,`PDA_USUARIO`,PDA_TIPO) VALUES (NULL,?, ?,?, ?, ?,?, ?,?,?,?, ?, ?, ?, ?  ,?, ?,?,?,?, ?,'2');";
		$result = $this->insert($insert, [$numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $correlative, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta, $user]);

		return $result;
	}

	public function insertSkip($numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $correlative, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta, $motivo)
	{
		$user = !isset($_SESSION['userData']['OPE_NUMERO']) ? '1' : $_SESSION['userData']['OPE_NUMERO'];
		$insert = "INSERT IGNORE INTO `adn_pesadas` (`ID`, `PDA_NUMERO`, `PDA_AMC_ORIGEN`,PDA_AMC_DESTINO, `PDA_SCS_CODIGO`, `PDA_UPP_PDT_CODIGO`, `PDA_DET_CODIGO`, `PDA_UPP_UND_ID`,`PDA_CANXUND`, `PDA_CANTIDAD`, PDA_CANASTA_TIPO,`PDA_CANASTA`, `PDA_EXTRA`, `PDA_UBICA`, PDA_FECHA, `PDA_INICIO`, `PDA_FIN`, PDA_LLEGADA , PDA_TK , PDA_TA ,`PDA_USUARIO`,PDA_TIPO,PDA_MOTIVO) VALUES (NULL,?, ?,?, ?, ?,?, ?,?,?,?, ?, ?, ?, ?  ,?, ?,?,?,?, ?,'2',?);";


		$result = $this->insert($insert, [$numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $correlative, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta, $user, $motivo]);
		return $result;
	}

	public function updateDetails($id, $cantidad)
	{

		$query = "UPDATE adn_pesadas SET PDA_CANTIDAD = ? WHERE ID = '$id' ";



		$update = $this->update($query, [$cantidad]);

		return $update;
	}

	public function getCanasta()
	{

		$query = "SELECT * FROM adn_canasta_tipo";

		$select = $this->select_all($query);


		return $select;
	}

	public function getAmc()
	{

		$query = "SELECT VALOR FROM adn_config WHERE CODIGO = 'ALMACEN_VARIABLE'";
		$select = $this->select($query);

		$query = $select['VALOR'];
		$select = $this->select_all($query);
		return $select;
	}

	public function getPesadas($numero, $proveedor, $sku)
	{

		$query = "SELECT `ID`, `PDA_NUMERO`, `PDA_AMC_ORIGEN`, `PDA_AMC_DESTINO`, `PDA_SCS_CODIGO`, `PDA_UPP_PDT_CODIGO`, `PDA_DET_CODIGO`, `PDA_UPP_UND_ID`, `PDA_CANXUND`, `PDA_CANTIDAD`, `PDA_CANASTA_TIPO`, `PDA_CANASTA`, ROUND( `PDA_EXTRA`,2) AS PDA_EXTRA, `PDA_UBICA`, `PDA_FECHA`, `PDA_INICIO`, `PDA_FIN`, `PDA_LLEGADA`, `PDA_TK`, `PDA_TA`, `PDA_TRANF_ID`, `PDA_USUARIO`, `PDA_TIPO`, PDA_MOTIVO  FROM adn_pesadas WHERE PDA_NUMERO = '$numero' AND PDA_DET_CODIGO = '$proveedor' AND PDA_UPP_PDT_CODIGO = '$sku' AND PDA_TIPO = '4' order by ID ASC";




		$select = $this->select_all($query);

		return $select;
	}

	public function deletePesadas($id)
	{

		$bridge = "DELETE FROM adn_pesadas_canastas WHERE PCT_PDA_ID = '$id'";

		$deletebridge = $this->delete($bridge);

		$query = "DELETE FROM adn_pesadas WHERE ID = '$id'";

		$delete = $this->delete($query);
		return $delete;
	}


	public function validateDocumento($numero, $vnd)
	{

		$query = "SELECT IF(PESADAS.CONTEO = INDICE.CONTEO_DOCUMENTO,1,0) AS VALIDATE
		FROM (
			SELECT PDA_NUMERO AS NUMERO, PDA_DET_CODIGO AS DET, 
			ROW_NUMBER() OVER (ORDER BY PDA_UPP_PDT_CODIGO DESC) AS CONTEO  
			FROM ADN_PESADAS
			WHERE PDA_NUMERO = '$numero' AND PDA_DET_CODIGO = '$vnd' AND PDA_TIPO = '4'
			GROUP BY PDA_UPP_PDT_CODIGO LIMIT 1
		) AS PESADAS
		JOIN (
			SELECT DOCUMENTOS.DCL_NUMERO AS NUMERO, DOCUMENTOS.DCL_VEN_CODIGO AS VENDEDOR, COUNT(*) AS CONTEO_DOCUMENTO
			FROM (
				SELECT DCL_NUMERO, DCL_VEN_CODIGO
				FROM ADN_MOVCLI
				JOIN ADN_DOCCLI ON MCL_DCL_NUMERO = DCL_NUMERO AND MCL_DCL_SCS_CODIGO = DCL_SCS_CODIGO AND MCL_DCL_TDT_CODIGO = DCL_TDT_CODIGO AND MCL_DCL_TIPTRA = DCL_TIPTRA
				
				WHERE DCL_NUMERO = '$numero' AND DCL_VEN_CODIGO = '$vnd' AND DCL_TDT_CODIGO = 'PEDW'
				GROUP BY MCL_UPP_PDT_CODIGO
			) AS DOCUMENTOS
			GROUP BY DOCUMENTOS.DCL_NUMERO, DOCUMENTOS.DCL_VEN_CODIGO
		) AS INDICE
		ON PESADAS.NUMERO = INDICE.NUMERO AND PESADAS.DET = INDICE.VENDEDOR;";


		$execute = $this->select($query);

		if (isset($execute)) {
			$result = $execute['VALIDATE'];
		} else {
			$result = 0;
		}

		return $result;
	}



	public function searchDocument($numero, $proveedor, $sucursal)
	{

		$query = "SELECT COUNT(*) AS CONTEO FROM ADN_DOCPRO WHERE DPV_NUMERO = '$numero' AND DPV_PVD_CODIGO ='$proveedor'  AND DPV_TDT_CODIGO = 'NCCI' AND DPV_SCS_CODIGO = '$sucursal' ";
		$result = $this->select($query);
		if (isset($result)) {
			$result = $result['CONTEO'];
		} else {
			$result = 0;
		}

		return $result;
	}


	public function searchPesada($numero, $vnd)
	{

		$query = "SELECT PDA_NUMERO,
					MAX(PDA_AMC_ORIGEN) AS PDA_AMC_ORIGEN, 
					MAX(PDA_AMC_DESTINO) AS PDA_AMC_DESTINO, 
					PDA_SCS_CODIGO,PDA_DET_CODIGO, 
					CONCAT(PDA_NUMERO,':',PDA_DET_CODIGO,':',PDA_SCS_CODIGO) AS INDICE 
					FROM ADN_PESADAS 
						WHERE PDA_TIPO = '4' GROUP BY  INDICE
					    HAVING INDICE = CONCAT('$numero',':','$vnd',':','000001');";

		$select = $this->select($query);


		$updateSincro = " UPDATE ADN_PRODUCTOS SET PDT_SINCRO = '1' 
							WHERE PDT_CODIGO IN(SELECT 
							PDA_UPP_PDT_CODIGO
							FROM `adn_pesadas`
							WHERE PDA_NUMERO = '$numero'	    
							AND PDA_DET_CODIGO = '$vnd'
							AND PDA_TIPO = '4'
							AND PDA_SCS_CODIGO = '000001'
							GROUP BY PDA_UPP_PDT_CODIGO); ";

		$executeUpdate = $this->select($updateSincro);

		return $select;
	}

	public function callTrans($numero, $vnd, $origen_amc, $destino_amc, $sucursal)
	{

		$call = "CALL `TRANSFERENCIA_PESADAS`('$numero', '$vnd', '$origen_amc','$destino_amc', '$sucursal' )";


		$execute = $this->select($call);

		return $execute;
	}

	public function correlative()
	{

		$query = "SELECT IFNULL(IF(LENGTH(MAX(CONVERT(DOC2.PCT_NUMERO, SIGNED)) + 1) < 10, LPAD(MAX(CONVERT(DOC2.PCT_NUMERO, SIGNED)) + 1, 10, '0'), MAX(CONVERT(DOC2.PCT_NUMERO, SIGNED)) + 1), '0000000001') AS CORRELATIVO
         FROM ADN_PESADAS_CANASTAS AS DOC2 ORDER BY PCT_NUMERO DESC LIMIT 1;";

		$execute = $this->select($query);

		$correlativo = !isset($execute['CORRELATIVO']) ? '0001' : $execute['CORRELATIVO'];

		return $correlativo;
	}

	public function setHeavyBaskets($correlativo, $tipo, $cantidad, $pesada)
	{

		$insert = "INSERT INTO `adn_pesadas_canastas` (`PCT_NUMERO`, `PCT_CTA_TIPO`,`PCT_CANTIDAD`, `PCT_PDA_ID`) VALUES (?, ?, ?,?);";

		$execute = $this->insert($insert, [$correlativo, $tipo, $cantidad, $pesada]);


		return $execute;
	}

	public function generatePdfGeneral($numero, $codigo, $sucursal)
	{
		$sql = "SELECT 
					PDA_NUMERO, 
					PDA_DET_CODIGO, 
					'P/D' AS DCG_VEH_PLACA,
					'P/D' AS DCG_ESTACION,
					VEN_NOMBRE AS TRA_NOMBRE,
					'P/D' AS DCG_RUTA,
					COUNT(PDA_UPP_PDT_CODIGO)AS PRODUCTOS,
					ROUND(SUM(IF(PDA_CANXUND >= 1 AND PDA_UPP_UND_ID = 'UND', CONCAT( PDA_CANTIDAD/PDA_CANXUND, ' CAJAS'), 0 )), 2) AS CAJAS,
					ROUND(SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD, 0)), 2)AS KG_UND ,
					CONCAT(SUM(ROUND(PDA_EXTRA,2)), ' KG') AS EXTRA,
					IFNULL(PESADASCANASTAS.PCT_CANTIDAD,0)AS TARAS,
					ROUND(SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD - PDA_EXTRA, PDA_EXTRA) ), 2) AS BRUTO,
					MIN(PDA_INICIO) AS INICIO, 
					MAX(PDA_FIN) AS FIN,
					PDA_FECHA,
					CONCAT(ROUND(TIME_TO_SEC(TIMEDIFF(MAX(PDA_FIN),MIN(PDA_INICIO)))/60,2), ' Min') AS DURACION,
					EMPRESA.EMP_NOMBRE, EMPRESA.EMP_RIF, EMPRESA.EMP_DIRECCION1, EMPRESA.EMP_TELEFONO1, EMPRESA.EMP_EMAIL
				FROM  ADN_PESADAS
				JOIN ( 
					SELECT '1' AS 
					INDICE, 
					EMP_NOMBRE, 
					EMP_RIF, 
					EMP_DIRECCION1, 
					EMP_TELEFONO1, 
					EMP_EMAIL 
					FROM sistemasadn.`adn_empresa` 
					LIMIT 1 
					) AS EMPRESA ON EMPRESA.INDICE = '1'
					LEFT JOIN (
						SELECT 
						GROUP_CONCAT( PCT_CANTIDAD, ' - ',CTA_EQUIVALENCIA) AS PCT_CANTIDAD,
						PCT_CTA_TIPO,
						PCT_NUMERO AS PCTNUMERO,
						PDA_NUMERO AS CANASTAS_PDANUMERO,
						PDA_DET_CODIGO AS DET,
						PDA_UPP_PDT_CODIGO AS PDTCODIGO
						FROM ADN_PESADAS
						JOIN ADN_PESADAS_CANASTAS ON PDA_CANASTA_TIPO = PCT_NUMERO 
						JOIN `adn_canasta_tipo` ON cta_codigo = pct_cta_tipo
						WHERE  PCT_CTA_TIPO != '0000'
						AND PDA_TIPO = '4'
						GROUP BY PDA_NUMERO, PDA_DET_CODIGO
						
					)AS PESADASCANASTAS
					ON PESADASCANASTAS.CANASTAS_PDANUMERO = PDA_NUMERO
					AND PESADASCANASTAS.DET = PDA_DET_CODIGO
				JOIN ADN_VENDEDORES ON PDA_DET_CODIGO = VEN_CODIGO
				WHERE 
				PDA_TIPO = '4' 
				AND PDA_NUMERO = '@NUMERO'  
				AND PDA_DET_CODIGO = '@CODIGO'
				AND PDA_INICIO <>  '00:00:00'
				GROUP BY PDA_NUMERO, PDA_DET_CODIGO;";

		$newSql = str_replace('@CODIGO', $codigo, str_replace('@NUMERO', $numero, $sql));

		$execute = $this->select_all($newSql);

	
		return $execute;
	}

	public function generatePdf($numero, $codigo)
	{

		$sql = "SELECT 
			PDA_NUMERO, 
			PDA_DET_CODIGO, 
			PDA_UPP_PDT_CODIGO, 
			'P/D' AS DCG_VEH_PLACA,
			'P/D' AS DCG_ESTACION,
			'P/D' AS DCG_RUTA, 
			VEN_NOMBRE AS TRA_NOMBRE,
			PDT_DESCRIPCION,
			PDA_UPP_UND_ID, 
			PDA_TK,
			PDA_TA,
			PDA_FECHA,
			PDA_LLEGADA,
			CONTEO_PESADAS.CANT_PESADAS AS TOTAL_PESADAS,
			CONCAT(ROUND(SUM(IF(PDA_CANXUND >= 1 AND PDA_UPP_UND_ID = 'UND', PDA_CANTIDAD/PDA_CANXUND, 0 )), 2), ' CAJAS') AS CAJAS,
	 		CONCAT(ROUND(SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD, 0)), 2), ' KG/UND')AS KG_UND , 
			IFNULL(PESADASCANASTAS.PCT_CANTIDAD,0) AS CANASTAS,
			CONCAT(ROUND(SUM(PDA_EXTRA), 2),' ',PDA_UPP_UND_ID) AS EXTRA,
			SUM(PDA_CANASTA) AS TOTAL_CANASTAS,
			MIN(PDA_INICIO) AS INICIO, 
			MAX(PDA_FIN) AS FIN,
			CONCAT(ROUND(TIME_TO_SEC(TIMEDIFF(MAX(PDA_FIN),MIN(PDA_INICIO)))/60,2), ' Min') AS DURACION,
			ROUND(SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD - PDA_EXTRA, PDA_EXTRA )), 2) AS NETO_MENOS_EXTRA,
			EMPRESA.EMP_NOMBRE, EMPRESA.EMP_RIF, EMPRESA.EMP_DIRECCION1, EMPRESA.EMP_TELEFONO1, EMPRESA.EMP_EMAIL
		FROM  ADN_PESADAS
		JOIN ADN_PRODUCTOS ON PDT_CODIGO = PDA_UPP_PDT_CODIGO
		JOIN ADN_UNDAGRU ON UGR_PDT_CODIGO = PDA_UPP_PDT_CODIGO AND UGR_UND_ID = PDA_UPP_UND_ID
		JOIN ADN_VENDEDORES ON PDA_DET_CODIGO = VEN_CODIGO	
				
			JOIN (
			 SELECT '1' AS INDICE, EMP_NOMBRE, EMP_RIF, EMP_DIRECCION1, EMP_TELEFONO1, EMP_EMAIL FROM sistemasadn.`adn_empresa` LIMIT 1 )
			AS EMPRESA ON EMPRESA.INDICE = '1'
			
			LEFT JOIN (
			SELECT 
			GROUP_CONCAT( PCT_CANTIDAD, ' - ',CTA_EQUIVALENCIA) AS PCT_CANTIDAD,
			PCT_CTA_TIPO,
			PCT_NUMERO AS PCTNUMERO,
			PDA_NUMERO AS CANASTAS_PDANUMERO,
			PDA_UPP_PDT_CODIGO AS PDTCODIGO
			FROM ADN_PESADAS
			JOIN ADN_PESADAS_CANASTAS ON PDA_CANASTA_TIPO = PCT_NUMERO 
			JOIN `ADN_CANASTA_TIPO` ON CTA_CODIGO = PCT_CTA_TIPO
			WHERE  PCT_CTA_TIPO != '0000'
			AND PDA_TIPO = '4'
			GROUP BY PDA_NUMERO, PDA_UPP_PDT_CODIGO
		)
		AS PESADASCANASTAS
		ON PESADASCANASTAS.CANASTAS_PDANUMERO = PDA_NUMERO
		AND PESADASCANASTAS.PDTCODIGO = PDA_UPP_PDT_CODIGO
			JOIN (
				SELECT 
				PDA_UPP_PDT_CODIGO AS PESADA_PRODUCTO,
				PDA_NUMERO AS PDANUMERO,
				PDA_DET_CODIGO AS DET_CODIGO,
				PDA_SCS_CODIGO AS SCS_CODIGO,
				COUNT(PDA_NUMERO )AS CANT_PESADAS
				FROM ADN_PESADAS
				WHERE PDA_TIPO = '4'
				GROUP BY PDA_NUMERO, PDA_DET_CODIGO,PDA_SCS_CODIGO,PDA_UPP_PDT_CODIGO
			)
			AS CONTEO_PESADAS
			ON CONTEO_PESADAS.PDANUMERO = PDA_NUMERO 
			AND CONTEO_PESADAS.DET_CODIGO = PDA_DET_CODIGO
			AND CONTEO_PESADAS.SCS_CODIGO = PDA_SCS_CODIGO  
			AND CONTEO_PESADAS.PESADA_PRODUCTO = PDA_UPP_PDT_CODIGO 
			
		WHERE PDA_TIPO = '4' AND PDA_NUMERO = '@NUMERO'  AND PDA_DET_CODIGO = '@CODIGO'
		GROUP BY PDA_UPP_PDT_CODIGO, PDA_UPP_UND_ID;";

		$newSql = str_replace('@CODIGO', $codigo, str_replace('@NUMERO', $numero, $sql));
		
		$execute = $this->select_all($newSql);

		return $execute;
	}

	public function updatePdtSincro($numero, $vnd)
	{

		$update = "UPDATE `adn_doccliguia` SET DCG_SINCRO = '1' WHERE DCG_NUMERO = ?  AND DCG_TRA_CODIGO = ?;";

		$execute = $this->update($update, [$numero, $vnd]);

		return $execute;
	}

	public function seeLots($pdt, $und, $amc)
	{

		$query = "SELECT 
					LOTE,
					CODIGO, 
					FECHALOTE,
					ROUND(SUM((CANTIDAD*CXUND*CONTABLE)/UGR_CANXUND),2) AS DISPONIBLE
				FROM `MOV_PRODUCTOS_LOTES`
					INNER JOIN `ADN_UNDAGRU` ON UGR_PDT_CODIGO = CODIGO
					INNER JOIN `ADN_PRECIOS` ON PRE_UGR_PDT_CODIGO = UGR_PDT_CODIGO 
				AND PRE_UGR_UND_ID = UGR_UND_ID
					INNER JOIN ADN_PRODUCTOS ON CODIGO=PDT_CODIGO
				WHERE  PRE_PLT_LISTA IN('A')  AND CODIGO NOT LIKE '%SER%'
					AND CODIGO = '$pdt' AND ALM = '$amc' 
				GROUP BY ALM , UGR_UND_ID, LOTE,CODIGO, PRE_PLT_LISTA
					HAVING DISPONIBLE > 0
				ORDER BY ALM,CODIGO,FECHALOTE";

		$execute = $this->select_all($query);

		return $execute;
	}


	public function insertCall($numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta, $tipoCanasta)
	{
		$user = !isset($_SESSION['userData']['OPE_NUMERO']) ? '1' : $_SESSION['userData']['OPE_NUMERO'];
		$call = "CALL INSERT_PESADAS('$numero', '$amc_origen', '$amc_destino', '$sucursal', '$producto', '$proveedor', '$und', '$canxund', '$cantidad', '$canasta', '$extra', '$ubica', '$fecha', '$inicio', '$fin', '$llegada', '$tk', '$ta','$user','4','$tipoCanasta')";



		$execute = $this->select($call);
		return $execute;
	}


	public function generatePdfDetallPesada($numero, $code, $producto)
	{
		$sql = "SELECT
			PDA_DET_CODIGO AS TRA_CODIGO,
			VEN_NOMBRE AS TRA_NOMBRE,
			ROUND (INFOGENERAL.NETO, 2) AS NETO,
			ROUND (INFOGENERAL.BRUTO, 2) AS BRUTO,
			ROUND (INFOGENERAL.EXTRA, 2) AS EXTRA,
			'P/D' AS DCG_VEH_PLACA,
			'P/D' AS DCG_ESTACION,
			'P/D' AS DCG_RUTA,
			PDA_FECHA,
			PDA_NUMERO,
			PDA_UPP_PDT_CODIGO,
			PDA_DET_CODIGO,
			PDA_UPP_UND_ID,
			PDA_CANTIDAD,
			PDA_CANXUND,
			ROUND (PDA_CANASTA, 2) AS PDA_CANASTA,
			CTA_DESCRIPCION,
			PDA_INICIO,
			PDA_FIN,
			ROUND(IF(PDA_CANXUND > 0 AND PDA_UPP_UND_ID = 'UND', PDA_CANTIDAD/PDA_CANXUND, 0), 2) AS CAJAS,
			ROUND(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD - PDA_EXTRA, 0), 2) AS 'KG_UND',
			ROUND(PDA_CANTIDAD, 2) AS PDA_CANTIDAD,
			ROUND(PDA_EXTRA, 2) AS PDA_EXTRA,
			IFNULL(PESADASCANASTAS.PCT_CANTIDAD,0)AS TARAS,
			OPE_NOMBRE,
			EMPRESA.EMP_NOMBRE, EMPRESA.EMP_RIF, EMPRESA.EMP_DIRECCION1, EMPRESA.EMP_TELEFONO1, EMPRESA.EMP_EMAIL
		FROM ADN_PESADAS
			JOIN ADN_PESADAS_CANASTAS ON PDA_CANASTA_TIPO = PCT_NUMERO 
			JOIN ADN_CANASTA_TIPO ON CTA_CODIGO = PCT_CTA_TIPO
			JOIN ( 
				SELECT 
				'1' AS INDICE, 
				EMP_NOMBRE, 
				EMP_RIF, 
				EMP_DIRECCION1, 
				EMP_TELEFONO1, 
				EMP_EMAIL 
				FROM sistemasadn.`adn_empresa` LIMIT 1 
				) AS EMPRESA
			JOIN ( 
				SELECT 
				OPE_NOMBRE, 
				OPE_NUMERO 
				FROM sistemasadn.adn_usuarios
				) AS OPERADORES ON OPE_NUMERO = PDA_USUARIO
			JOIN (
				SELECT
				PDA_UPP_PDT_CODIGO AS PDT_CODIGO,
				IF(PDA_CANXUND > 0 AND PDA_UPP_UND_ID = 'UND', PDA_CANTIDAD/PDA_CANXUND, 0) AS CAJAS,
				SUM(PDA_EXTRA) AS EXTRA,
				SUM(PDA_CANTIDAD) AS BRUTO,
				SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD - PDA_EXTRA, PDA_CANTIDAD)) AS NETO
				FROM ADN_PESADAS
					WHERE PDA_NUMERO = '$numero'
					AND PDA_DET_CODIGO = '$code'
					AND PDA_UPP_PDT_CODIGO = '$producto'
					AND PDA_TIPO = '4'
					GROUP BY PDA_UPP_PDT_CODIGO
				) AS INFOGENERAL ON INFOGENERAL.PDT_CODIGO = PDA_UPP_PDT_CODIGO
			LEFT JOIN (
				SELECT 
				ID AS PDAID,
				GROUP_CONCAT( PCT_CANTIDAD, ' - ',CTA_EQUIVALENCIA) AS PCT_CANTIDAD,
				PCT_CTA_TIPO,
				PCT_NUMERO AS PCTNUMERO,
				PDA_NUMERO AS CANASTAS_PDANUMERO,
				PDA_UPP_PDT_CODIGO AS PDTCODIGO
				FROM ADN_PESADAS
					JOIN ADN_PESADAS_CANASTAS ON PDA_CANASTA_TIPO = PCT_NUMERO 
					JOIN `adn_canasta_tipo` ON cta_codigo = pct_cta_tipo
				WHERE  PCT_CTA_TIPO != '$producto'
				AND PDA_TIPO = '4'
				GROUP BY ID, PDA_NUMERO, PDA_UPP_PDT_CODIGO
						
					)AS PESADASCANASTAS ON PESADASCANASTAS.CANASTAS_PDANUMERO = PDA_NUMERO
			AND PESADASCANASTAS.PDTCODIGO = PDA_UPP_PDT_CODIGO
			AND PESADASCANASTAS.PDAID = ID	
			LEFT JOIN ADN_VENDEDORES ON PDA_DET_CODIGO = VEN_CODIGO
		WHERE PDA_NUMERO = '$numero'
			AND PDA_DET_CODIGO = '$code'
			AND PDA_UPP_PDT_CODIGO = '$producto'
			AND PDA_TIPO = '4'
		GROUP BY ID,PDA_NUMERO, PDA_SCS_CODIGO, PDA_DET_CODIGO, PDA_UPP_PDT_CODIGO;";

		$execute = $this->select_all($sql);

		return $execute;
	}

	public function cut()
	{
		$execute = $this->handleLockWaitTimeout();

		return $execute;
	}

	public function callSpecialImport($vnd, $numero, $sucursal)
	{

		$call = "CALL `IMPORT_PESADA_ESPECIAL`('$numero', '$vnd','$sucursal' )";


		$execute = $this->select($call);

		return $execute;
	}

	public function callUpdateAmount($numero,$codigo,$tipo){

		$procedure = "CALL POSTCERRAR_PESADA_POLLO('$numero','$codigo','$tipo')";

		$callExecute = $this->select($procedure);

		return $callExecute;

	}
}
