<?php
	include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$codigo = $_SESSION["codigo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//_$POST
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	//--
	$ClsMae = new ClsMaestro();
	$ClsAsi = new ClsAsignacion();
	$ClsAcadem = new ClsAcademico();
	$ClsHor = new ClsHorario();
	
	if($tipo_usuario == 5){
		$result_maestro = $ClsMae->get_grado_maestro($pensum,$nivel,$grado,'');
	}else if($tipo_usuario == 1){
		$result = $ClsAcadem->get_grado_otros_usuarios($pensum,'','',$tipo_codigo);
		if(is_array($result)){
			$nivel = "";
			$grado = "";
			foreach($result as $row){
				$nivel.= $row["gra_nivel"].",";
				$grado.= $row["gra_codigo"].",";
			}
			$nivel = substr($nivel, 0, -1);
			$grado = substr($grado, 0, -1);
		}
		$result = $ClsMae->get_grado_maestro($pensum,$nivel,$grado,'');
		if(is_array($result)){
			$maestros = "";
			foreach($result as $row){
				$maestros.= "'".$row["mae_cui"]."',";
			}
			$maestros = substr($maestros, 0, -1);
		}
		$result_maestro = $ClsMae->get_maestro_IN($maestros); 
	}else if($tipo_usuario == 2){
		$result_maestro = $ClsMae->get_maestro($tipo_codigo,'','',1);
	}
	
	$json = "";
	if(is_array($result_maestro)){
		foreach($result_maestro as $row_maestro){
			$maestro = $row_maestro["mae_cui"];
			$nombre = $row_maestro["mae_nombre_completo"];
			//echo "$nombre <br>";
			$result_horario = $ClsHor->get_horario('','','','','','','','','','','',$maestro,'');
			if(is_array($result_horario)){
				$minutos = 0;
				foreach($result_horario as $row_horario){
					$ini = $row_horario["per_hini"];
					$fin = $row_horario["per_hfin"];
					$resta = restaHoras($fin,$ini);
					$minutos+= $resta;
				}
				//calcula Horas
				$detalle = ($minutos/60);
				$arr = explode(".",$detalle);
				$hor = $arr[0];
				$min = $arr[1];
				//echo "$detalle $hor $min <br>";
				$min = round(($min*60)/100);
				$horas = $hor.".".$min;
				$json.='{y: "'.$nombre.'", x: '.$minutos.', z: "'.$horas.'"},';
			}else{
				$json.='{y: "'.$nombre.'", x: 0, z: 0},';
			}	
		}
	}
	
	$json = substr($json,0,-1);
	
	
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

     <!-- Morris Charts CSS -->
    <link href="../../assets.3.6.2/bower_components/morrisjs/morris.css" rel="stylesheet">

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
						<a href="../../CPMENU/MENUhorario.php"><i class="fa fa-indent"></i> Men&uacute;</a>
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
						<span class="fa fa-bar-chart-o" aria-hidden="true"></span>
							Estad&iacute;sticas Diaria de Tiempo Laborado por Maestro
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12">
								<div id="morris-bar-chart"></div>
							</div>
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

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

	<!-- Morris Charts JavaScript -->
    <script src="../../assets.3.6.2/bower_components/raphael/raphael-min.js"></script>
    <script src="../../assets.3.6.2/bower_components/morrisjs/morris.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/horario/periodo.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(function() {
			
			Morris.Bar({
				element: 'morris-bar-chart',
				data: [
					<?php echo $json; ?>
				],
				xkey: 'y',
				ykeys: ['x','z'],
				labels: ['Minutos','Horas'],
				hideHover: 'auto',
				resize: true,
				axes: false
			});
			
		});
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