<?php
	include_once('xajax_funct_circular.php');
	$titulo = $_SESSION["nombre"];
	
if($titulo != ""){	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
	
<?php
// obtenemos los datos del archivo
    // otros parametros
	$codigo = $_REQUEST['codigo'];
	$target = $_REQUEST['target'];
	$tipo = $_REQUEST['tipotarget'];
	$tipo = ($tipo == "")?0:$tipo;
		
			$filas = $_REQUEST["gruposrows"];
			$checks = $_REQUEST["chequeados"];
			$checks = explode("|",$checks); 
			
			$ClsCir = new ClsCircular();
				$sql = $ClsCir->delete_det_circular_grupos($codigo); //elimina detalles
				$sql.= $ClsCir->delete_det_circular_secciones($codigo); //elimina detalles
				$sql.= $ClsCir->modifica_target_circular($codigo,$target,$tipo); /// Actualiza Maestra
				
				if($target == "SELECT"){
					if($tipo == 1){
						for($i = 0; $i< $filas; $i++){
						   $bloque = explode(".",$checks[$i]);
						   $pensum = $bloque[0];
						   $nivel = $bloque[1];
						   $grado = $bloque[2];
						   $seccion = $bloque[3];
						   $sql.= $ClsCir->insert_det_circular_secciones($codigo,$pensum,$nivel,$grado,$seccion); /// Inserta detalle
						}
					}else if($tipo == 2){	
						for($i = 0; $i< $filas; $i++){
						   $grupo = $checks[$i];
						   $sql.= $ClsCir->insert_det_circular_grupos($codigo,$grupo); /// Inserta detalle
						}
					}
				}
				
				$rs = $ClsCir->exec_sql($sql);
				//echo $sql;
				if($rs == 1){
					$msj = 'Participantes Actualizados Satisfactoriamente!!!';
					$status = 1;
				}else{
					$msj = 'Error al actualizar el evento...';
					$status = 1;
				}
				
 
?>    
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
    <script type='text/javascript' >
		function mensaje(status){
			switch(status){
				case 1: status = 'success'; titulo = "Excelente!"; break;
				case 0: status = 'error'; titulo = "Error..."; break;
			}
			//-----
			swal({
				title: titulo,
				text:'<?php echo $msj; ?>',
				icon: status,
			}).then((value) => {
				window.location.href = 'FRMmodcircular.php';
			});
		}
		window.setTimeout('mensaje(<?php echo $status; ?>);',500);
	</script>
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/seguridad/usuario.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/reglas.js"></script>
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>