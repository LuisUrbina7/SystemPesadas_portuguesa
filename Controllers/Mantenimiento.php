<?php 

	class Mantenimiento extends Controllers{
		public function __construct()
		{
			parent::__construct();
		}

		public function maintenance()
		{
			$this->views->getView($this,"mantenimiento");
		}
	}

	$maintenance = new Mantenimiento();
	$maintenance->maintenance();
 ?>