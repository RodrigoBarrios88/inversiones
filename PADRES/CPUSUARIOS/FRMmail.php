<?php
  require_once("../../CONFIG/constructor.php"); //--correos
  require_once("../recursos/mandrill/src/Mandrill.php"); //--correos
	
//////////////////////// CREDENCIALES DE COLEGIO
require_once ("../Clases/ClsRegla.php");
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
   
function depurador_texto($texto) {
	$texto = trim($texto);
	$texto = str_replace("á","a",$texto);
	$texto = str_replace("é","e",$texto);
	$texto = str_replace("í","i",$texto);
	$texto = str_replace("ó","o",$texto);
	$texto = str_replace("ú","u",$texto);
	$texto = str_replace("Á","A",$texto);
	$texto = str_replace("É","E",$texto);
	$texto = str_replace("Í","I",$texto);
	$texto = str_replace("Ú","U",$texto);
	$texto = str_replace("ñ","n",$texto);
	$texto = str_replace("Ñ","N",$texto);
	
   return $texto;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Ayuda</title>
    <link rel="shortcut icon" href="../../CONFIG/images/icono.ico" >
		
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	
    <!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
		
	<link rel="stylesheet" type="text/css" href="assets.3.5.20/css/plugins/sweetalert/sweetalert.css">
	<style>
		body {
			font-family: 'Open Sans', sans-serif;
			background-color: #D8D8D8;
			position: relative;
			margin: 0px;
			font-size: 12px;
			padding: 0px;
		}
	</style>
  </head>
  <body>
<?php
	$nombre = $_REQUEST["name"];
    $correo = $_REQUEST["email"];
    $telefono = $_REQUEST["phone"];
    $message = $_REQUEST["message"];

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
   $texto = "Has recibido un nuevo mensaje desde ASMS ($colegio_nombre).<br><br> Aqui estan los detalles:<br>";
	$texto = "Nombre: <b>$nombre</b><br>Telefono: <b>$telefono</b><br>E-mail: <b>$correo</b><br>Asunto: <b>$subject</b><br>Mensaje: <p>$message</p>";
	$texto.= "<br><br>Que pases un feliz dia!!!";
	
	$html = mail_constructor($subject,$texto);
   
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
         $status = 1;
	} catch(Mandrill_Error $e) { 
		//echo "<br>";
		//print_r($e);
		//devuelve un mensaje de manejo de errores
        $status = 0;
	}
	
	//echo $msj;
?>    
    <!-- //////////////////////////////////////////////////////// -->
    <script type='text/javascript' >
		function mensaje(status){
			if(status == 1){
				swal("Ok!", "Su mensaje ha sido enviado exitosamente, en un momento uno de nuestros agentes lo contactar\u00E1...", "success").then((value)=>{ window.location.href="FRMcontact_admin.php"; });
			}else{
				swal("Ohoo!", "Su mensaje no ha podido ser entregado en este momento, lo sentimos...", "error").then((value)=>{ window.location.href="FRMcontact_admin.php"; });
			}
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',500);
	</script>	
		
  </body>

</html>