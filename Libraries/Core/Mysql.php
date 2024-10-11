<?php 
	
	class Mysql extends Conexion
	{
		private $conexion;
		private $strquery;
		private $arrValues;
		private $isTransactionActive = false;

		function __construct()
		{
			$this->conexion = new Conexion();
			$this->conexion = $this->conexion->conect();
		}

		//Insertar un registro
		public function insert(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
        	$insert = $this->conexion->prepare($this->strquery);
        	$resInsert = $insert->execute($this->arrVAlues);
        	if($resInsert)
	        {
	        	$lastInsert = $this->conexion->lastInsertId();
	        }else{
	        	$lastInsert = 0;
	        }
	        return $lastInsert; 
		}
		//Insertar varios registors
		public function insert_massive(string $query){
			$this->strquery = $query;
			$insert = $this->conexion->prepare($this->strquery);
			$insert->execute();
			if($insert)
	        {
	        	$lastInsert = 1;
	        }else{
	        	$lastInsert = 0;
	        }
	        return $lastInsert; 
		}
		//Busca un registro
		public function select(string $query)
		{
			$this->strquery = $query;
        	$result = $this->conexion->prepare($this->strquery);
			$result->execute();
        	$data = $result->fetch(PDO::FETCH_ASSOC);
        	return $data;
		}
		//Devuelve todos los registros
		public function select_all(string $query)
		{
			$this->strquery = $query;
        	$result = $this->conexion->prepare($this->strquery);
			$result->execute();
        	$data = $result->fetchall(PDO::FETCH_ASSOC);
        	return $data;
		}
		//Actualiza registros
		public function update(string $query, array $arrValues)
		{
			$this->strquery = $query;
			$this->arrVAlues = $arrValues;
			$update = $this->conexion->prepare($this->strquery);
			$resExecute = $update->execute($this->arrVAlues);
	        return $resExecute;
		}
		//actualizar varios registors
		public function update_massive(string $query){
			$this->strquery = $query;
			$update = $this->conexion->prepare($this->strquery);
			$update->execute();
	        return $update; 
		}
		//Eliminar un registros
		public function delete(string $query)
		{
			$this->strquery = $query;
        	$result = $this->conexion->prepare($this->strquery);
			$del = $result->execute();
        	return $del;
		}


		public function beginTransaction() {
			$this->conexion->beginTransaction();
			$this->isTransactionActive = true; 
		}

		
		public function commit() {
			$this->conexion->commit();
			$this->isTransactionActive = false;
		}

		
		public function rollBack() {
			$this->conexion->rollBack();
			$this->isTransactionActive = false;
		}

		public function isTransactionActive() {
			return $this->isTransactionActive;
		}



		public function handleLockWaitTimeout()
		{
			try {
		
				$killConn = new Conexion();
				$killConn = $killConn->conect();
				$stmt = $killConn->prepare("CALL KILL_METADATALOCK();");
				$data = $stmt->execute();
				$killConn = null;
	
				return $data;
			} catch (PDOException $e) {
				return $e->getMessage();
			}
		}


		
	}


 ?>




