<?php
const BASE_URL = "http://localhost/Pesadas_estables/SystemPesadas_portuguesa";

//Zona horaria
date_default_timezone_set('America/Caracas');

//Datos de conexión a Base de Datos
const DB_HOST = "localhost:3306";
const DB_NAME = "feriapollo";
const DB_USER = "sistemas";
const DB_PASSWORD = 'adn';
const DB_CHARSET = "utf8";

//Deliminadores decimal y millar Ej. 24,1989.00
const SPD = ".";
const SPM = ",";

//Simbolo de moneda
const SMONEY = "$";

const RAIZ_IMPRESORA = '';
//constates para envio de correo
/*const NOMBRE_EMPESA = "Intersat Los Andes C.A.";
	const NOMBRE_REMITENTE = "Intersat Los Andes C.A.";
	const EMAIL_REMITENTE = "jacksonnieto98@gmail.com";
	const WEB_EMPRESA = "https://intersatlosandes.com";


	//Api-Key para Wisphub
	const API_KEY_WISPHUB = "7pzsjPkT.jPCqtSL6E1CtPtPlnAIizLoFsfWreQAC";

	//credenciales boton de pago banco de venezuela

	const USUARIO_BOTON_DE_PAGO_VENEZUELA 	= "77120068";
	const CLAVE_BOTON_DE_PAGO_VENEZUELA 	= "r1E6hacW";

	/*const USUARIO_BOTON_DE_PAGO_VENEZUELA 	= "72715225";
	const CLAVE_BOTON_DE_PAGO_VENEZUELA 	= "G3Gunm7j";


	
	const ID_FORMA_PAGO_ONLINE_WISPHUB = 45013;*/
