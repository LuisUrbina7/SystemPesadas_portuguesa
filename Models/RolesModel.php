<?php 

	class RolesModel extends Mysql
	{
		public $intIdrol;
		public $strRol;
		public $strDescripcion;
		public $intStatus;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectRoles()
		{
			$bd = $_SESSION['userData']['BDSINCRO'];
			$sql = "SELECT * FROM $bd.roles WHERE status != 0 ORDER BY id asc";
			$request = $this->select_all($sql);
			return $request;
		}
	

	}
 ?>