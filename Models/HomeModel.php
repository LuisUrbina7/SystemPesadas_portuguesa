<?php 

	class HomeModel extends Mysql
	{	


		public function __construct()
		{
			parent::__construct();
		}
		

		public function getInfo(){


			$queryOne = "SELECT IFNULL(COUNT(*),0) AS CANTIDAD FROM `adn_pesadas`";
			$queryTwo= "SELECT 
			ROUND( SUM(IF(PDA_CANXUND >=1 AND PDA_UPP_UND_ID IN ('UND','KG'),  (PDA_CANTIDAD/PDA_CANXUND),0 )),2)
			 AS CAJA_ONE,
			ROUND(SUM(IFNULL(CASE  
				WHEN PDA_CANXUND =0 AND PDA_UPP_UND_ID = 'UND' THEN (PDA_CANTIDAD)
				WHEN PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG' THEN (PDA_CANTIDAD)
			END,0)),2) AS UND_KG_ONE
		FROM ADN_PESADAS
		WHERE PDA_TIPO = '1'";

			$queryThre = "	SELECT 
			ROUND( IFNULL(SUM(IF(PDA_CANXUND >=1 AND PDA_UPP_UND_ID IN ('UND','KG'),  (PDA_CANTIDAD/PDA_CANXUND),0 )),0),2)
			 AS CAJA_TWO,
			ROUND(IFNULL(SUM(IFNULL(CASE  
				WHEN PDA_CANXUND =0 AND PDA_UPP_UND_ID = 'UND' THEN (PDA_CANTIDAD)
				WHEN PDA_CANXUND >= 0 AND PDA_UPP_UND_ID = 'KG' THEN (PDA_CANTIDAD)
			END,0)),0),2) AS UND_KG_TWO
		FROM ADN_PESADAS
		WHERE PDA_TIPO = '2'";

			$executeTotal = [];
			$executeTotal[] =  $this->select($queryOne);
			$executeTotal[] =  $this->select($queryTwo);
			$executeTotal[] =  $this->select($queryThre);

			return $executeTotal;
		}

		public function byTransfer()
		{
	
			$sql = "SELECT PDA_NUMERO, 
					PDA_DET_CODIGO, 
					TRA_NOMBRE,
					ROUND((SUM(PDA_CANTIDAD*UGR_PESO)/1000),4) AS TONELADA, 
					PDA_UPP_PDT_CODIGO, 
					PDA_UPP_UND_ID,
					UGR_PESO,
					IF(SUM(PDA_TRANF_ID)>0, 1,0) AS TRANSFERENCIA
					FROM ADN_PESADAS
						JOIN adn_undagru ON UGR_PDT_CODIGO = PDA_UPP_PDT_CODIGO 
						AND UGR_UND_ID = PDA_UPP_UND_ID
						JOIN `adn_transportistas` ON PDA_DET_CODIGO = TRA_CODIGO
					WHERE PDA_TIPO = '2'
					GROUP BY PDA_NUMERO, PDA_SCS_CODIGO, PDA_DET_CODIGO ORDER BY PDA_NUMERO DESC LIMIT 20;";
	
			$select = $this->select_all($sql);
	
			return $select;
		}
	
		public function graph()
		{
			$sql = "SELECT  
			IFNULL(COUNT(*),0) AS TOTAL,  
			IFNULL(SUM(IF(PDA_TRANF_ID >0, 1,0)),0) AS TRANSFERIDOS 
			FROM ADN_PESADAS LIMIT 5";
	
			$select = $this->select($sql);
	
	
			return $select;
		}


		
	}


 ?>
