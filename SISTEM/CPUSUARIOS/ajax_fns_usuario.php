<?php
ob_start();
header("Cache-control: private, no-cache");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Pragma: no-cache");
header("Cache: no-cahce");
ini_set('max_execution_time', 90000);
ini_set("memory_limit", -1);

include_once('html_fns_usuarios.php');

$request = $_REQUEST["request"]; 
switch($request){
	case "mail":
		$tipo = $_REQUEST["tipo"];
		$mail = $_REQUEST["mail"];
		envia_mail($tipo,$mail);
		break;
	case "admin":
		$nombre = $_REQUEST["name"];
		$correo = $_REQUEST["email"];
		$telefono = $_REQUEST["phone"];
		$message = $_REQUEST["message"];
		admin_mail($nombre,$correo,$telefono,$message);
		break;
	default:
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Seleccione un metodo..."
		);
		echo json_encode($arr_respuesta);
}

////////////////// RESPUESTAS /////////////////////////

function envia_mail($tipo,$mail){
	//////////////////////// CREDENCIALES DE COLEGIO
	$ClsReg = new ClsRegla();
	$result = $ClsReg->get_credenciales();
	if(is_array($result)){
	   foreach($result as $row){
		  $colegio_nombre = utf8_decode($row['colegio_nombre']);
	   }
	}
	////////////////
	$colegio_nombre = depurador_texto($colegio_nombre);
	
	if($mail != ""){
		$ClsUsu = new ClsUsuario();
		$result = $ClsUsu->get_usuario('','',$mail);
		if(is_array($result)){
			foreach($result as $row){
				$nombre = utf8_decode($row["usu_nombre"]);
				$nombre = depurador_texto($nombre);
				$seguridad = $row["usu_seguridad"];
				$situacion = $row["usu_situacion"];
				//--
				$usu = $row["usu_usuario"];
				$pass = $row["usu_pass"];
				$pass = $ClsUsu->decrypt($pass, $usu); //desencripta el password
			}
			if($situacion == 1){
				if($seguridad == 0){
					// Instancia el API KEY de Mandrill
					$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
					//--
					// Create the email and send the message
					$to = array(
						array(
							'email' => "$mail",
							'name' => "Usuario",
							'type' => 'to'
						)
					);
					/////////////_________ Correo a admin
					$subject = "Tu Password";
					$cuerpo = "Has recibido un nuevo mensaje desde el Sistema ASMS de $colegio_nombre. <br><br>"."Aqu&iacute; est&aacute;n los detalles:<br><br>Estimado(a) $nombre<br>E-mail: $mail<br>Usuario: $usu<br>Password: $pass<br><br>Que pases un feliz d&iacute;a!!!";
					$html = mail_constructor($subject, $cuerpo);
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
						
						$arr_respuesta = array(
							"status" => true,
							"data" => [],
							"message" => "Se ha enviado un correo electrónico ë con su contraseña...."
						);
						echo json_encode($arr_respuesta);
							
					} catch(Mandrill_Error $e) { 
						//echo "<br>";
						//print_r($e);
						$arr_respuesta = array(
							"status" => false,
							"data" => [],
							"message" => "Su mensaje no ha podido ser entregado en este momento, lo sentimos..."
						);
						echo json_encode($arr_respuesta);
					}         
				}else{
					$arr_respuesta = array(
						"status" => false,
						"data" => [],
						"message" => "Su usuario se encuentra bloqueado, por favor contacte al administrador."
					);
					echo json_encode($arr_respuesta);
					return;
				}
			}else{
				$arr_respuesta = array(
					"status" => false,
					"data" => [],
					"message" => "Su usuario se encuentra inactivo."
				);
				echo json_encode($arr_respuesta);
				return;
			}
		}else{
			$arr_respuesta = array(
				"status" => false,
				"data" => [],
				"message" => "Este correo no esta registrado en el sistema, por favor contacte al administrador..."
			);
			echo json_encode($arr_respuesta);
		}
	}else{
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Debe llenar los campos obligatorios..."
		);
		echo json_encode($arr_respuesta);
	}
}


function admin_mail($nombre,$correo,$telefono,$message){
	
	//////////////////////// CREDENCIALES DE COLEGIO
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
	////////////////

	$mailadmin = "soporte@inversionesd.com";
	// Instancia el API KEY de Mandrill
	$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
	//--
	// Create the email and send the message
	$to = array(
		array(
			'email' => $mailadmin,
			'name' => 'Administrador',
			'type' => 'to'
		)
	);
	/////////////_________ Correo a admin
	$subject = trim("Correo de Usuario desde ASMS ($colegio_nombre_titulo)");
	$texto = "Has recibido un nuevo mensaje desde ASMS ($colegio_nombre).<br><br> Aqu&iacute; est&aacute;n los detalles:<br>";
	$texto = "Nombre: <b>$nombre</b><br>Tel&eacute;fono: <b>$telefono</b><br>E-mail: <b>$correo</b><br>Asunto: <b>$subject</b><br>Mensaje: <p>$message</p>";
	$texto.= "<br><br>Que pases un feliz d&iacute;a!!!";
	
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
		$arr_respuesta = array(
			"status" => true,
			"data" => [],
			"message" => "Su mensaje ha sido enviado exitosamente, en un momento uno de nuestros agentes lo contactará..."
		);
		echo json_encode($arr_respuesta);
	} catch(Mandrill_Error $e) { 
		//echo "<br>";
		//print_r($e);
		//devuelve un mensaje de manejo de errores
		$arr_respuesta = array(
			"status" => false,
			"data" => [],
			"message" => "Su mensaje no ha podido ser entregado en este momento, lo sentimos..."
		);
		echo json_encode($arr_respuesta);
	}
}

?>