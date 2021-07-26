<?php
	include_once('html_fns_reportes.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	//--
	echo $hashkey = $_REQUEST["hashkey"];
	$ClsAlu = new ClsAlumno();
	$alumno = $ClsAlu->decrypt($hashkey, $usuario);
	$result = $ClsAlu->get_alumno($alumno,"","",1);
	if(is_array($result)){
		foreach($result as $row){
			$cui = $row["alu_cui"];
			$nombre = utf8_decode($row["alu_nombre"]);
			$apellido = utf8_decode($row["alu_apellido"]);
		}
		$nombre_alumno = $nombre." ".$apellido;
	}
	
if($nombre != "" && $valida != ""){	
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../../../CONFIG/images/logo.png">
	
	<!-- CSS personalizado -->
    <link href="../../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Data Table plugin CSS -->
	<link href="../../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
   
    <!-- Custom CSS -->
    <link href="../../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
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
				<?php echo $_SESSION["rotulos_colegio_subpantalla"]; ?>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="fa fa-print"></i> Reporte</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-close"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
	<br><br><br><br>
    <div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-group"></i> Padres o Encargados
		</div>
		<div class="panel-body">
			<div class = "row">
				<div class = "col-xs-10 col-xs-offset-1 text-center">
					<h5 class="alert alert-danger">
						<i class="fa fa-user"></i> Listado de Padres o Encargados asociados a <?php echo $nombre_alumno; ?>
					</h5>
				</div>
			</div>
			<div class = "row">
				<div class = "col-xs-12">
					<?php
						$ClsAsig = new ClsAsignacion();
						$result = $ClsAsig->get_alumno_padre('',$alumno);
						if(is_array($result)){
					?>
					<div class="dataTable_wrapper">
						<table class="table table-striped table-bordered table-hover" id="dataTables-example">
							<thead>
							<tr>
								<th class = "text-center" width = "5px">No.</th>
								<th class = "text-center" width = "60px">DPI</td>
								<th class = "text-center" width = "120px">NOMBRE Y APELLIDO</td>
								<th class = "text-center" width = "100px">CORREO</td>
								<th class = "text-center" width = "50px">TELEFONO DE CASA</td>
								<th class = "text-center" width = "50px">CELULAR</td>
								<th class = "text-center" width = "100px">LUGAR DE TRABAJO</td>
								<th class = "text-center" width = "50px">TELEFONO DE TRABAJO</td>
								<th class = "text-center" width = "10px"></td>
							</tr>
							</thead>
						<?php
							$i = 1;
							foreach($result as $row){
								$dpi = $row["pad_cui"];
								$nombre = utf8_decode($row["pad_nombre"]);
								$apellido = utf8_decode($row["pad_apellido"]);
								$mail = trim($row["pad_mail"]);
								$telcasa = $row["pad_telefono"];
								$celular = $row["pad_celular"];
								$trabajo = utf8_decode($row["pad_lugar_trabajo"]);
								$teltrabajo = $row["pad_telefono_trabajo"];
						?>
							<tr>
								<td class = "text-center"><?php echo $i; ?>.</td>
								<td class = "text-center"><?php echo $dpi; ?></td>
								<td class = "text-left"><?php echo $nombre." ".$apellido; ?></td>
								<td class = "text-center"><?php echo $mail; ?></td>
								<td class = "text-center"><?php echo $telcasa; ?></td>
								<td class = "text-center"><?php echo $celular; ?></td>
								<td class = "text-center"><?php echo $trabajo; ?></td>
								<td class = "text-center"><?php echo $teltrabajo; ?></td>
								<td class = "text-center">
								<?php
									$usu = $_SESSION["codigo"];
									$hashkey = $ClsAsig->encrypt($dpi, $usu);
								?>
									<a href="../../CPPADRES/FRMficha.php?hashkey=<?php echo $hashkey; ?>" class="btn btn-success"><i class="fa fa-search"></i></a>
								</td>
							</tr>
						<?php
								$i++;
							}
							$i--; //quita una vuelta para cuadrar
							$padres = $i;
						?>
						</table>
					<?php }?>
					</div>
				</div>
			</div>
		</div>
	</div>

    <!-- //////////////////////////////////////////////////////// -->
    
    <!-- jQuery -->
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
	
	<!-- DataTables JavaScript -->
    <script src="../../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/colegiatura/boleta.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function(){
           $('#dataTables-example').DataTable({
                pageLength: 10,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: []
            });

        });
    </script>
    
</body>

</html>
<?php
}else{
	echo "<form id='f1' name='f1' action='../../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>