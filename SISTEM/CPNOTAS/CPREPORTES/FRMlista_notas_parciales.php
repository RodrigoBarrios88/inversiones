<?php
	include_once('html_fns_reportes.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	//$_POST
	$pensum = $_REQUEST["pensum"];
	$nivel = $_REQUEST["nivel"];
	$grado = $_REQUEST["grado"];
	$tipo = $_REQUEST["tipo"];
	$num = $_REQUEST["num"];
	$tiposec = $_REQUEST["tiposec"];
	$seccion = $_REQUEST["seccion"];
	$filas_materia = $_REQUEST["materiarows"];
	//--formato de notas
	$chkzona = $_REQUEST["chkzona"];
	$chknota = $_REQUEST["chknota"];
	$chktotal = $_REQUEST["chktotal"];
	//--$POST de Configuración
	$titulo = $_REQUEST["titulo"];
	$acho_cols = $_REQUEST["anchocols"];
	$fontsize = $_REQUEST["font"];
	$tipo_papel = $_REQUEST["papel"];
	$orientacion = $_REQUEST["orientacion"];
	$nota_minima = $_REQUEST["notaminima"];
	
	$ClsAcad = new ClsAcademico();
	$ClsPen = new ClsPensum();
	$ClsNot = new ClsNotas();
								
	switch($num){
		case 1: $num_desc = "1ER."; break;
		case 2: $num_desc = "2DO."; break;
		case 3: $num_desc = "3ER."; break;
		case 4: $num_desc = "4TO."; break;
		case 5: $num_desc = "5TO."; break;
	}
	$titulo = str_replace("PRESENTE",$num_desc,$titulo);
	
	////// Trae las materias a listar en las notas
	$mat_count = 1;
	for($y = 1; $y <= $filas_materia; $y++){
		if($_REQUEST["materia$y"] != ""){
			$materia[$mat_count] = $_REQUEST["materia$y"];
			$result_materias = $ClsPen->get_materia($pensum,$nivel,$grado,$materia[$mat_count],'',1);
			if(is_array($result_materias)){
				foreach($result_materias as $row_materia){
					$mat_cod = $row_materia["mat_codigo"];
					$materia_codigo[$mat_count] = $row_materia["mat_codigo"];
					$materia_descripcion[$mat_count] = utf8_decode($row_materia["mat_desc_ct"]);
				}
				$mat_count++;
			}
		}
	}
	$mat_count--;
	//--
	
	///coloca los formatos porsible en la impresion
	if($chkzona == 1 && $chknota == 1 && $chktotal == 1){
		$formato = "Actividades + Nota de Evaluaciones = Total";
	}else if($chkzona == 1 && $chknota == 1 && $chktotal != 1){
		$formato = "Actividades y Nota";
	}else if($chkzona == 1 && $chknota != 1 && $chktotal != 1){
		$formato = "Zonas";
	}else if($chkzona != 1 && $chknota == 1 && $chktotal != 1){
		$formato = "Nota de Evaluaciones";
	}else if($chkzona != 1 && $chknota != 1 && $chktotal == 1){
		$formato = "Punteo Total";
	}else{
		$formato = "Formato Desconocido (Se usa Punteo Total)"; ///cualquier otra variacion no contemplada se colocara con la nota unicamnete
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
        <div class="row">
			<div class="col-xs-12">
				<div class="">
					<div class="panel-heading">
						<i class="fa fa-file-text fa-fw"></i> Listado de Notas para Examenes Parciales
					</div>
					<div class="">
						<div class = "row">
							<div class = "col-xs-10 col-xs-offset-1 text-center">
								<h5 class="alert alert-info"><?php echo $titulo; ?></h5>
							</div>
						</div>
						<div class = "row">
							<div class = "col-xs-12">
		
							<?php
								/////// TRAE LA NOMINA DE TODAS LAS SECCIONES
								$result_alumnos = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','',$tiposec,1);
								
								if(is_array($result_alumnos)){
							?>		
									<table class="table table-striped table-bordered table-hover" id="dataTables-example">
										<?php
											$num = 1;
											$seccX = 0;
											foreach($result_alumnos as $row){
													$seccion_codigo = $row["seca_seccion"];
													$seccion_nombre = utf8_decode($row["sec_descripcion"]);
													$alumno = $row["alu_cui"];
													$nombre = utf8_decode($row["alu_nombre"]);
													$apellido = utf8_decode($row["alu_apellido"]);
													$nombres = $apellido.", ".$nombre;
													
												if($seccion_codigo != $seccX){
														$colspan = 5 + $mat_count;
														//echo '<tr class="info"><th class = "text-center" colspan = "'.$colspan.'">SECCION '.$seccion_nombre.'</th></tr>';
														$seccX = $seccion_codigo;
										?>
											<thead>
												<tr>
													<th class = "text-center" width = "20px">No.</th>
													<!--th class = "text-center" width = "50px">CUI</th-->
													<th class = "text-center" width = "250px">ALUMNO</th>
													<?php
														for($y = 1; $y <= $mat_count; $y++){
															echo '<th class = "text-center" width = "50px">'.$materia_descripcion[$y].'</th>';
														}	
																
													?>
													<th class = "text-center text-info" width = "50px">PROMEDIO</th>
													<th class = "text-center text-info" width = "50px">ROJOS</th>
												</tr>
											</thead>
											
										<?php		
												}
										?>
								
												<tr>
													<th class = "text-center"><?php echo $num; ?>. </th>
													<!--td class = "text-center">
														<?php //echo $alumno; ?>
														<input type = "hidden" id = "alumno<?php echo $num; ?>" name = "alumno<?php echo $num; ?>" value = "<?php echo $alumno; ?>" />
													</td-->
													<td class = "text-left"><?php echo $nombres; ?></td>
										<?php
												$total = 0;
												$rojos = 0;
												$pendientes = 0;
												$notas_validas = 1;
												for($y = 1; $y <= $mat_count; $y++){
													$result_notas = $ClsNot->comprueba_notas_alumno($alumno,$pensum,$nivel,$grado,$materia[$y],$parcial);
													if(is_array($result_notas)){
														foreach($result_notas as $row_notas){
															$zona = $row_notas["not_zona"];
															$nota = $row_notas["not_nota"];
															$punteo = $row_notas["not_total"];
															$total+= $punteo;
															$text_color = ($punteo < $nota_minima && $punteo > 0)?"text-danger":"text-info";
															
															
															///coloca los formatos porsible en la impresion
															if($chkzona == 1 && $chknota == 1 && $chktotal == 1){
																$formato = "$zona + $nota = $punteo";
																$formato = $zona.' + '.$nota.' = <strong class = "'.$text_color.'">'.$punteo.'</strong>';
															}else if($chkzona == 1 && $chknota == 1 && $chktotal != 1){
																$formato = "$zona | $nota";
																$formato = $zona.' | '.$nota;
															}else if($chkzona == 1 && $chknota != 1 && $chktotal != 1){
																$formato = "$zona";
															}else if($chkzona != 1 && $chknota == 1 && $chktotal != 1){
																$formato = "$nota";
															}else if($chkzona != 1 && $chknota != 1 && $chktotal == 1){
																$formato = '<strong class = "'.$text_color.'">'.$punteo.'</strong>';
															}else{
																$formato = '<strong class = "'.$text_color.'">'.$punteo.'</strong>'; ///cualquier otra variacion no contemplada se colocara con la nota unicamnete
															}
															echo '<td class = "text-center">'.$formato;
															echo '<input type = "hidden" id = "zonaF'.$num.'C'.$y.'" name = "zonaF'.$num.'C'.$y.'" value = "'.$zona.'" />';
															echo '<input type = "hidden" id = "notaF'.$num.'C'.$y.'" name = "notaF'.$num.'C'.$y.'" value = "'.$nota.'" />';
															echo '</td>';
															$notas_validas++;
															if($punteo < $nota_minima && $punteo > 0){
																$rojos++;
															}
														}
													}else{
														echo '<td class = "text-center warning">-';
														echo '<input type = "hidden" id = "zonaF'.$num.'C'.$y.'" name = "zonaF'.$num.'C'.$y.'" value = "0" />';
														echo '<input type = "hidden" id = "notaF'.$num.'C'.$y.'" name = "notaF'.$num.'C'.$y.'" value = "0" />';
														echo '</td>';
														$pendientes++;
													}
												}
													$notas_validas--;
													if($total > 0){
														$promedio = ($total/$notas_validas);
														$promedio = round($promedio, 2);
													}else{
														$promedio = 0;
													}
													$text_color = ($promedio < $nota_minima)?"text-danger":"text-info";
													$promedio = ($promedio > 0)?$promedio:"";
													echo '<th class = "text-center '.$text_color.'">'.$promedio.'</th>';
													$text_color = ($rojos == 0)?"text-info":"text-danger";
													echo '<td class = "text-center '.$text_color.'">'.$rojos.'</td>';
													$num++;
										?>
												</tr>
										<?php
											}
											$num--;
										?>		
										</tbody>			
									</table>
							
							<?php		
								}
							?>
							
								
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
	
	<!-- DataTables JavaScript -->
	<script src="../../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
	
	<!-- Custom Theme JavaScript -->
	<script src="../../assets.3.6.2/dist/js/sb-admin-2.js"></script>
	
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/academico/notas.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
	<!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#notas').DataTable({
				pageLength: 50,
				responsive: true,
				dom: '<"html5buttons"B>lTfgitp',
				buttons: [
					'copyHtml5',
					'csvHtml5',
					{extend: 'excel', title: '<?php echo $titulo; ?>'}
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