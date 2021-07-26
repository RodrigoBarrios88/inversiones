<?php
	include_once('html_fns_reportes.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$usuario = $_SESSION["codigo"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//_$POST
	$ClsEnc = new ClsEncuesta();
	$hashkey = $_REQUEST["hashkey"];
	$encuesta = $ClsEnc->decrypt($hashkey, $usuario);
	
	$ClsEnc = new ClsEncuesta();
	$result = $ClsEnc->get_encuesta($encuesta);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["enc_codigo"];
			$titulo = utf8_decode($row["enc_titulo"]);
			$descripcion = utf8_decode($row["enc_descripcion"]);
			$feclimit = trim($row["enc_fecha_limite"]);
		}
	}else{
		
	}
	
	
		 //if
				$min = round(($min*60)/100);
				$horas = $hor.".".$min;
				$json.='{y: "'.$nombre.'", x: '.$minutos.', z: "'.$horas.'"},';
		//elese
				$json.='{y: "'.$nombre.'", x: 0, z: 0},';
	
	
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
	
	<!-- CSS personalizado -->
	<link href="../../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Bootstrap Core CSS -->
	<link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- MetisMenu CSS -->
	<link href="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
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
							Estad&iacute;sticas Resultado de encuestas
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<h4><a href="javascript:void(0);"><?php echo $titulo; ?></a></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<p class="text-justify"><?php echo $descripcion; ?></p>
							</div>
						</div>
                        <hr>
						
							
					<?php
						//echo "$hashkey , $encuesta";
						$salida = "";
						$salida_js = "";
						$result = $ClsEnc->get_pregunta('',$encuesta);
						if(is_array($result)){
							$i = 1;
							$boxes = 1;
							foreach ($result as $row){
								$codigo = $row["pre_codigo"];
								$pregunta = utf8_decode($row["pre_descripcion"]);
								$tipo = trim($row["pre_tipo"]);
								$result_respuesta = $ClsEnc->get_pregunta_respuesta($encuesta,$codigo,'');
								$json = "";
								$tabla = "";
								$tr = "";
								if(is_array($result_respuesta)){
									$r1 = 0; $r2 = 0; $r3 = 0; $r4 = 0; $r5 = 0;
									$nresp = 1;
									foreach ($result_respuesta as $row_respuesta){
										$ponderacion = trim($row_respuesta["resp_ponderacion"]);
										$respuesta = utf8_decode($row_respuesta["resp_respuesta"]);
										$tipo_respuesta = trim($row_respuesta["resp_tipo"]);
										if($tipo_respuesta == 1){
											if($ponderacion == 1){
												$r1++;
											}else if($ponderacion == 2){
												$r2++;
											}else if($ponderacion == 3){
												$r3++;
											}else if($ponderacion == 4){
												$r4++;
											}else if($ponderacion == 5){
												$r5++;
											}
										}else if($tipo_respuesta == 2){
											if($ponderacion == 1){
												$r1++;
											}else if($ponderacion == 5){
												$r5++;
											}
										}else if($tipo_respuesta == 3){
											$tr.= '<tr>';
											$tr.= '<td class = "text-justify">'.$nresp.'.- '.$respuesta.'</td>';
											$tr.= '</tr>';
											$nresp++;
										}
									}
									if($tipo_respuesta == 1){
										$r1 = ($r1 == "")?0:$r1;
										$r2 = ($r2 == "")?0:$r2;
										$r3 = ($r3 == "")?0:$r3;
										$r4 = ($r4 == "")?0:$r4;
										$r5 = ($r5 == "")?0:$r5;
										$json.='{y: "Valor1", x: "'.$r1.'"},{y: "Valor2", x: "'.$r2.'"},{y: "Valor3", x: "'.$r3.'"},{y: "Valor4", x: "'.$r4.'"},{y: "Valor5", x: "'.$r5.'"}';
									}else if($tipo_respuesta == 2){
										$r1 = ($r1 == "")?0:$r1;
										$r5 = ($r5 == "")?0:$r5;
										$json.='{y: "Verdadero", x: "'.$r5.'"},{y: "Falso", x: "'.$r1.'"}';
									}else if($tipo_respuesta == 3){
										$tabla.= '<div class="dataTable_wrapper">';
										$tabla.= '<table class="table table-striped table-bordered table-hover">';
										$tabla.= $tr;
										$tabla.= '</table>';
										$tabla.= '</div>';
									}
								}
								
								if($boxes == 1){
									$salida.= '<div class="row">';
									$salida.= '<div class="col-xs-6">';
										$salida.= '<div class="panel panel-default">';
											$salida.= '<div class="panel-heading"><i class="fa fa-bar-chart-o fa-fw"></i> <strong>'.$i.'.</strong> <em>'.$pregunta.'<em></div>';
											$salida.= '<div class="panel-body">';
												$salida.= '<div id="chart'.$i.'">'.$tabla.'</div>';
											$salida.= '</div>';
										$salida.= '</div>';
									$salida.= '</div>';
									$boxes++;
								}else if($boxes == 2){
									$salida.= '<div class="col-xs-6">';
										$salida.= '<div class="panel panel-default">';
											$salida.= '<div class="panel-heading"><i class="fa fa-bar-chart-o fa-fw"></i> <strong>'.$i.'.</strong> <em>'.$pregunta.'<em></div>';
											$salida.= '<div class="panel-body">';
												$salida.= '<div id="chart'.$i.'">'.$tabla.'</div>';
											$salida.= '</div>';
										$salida.= '</div>';
									$salida.= '</div>';
									$salida.= '</div>';
									$boxes = 1;
								}
								
								if($tipo == 1){
									$salida_js.= "$(function() { Morris.Bar({ ";
									$salida_js.= "element: 'chart$i',";
									$salida_js.= "	data: [ $json ], xkey: 'y', ykeys: ['x'], labels: ['Respuestas'],";
									$salida_js.= "hideHover: 'auto',";
									$salida_js.= "resize: true }); });";
								}else if($tipo == 2){
									$salida_js.= "$(function() { Morris.Bar({ ";
									$salida_js.= "element: 'chart$i',";
									$salida_js.= "	data: [ $json ], xkey: 'y', ykeys: ['x'], labels: ['Respuestas'],";
									$salida_js.= "hideHover: 'auto',";
									$salida_js.= "resize: true }); });";
								}else if($tipo == 3){
									
								}
								
								$i++;
							}
							$i--;
							
							echo $salida;
						}else{
							
						}
					?>
							
							
							

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
		<?php echo $salida_js; ?>
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