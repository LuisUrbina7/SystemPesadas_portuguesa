<?php

class P2cBdv {
    private $url;
    private $headers;

    public function __construct() {
        $this->url = "http://200.11.243.176:444/getMovement";
        $this->headers = array(
            "x-api-key: 96R7T1T5J2134T5YFC2GF15SDFG4BD1Z",
            "Content-Type: application/json"
        );
    }

    public function sendRequest($data) {
        $ch = curl_init($this->url);

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
