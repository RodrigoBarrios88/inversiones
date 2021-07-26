<?php
include_once('../html_fns.php');
require_once("../recursos/mandrill/src/Mandrill.php"); //--correos

////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////

function mail_pide_passw($id,$usu,$preg,$resp,$mail){
	$ClsUsu = new ClsUsuario();
	$resp = trim($resp);
	$result = $ClsUsu->get_valida_pregunta_resp($id,$usu,$preg,$resp);
	if(is_array($result)){
		foreach($result as $row){
			$nom = $row["usu_nombre"];
			$mail = $row["usu_mail"];
			$usu = $row["usu_usuario"];
			$pass = $row["usu_pass"];
			$pass = $ClsUsu->decrypt($pass, $usu); //desencripta el password
		}
		
		// Instancia el API KEY de Mandrill
		$mandrill = new Mandrill('kwBB4mXd5D3Jf1Ki3y1KYA');
		//--
		// Create the email and send the message
		$to = array(
			array(
				'email' => $mail,
				'name' => $nombre,
				'type' => 'to'
			)
		);
		//print_r($to);
		/////////////_________ Correo a admin
		$subject = "Tu Password";
		$cuerpo = "Has recibido un nuevo mensaje desde ASMS.\n\n"."Aqui estan los detalles:\n\nNombre: $nom\nE-mail: $mail\nUsuario: $usu\nPassword: $pass\n\nQue pases un feliz dia!!!";
		try{
		
			$message = array(
				'subject' => $subject,
				'text' => $cuerpo,
				'from_email' => 'noreply@inversionesd.com',
				'to' => $to
			 );
			 
			 //print_r($message);
			 //echo "<br>";
			 $result = $mandrill->messages->send($message);
			 $validacion =  1;
		} catch(Mandrill_Error $e) { 
			//echo "<br>";
			//print_r($e);
			//devuelve un mensaje de manejo de errores
			$validacion =  0;
		}          
		
		return $validacion;
	}else{
		return 0;
	}	
}


?>