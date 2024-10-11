<?php 

	class PermissionsModel extends Mysql
	{
		public $idpermission;
		public $roleId;
		public $ModuleId;
		public $r;
		public $w;
		public $u;
		public $d;

		public function __construct()
		{
			parent::__construct();
		}

		public function selectModules()
		{
			$sql = "SELECT * FROM modules WHERE status != 0";
			$request = $this->select_all($sql);
			return $request;
		}	
		public function selectPermissionsRole(int $idrole)
		{
			$this->intRolid = $idrol;
			$sql = "SELECT * FROM permissions WHERE rolid = $this->intRolid";
			$request = $this->select_all($sql);
			return $request;
		}

		public function deletePermissions(int $idrol)
		{
			$this->intRolid = $idrol;
			$sql = "DELETE FROM permisos WHERE rolid = $this->intRolid";
			$request = $this->delete($sql);
			return $request;
		}

		public function insertPermisos(int $idrol, int $idmodulo, int $r, int $w, int $u, int $d){
			$this->intRolid = $idrol;
			$this->intModuloid = $idmodulo;
			$this->r = $r;
			$this->w = $w;
			$this->u = $u;
			$this->d = $d;
			$query_insert  = "INSERT INTO permisos(rolid,moduloid,r,w,u,d) VALUES(?,?,?,?,?,?)";
        	$arrData = array($this->intRolid, $this->intModuloid, $this->r, $this->w, $this->u, $this->d);
        	$request_insert = $this->insert($query_insert,$arrData);		
	        return $request_insert;
		}

		public function permissionsModule(int $idrole){
			$this->roleId = $idrole;
			$sql = "SELECT p.rol_id,
						   p.module_id,
						   m.title as module,
						   p.r,
						   p.w,
						   p.u,
						   p.d 
					FROM permissions p 
					INNER JOIN modules m
					ON p.module_id = m.id
					WHERE p.rol_id = $this->roleId";
			$request = $this->select_all($sql);
			$arrPermisos = array();
			for ($i=0; $i < count($request); $i++) { 
				$arrPermisos[$request[$i]['module_id']] = $request[$i];
			}
			return $arrPermisos;
		}
	}
 ?>