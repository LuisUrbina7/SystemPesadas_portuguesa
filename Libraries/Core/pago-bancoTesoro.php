<?php

class BancoTesoro {
    private $url;
    private $headers;
    private $codAfiliado;
    private $rif;

    public function __construct() {
        $this->url = "https://tpmovil.bt.gob.ve/RestTesoro_C2P/com/services";
        $this->headers = array("Content-Type: application/json");

        $this->codAfiliado = "010721";
        $this->rif = "J500774613";

    }

    public function bancos() {
        $ch = curl_init($this->url."/bancos");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([]));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
        
        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error al realizar la petición: ' . curl_error($ch);
        }


        curl_close($ch);
        return $response;
    }


    public function pagos($data) {
        $ch = curl_init($this->url."/botonDePago/pago");

        $data['codAfiliado'] = $this->codAfiliado;
        $data['RIF'] = $this->rif;

        //return $data; die();

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error al realizar la petición: ' . curl_error($ch);
        }

        curl_close($ch);
        return $response;
    }


    public function conformacion($data) {
        $ch = curl_init($this->url."/botonDePago/conformacion");

        $data['codAfiliado'] = $this->codAfiliado;
        $data['RIF'] = $this->rif;

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error al realizar la petición: ' . curl_error($ch);
        }

        curl_close($ch);
        return $response;
    }

    public function token() {
        $ch = curl_init($this->url."/lotes/solicitud/clave");

        $data = array('canal' => '01', 'celularDestino' => 'V011484286 ');

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Error al realizar la petición: ' . curl_error($ch);
        }

        curl_close($ch);
        return $response;
    }

}

?>
