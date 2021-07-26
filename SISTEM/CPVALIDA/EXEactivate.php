<?php
	include_once('html_fns_valida.php');
	
	
$nombre_pantalla = utf8_decode($_REQUEST["nom"]);
$cod = $_REQUEST['cod'];
$mail = $_REQUEST['mail'];
$tel = $_REQUEST['tel'];
$usu = $_REQUEST['usu'];
$pass = $_REQUEST['pass1'];	
$preg = $_REQUEST['preg'];
$resp = $_REQUEST['resp'];

$ClsUsu = new ClsUsuario();

	$sql = "";
	$sql.= $ClsUsu->modifica_pass($cod,$usu,$pass);
	$sql.= $ClsUsu->modifica_perfil($cod,$nombre_pantalla,$mail,$tel);
	$sql.= $ClsUsu->cambia_usu_avilita($cod,1);
	//echo $sql;
	if($preg != "" && $resp != ""){
		$sql.=$ClsUsu->cambia_pregunta($cod,$usu,$preg,$resp);	//modifica solo si el usuario prefiere cambiar su pregunta clave
	}
	$rs = $ClsUsu->exec_sql($sql);
	if($rs == 1){
		//mensaje
		$pagina = "../logout.php";
		$msj = "Cambio de usuario y contrase�a exitoso...";
		$status = 1;
	}else{
		//mensaje
		$pagina = "FRMactivate.php";
		$msj = "Error de Conexion..., verifique que los datos ingresados no tengan apostrofes, comillas dobles o simples que interfieran con la conexi�n del Servidor...";
		$status = 0;
	}	

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	<!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Sweet Alert -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
	<!-- //////////////////////////////////////////////////////// -->
	 <script type='text/javascript' >
		function mensaje(status){
			switch(status){
				case 1: status = 'success'; titulo = "Excelente!"; break;
				case 0: status = 'error'; titulo = "Error..."; break;
			}
			var msj = '<?php echo $msj; ?>';
			//-----
			swal(titulo, msj, status).then((value)=>{ window.location = '<?php echo $pagina; ?>'; });
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',1000);
	 </script>
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/usuario.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
    
</body>

</html>