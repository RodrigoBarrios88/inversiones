<?php
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos

ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);

//--
include_once('html_fns_api.php');

header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
header("Access-Control-Allow-Origin: *");

include_once("FRMmail_pass.php");
///API REQUEST
$request = $_REQUEST["request"];

if($request != ""){
	switch($request){
		case "pidepass":
			$mail = $_REQUEST["mail"];
			API_enviar_mail($mail);
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


function API_enviar_mail($mail){
	$ClsUsu = new ClsUsuario();
	
	if($mail != ""){
		$result = $ClsUsu->get_usuario('','',$mail);
		if(is_array($result)){
			foreach($result as $row){
				$nombre = $row["usu_nombre"];
				$seguridad = $row["usu_seguridad"];
				$situacion = $row["usu_situacion"];
				//--
				$usu = $row["usu_usuario"];
				$pass = $row["usu_pass"];
				$pass = $ClsUsu->decrypt($pass, $usu); //desencripta el password
			}
			if($situacion == 1){
				if($seguridad == 0){
					$mensaje_error = "";
				}else{
					$mensaje_error = "Su usuario se encuentra bloqueado, por favor contacte al administrador.";
				}
			}else{
				$mensaje_error = "Su usuario se encuentra inactivo.";
				$usu = "(Usuario Inactivo)";
				$pass = "- Pendiente de Activar -";
			}
			// Instancia el API KEY de Mandrill
			$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
			//--
			// Create the email and send the message
			$to = array(
					array(
							'email' => "$mail",
							'name' => "$nombre",
							'type' => 'to'
					)
			);
			/////////////_________ Correo a admin
			$subject = "Tu Password";
			$html = mail_constructor($nombre, $mail, $usu, $pass, $mensaje_error);
			try{
    
				$message = array(
					'subject' => $subject,
					'html' => $html,
					'from_email' => 'noreply@inversionesd.com',
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
				"message" => "Este correo no existe o no está registrado como usuario");
				echo json_encode($arr_data);
		}
	}else{
		//devuelve un mensaje de manejo de errores
		$arr_data = array(
			"status" => "vacio",
			"message" => "parametro vacio....");
			echo json_encode($arr_data);
	}
	
}
