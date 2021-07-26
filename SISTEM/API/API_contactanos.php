<?php

ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);

//--
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
require_once("../../CONFIG/constructor.php"); //--correos
include_once('html_fns_api.php');

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "contactanos":
			$data = $_REQUEST["data"];
			API_enviar_mail($data);
			break;
		case "credenciales":
			API_credenciales();
			break;
		default:
			$arr_data = array(
			"status" => "error",
			"message" => "Parametros invalidos...");
			echo json_encode($arr_data);
			break;
	}
}else{
	//devuelve un mensaje de manejo de errores
	$arr_data = array(
		"status" => "error",
		"message" => "Delimite el tipo de consulta a realizar...");
		echo json_encode($arr_data);
}


//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////// FUNCIONES Y CONSULTAS ////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


function API_enviar_mail($data){
	$ClsTar = new ClsTarea();
	
	$data = json_decode(stripslashes($data), true);
	if(is_array($data)){
		//pasa a mayusculas
		$nombre = trim($data[0]["nombre"]);
		$mail = trim($data[0]["email"]);
		$telefono = trim($data[0]["telefono"]);
		$asunto = trim($data[0]["asunto"]);
		$mensaje = trim($data[0]["mensaje"]);
		if($nombre !="" && $mail !="" && $mensaje !=""){
			// Instancia el API KEY de Mandrill
			$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
			//--
			// Create the email and send the message
			$to = array(
				array(
					'email' => 'soporte@inversionesd.com',
					'name' => 'Manuel Sosa',
					'type' => 'to'
				)
			);
			/// COLEGIO
			$ClsReg = new ClsRegla();
			$result = $ClsReg->get_credenciales();
			if(is_array($result)){
				foreach($result as $row){
				   $colegio_nombre = utf8_decode($row['colegio_nombre']);
				   $colegio_nombre_titulo = utf8_decode($row['cliente_nombre_reporte']);
				}
			}
			$colegio_nombre = depurador_texto($colegio_nombre);
			$colegio_nombre_titulo = depurador_texto($colegio_nombre_titulo);
			
			/////////////_________ Correo a admin
			$subject = trim("Correo de Usuario desde el APP ($colegio_nombre_titulo)");
			$texto = "Has recibido un nuevo mensaje desde el APP ($colegio_nombre).<br><br> Aqui estan los detalles:<br>";
			$texto = "Nombre: <b>$nombre</b><br>Telefono: <b>$telefono</b><br>E-mail: <b>$mail</b><br>Asunto: <b>$asunto</b><br>Mensaje: <p>$mensaje</p>";
			$texto.= "<br><br>Que pases un feliz dia!!!";
			
			$html = mail_constructor($subject,$texto);
			
			try{
				$message = array(
					'subject' => $subject,
					'html' => $html,
					'from_email' => 'noreply@inversionesd.com',
					'from_name' => 'ASMS',
					'to' => $to
				 );
				 
				 //print_r($message);
				 //echo "<br>";
				 $result = $mandrill->messages->send($message);
				 
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "success",
					"message" => "Correo enviado satisfactoriamente");
					echo json_encode($arr_data);
			} catch(Mandrill_Error $e) { 
				//echo "<br>";
				//print_r($e);
				//devuelve un mensaje de manejo de errores
				$arr_data = array(
					"status" => "error",
					"message" => "Uno o mas datos no cumplen con las normas de integridad de la información, contacte al administrador...");
					echo json_encode($arr_data);
			}         
		}else{
			//devuelve un mensaje de manejo de errores
			$arr_data = array(
				"status" => "error",
				"message" => "Algunos datos estan vacios");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "error",
			"message" => "Formato no valido...");
			echo json_encode($arr_data);
	}
	
}


function API_credenciales(){
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_credenciales();
	$i = 0;
	if(is_array($result)) {
		foreach ($result as $row){
			$arr_data[$i]['logo'] = "https://" . $_SERVER['HTTP_HOST'] . "/CONFIG/images/logo.png";
			$arr_data[$i]['nombre'] = trim($row["colegio_nombre_reporte"]);
			$arr_data[$i]['direccion1'] = trim($row["colegio_direccion1"]);
			$arr_data[$i]['direccion2'] = trim($row["colegio_direccion2"]);
			$arr_data[$i]['telefono'] = trim($row["colegio_telefono"]);
			$arr_data[$i]['correo'] = trim($row["colegio_correo"]);
			$arr_data[$i]['website'] = trim($row["colegio_website"]);
		}
		echo json_encode($arr_data);
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "No se registran datos...");
			echo json_encode($arr_data);
	}
}
