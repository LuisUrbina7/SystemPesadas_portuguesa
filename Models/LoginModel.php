<?php

class LoginModel extends Mysql
{
	private $idUser;
	private $email;
	private $username;
	private $password;
	private $token;

	public function __construct()
	{
		parent::__construct();
	}

	public function loginUser(string $user, string $password)
	{
		$this->username = $user;
		$this->email = $user;
		$this->password = $password;

		$sql = "SELECT OPE_NUMERO, OPE_NOMBRE, OPE_CLAVE FROM sistemasadn.`adn_usuarios` WHERE OPE_ACTIVO = '1' AND OPE_NOMBRE = '$user' AND OPE_CLAVE = '$password' LIMIT 1;";


		$request = $this->select($sql);

		$request = !isset($request['OPE_NUMERO']) ? 'errorPassword' : $request;

		return $request;
	}

	public function sessionLogin(int $iduser)
	{
		$this->idUser = $iduser;
		$sql = "SELECT  
		OPE_NUMERO, 
		OPE_NOMBRE, 
		OPE_CLAVE, 
		OPE_AMC_PESADA,
		ACCES_ODC, 
		ACCES_GUIA ,
		INCLUIR_ODC,
		MANUAL_ODC,
		INCLUIR_GUIA,
		MANUAL_GUIA 
	FROM sistemasadn.`adn_usuarios` 
	JOIN sistemasadn.`adn_perfil` ON OPE_PRF_CODIGO = PRF_CODIGO
	JOIN (
	
		SELECT  PXP_PRF_ID, 
			PXP_IND_CODIGO, 
			SUM(IF(PXP_IND_CODIGO= '1.PO.01', PXP_ACCESO,0)) AS ACCES_ODC,
			SUM(IF(PXP_IND_CODIGO= '1.PG.01', PXP_ACCESO,0)) AS ACCES_GUIA
			 FROM sistemasadn.adn_permixper WHERE PXP_IND_CODIGO IN('1.PO.01','1.PG.01')
		GROUP BY PXP_PRF_ID
	    ) AS PERXPER ON PERXPER.PXP_PRF_ID = PRF_CODIGO
	 JOIN (
	 
		 SELECT PXA_PRF_CODIGO,
			MAX(IF(PXA_PXI_CODIGO ='INCLUIR' AND PXA_IND_CODIGO = '1.PO.01',PXA_VALOR,0)) AS INCLUIR_ODC,
			MAX(IF(PXA_PXI_CODIGO ='MANUAL' AND PXA_IND_CODIGO = '1.PO.01',PXA_VALOR,0)) AS MANUAL_ODC ,
			MAX(IF(PXA_PXI_CODIGO ='INCLUIR' AND PXA_IND_CODIGO = '1.PG.01',PXA_VALOR,0)) AS INCLUIR_GUIA,
			MAX(IF(PXA_PXI_CODIGO ='MANUAL' AND PXA_IND_CODIGO = '1.PG.01',PXA_VALOR,0)) AS MANUAL_GUIA  
			FROM sistemasadn.`adn_perxindxper`  WHERE PXA_IND_CODIGO IN('1.PO.01','1.PG.01') 
		
		GROUP BY PXA_PRF_CODIGO
	     ) AS PERXINXPER ON PERXINXPER.PXA_PRF_CODIGO = PRF_CODIGO
	 
	  WHERE OPE_NUMERO = '$this->idUser' LIMIT 1;";

	  
		$request = $this->select($sql);
		$_SESSION['userData'] = $request;
		return $request;
	}


	public function getUserEmail(string $email)
	{

		$this->email = $email;
		$sql = "SELECT * FROM users WHERE email = '$this->email' AND status = 1";
		$request = $this->select($sql);
		return $request;
	}

	public function getEmail(string $value)
	{

		$sql = "SELECT * FROM users WHERE (email = '$value' OR documento_identidad = '$value' )  AND status = 1 AND email <> ''";
		$request = $this->select($sql);
		return $request;
	}

	public function setTokenUser(int $id, string $token)
	{
		$this->idUser = $id;
		$this->token  = $token;

		$update = "UPDATE users SET token = ? WHERE id = ? ";
		$arrData = array($this->token, $this->idUser);
		$request = $this->update($update, $arrData);
		return $request;
	}

	public function getUsuarioByToken(string $email, string $token)
	{
		$this->email = $email;
		$this->token = $token;
		$sql = "SELECT id FROM users WHERE email = '$this->email' AND token  = '$this->token' AND status = 1";
		$request = $this->select($sql);
		return $request;
	}

	public function updatePassword(int $id, string $password)
	{
		$this->idUser = $id;
		$this->password = $password;

		$update = "UPDATE users SET password = ?, token = ? WHERE id = $this->idUser";
		$arrData = array($this->password, "");
		$request = $this->update($update, $arrData);
		return $request;
	}
}
