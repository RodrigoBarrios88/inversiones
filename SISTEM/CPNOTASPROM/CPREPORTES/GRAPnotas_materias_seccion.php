<?php
	include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$codigo = $_SESSION["codigo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$seccion = $_REQUEST["seccion"];
	$tipo = $_REQUEST["tipo"];
	$num = $_REQUEST["num"];
	//--$POST de Configuración
	$notaminima = $_REQUEST["notaminima"];
		
	$ClsAcad = new ClsAcademico();
	$ClsAlu = new ClsAlumno();
	$ClsNot = new ClsNotas();
	
	switch($parcial){
		case 1: $num_desc = "1ER."; break;
		case 2: $num_desc = "2DO."; break;
		case 3: $num_desc = "3ER."; break;
		case 4: $num_desc = "4TO."; break;
		case 5: $num_desc = "5TO."; break;
	}
	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();

	//$json='{alumno: "MANUEL", aprobadas: "2", reprobadas: "1", pendientes: "0"}';
	
	
if($nombre != "" && $codigo != ""){	
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
   
    <!-- MetisMenu CSS -->
    <link href="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- c3 Charts -->
    <link href="../../assets.3.6.2/css/plugins/c3/c3.min.css" rel="stylesheet">

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
				<?php echo $_SESSION["rotulos_colegio_subpantalla"]; ?>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="fa fa-print"></i> Reporte</a>
					</li>
					<li>
						<a href="../../CPMENU/MENUacademico.php"><i class="fa fa-indent"></i> Men&uacute;</a>
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
	<div class="panel panel-default">
		<div class="panel-heading">
			<span class="fa fa-bar-chart-o" aria-hidden="true"></span>
			Estad&iacute;sticas de Materias Aprobadas y Reprobadas por Secci&oacute;n
		</div>
		<div class="panel-body">
			<div class = "row">
				<div class = "col-xs-10 col-xs-offset-1">
					<div class = "row">
						<h5 class="text-center"> Listado de Materias </h5>
						<hr>
						<?php
							////// Trae las materias a listar en las notas
							$json = "";
							$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,'','',1);
							if(is_array($result_materias)){
								$mat_count = 1;
								$arraprobadas = "";
								$arrreprobadas = "";
								$i = 0;
								foreach($result_materias as $row_materia){
									//--
									$materia = $row_materia["mat_codigo"];
									$materia_desc = utf8_decode($row_materia["mat_descripcion"]);
									//--
									$aprobadas = 0;
									$reprobadas = 0;
									$result = $ClsNot->get_notas_alumno_tarjeta('',$pensum,$nivel,$grado,$seccion,$materia,$num);
									if(is_array($result)){
										$total = 0;
										foreach($result as $row){
											$zona = $row["not_zona"];
											$nota = $row["not_nota"];
											$total = ($zona + $nota);
											if($total >= $notaminima){
												$aprobadas++;
											}else{
												$reprobadas++;
											}
										}
									}
									//--
									$mat_count++;
									echo '<div class = "col-xs-4 text-left"><strong>'.$i.'.</strong> '.$materia_desc.'</div>';
									//break;
									$arraprobadas.= $aprobadas.",";
									$arrreprobadas.= $reprobadas.",";
									$i++;
								}
								$mat_count--;
							}
							//// limpia la cadena
							$arraprobadas = substr($arraprobadas,0,-1);
							$arrreprobadas = substr($arrreprobadas,0,-1);
						?>
					</div>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-xs-12">
					<div id="stocked"></div>
				</div>
			</div>
		</div>
	</div>
		
    <!-- //////////////////////////////////////////////////////// -->
	<!-- jQuery -->
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

	<!-- d3 and c3 charts -->
    <script src="../../assets.3.6.2/js/plugins/d3/d3.min.js"></script>
    <script src="../../assets.3.6.2/js/plugins/c3/c3.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/academico/promnotas.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function () {
			c3.generate({
                bindto: '#stocked',
                data:{
                    columns: [
                        ['Alumnos Aprobados', <?php echo $arraprobadas; ?>],
                        ['Alumnos Reprobados', <?php echo $arrreprobadas; ?>]
                    ],
                    colors:{
                        data1: '#2A79AA',
                        data2: '#A82A2A'
                    },
                    type: 'bar',
                    groups: [
                        ['Alumnos Aprobados', 'Alumnos Reprobados']
                    ]
                }
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