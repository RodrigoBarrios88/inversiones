<?php
	include_once('html_fns_valida.php');
	
	
$nombre_pantalla = utf8_decode($_REQUEST["nompant"]);
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
	
	<!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
	

    <!-- Sweet Alert -->
	<script src="../assets.3.5.20/js/plugins/sweetalert/sweetalert.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/plugins/sweetalert/sweetalert.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.assets.3.5.20/js/1.4.2/respond.min.js"></script>
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
			swal({
				title: titulo,
				text: msj,
				type: status,
			  },
			  function(){
				window.location = '<?php echo $pagina; ?>';
			  });
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',1000);
	 </script>
	
   <!-- scripts -->
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/perfil/perfil.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
    
</body>
</html>