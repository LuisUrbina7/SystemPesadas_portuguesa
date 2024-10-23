<?php

class CanastasModel extends Mysql
{

	public function __construct()
	{
		parent::__construct();
	}

    public function get_canastas(){

        $canasta = "SELECT CTA_CODIGO, CTA_DESCRIPCION, CTA_EQUIVALENCIA, CTA_ACTIVO FROM adn_canasta_tipo WHERE CTA_CODIGO != '0000';";

		$select = $this->select_all($canasta);

		return $select;
    }

	public function get_one_canasta(string $canasta){

        $canasta = "SELECT CTA_CODIGO, CTA_DESCRIPCION, CTA_EQUIVALENCIA, CTA_ACTIVO FROM adn_canasta_tipo WHERE CTA_CODIGO = '$canasta'";

		$select = $this->select_all($canasta);

		return $select;
    }


    public function delete_canasta(string $codigo){

        $canasta = "DELETE FROM adn_canasta_tipo WHERE CTA_CODIGO = '$codigo'";

		$response = $this->delete($canasta);

		return $response;
    }



	public function update_canasta(string $codigo, string $descripcion, float $equivalencia, int $activo){

        $canasta = "UPDATE adn_canasta_tipo SET CTA_DESCRIPCION = ?, CTA_EQUIVALENCIA = ?, CTA_ACTIVO = ? WHERE CTA_CODIGO = '$codigo';";

		$response = $this->update($canasta, [$descripcion, $equivalencia, $activo]);

		return $response;
    }

	public function create_canasta(string $codigo, string $descripcion, float $equivalencia){

        $canasta = "INSERT INTO adn_canasta_tipo (CTA_CODIGO, CTA_DESCRIPCION, CTA_EQUIVALENCIA, CTA_ACTIVO) VALUES (?,?,?,1)";

		$response = $this->insert($canasta, [$codigo, $descripcion, $equivalencia]);

		return $response;
    }


	public function get_coorelativo(){

		$coorelativo = "SELECT LPAD(CAST(CTA_CODIGO AS INTEGER ) + 1, 4, 0 ) AS COORELATIVO FROM ADN_CANASTA_TIPO ORDER BY CTA_CODIGO DESC LIMIT 1;";

		$coorelativo = $this->select($coorelativo);

		return $coorelativo;
	}
}
