<?php
	include_once('html_fns_reportes.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	//$_POST
	$periodo = $_REQUEST["periodo"];
	$desde = $_REQUEST["desde"];
	$hasta = $_REQUEST["hasta"];
	//--
	
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
   
    <!-- Custom CSS -->
    <link href="../../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">

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
        <div class="row">
			<div class="col-xs-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<i class="fa fa-plus"></i> <i class="fa fa-dollar"></i> Reporte de Ingresos
					</div>
					<div class="panel-body">
						<div class = "row">
							<div class = "col-xs-10 col-xs-offset-1 text-center">
								<h5 class="alert alert-info">
									<i class="fa fa-plus"></i> <i class="fa fa-dollar"></i> Reporte de Ingresos por Boletas de Inscripci&oacute;n
								</h5>
							</div>
						</div>
						<div class = "row">
							<div class = "col-xs-12">
								<?php
									if($desde != "" && $hasta != ""){
										echo tabla_ingresos($periodo,$desde,$hasta);
									}else{
										echo '<h5 class="alert alert-warning text-center">Debe de seleccionar el periodo de fechas a especifica para listar el reporte...</h5>';
									}
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    <!-- //////////////////////////////////////////////////////// -->
    
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Bootstrap Core JavaScript -->
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/inscripcion/inscripcion.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function(){
            $('.dataTables-example').DataTable({
                pageLength: 100,
                responsive: true,
                dom: '<"html5buttons"B>lTfgitp',
                buttons: [
                    {extend: 'copy'},
                    {extend: 'csv'},
                    {extend: 'excel', title: 'Reporte de Ingresos'},
                    {extend: 'print',
						customize: function (win){
							   $(win.document.body).addClass('white-bg');
							   $(win.document.body).css('font-size', '10px');
   
							   $(win.document.body).find('table')
									   .addClass('compact')
									   .css('font-size', 'inherit');
					    },
						title: 'Reporte de Ingresos'
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