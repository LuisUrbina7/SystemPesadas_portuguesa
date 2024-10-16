<?php

class TransferenciaModel extends Mysql
{


    public function __construct()
    {
        parent::__construct();
    }

    public function getVentas()
    {

        $sql = "";
        $request = $this->select_all($sql);
        return $request;
    }



    public function getDocument()
    {

        $document = "SELECT 
                            DCL_NUMERO, 
                            ROUND(SUM(UGR_PESO*MCL_CANTIDAD*PDT_LICLTSCAJA*MCL_ACTIVO) / 1000,2) AS PESO,
                            DCL_CLT_CODIGO,
                            CLT_NOMBRE,
                            DCL_FECHA,
                            DCL_TDT_CODIGO,
                            DCL_ACTIVO,
                            DCL_SCS_CODIGO
                            FROM ADN_DOCCLI 
                            JOIN  ADN_CLIENTES ON DCL_CLT_CODIGO = CLT_CODIGO 
                            LEFT JOIN ADN_MOVCLI ON MCL_DCL_NUMERO = DCL_NUMERO
                                        AND MCL_DCL_TDT_CODIGO = DCL_TDT_CODIGO
                            LEFT JOIN ADN_UNDAGRU ON MCL_UPP_PDT_CODIGO = UGR_PDT_CODIGO AND MCL_UPP_UND_ID = UGR_UND_ID  
                            JOIN ADN_PRODUCTOS ON MCL_UPP_PDT_CODIGO =  PDT_CODIGO
                          
                            AND DCL_TDT_CODIGO = 'PDA'
                            GROUP BY DCL_CLT_CODIGO, DCL_NUMERO, DCL_SCS_CODIGO
                            ORDER BY DCL_FECHA DESC;";

        $select = $this->select_all($document);

        return $select;
    }

    public function getDetails($number, $cliente)
    {

        $details = "SELECT 
            CLIENTES.CLTNOMBRE AS CLT_NOMBRE,
            PDT_CODIGO,
            PDT_LICLTSCAJA,
            PDC_CLT_CODIGO,
            PDC_ACTIVO,
            PMV_PDC_NUMERO,
            PMV_PDC_CLT_CODIGO, 
            PMV_UPP_PDT_CODIGO,
            PMV_UPP_UND_ID,  
            PDC_NUMERO,
            ROUND(IF(PMV_CANXUND >=1 AND PMV_UPP_UND_ID IN ('UND','KG'),  (SUM(PMV_CANTIDAD/PMV_CANXUND)),0 ),2) AS CAJA,
            ROUND(IFNULL(CASE  
                WHEN PMV_CANXUND =0 AND PMV_UPP_UND_ID = 'UND' THEN SUM(PMV_CANTIDAD)
                WHEN PMV_CANXUND >= 0 AND PMV_UPP_UND_ID = 'KG' THEN SUM(PMV_CANTIDAD)
            END,0),2) AS UND_KG,
            PMV_CANXUND,         
            PDC_NUMERO,
            UGR_UND_ID
            FROM ADN_PESADAS_MOV 
            RIGHT JOIN ADN_PRODUCTOS ON PMV_UPP_PDT_CODIGO = PDT_CODIGO
            RIGHT JOIN `adn_undagru` ON PMV_UPP_PDT_CODIGO = UGR_PDT_CODIGO
            RIGHT JOIN ADN_PESADAS_DOC ON PMV_PDC_NUMERO = PDC_NUMERO 
                AND PMV_PDC_TDT_CODIGO = PDC_TDT_CODIGO
                AND PMV_PDC_CLT_CODIGO = PDC_CLT_CODIGO 
                AND PMV_PDC_SCS_CODIGO = PDC_SCS_CODIGO
            RIGHT JOIN(SELECT CLT_CODIGO AS CLTCODIGO, CLT_NOMBRE AS CLTNOMBRE FROM ADN_CLIENTES) AS CLIENTES
            ON CLIENTES.CLTCODIGO = PDC_CLT_CODIGO
            WHERE 
            PDC_NUMERO = $number
            AND PDC_CLT_CODIGO = $cliente
            GROUP BY  PDT_CODIGO;";



        $select = $this->select_all($details);

        return $select;
    }

    public function copy($id, $pv)
    {

        $queryDoc = "INSERT INTO `pesadas`.`adn_docpro` (`DPV_NUMERO`,`DPV_PVD_CODIGO`,`DPV_SCS_CODIGO`,`DPV_TDT_CODIGO`,`DPV_FECHA`,`DPV_NETO`,`DPV_BASEG`,`DPV_BASER`,`DPV_EXENTO`,`DPV_ACTIVO`,`DPV_STD_ESTADO`,`DPV_PORDCTO`,`DPV_FECHAHORA`,`DPV_HORA`,`DPV_NUMFIS`,`DPV_PLAZO`,`DPV_CONDICION`,`DPV_IVAG`,`DPV_IVAR`,`DPV_ID`,`DPV_ORDEN`,`DPV_DESCRIPCION`,`DPV_PORCENTAJE`,`DPV_TIPTRA`,`DPV_FACAFE`,`DPV_TIPOINV`,`DPV_CXP`,`DPV_BRUTO`,`DPV_FECHAVEN`,`DPV_NUMORIGEN`,`DPV_PRORRATEA`,`DPV_NUMAUX`,`DPV_VALORCAM`,`DPV_BRUTOUSD`,`DPV_NETOUSD`,`DPV_BASEGUSD`,`DPV_BASERUSD`,`DPV_BASESUSD`,`DPV_EXENTOUSD`,`DPV_IVAGUSD`,`DPV_IVARUSD`,`DPV_IVASUSD`,`DPV_VALORCAM2`,`DPV_MONEDA`,`DPV_IGTF`,`DPV_COMPENSACION`)
            SELECT `DPV_NUMERO`,`DPV_PVD_CODIGO`,`DPV_SCS_CODIGO`,`DPV_TDT_CODIGO`,`DPV_FECHA`,`DPV_NETO`,`DPV_BASEG`,`DPV_BASER`,`DPV_EXENTO`,`DPV_ACTIVO`,`DPV_STD_ESTADO`,`DPV_PORDCTO`,`DPV_FECHAHORA`,`DPV_HORA`,`DPV_NUMFIS`,`DPV_PLAZO`,`DPV_CONDICION`,`DPV_IVAG`,`DPV_IVAR`,`DPV_ID`,`DPV_ORDEN`,`DPV_DESCRIPCION`,`DPV_PORCENTAJE`,`DPV_TIPTRA`,`DPV_FACAFE`,`DPV_TIPOINV`,`DPV_CXP`,`DPV_BRUTO`,`DPV_FECHAVEN`,`DPV_NUMORIGEN`,`DPV_PRORRATEA`,`DPV_NUMAUX`,`DPV_VALORCAM`,`DPV_BRUTOUSD`,`DPV_NETOUSD`,`DPV_BASEGUSD`,`DPV_BASERUSD`,`DPV_BASESUSD`,`DPV_EXENTOUSD`,`DPV_IVAGUSD`,`DPV_IVARUSD`,`DPV_IVASUSD`,`DPV_VALORCAM2`,`DPV_MONEDA`,`DPV_IGTF`,DPV_COMPENSACION FROM ADN_DOCPRO WHERE DPV_TDT_CODIGO = 'PDA' AND DPV_ACTIVO = '1' AND DPV_NUMERO = '$id'; AND DPV_PVD_CODIGO = '$pv'";

        $queryMov = "INSERT INTO `pesadas`.`adn_movpro` (`MPR_ID`,`MPR_DPV_NUMERO`,`MPR_AMC_CODIGO`,`MPR_DPV_PVD_CODIGO`,`MPR_DPV_SCS_CODIGO`,`MPR_DPV_TDT_CODIGO`,`MPR_UPP_PDT_CODIGO`,`MPR_UPP_UND_ID`,`MPR_CTR_CODIGO`,`MPR_CANTIDAD`,`MPR_COSTOT`,`MPR_COSTOP`,`MPR_FISICO`,`MPR_LOGICO`,`MPR_CONTABLE`,`MPR_ACTIVO`,`MPR_PORDCTO`,`MPR_CANTXUND`,`MPR_PORIVA`,`MPR_TIVACOD`,`MPR_HTI_ID`,`MPR_SALDOV`,`MPR_LOTE`,`MPR_FECHALOTE`,`MPR_PRECIOLOTE`,`MPR_DESCDCTO`,`MPR_COSTOBRUTO`,`MPR_PORDESC1`,`MPR_DESCRI`,`MPR_TIPCOSANT`,`MPR_COSANT`,`MPR_NUMORG`,`MPR_TIPOORG`,`MPR_EXPORT`,`MPR_CANTAUX`,`MPR_DPV_TIPTRA`,`MPR_COSTOUSD`,`MPR_AMPLIO`,`MPR_VALORCAM`,`MPR_PIEZAS`,`MPR_CANTRECIBIDA`,`MPR_COSTOTUSD`,`MPR_FECHAVEN`)
        SELECT `MPR_ID`,`MPR_DPV_NUMERO`,`MPR_AMC_CODIGO`,`MPR_DPV_PVD_CODIGO`,`MPR_DPV_SCS_CODIGO`,`MPR_DPV_TDT_CODIGO`,`MPR_UPP_PDT_CODIGO`,`MPR_UPP_UND_ID`,`MPR_CTR_CODIGO`,`MPR_CANTIDAD`,`MPR_COSTOT`,`MPR_COSTOP`,`MPR_FISICO`,`MPR_LOGICO`,`MPR_CONTABLE`,`MPR_ACTIVO`,`MPR_PORDCTO`,`MPR_CANTXUND`,`MPR_PORIVA`,`MPR_TIVACOD`,`MPR_HTI_ID`,`MPR_SALDOV`,`MPR_LOTE`,`MPR_FECHALOTE`,`MPR_PRECIOLOTE`,`MPR_DESCDCTO`,`MPR_COSTOBRUTO`,`MPR_PORDESC1`,`MPR_DESCRI`,`MPR_TIPCOSANT`,`MPR_COSANT`,`MPR_NUMORG`,`MPR_TIPOORG`,`MPR_EXPORT`,`MPR_CANTAUX`,`MPR_DPV_TIPTRA`,`MPR_COSTOUSD`,`MPR_AMPLIO`,`MPR_VALORCAM`,`MPR_PIEZAS`,`MPR_CANTRECIBIDA`,`MPR_COSTOTUSD`,`MPR_FECHAVEN` FROM ADN_MOVPRO WHERE MPR_DPV_NUMERO = '$id' AND MPR_DPV_PVD_CODIGO = '$pv' AND MPR_DPV_TDT_CODIGO = 'PDA' AND MPR_ACTIVO = '1';";



        $resultDoc = $this->select($queryDoc);
        $resultMov = $this->select($queryMov);


        return $resultDoc;
    }


    public function insertDetails($numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $correlative, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta)
    {
        $user = !isset($_SESSION['userData']['OPE_NUMERO']) ? '1' : $_SESSION['userData']['OPE_NUMERO'];

        $insert = "INSERT IGNORE INTO `adn_pesadas` (`ID`, `PDA_NUMERO`, `PDA_AMC_ORIGEN`,PDA_AMC_DESTINO, `PDA_SCS_CODIGO`, `PDA_UPP_PDT_CODIGO`, `PDA_DET_CODIGO`, `PDA_UPP_UND_ID`,`PDA_CANXUND`, `PDA_CANTIDAD`, PDA_CANASTA_TIPO,`PDA_CANASTA`, `PDA_EXTRA`, `PDA_UBICA`, PDA_FECHA, `PDA_INICIO`, `PDA_FIN`, PDA_LLEGADA , PDA_TK , PDA_TA ,`PDA_USUARIO`,PDA_TIPO) VALUES (NULL,?, ?,?, ?, ?,?, ?,?,?,?, ?, ?, ?, ?  ,?, ?,?,?,?, ?,'3');";
        $result = $this->insert($insert, [$numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $correlative, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta, $user]);




        return $result;
    }


    public function insertSkip($numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $correlative, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta, $motivo)
    {

        $user = !isset($_SESSION['userData']['OPE_NUMERO']) ? '1' : $_SESSION['userData']['OPE_NUMERO'];
        $insert = "INSERT IGNORE INTO `adn_pesadas` (`ID`, `PDA_NUMERO`, `PDA_AMC_ORIGEN`,PDA_AMC_DESTINO, `PDA_SCS_CODIGO`, `PDA_UPP_PDT_CODIGO`, `PDA_DET_CODIGO`, `PDA_UPP_UND_ID`,`PDA_CANXUND`, `PDA_CANTIDAD`, PDA_CANASTA_TIPO,`PDA_CANASTA`, `PDA_EXTRA`, `PDA_UBICA`, PDA_FECHA, `PDA_INICIO`, `PDA_FIN`, PDA_LLEGADA , PDA_TK , PDA_TA ,`PDA_USUARIO`,PDA_TIPO,PDA_MOTIVO) VALUES (NULL,?, ?,?, ?, ?,?, ?,?,?,?, ?, ?, ?, ?  ,?, ?,?,?,?, ?,'3',?);";
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

    public function getPesadas($numero, $cliente, $sku)
    {


        $query = "SELECT `ID`, `PDA_NUMERO`, `PDA_AMC_ORIGEN`, `PDA_AMC_DESTINO`, `PDA_SCS_CODIGO`, `PDA_UPP_PDT_CODIGO`, `PDA_DET_CODIGO`, `PDA_UPP_UND_ID`, `PDA_CANXUND`, `PDA_CANTIDAD`, `PDA_CANASTA_TIPO`, `PDA_CANASTA`, ROUND( `PDA_EXTRA`,2) AS PDA_EXTRA, `PDA_UBICA`, `PDA_FECHA`, `PDA_INICIO`, `PDA_FIN`, `PDA_LLEGADA`, `PDA_TK`, `PDA_TA`, `PDA_TRANF_ID`, `PDA_USUARIO`, `PDA_TIPO`,PDA_MOTIVO FROM adn_pesadas WHERE PDA_NUMERO = '$numero' AND PDA_DET_CODIGO = '$cliente' AND PDA_UPP_PDT_CODIGO = '$sku' AND PDA_TIPO = '3' order by ID ASC";


        $select = $this->select_all($query);

        return $select;
    }

    public function deletePesadas($id, $cantidad)
    {
        $row = "SELECT * FROM ADN_PESADAS WHERE ID = '$id'";

        $executeRow = $this->select($row);

        $query = "UPDATE ADN_MOVPRO SET MPR_CANTRECIBIDA = (MPR_CANTRECIBIDA -  ? )   WHERE MPR_DPV_TDT_CODIGO = 'ODC' AND MPR_DPV_NUMERO = ? AND MPR_AMC_CODIGO = ?
            AND MPR_DPV_SCS_CODIGO = ? AND MPR_DPV_PVD_CODIGO = ? AND MPR_UPP_PDT_CODIGO = ? AND MPR_UPP_UND_ID = ?
            AND MPR_ACTIVO = '1' LIMIT 1";

        $executeUpdate = $this->update($query, [$cantidad, $executeRow['PDA_NUMERO'], $executeRow['PDA_AMC_ORIGEN'], $executeRow['PDA_SCS_CODIGO'], $executeRow['PDA_DET_CODIGO'], $executeRow['PDA_UPP_PDT_CODIGO'], $executeRow['PDA_UPP_UND_ID']]);


        $bridge = "DELETE FROM adn_pesadas_canastas WHERE PCT_PDA_ID = '$id'";

        $deletebridge = $this->delete($bridge);

        $query = "DELETE FROM adn_pesadas WHERE ID = '$id'";

        $delete = $this->delete($query);

        return $delete;
    }

    public function getDetailsToEdit($numero, $proveedor)
    {

        $query = "SELECT PDA_NUMERO,PDA_AMC_ORIGEN,PDA_AMC_DESTINO,PDA_SCS_CODIGO,PDA_DET_CODIGO,PDA_UPP_PDT_CODIGO,PDA_UPP_UND_ID, SUM(PDA_CANTIDAD) AS PDA_CANTIDAD  FROM adn_pesadas WHERE PDA_AMC_ORIGEN = '001' AND PDA_NUMERO = '$numero' AND PDA_DET_CODIGO = '$proveedor' AND PDA_TIPO = '1' GROUP BY PDA_UPP_PDT_CODIGO;";


        $result = $this->select_all($query);

        return $result;
    }

    public function receivedAmount($numero, $almacen, $sucursal, $proveedor, $producto, $unidad, $cantidad)
    {

        $query = "UPDATE ADN_MOVPRO SET MPR_CANTRECIBIDA = ? WHERE MPR_DPV_TDT_CODIGO = 'ODC' AND MPR_DPV_NUMERO = ? AND MPR_AMC_CODIGO = ?
            AND MPR_DPV_SCS_CODIGO = ? AND MPR_DPV_PVD_CODIGO = ? AND MPR_UPP_PDT_CODIGO = ? AND MPR_UPP_UND_ID = ?
            AND MPR_ACTIVO = '1' LIMIT 1";



        $update = $this->update($query, [$cantidad, $numero, $almacen, $sucursal, $proveedor, $producto, $unidad]);

        return $update;
    }

    public function searchWarrant($numero, $almacen, $sucursal, $proveedor)
    {

        $select = "SELECT *, IF(MPR_CANTIDAD <>MPR_CANTRECIBIDA,1,0) AS MERMA FROM ADN_MOVPRO WHERE MPR_DPV_TDT_CODIGO = 'ODC' 
                AND MPR_DPV_NUMERO = '$numero' AND MPR_AMC_CODIGO = '$almacen'
                AND MPR_DPV_SCS_CODIGO = '$sucursal' AND MPR_DPV_PVD_CODIGO = '$proveedor' 
                AND MPR_ACTIVO = '1' HAVING MERMA <>0";



        $result = $this->select_all($select);
        return $result;
    }

    public function validate($numero, $almacen, $sucursal, $proveedor)
    {

        /* SIN USO
            $query = "SELECT  IF(MPR_CANTIDAD <>MPR_CANTRECIBIDA,1,0) AS MERMA, SUM(IF(MPR_CANTIDAD <> 0 AND MPR_CANTRECIBIDA = 0, 1,0)) AS VALIDA  FROM ADN_MOVPRO WHERE MPR_DPV_TDT_CODIGO = 'ODC' 
            AND MPR_DPV_NUMERO = '$numero' AND MPR_AMC_CODIGO = '$almacen'
            AND MPR_DPV_SCS_CODIGO = '$sucursal' AND MPR_DPV_PVD_CODIGO = '$proveedor' 
            AND MPR_ACTIVO = '1' HAVING MERMA <>0";


            $result = $this->select($query);


            if (isset($result['VALIDA'])) {
                $result = $result['VALIDA'];
            } else {
                $result = 0;
            }

            return $result;

            */
    }

    public function validateDocument($numero, $clt)
    {

        $query = "SELECT IF(PESADAS.CONTEO = REGISTRO.CONTEO_DOCUMENTO,1,0) AS VALIDATE
        FROM (
            SELECT PDA_NUMERO AS NUMERO, PDA_DET_CODIGO AS DET, 
            ROW_NUMBER() OVER (ORDER BY PDA_UPP_PDT_CODIGO DESC) AS CONTEO  
            FROM ADN_PESADAS
            WHERE PDA_NUMERO = '$numero' AND PDA_DET_CODIGO = '$clt' AND PDA_TIPO = '3'
            GROUP BY PDA_UPP_PDT_CODIGO LIMIT 1
        ) AS PESADAS
        JOIN (
            SELECT DOCUMENTOS.DCL_NUMERO AS NUMERO, DOCUMENTOS.DCL_CLT_CODIGO AS CLIENTE, COUNT(*) AS CONTEO_DOCUMENTO
            FROM (
                SELECT DCL_NUMERO,
                 DCL_CLT_CODIGO
                FROM ADN_MOVCLI
                JOIN ADN_DOCCLI ON MCL_DCL_NUMERO = DCL_NUMERO AND MCL_DCL_SCS_CODIGO = DCL_SCS_CODIGO AND MCL_DCL_TDT_CODIGO = DCL_TDT_CODIGO AND MCL_DCL_TIPTRA = DCL_TIPTRA
                
                WHERE DCL_NUMERO = '$numero' AND DCL_CLT_CODIGO = '$clt'
                AND DCL_TDT_CODIGO = 'PDA'
                GROUP BY MCL_UPP_PDT_CODIGO
                
            ) AS DOCUMENTOS
            GROUP BY DOCUMENTOS.DCL_NUMERO, DOCUMENTOS.DCL_CLT_CODIGO
        ) AS REGISTRO
        ON PESADAS.NUMERO = REGISTRO.NUMERO AND PESADAS.DET = REGISTRO.CLIENTE;";


        $execute = $this->select($query);

        if (isset($execute)) {
            $result = $execute['VALIDATE'];
        } else {
            $result = 0;
        }

        return $result;
    }




    public function getNetCalculation($numero, $proveedor, $sucursal)
    {

        /*
            $calculoNeto = "SELECT SUM( MPR_CANTIDAD * MPR_COSTOBRUTO ) as COSTO
            FROM adn_movpro
            WHERE MPR_DPV_NUMERO = '$numero'
            AND MPR_DPV_PVD_CODIGO = '$proveedor'
            AND MPR_DPV_SCS_CODIGO = '$sucursal'
            AND MPR_DPV_TDT_CODIGO = 'NCCI'
            AND MPR_DPV_TIPTRA = 'D'";



            $neto = $this->select($calculoNeto);

            $netoNew = !isset($neto['COSTO']) ? 0 : $neto['COSTO'];

            $queryUpdate = "UPDATE adn_docpro SET DPV_NETO = ?
            WHERE DPV_NUMERO = ?
            AND DPV_PVD_CODIGO = ?
            AND DPV_SCS_CODIGO = ?
            AND DPV_TDT_CODIGO = 'NCCI'
            AND DPV_ACTIVO = '1' AND DPV_TIPTRA = 'D'";


            $executeUpdateDocpro = $this->update($queryUpdate, [$netoNew, $numero, $proveedor, $sucursal]);
            */

        $docUpdate = "UPDATE adn_docpro SET DPV_CERRADO = 1 
            WHERE DPV_NUMERO = ?
            AND DPV_PVD_CODIGO = ?
            AND DPV_SCS_CODIGO = ?
            AND DPV_TDT_CODIGO = 'ODC'
            AND DPV_ACTIVO = '1' AND DPV_TIPTRA = 'D'";


        $executeDocproUpdate = $this->update($docUpdate, [$numero, $proveedor, $sucursal]);

        return $executeDocproUpdate;
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

    public function getProducts()
    {

        $query = "SELECT
            'PDA' AS TIPO,
            PDT_CODIGO AS CODIGO,
            PDT_DESCRIPCION AS DESCRIPCION, 
            IFNULL(UGR_UND_ID,'') AS UND,
            PRE_PRECIO AS PRECIO,
            PDT_TIV_CODIGO AS TIV,  
            UGR_EX1/*-PERSONALIZAR_PEDIDO_COMPROMETIDO( PDT_CODIGO ) */AS EXIS,
            PRE_PLT_LISTA AS LISTA,
            PDT_LICLTSCAJA AS CAPACIDAD,
            PRE_METCOS AS METCOS,  
            IF(PRE_METCOS = '4',PDT_COSTOMER,IF(PRE_METCOS = '1',UPP_COSTOU,IF(PRE_METCOS = '2',UPP_COSTOP, IF(PRE_METCOS = '0',IF(UPP_COSTOP>UPP_COSTOU, UPP_COSTOP,UPP_COSTOU), IF(UPP_COSTOP>UPP_COSTOU,UPP_COSTOP,UPP_COSTOU))))) AS COSTOT,  
            UPP_COSTOP AS COSTOP,
            PDT_COSTOMER AS  COSTOMER,
            UPP_COSTOU AS COSTOU,
            '0' AS CANTIDAD,
            '001' AS ALMCOD,
            GET_IVA(1, PDT_TIV_CODIGO, CURDATE()) AS HTI,
            ROUND(PRE_PRECIO/(1+(GET_IVA(5, PDT_TIV_CODIGO, CURDATE())/100)), 2) AS BASE,
            GET_IVA(5, PDT_TIV_CODIGO, CURDATE()) AS PORIVA,
            VALIDA_PRECIO_COSTO(PDT_CODIGO,UGR_UND_ID,PRE_PRECIO) AS VALIDA_PRECIO
            FROM ADN_PRODUCTOS  
            INNER JOIN ADN_UNDPROD ON UPP_PDT_CODIGO = PDT_CODIGO
            INNER JOIN ADN_UNDAGRU ON UGR_PDT_CODIGO = PDT_CODIGO 
            INNER JOIN ADN_PRECIOS ON PRE_UGR_PDT_CODIGO = UGR_PDT_CODIGO AND PRE_UGR_UND_ID = UGR_UND_ID
            INNER JOIN ADN_PRELISTA ON PLT_LISTA = PRE_PLT_LISTA
            WHERE PDT_CODIGO <> '+' 
                AND PDT_CODIGO <> '-'
                AND PDT_CODIGO <> '++'
                AND PDT_CODIGO <> '--'
                AND UGR_VENTA = '1'
                AND IF(PDT_UPT_CODIGO = '000002',1,UGR_EX1)
                AND PDT_ESTADO = '1'
                AND PRE_PLT_LISTA='A'
                HAVING  VALIDA_PRECIO <> 1;";

        $execute = $this->select_all($query);


        return $execute;
    }

    public function setProducts($numero, $scs_codigo, $tipodoc, $pda_det_codigo, $upp_pdt_codigo, $upp_und_id, $canxund, $cantidad)
    {
        $insert = "INSERT INTO `adn_pesadas_mov` (`PMV_PDC_NUMERO`, `PMV_PDC_SCS_CODIGO`, `PMV_PDC_TDT_CODIGO`,`PMV_PDC_CLT_CODIGO`, `PMV_UPP_PDT_CODIGO`, `PMV_UPP_UND_ID`, `PMV_CANXUND`, `PMV_CANTIDAD`, `PMV_ACTIVO`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?); ";

        $execute = $this->insert($insert, [$numero, $scs_codigo, $tipodoc, $pda_det_codigo, $upp_pdt_codigo, $upp_und_id, $canxund, $cantidad, 1]);

        return $execute;
    }

    public function postClose($numero, $sucursal, $proveedor, $tipo)
    {

        $call = "CALL `POSTCERRAR_PESADAS_ODC`('$numero', '$proveedor', '$sucursal','$tipo')";

        //$execute = $this->select($call);
        $execute = 1;
        return $execute;
    }


    public function getCorrelative()
    {

        $coorelativo = "SELECT LPAD(CAST(PDC_NUMERO AS INTEGER ) + 1, 4, 0 ) AS PDC_CORRELATIVE FROM ADN_PESADAS_DOC ORDER BY PDC_NUMERO DESC LIMIT 1;";

        $coorelativo = $this->select($coorelativo);

        return $coorelativo;
    }

    public function getSellers()
    {
        $clients = "SELECT VEN_CODIGO, VEN_NOMBRE FROM ADN_VENDEDORES";

        $clients = $this->select_all($clients);

        return $clients;
    }



    public function setDocument($numero, $cliente)
    {


        $insert = "INSERT `adn_pesadas_doc` (`PDC_NUMERO`, `PDC_SCS_CODIGO`, `PDC_CLT_CODIGO`,PDC_FECHA, `PDC_USUARIO`, `PDC_TDT_CODIGO`, `PDC_ID`, `PDC_ACTIVO`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?);";
        $result = $this->insert($insert, [$numero, '000001', $cliente, '0000-00-00', '1', 'FAV', NULL, 0]);
    }



    public function cancelDocument($codigo)
    {

        $select = "SELECT PMV_PDC_NUMERO FROM ADN_PESADAS_MOV WHERE PMV_PDC_NUMERO = '$codigo'";
        $request = $this->select_all($select);

        if (!empty($request)) {
            $query = "DELETE FROM ADN_PESADAS_MOV WHERE PMV_PDC_NUMERO = '$codigo';";
            $delete = $this->delete($query);
        }

        $select = "SELECT PDC_NUMERO FROM ADN_PESADAS_DOC WHERE PDC_NUMERO = '$codigo'";
        $request = $this->select_all($select);


        if (!empty($request)) {
            $query = "DELETE FROM ADN_PESADAS_DOC WHERE PDC_NUMERO = '$codigo';";
            $delete = $this->delete($query);
        }


        $select = "SELECT PDA_NUMERO FROM ADN_PESADAS JOIN ADN_PESADAS_CANASTAS ON PCT_PDA_ID = ID WHERE PDA_NUMERO = '$codigo'";
        $request = $this->select_all($select);

        if (!empty($request)) {
            $query = "DELETE FROM ADN_PESADAS_CANASTAS  WHERE PCT_PDA_ID IN (SELECT ID FROM ADN_PESADAS WHERE PDA_NUMERO = '$codigo');";
            $delete = $this->delete($query);
        }

        $select = "SELECT PDA_NUMERO FROM ADN_PESADAS WHERE PDA_NUMERO = '$codigo'";
        $request = $this->select_all($select);

        if (!empty($request)) {
            $query = "DELETE FROM ADN_PESADAS WHERE PDA_NUMERO = '$codigo';";
            $delete = $this->delete($query);
        }


        return $delete;
    }



    public function updateDocument($codigo, $cliente)
    {

        $query = "UPDATE ADN_PESADAS_DOC SET PDC_CLT_CODIGO = ?, PDC_ACTIVO = ? WHERE PDC_NUMERO = ?";
        $update = $this->update($query, [$cliente, 1, $codigo]);

        return $update;
    }


    public function getDoc($idClient)
    {

        $query = "SELECT
                A.DCL_NUMERO,
                A.DCL_FECHA,
                A.DCL_NETO,
                A.DCL_TDT_CODIGO AS TIPODOC,
                DCL_CLT_CODIGO
                FROM ADN_DOCCLI A
                    INNER JOIN ADN_MOVCLI ON MCL_DCL_SCS_CODIGO = DCL_SCS_CODIGO
                        AND MCL_DCL_NUMERO = DCL_NUMERO 
                        AND MCL_DCL_TDT_CODIGO = DCL_TDT_CODIGO
                WHERE DCL_TDT_CODIGO IN  ('PED','PEDW','PEDW2')
                    AND DCL_SCS_CODIGO = '000001'
                    AND DCL_CLT_CODIGO = '$idClient'
                    AND DCL_ACTIVO = '1' 
                    AND DCL_TIPTRA = 'D'
                    AND DCL_NUMGUIA = ''
                    AND MCL_COMPUESTO = 0
                    AND DCL_STD_ESTADO IN ('PEN','PAG')
                GROUP BY MCL_DCL_TDT_CODIGO, MCL_DCL_NUMERO  HAVING SUM(MCL_CANTIDAD - MCL_EXPORT) > 0 ;";
        $execute = $this->select_all($query);

        return $execute;
    }

    public function getDocDetails($idNumber, $tipodoc, $idClient)
    {

        $query = " SELECT   MCL_ID AS ID,       
                            MCL_DCL_NUMERO AS NUMERO,
                            DCL_CLT_CODIGO AS CLIENTE,
                            DCL_VEN_CODIGO AS VENDEDOR,
                            MCL_DCL_TDT_CODIGO AS TDT,
                            MCL_UPP_PDT_CODIGO AS CODIGO,
                            MCL_DESCRI AS DESCRIPCION,
                            (MCL_CANTIDAD-MCL_EXPORT)  AS CANT,
                            MCL_UPP_UND_ID AS UND,
                            PDT_LICLTSCAJA AS CAPACIDAD,
                            ROUND(IF(PDT_PESO_BALANZA=0 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR((MCL_CANTIDAD/PDT_LICLTSCAJA)),
                      IF(PDT_PESO_BALANZA=1 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR((MCL_PIEZAS/PDT_LICLTSCAJA)),0 )),2) AS CAJA,
                             ROUND(IFNULL(CASE  
                            WHEN PDT_LICLTSCAJA >=0 AND MCL_UPP_UND_ID = 'UND' THEN MCL_CANTIDAD - MCL_EXPORT
                            WHEN PDT_LICLTSCAJA >= 0 AND MCL_UPP_UND_ID = 'KG' THEN MCL_CANTIDAD - MCL_EXPORT       
                            END,0),2)  AS  UND_KG,
                       
                 IF(PRE_METCOS = '4',PDT_COSTOMER,IF(PRE_METCOS = '1',UPP_COSTOU,IF(PRE_METCOS = '2',UPP_COSTOP, IF(PRE_METCOS = '0',IF(UPP_COSTOP>UPP_COSTOU,UPP_COSTOP,UPP_COSTOU), IF(UPP_COSTOP>UPP_COSTOU,UPP_COSTOP,UPP_COSTOU))))) AS COSTOT,
                UPP_COSTOP AS COSTOP,
                PLT_LISTA AS LISTA,
                GET_IVA('5',PDT_TIV_CODIGO,CURDATE()) AS PORIVA,
                PDT_TIV_CODIGO AS TIV,
                PRE_METCOS AS METCOS,
                PDT_DESCRIPCION AS DESCRIPCION,
                PDT_COSTOMER AS COSTOMER,
                UPP_COSTOU AS COSTOU,
                MCL_BASE AS BASE,
                /* ROUND(PRE_PRECIO/(1+(GET_IVA(5, PDT_TIV_CODIGO, CURDATE())/100)), 2) AS BASE,*/
                MCL_HTI_ID AS HTI
                            FROM ADN_MOVCLI
                JOIN ADN_DOCCLI ON MCL_DCL_NUMERO = DCL_NUMERO 
                    AND MCL_DCL_TDT_CODIGO = DCL_TDT_CODIGO
                    AND MCL_DCL_SCS_CODIGO = DCL_SCS_CODIGO 
                    AND MCL_DCL_TIPTRA = DCL_TIPTRA 
                INNER JOIN ADN_PRELISTA ON PLT_LISTA = MCL_PLT_LISTA
                            INNER JOIN ADN_PRECIOS ON PRE_UGR_PDT_CODIGO = MCL_UPP_PDT_CODIGO
                            AND PRE_PLT_LISTA = MCL_PLT_LISTA AND PRE_UGR_UND_ID = MCL_UPP_UND_ID
                            INNER JOIN ADN_PRODUCTOS ON PDT_CODIGO = MCL_UPP_PDT_CODIGO
                INNER JOIN adn_undagru ON MCL_UPP_PDT_CODIGO = UGR_PDT_CODIGO 
                INNER JOIN ADN_UNDPROD ON UPP_PDT_CODIGO = PRE_UGR_PDT_CODIGO 
                        AND MCL_UPP_UND_ID = UGR_UND_ID  
                            WHERE MCL_DCL_SCS_CODIGO = '000001'
                            AND MCL_DCL_NUMERO = '$idNumber'
                            AND MCL_DCL_TDT_CODIGO = '$tipodoc'
                            AND DCL_CLT_CODIGO = '$idClient'
                            AND  (MCL_CANTIDAD-MCL_EXPORT)  > 0
                            AND MCL_COMPUESTO <> 1
                            ORDER BY MCL_ID;";


        $execute = $this->select_all($query);

        return $execute;
    }


    public function correlativePDAT()
    {

        $query = "SELECT IFNULL(LPAD( CAST(MAX(DIN_NUMERO) AS UNSIGNED)+1,20,'0'),'00000000000000000001') AS CORRELATIVO FROM `ADN_DOCINV`
 WHERE DIN_TDT_CODIGO = 'PDAT' ORDER BY DIN_NUMERO DESC LIMIT 1;";

        $execute = $this->select($query);

        $correlativo = !isset($execute['CORRELATIVO']) ? '0001' : $execute['CORRELATIVO'];

        return $correlativo;
    }


    public function insertDetailsImport($numero, $tipodoc, $scs, $clt, $tdtOrigen, $NumberOrigen, $pdts, $unds, $canxund, $cantidades, $fecha, $ids)
    {
        $user = !isset($_SESSION['userData']['OPE_NUMERO']) ? '1' : $_SESSION['userData']['OPE_NUMERO'];

        $query = "INSERT IGNORE INTO `adn_pesadas_doc` (`PDC_NUMERO`, `PDC_TDT_CODIGO`, `PDC_SCS_CODIGO`, `PDC_CLT_CODIGO`, `PDC_FECHA`, `PDC_USUARIO`, `PDC_ACTIVO`) 
                                             VALUES (          ?   ,     ?         , ?            ,    ?       , ?     ,   ?      , ?); ";



        $inserMov = "INSERT IGNORE INTO `ADN_PESADAS_MOV` (`PMV_ID`, `PMV_PDC_NUMERO`, `PMV_PDC_TDT_CODIGO`, `PMV_PDC_SCS_CODIGO`, `PMV_UPP_PDT_CODIGO`, `PMV_UPP_UND_ID`, `PMV_CANXUND`, `PMV_CANTIDAD`, `PMV_EXPORT`, `PMV_ACTIVO`, `PMV_TIPO`) 
        VALUES ";

        foreach ($cantidades as $index => $cantidad) {
            $inserMov = $inserMov . "(NULL   , '$numero'       , '$tipodoc'          , '$scs'             , '" . $pdts[$index] . "'  , '" . $unds[$index] . "' , '" . $canxund[$index] . "'  , '" . $cantidades[$index] . "'        , 0          , 1        , 3),";
        }

        $inserMov = substr($inserMov, 0, -1);

        $execute = $this->insert($query, [$numero, $tipodoc, $scs, $clt, $fecha, $user, 1]);

        $executeMov = $this->insert_massive($inserMov);


        /* foreach($cantidades as $index => $cantidad ){
            
            $this->updateExpot($ids[$index],$cantidad);
            
        }*/

        //  $selectDetails = $this->getDetailsImport($clt, $numero);

        //return $selectDetails;
    }


    public function insertCallTransfer($numero, $tipodoc, $scs, $vnd, $tdtOrigen, $NumberOrigen, $fecha, $data, $type, $amc)
    {

        $procedure = "CALL `IMPORT_PESADAS`( '$numero', '$tipodoc', '$scs','$vnd', '$tdtOrigen', '$NumberOrigen', '$data','$type' );";


        dep($procedure);

        die();

        $execute = $this->select($procedure);


        if (isset($execute['CORRELATIVE'])) {
            $correlative = $execute['CORRELATIVE'];
        } else {
            $correlative = '0000000001';
        }

        $selectDetails = $this->getDetailsImport($clt, $correlative, $amc);

        return $selectDetails;
    }

    public  function getDetailsImport($clt, $number, $amc)
    {
        $userAmc = substr($amc, -1);


        $query = " SELECT 
           DCL_NUMERO,
          CLT_NOMBRE,
          PDT_PESO_BALANZA,
          DCL_NUMERO, 
          CLT_CODIGO AS DCL_CLT_CODIGO,
          PDT_DESCRIPCION,
          MCL_UPP_PDT_CODIGO,
          MCL_UPP_UND_ID,
          DCL_DESCRIDOWN,     
          IF(DCL_DESCRIDOWN = '1',
          IF(PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND'), FLOOR(SUM(UGR_EX1/PDT_LICLTSCAJA)), 0.00 ),

                    IF(
                        ROUND(IF(PDT_PESO_BALANZA=1 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(SUM(MCL_PIEZAS/PDT_LICLTSCAJA)),
                            IF(PDT_PESO_BALANZA=0 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(SUM(MCL_CANTIDAD/PDT_LICLTSCAJA)),0 )),2) >
                        ROUND(IF(PDT_PESO_BALANZA=0 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(UGR_EX$userAmc/PDT_LICLTSCAJA),
                            IF(PDT_PESO_BALANZA=1 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(UGR_EX$userAmc/PDT_LICLTSCAJA),0 )),2),
                        ROUND(IF(PDT_PESO_BALANZA=0 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(UGR_EX$userAmc/PDT_LICLTSCAJA),
                            IF(PDT_PESO_BALANZA=1 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(UGR_EX$userAmc/PDT_LICLTSCAJA),0 )),2) ,
                        ROUND(IF(PDT_PESO_BALANZA=0 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(SUM(MCL_CANTIDAD/PDT_LICLTSCAJA)),
                            IF(PDT_PESO_BALANZA=1 AND PDT_LICLTSCAJA >=1 AND UGR_UND_ID IN ('UND','KG'),  FLOOR(SUM(MCL_PIEZAS/PDT_LICLTSCAJA)),0 )),2)
                        )
            )  AS CAJA,
      ROUND(IFNULL(CASE  
            WHEN PDT_LICLTSCAJA =0 AND MCL_UPP_UND_ID = 'UND' THEN SUM(IF(DCL_DESCRIDOWN = '1',UGR_EX$userAmc, MCL_CANTIDAD))
            WHEN PDT_LICLTSCAJA >= 0 AND MCL_UPP_UND_ID = 'KG' THEN SUM(IF(DCL_DESCRIDOWN = '1',UGR_EX$userAmc, MCL_CANTIDAD))
            WHEN PDT_LICLTSCAJA >= 1 AND MCL_UPP_UND_ID = 'UND' THEN 
            (SUM(IF(DCL_DESCRIDOWN = '1',UGR_EX$userAmc, MCL_CANTIDAD)/PDT_LICLTSCAJA) - FLOOR(SUM(IF(DCL_DESCRIDOWN = '1',UGR_EX$userAmc, MCL_CANTIDAD)/PDT_LICLTSCAJA)))*PDT_LICLTSCAJA
        END,0),2) AS UND_KG,
      PDT_LICLTSCAJA,
      DCL_ACTIVO AS DCL_PDA_CONTEO,
      IFNULL(PESADO.PESADO,0) AS PESADO,
    '0' AS PIEZAS
            
           FROM `ADN_MOVCLI` 
        JOIN `ADN_DOCCLI` ON MCL_DCL_NUMERO = DCL_NUMERO
            AND MCL_DCL_TDT_CODIGO = DCL_TDT_CODIGO
            AND MCL_DCL_SCS_CODIGO = DCL_SCS_CODIGO
        JOIN `adn_clientes` ON DCL_CLT_CODIGO = CLT_CODIGO
        JOIN `adn_productos` ON MCL_UPP_PDT_CODIGO = PDT_CODIGO
        JOIN `adn_undagru` ON PDT_CODIGO = UGR_PDT_CODIGO AND MCL_UPP_UND_ID = UGR_UND_ID
        LEFT JOIN (
             SELECT 
                PDA_NUMERO, 
                PDA_DET_CODIGO, 
                PDA_UPP_PDT_CODIGO, 
                PDA_UPP_UND_ID, 
                IFNULL(ROUND(SUM( IF(PDA_CANXUND >= 1 AND PDA_UPP_UND_ID = 'UND', (PDA_CANTIDAD-PDA_EXTRA)/PDA_CANXUND, PDA_CANTIDAD-PDA_EXTRA)),2),0) AS PESADO 
            FROM ADN_PESADAS 
                WHERE 
                      PDA_DET_CODIGO = '$clt' 
                  AND PDA_NUMERO = '$number'
                  AND PDA_TIPO = '3'
                GROUP BY PDA_UPP_PDT_CODIGO, PDA_UPP_UND_ID
                
                ) AS PESADO ON PESADO.PDA_NUMERO = DCL_NUMERO 
                      AND PESADO.PDA_DET_CODIGO = DCL_CLT_CODIGO 
                      AND PESADO.PDA_UPP_PDT_CODIGO = MCL_UPP_PDT_CODIGO 
                      AND PESADO.PDA_UPP_UND_ID = MCL_UPP_UND_ID
              WHERE DCL_NUMERO = '$number'
          AND DCL_CLT_CODIGO = '$clt'
               AND DCL_TDT_CODIGO = 'PDA'
             GROUP BY MCL_UPP_PDT_CODIGO; ";


        $execute = $this->select_all($query);

        return $execute;
    }

    public function updateExpot($id, $cantidad)
    {

        $query = "UPDATE ADN_MOVCLI SET MCL_EXPORT = ? WHERE MCL_ID = ?";

        $update = $this->update($query, [$cantidad, $id]);

        return $update;
    }

    public function insertCall($numero, $amc_origen, $amc_destino, $sucursal, $producto, $proveedor, $und, $canxund, $cantidad, $canasta, $extra, $ubica, $fecha, $inicio, $fin, $llegada, $tk, $ta, $tipoCanasta)
    {
        $user = !isset($_SESSION['userData']['OPE_NUMERO']) ? '1' : $_SESSION['userData']['OPE_NUMERO'];
        $call = "CALL INSERT_PESADAS('$numero', '$amc_origen', '$amc_destino', '$sucursal', '$producto', '$proveedor', '$und', '$canxund', '$cantidad', '$canasta', '$extra', '$ubica', '$fecha', '$inicio', '$fin', '$llegada', '$tk', '$ta','$user','3','$tipoCanasta')";


        $execute = $this->select($call);
        return $execute;
    }

    public function updateClose($numero, $clt, $scs)
    {

        $call = "CALL UPDATE_PESADAS('$clt', '$numero', '$scs')";


        $execute = $this->select($call);
        return $execute;
    }



    public function deleteDocument($numero, $clt, $scs)
    {

        $callDelete = "CALL DELETE_PESADAS('$numero', '$clt','$scs')";


        $execute = $this->select($callDelete);
        return $execute;
    }


    public function generatePdfGeneral($numero, $codigo, $sucursal)
    {

        $sql = "SELECT 
            PDA_NUMERO, 
            PDA_DET_CODIGO, 
            CLT_NOMBRE,
            PDA_TK,
            PDA_TA,
            PDA_LLEGADA,
            COUNT(PDA_UPP_PDT_CODIGO) AS PRODUCTOS,
            CONCAT(ROUND(SUM(IF(PDA_CANXUND >= 1 AND PDA_UPP_UND_ID = 'UND', PDA_CANTIDAD/PDA_CANXUND, 0 )) , 2), ' CAJAS') AS CAJAS,
            CONCAT(ROUND(SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD, 0)), 2 ), ' KG/UND')AS KG_UND ,
            CONCAT(SUM(ROUND(PDA_EXTRA,2)), ' KG') AS EXTRA,
            IFNULL(PESADASCANASTAS.PCT_CANTIDAD,0)AS TARAS,
            ROUND( SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG',PDA_CANTIDAD - PDA_EXTRA, PDA_EXTRA) ),2) AS BRUTO,
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
        JOIN ADN_CLIENTES ON CLT_CODIGO = PDA_DET_CODIGO
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

            GROUP BY PDA_NUMERO, PDA_DET_CODIGO
            
        )AS PESADASCANASTAS
        ON PESADASCANASTAS.CANASTAS_PDANUMERO = PDA_NUMERO
         AND PESADASCANASTAS.DET = PDA_DET_CODIGO
        WHERE 
        PDA_TIPO = '3'
        AND PDA_NUMERO = '@NUMERO'  
        AND PDA_DET_CODIGO = '@CODIGO'
        AND  PDA_SCS_CODIGO = '@SUCURSAL'
        AND PDA_INICIO <>  '00:00:00'
        GROUP BY PDA_NUMERO, PDA_DET_CODIGO;";

        $newSql = str_replace('@SUCURSAL', $sucursal, str_replace('@CODIGO', $codigo, str_replace('@NUMERO', $numero, $sql)));

        $execute = $this->select_all($newSql);

        return $execute;
    }

    public function generatePdf($numero, $codigo, $sucursal)
    {
        $sql = "SELECT 
        PDA_NUMERO, 
        PDA_DET_CODIGO, 
        CLT_NOMBRE,
        PDA_UPP_PDT_CODIGO, 
        PDT_DESCRIPCION, 
        PDA_UPP_UND_ID, 
        PDA_TK,
        PDA_TA,
        PDA_LLEGADA,
        CONTEO_PESADAS.CANT_PESADAS AS TOTAL_PESADA,
        CONCAT(SUM(PDA_CANTIDAD),' ',PDA_UPP_UND_ID) AS RECIBIDO,
        CONCAT(ROUND(SUM(IF(PDA_CANXUND >= 1 AND PDA_UPP_UND_ID = 'UND', PDA_CANTIDAD/PDA_CANXUND, 0 ) ), 2), ' CAJAS')AS CAJAS,
        SUM(PDA_CANTIDAD),
        CONCAT(ROUND(SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD, 0)), 2 ),  ' KG/UND')AS KG_UND , 
        IFNULL(PESADASCANASTAS.PCT_CANTIDAD,0)AS CANASTAS,
        CONCAT(ROUND(SUM(PDA_EXTRA),2), ' KG') AS EXTRA,
        MIN(PDA_INICIO) AS INICIO, 
        MAX(PDA_FIN) AS FIN,
        PDA_FECHA,
        CONCAT(ROUND(TIME_TO_SEC(TIMEDIFF(MAX(PDA_FIN),MIN(PDA_INICIO)))/60,2), ' Min') AS DURACION,
        ROUND(SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD - PDA_EXTRA, PDA_EXTRA )), 2) AS NETO_MENOS_EXTRA,
        EMPRESA.EMP_NOMBRE, EMPRESA.EMP_RIF, EMPRESA.EMP_DIRECCION1, EMPRESA.EMP_TELEFONO1, EMPRESA.EMP_EMAIL
        FROM  ADN_PESADAS
        JOIN ADN_PRODUCTOS ON PDT_CODIGO = PDA_UPP_PDT_CODIGO
        JOIN ( SELECT '1' AS INDICE, EMP_NOMBRE, EMP_RIF, EMP_DIRECCION1, EMP_TELEFONO1, EMP_EMAIL FROM sistemasadn.`adn_empresa` LIMIT 1 )
        AS EMPRESA ON EMPRESA.INDICE = '1'
        JOIN ADN_CLIENTES ON CLT_CODIGO = PDA_DET_CODIGO
        LEFT JOIN (
            SELECT 
            GROUP_CONCAT( PCT_CANTIDAD, ' - ',CTA_EQUIVALENCIA) AS PCT_CANTIDAD,
            PCT_CTA_TIPO,
            PCT_NUMERO AS PCTNUMERO,
            PDA_NUMERO AS CANASTAS_PDANUMERO,
            PDA_UPP_PDT_CODIGO AS PDTCODIGO
            FROM ADN_PESADAS
            JOIN ADN_PESADAS_CANASTAS ON PDA_CANASTA_TIPO = PCT_NUMERO 
            JOIN `adn_canasta_tipo` ON cta_codigo = pct_cta_tipo
            WHERE  PCT_CTA_TIPO != '0000'
            GROUP BY PDA_NUMERO, PDA_UPP_PDT_CODIGO
            
        )
        AS PESADASCANASTAS
        ON PESADASCANASTAS.CANASTAS_PDANUMERO = PDA_NUMERO
        AND PESADASCANASTAS.PDTCODIGO = PDA_UPP_PDT_CODIGO
        JOIN (
            SELECT 
            PDA_NUMERO AS PDANUMERO,
            PDA_DET_CODIGO AS DET_CODIGO,
            PDA_SCS_CODIGO AS SCS_CODIGO,
            COUNT(PDA_NUMERO )AS CANT_PESADAS,
            PDA_UPP_PDT_CODIGO AS PDAPRODUCTO
            FROM ADN_PESADAS_CANASTAS 
            JOIN ADN_PESADAS ON PCT_NUMERO = PDA_CANASTA_TIPO
            GROUP BY PDA_NUMERO, PDA_DET_CODIGO,PDA_SCS_CODIGO,PDA_UPP_PDT_CODIGO
        )
        AS CONTEO_PESADAS
        ON CONTEO_PESADAS.PDANUMERO = PDA_NUMERO
        AND CONTEO_PESADAS.DET_CODIGO = PDA_DET_CODIGO
        AND CONTEO_PESADAS.SCS_CODIGO = PDA_SCS_CODIGO 
        AND CONTEO_PESADAS.PDAPRODUCTO = PDA_UPP_PDT_CODIGO 
        WHERE PDA_TIPO = '3' AND PDA_NUMERO = '@NUMERO'  AND PDA_DET_CODIGO = '@CODIGO'
        AND  PDA_SCS_CODIGO = '@SUCURSAL'
        GROUP BY PDA_UPP_PDT_CODIGO, PDA_UPP_UND_ID;";

        $newSql = str_replace('@SUCURSAL', $sucursal, str_replace('@CODIGO', $codigo, str_replace('@NUMERO', $numero, $sql)));


        $execute = $this->select_all($newSql);

        return $execute;
    }

    public function generatePdfDetallPesada($numero, $codigo, $producto)
    {
        $sql = "SELECT
        ROUND(INFOGENERAL.NETO,2) AS NETO,
        ROUND(INFOGENERAL.BRUTO,2) AS BRUTO,
        ROUND(INFOGENERAL.EXTRA,2) AS EXTRA,
        PDA_TK,
        PDA_TA,
        PDA_FECHA,
        CLT_CODIGO,
        CLT_NOMBRE,
        PDA_NUMERO,
        PDA_UPP_PDT_CODIGO,
        PDA_DET_CODIGO,
        PDA_UPP_UND_ID,
        PDA_CANTIDAD,
        PDA_CANXUND,
        PDA_CANASTA,
        CTA_DESCRIPCION,
        PDA_INICIO,
        PDA_FIN,
        PDA_LLEGADA,
        ROUND(IF(PDA_CANXUND > 0 AND PDA_UPP_UND_ID = 'UND', PDA_CANTIDAD/PDA_CANXUND, 0), 2) AS CAJAS,
        ROUND(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD - PDA_EXTRA, 0), 2)AS 'KG_UND',
        ROUND(PDA_CANTIDAD,2) AS PDA_CANTIDAD,
        ROUND(PDA_EXTRA, 2) AS PDA_EXTRA,
        IFNULL(PESADASCANASTAS.PCT_CANTIDAD,0)AS TARAS,
        OPE_NOMBRE,
        EMPRESA.EMP_NOMBRE, EMPRESA.EMP_RIF, EMPRESA.EMP_DIRECCION1, EMPRESA.EMP_TELEFONO1, EMPRESA.EMP_EMAIL
        FROM ADN_PESADAS
        JOIN ADN_PESADAS_CANASTAS ON PDA_CANASTA_TIPO = PCT_NUMERO 
        JOIN ADN_CANASTA_TIPO ON CTA_CODIGO = PCT_CTA_TIPO
        JOIN ADN_DOCCLI ON PDA_DET_CODIGO = DCL_CLT_CODIGO AND PDA_NUMERO = DCL_NUMERO
        JOIN ADN_CLIENTES ON CLT_CODIGO = DCL_CLT_CODIGO
        JOIN ( SELECT '1' AS INDICE, EMP_NOMBRE, EMP_RIF, EMP_DIRECCION1, EMP_TELEFONO1, EMP_EMAIL FROM sistemasadn.`adn_empresa` LIMIT 1 ) AS EMPRESA
        JOIN ( SELECT OPE_NOMBRE, OPE_NUMERO FROM sistemasadn.adn_usuarios) AS OPERADORES ON OPE_NUMERO = PDA_USUARIO
        JOIN (
            SELECT
            /*PDA_NUMERO AS PDANUMERO, 
            PDA_UPP_PDT_CODIGO AS PDT_CODIGO,
            PDA_DET_CODIGO AS DETCODIGO,
            PDA_UPP_UND_ID AS UNIDAD,
            SUM(PDA_CANTIDAD )as PDACANTIDAD,
            PDA_CANXUND AS CANXUND,
            PDA_CANASTA AS CANASTA,
            CTA_DESCRIPCION AS CANASTADESCRI,
            PDA_INICIO AS INICIO,
            PDA_FIN AS FIN,
            */
            PDA_UPP_PDT_CODIGO AS PDT_CODIGO,
            IF(PDA_CANXUND > 0 AND PDA_UPP_UND_ID = 'UND', PDA_CANTIDAD/PDA_CANXUND, 0) AS CAJAS,
            SUM(PDA_EXTRA) AS EXTRA,
            SUM(PDA_CANTIDAD) AS BRUTO,
            SUM(IF(PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG', PDA_CANTIDAD - PDA_EXTRA, PDA_CANTIDAD)) AS NETO
            FROM ADN_PESADAS
            
            WHERE PDA_NUMERO = '$numero'
            AND PDA_DET_CODIGO = '$codigo'
            AND PDA_UPP_PDT_CODIGO = '$producto'
            AND PDA_TIPO = '3'
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
                WHERE  PCT_CTA_TIPO != '0000'
                GROUP BY ID, PDA_NUMERO, PDA_UPP_PDT_CODIGO
                
            )
            AS PESADASCANASTAS
            ON PESADASCANASTAS.CANASTAS_PDANUMERO = PDA_NUMERO
            AND PESADASCANASTAS.PDTCODIGO = PDA_UPP_PDT_CODIGO
            AND PESADASCANASTAS.PDAID = ID  
        WHERE PDA_NUMERO = '$numero'
        AND PDA_DET_CODIGO = '$codigo'
        AND PDA_UPP_PDT_CODIGO = '$producto'
        AND PDA_TIPO = '3'
        GROUP BY ID,PDA_NUMERO, PDA_SCS_CODIGO, PDA_DET_CODIGO, PDA_UPP_PDT_CODIGO;";

        $execute = $this->select_all($sql);

        return $execute;
    }

    public function cut()
    {

        $execute = $this->handleLockWaitTimeout();

        return $execute;
    }
}
