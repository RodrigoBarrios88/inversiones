<?php
	include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$pensum = $_SESSION["pensum"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$ban = $_REQUEST["ban"];
	$cue = $_REQUEST["cue"];
	//--
	$ClsBan = new ClsBanco();
	$ClsAcad = new ClsAcademico();
	$result = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}
	}
	
	$result = $ClsBan->get_cuenta_banco($cue,$ban,'','','','',1);
	if(is_array($result)){
		foreach($result as $row){
			$cuenta = $row["cueb_ncuenta"];
			$banco = $row["ban_desc_ct"];
		}
	}
	
	$titulo = "BOLETAS DE COBRO PARA $grado_desc SECCI&Oacute;N $seccion_desc DEL LA CUENTA $cuenta EN EL BANCO $banco";
	
if($nombre != "" && $tipo_codigo != ""){	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../../CONFIG/images/logo.png">
	<!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- CSS personalizado -->
    <link href="../../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
   
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet">
	<!-- jQuery --> 
    <script type="text/javascript" src=" https://code.jquery.com/jquery-1.12.3.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src=" https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src=" https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script type="text/javascript" src=" https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script type="text/javascript" src=" https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
	
    <!-- Custom CSS -->
    <link href="../../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
	
	<nav class="navbar navbar-default navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<?php echo $_SESSION["rotulos_colegio"]; ?>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="fa fa-print"></i> Reporte</a>
					</li>
					<li>
						<a href="../../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-close"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
		<br><br><br><br>
        <div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa  fa-file-excel-o"></i> Generador de .CSV de Boletas por Secci&oacute;n 
						
					</div>
					<div class="panel-body">
						<div class = "row">
							<div class = "col-xs-10 col-xs-offset-1 text-center">
								<h5 class="alert alert-info"><?php echo $titulo; ?></h5>
							</div>
						</div>
						<div class = "row">
							<div class = "col-xs-12">
								<?php
									if($pensum != "" && $nivel != "" && $grado != "" && $seccion != "" && $cue != "" && $ban != ""){
										echo tabla_boleta_cobro($pensum,$nivel,$grado,$seccion,$cue,$ban);
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    <!-- //////////////////////////////////////////////////////// -->

    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/horario/periodo.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
	$(document).ready(function() {
		$('#dataTables-example').DataTable({
			pageLength: 100,
            responsive: true,
			dom: '<"html5buttons"B>lTfgitp',
			buttons: [
				'copyHtml5',
				'csvHtml5',
				 {extend: 'excel', title: 'Boletas de Cobro <?php echo $grado_desc; ?> Seccion <?php echo $seccion_desc; ?> Cuenta <?php echo $cuenta; ?>'}
			]
		} );
	} );
    </script>	
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	//echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>