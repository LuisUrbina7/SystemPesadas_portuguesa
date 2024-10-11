<?php

class RegisterModel extends Mysql
{

	private $idUser;
	private $firstName;
	private $lastName;
	private $email;
	private $username;
	private $password;

	public function __construct()
	{
		parent::__construct();
	}

	public function insertUserWisphub($data)
	{

		$query = "INSERT INTO users (name, username, documento_identidad, phone, email, password, token, role_id, status, profile_photo_path, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?); ";

		$insert = $this->insert($query, $data);

		$sql = "SELECT  u.id,
						u.username,
						u.email,
						u.status,
						u.role_id,
						u.documento_identidad,
						u.password,
						u.phone,
						r.role
				FROM users u
				INNER JOIN roles r 
				ON u.role_id = r.id
				WHERE u.id = '" . $insert . "'";

		$select = $this->select($sql);

		$_SESSION['userData'] = $select;

		return $select;
	}

	public function updateUserEmail($user, $email)
	{

		$update = "UPDATE users SET email= ? WHERE documento_identidad = '$user'";

		$execute = $this->update($update, [$email]);

		$sql = "SELECT * FROM users WHERE (email = '$email' OR documento_identidad = '$user' )  AND status = 1 AND email <> ''";
		$request = $this->select($sql);

		return $request;
	}

	public function insertUserServices($dataServices)
	{

		foreach ($dataServices as $services) {

			$query = " INSERT INTO services (id_services, dni,concept,zone,cut_date) VALUES (?, ?,?,?,?); ";

			$insert = $this->insert($query, $services);
		}


		return $insert;
	}

	public function inserUpdateServices($dataServices, $dni, $name, $email)
	{

		$update = "UPDATE users SET name = ?, username= ?, email= ? WHERE documento_identidad = '$dni'";

		$execute = $this->update($update, [$name, $name, $email]);


		$query_delete = "DELETE FROM services WHERE dni = '$dni';";

		$delete = $this->delete($query_delete);

		foreach ($dataServices as $services) {

			$query = " INSERT INTO services (id_services, dni,concept,zone,cut_date) VALUES (?, ?,?,?,?); ";

			$insert = $this->insert($query, $services);
		}


		return $insert;
	}


	public function insertUser(string $firstName, string $lastName, string $email, string $username, string $password)
	{

		$this->firstName = $firstName;
		$this->lastName = $lastName;
		$this->email = $email;
		$this->username = $username;
		$this->password = $password;

		$return = 0;

		$sql = "SELECT * FROM users WHERE email = '$this->email' OR username =  '$this->username' ";
		$request = $this->select($sql);

		if (empty($request)) {
			$query_insert  = "INSERT INTO users (first_name,last_name,email,username,password,rol_id,status) VALUES(?,?,?,?,?,?,?)";
			$arrData = array($this->firstName, $this->lastName, $this->email, $this->username, $this->password,	2, 1);
			$request_insert = $this->insert($query_insert, $arrData);
			$lastInsert = $request_insert;

			$sql = "SELECT  u.id,
							u.first_name,
							u.last_name,
							u.username,
							u.email,
							u.status,
							u.rol_id,
							r.role
					FROM users u
					INNER JOIN roles r 
					ON u.rol_id = r.id
					WHERE u.id = $lastInsert";
			$result = $this->select($sql);
			$_SESSION['userData'] = $result;
			$return =  $result;
		} else {
			$return = "exist";
		}
		return $return;
	}
}
