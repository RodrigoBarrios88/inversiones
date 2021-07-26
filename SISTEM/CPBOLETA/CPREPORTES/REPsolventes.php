<?php
	include_once('html_fns_reportes.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$ClsPer = new ClsPeriodoFiscal();
	$ClsBan = new ClsBanco();
	//$_POST
	$division = $_REQUEST["division"];
	$grupo = $_REQUEST["grupo"];
	$anio = $_REQUEST["anio"];
	$periodo = $_REQUEST["periodo"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	//--
	if($division != "" && $grupo != ""){
		$ClsDiv = new ClsDivision();
		$result = $ClsDiv->get_division($division,$grupo);
		if(is_array($result)){
			foreach($result as $row){
				$division_desc = utf8_decode($row["div_nombre"]);
				$grupo_desc = utf8_decode($row["gru_nombre"]);
			}
		}
		$division_titulo = " ($division_desc)";
	}
	if($anio == "" && $periodo != ""){
		$anio = $ClsPer->get_anio_periodo($periodo);
	}else if($anio != "" && $periodo == ""){
		$periodo = $ClsPer->get_periodo_anio($anio);
	}else{
		$periodo = $ClsPer->get_periodo_activo();
		$anio = $ClsPer->get_pensum_periodo($periodo);
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
			<i class="fa fa-check-square-o"></i> Reporte de Solventes (Alumnos que tienen saldo 0 a a favor)
		</div>
		<div class="panel-body">
			<div class = "row">
				<div class = "col-xs-10 col-xs-offset-1 text-center">
					<h5 class="alert alert-success">
						<i class="fa fa-check-square-o"></i> Reporte de Alumnos que tienen saldo 0 a favor <?php echo $division_titulo; ?>
					</h5>
				</div>
			</div>
			<div class = "row">
				<div class = "col-xs-12">
					<?php
						echo tabla_solventes($periodo,$division,$grupo,$anio,$nivel,$grado,$seccion,$hasta);
					?>
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
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/inscripcion/inscripcion.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function(){
           $('#dataTables-example').DataTable({
                pageLength: 100,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Reporte de Solventes (Alumnos que tienen saldo 0 a favor)'},
                    {extend: 'pdf', title: 'Reporte de Solventes (Alumnos que tienen saldo 0 a favor)'},

                    {extend: 'print',
						customize: function (win){
							   $(win.document.body).addClass('white-bg');
							   $(win.document.body).css('font-size', '10px');
   
							   $(win.document.body).find('table')
									   .addClass('compact')
									   .css('font-size', 'inherit');
					    },
						title: 'Reporte de Solventes (Alumnos que tienen saldo 0 a favor)'
                    }
                ]

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