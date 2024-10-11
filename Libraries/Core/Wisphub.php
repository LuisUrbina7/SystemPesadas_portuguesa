<?php 

class Wisphub {

	public static function getSaldo(int $id_wisphub){

		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => 'https://api.wisphub.net/api/clientes/'.$id_wisphub.'/saldo/',
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'GET',
		  CURLOPT_HTTPHEADER => array(
		    'Authorization: Api-Key '.API_KEY_WISPHUB
		  ),
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;


	}

	public static function getTickets(){

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://api.wisphub.net/api/tickets/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

		$headers = array();
		$headers[] = 'Authorization: Api-Key '.API_KEY_WISPHUB;
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		return $result;
	}


	public static function getFactura(int $id_factura){

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, 'https://api.wisphub.net/api/facturas/'.$id_factura.'/');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		

		$headers = array();
		$headers[] = 'Authorization: Api-Key '.API_KEY_WISPHUB;
		
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		// puedes imprimir el resultado
		return $result;
	}

	public static function setPayment(int $id_factura,$data){

		$ch = curl_init();
	//	https://api.wisphub.net/api/facturas/{id_factura}/registrar-pago/
		curl_setopt($ch, CURLOPT_URL, 'https://api.wisphub.net/api/facturas/'.$id_factura.'/registrar-pago/');
		//curl_setopt($ch, CURLOPT_URL, 'https://api.wisphub.net/api/facturas/'.$id_factura.'/registrar-pago');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data,JSON_UNESCAPED_UNICODE));

		$headers = array();
		$headers[] = 'Authorization: Api-Key '.API_KEY_WISPHUB;
		$headers[] = 'Content-Type: application/json';
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$result = curl_exec($ch);
		if (curl_errno($ch)) {
		    echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		// puedes imprimir el resultado
		return $result;
	}

}




?>