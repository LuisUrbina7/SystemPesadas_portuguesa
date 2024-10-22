<?php 

	//Retorla la url del proyecto
function base_url()
{
  return BASE_URL;
}

function url_sockets()
{
  return URL_SOCKETS;
}
    //Retorla la url de Assets
function media()
{
    return BASE_URL."/Assets";
}



function headerAdmin($data="")
{
    $view_header = "Views/Template/header_admin.php";
    require_once ($view_header);
}
function footerAdmin($data="")
{
    $view_footer = "Views/Template/footer_admin.php";
    require_once ($view_footer);        
}
	//Muestra información formateada
function dep($data)
{
    $format  = print_r('<pre>');
    $format .= print_r($data);
    $format .= print_r('</pre>');
    return $format;
}
function getModal(string $nameModal, $data)
{
    $view_modal = "Views/Template/Modals/{$nameModal}.php";
    require_once $view_modal;        
}
    //Envio de correos
function sendEmail($data,$template)
{
    $asunto = $data['asunto'];
    $emailDestino = $data['email'];
    $empresa = NOMBRE_REMITENTE;
    $remitente = EMAIL_REMITENTE;
        //ENVIO DE CORREO
    $de = "MIME-Version: 1.0\r\n";
    $de .= "Content-type: text/html; charset=UTF-8\r\n";
    $de .= "From: {$empresa} <{$remitente}>\r\n";
    ob_start();
    require_once("Views/Template/Email/".$template.".php");
    $mensaje = ob_get_clean();
    $send = mail($emailDestino, $asunto, $mensaje, $de);
    return $send;
}

function getPermisos(int $idmodule){
    require_once ("Models/PermissionsModel.php");
    $objPermisos = new PermissionsModel();
   /* $idrol = $_SESSION['userData']['role_id'];
    $arrPermissions = $objPermisos->permissionsModule($idrol);
    $permissions = '';
    $permissionsMod = '';
    if(count($arrPermissions) > 0 ){
        $permissions = $arrPermissions;
        $permissionsMod = isset($arrPermissions[$idmodule]) ? $arrPermissions[$idmodule] : "";
    }
    $_SESSION['permissions'] = $permissions;
    $_SESSION['permissionsMod'] = $permissionsMod;*/
}

function sessionUser(int $idpersona){
    require_once ("Models/LoginModel.php");
    $objLogin = new LoginModel();
    $request = $objLogin->sessionLogin($idpersona);
    return $request;
}

    //Elimina exceso de espacios entre palabras
function strClean($strCadena){
    $string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
        $string = trim($string); //Elimina espacios en blanco al inicio y al final
        $string = stripslashes($string); // Elimina las \ invertidas
        $string = str_ireplace("<script>","",$string);
        $string = str_ireplace("</script>","",$string);
        $string = str_ireplace("<script src>","",$string);
        $string = str_ireplace("<script type=>","",$string);
        $string = str_ireplace("SELECT * FROM","",$string);
        $string = str_ireplace("DELETE FROM","",$string);
        $string = str_ireplace("INSERT INTO","",$string);
        $string = str_ireplace("SELECT COUNT(*) FROM","",$string);
        $string = str_ireplace("DROP TABLE","",$string);
        $string = str_ireplace("OR '1'='1","",$string);
        $string = str_ireplace('OR "1"="1"',"",$string);
        $string = str_ireplace('OR ´1´=´1´',"",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("is NULL; --","",$string);
        $string = str_ireplace("LIKE '","",$string);
        $string = str_ireplace('LIKE "',"",$string);
        $string = str_ireplace("LIKE ´","",$string);
        $string = str_ireplace("OR 'a'='a","",$string);
        $string = str_ireplace('OR "a"="a',"",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("OR ´a´=´a","",$string);
        $string = str_ireplace("--","",$string);
        $string = str_ireplace("^","",$string);
        $string = str_ireplace("[","",$string);
        $string = str_ireplace("]","",$string);
        $string = str_ireplace("==","",$string);
        return $string;
    }
    //Genera una contraseña de 10 caracteres
    function passGenerator($length = 10)
    {
        $pass = "";
        $longitudPass=$length;
        $cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
        $longitudCadena=strlen($cadena);

        for($i=1; $i<=$longitudPass; $i++)
        {
            $pos = rand(0,$longitudCadena-1);
            $pass .= substr($cadena,$pos,1);
        }
        return $pass;
    }
    //Genera un token
    function token()
    {
        $r1 = bin2hex(random_bytes(10));
        $r2 = bin2hex(random_bytes(10));
        $r3 = bin2hex(random_bytes(10));
        $r4 = bin2hex(random_bytes(10));
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
        return $token;
    }
    //Formato para valores monetarios
    function formatMoney($cantidad){
        $cantidad = number_format($cantidad,2,SPD,SPM);
        return $cantidad;
    }

    
    /* SE REALIZO UNA NUEVA FORMA DE EXTRAER LA TASA DEL BANCO DE VENEZUELA ÉSTE FORMA QUEDA COMENTADA POR SI ES NECESARIO RETOMARLA A 
    FUTURO.
    function getTasa(){



        $curl = curl_init();

        curl_setopt_array($curl, array(
          //CURLOPT_URL => 'https://meta.adnpanel.com/tasa_bcv_service/get_tasa.php',
          CURLOPT_URL => 'http://127.0.0.1/tasa_bcv_service/get_tasa.php',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'GET',
          CURLOPT_HTTPHEADER => array(),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        $tasa = json_decode($response,true);
        $string = str_replace(",", ".", $tasa['usd']);
        $tasa = floatval($string);
        return $tasa;
    }

  */
    function show_rate(){

        require_once('Models/RateModel.php');

        $data = new RateModel();

        $register = $data->getRateDay();

        if (!empty($register)) {
            $rate = $register['usd'];

            return json_decode($rate);
        } else {

            try {
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => 'https://www.bcv.org.ve/',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_SSL_VERIFYPEER => false,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'GET',
                    CURLOPT_HTTPHEADER => array(),
                ));

                $response = curl_exec($curl);

                if (curl_errno($curl)) {
                    echo 'Error al realizar la solicitud: ' . curl_error($curl);
                }

                curl_close($curl);


                $prueba = new simple_html_dom();

                $prueba->load($response);

                $element = $prueba->find('div#dolar div.recuadrotsmc div.centrado strong', 0);


                $rate = [
                    'usd' => str_replace(',', '.', $element->innertext),
                    'cop' => 4.000
                ];

                $insert = $data->insertRateDay($rate['usd'], $rate['cop'], date("Y-m-d"));

                return json_decode($rate['usd']);

                
            } catch (Exception $e) {

                echo json_decode('error');
            }
        }
    }

?>