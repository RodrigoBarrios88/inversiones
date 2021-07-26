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
	
	$result = $ClsPen->get_seccion($pensum,$nivel,$grado,$seccion);
	if(is_array($result)){
		foreach($result as $row){
			$grado_desc = utf8_decode($row["gra_descripcion"]);
			$seccion_desc = utf8_decode($row["sec_descripcion"]);
		}
	}
	
	switch($num){
		case 1: $num_desc = "1ER."; break;
		case 2: $num_desc = "2DO."; break;
		case 3: $num_desc = "3ER."; break;
		case 4: $num_desc = "4TO."; break;
		case 5: $num_desc = "5TO."; break;
	}
								
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
					$materia_descripcion[$mat_count] = utf8_decode($row_materia["mat_descripcion"]);
				}
				$mat_count++;
			}
		}
	}
	$mat_count--;
	//--
	
	/////////// Valida los porcentajes de cada unidad por si deben variar
	function porcentajes_unidad($unidad){
		switch($unidad){
			case 1: $porcentaje = 0.2; break;
			case 2: $porcentaje = 0.2; break;
			case 3: $porcentaje = 0.2; break;
			case 4: $porcentaje = 0.2; break;
			case 5: $porcentaje = 0.2; break;
		}
		return $porcentaje;
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
				
		<div class="panel panel-default">
			<div class="panel-heading">
				<i class="fa fa-file-text fa-fw"></i> Listado de Promedios
			</div>
			<div class="panel-body">
				<div class = "row">
					<div class = "col-xs-10 col-xs-offset-1 text-center">
						<h4 class="alert alert-info"> <?php echo $titulo." ".$grado_desc." ".$seccion_desc; ?> </h4>
					</div>
				</div>
				
				<div class = "row">
					<div class = "col-xs-10 col-xs-offset-1">
						<div class = "row">
							<h5 class="text-center"> Materias del Grado </h5>
							<hr>
							<?php for($y = 1; $y <= $mat_count; $y++){ ?>
							<div class = "col-xs-4 text-left">
								<?php echo $y; ?>. <?php echo $materia_descripcion[$y]; ?>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
				<br>
				<div class = "row">
					<div class = "col-xs-12">
					<?php
						$result_alumnos = $ClsAcad->get_seccion_alumno($pensum,$nivel,$grado,$seccion,'','','',1);
						if(is_array($result_alumnos)){
					?>
						<table class="table table-striped table-bordered table-hover" id="notas">
							<thead>
								<tr>
									<th class = "text-center font-10" width = "10px">No.</th>
									<th class = "text-center font-10" width = "100px">Alumno</th>
									<?php
										for($y = 1; $y <= $mat_count; $y++){
									?>		
									<th class = "text-center font-10" width = "10px"><?php echo $y; ?></th>
									<?php
										}	
									?>
									<th class = "text-center font-10" width = "10px">PROM.</th>
									<th class = "text-center font-10" width = "10px">ROJOS</th>	
								</tr>	
							</thead>
							<tbody>
							<?php
								$i = 1;
								foreach($result_alumnos as $row){
									$alumno = $row["alu_cui"];
									$nombre = utf8_decode($row["alu_nombre"]);
									$apellido = utf8_decode($row["alu_apellido"]);
									$nombres = $apellido.", ".$nombre."";
							?>
								<tr>
									<th class = "text-center font-10"><?php echo $i; ?>. </th>
									<td class = "text-left font-10">
										<?php echo $nombres; ?>
										<input type = "hidden" id = "alumno<?php echo $i; ?>" name = "alumno<?php echo $i; ?>" value = "<?php echo $alumno; ?>" />
									</td>
							<?php
									$total = 0;
									$rojos = 0;
									$pendientes = 0;
									$notas_validas = 1;
									for($y = 1; $y <= $mat_count; $y++){
										$result_notas = $ClsNot->get_promedios_materia($pensum,$nivel,$grado,$alumno,$materia[$y]);
										if(is_array($result_notas)){
											foreach($result_notas as $row_notas){
												$nota = $row_notas["nota_promedio"];
												$punteo = number_format($nota, 2, '.', '');
												$total+= $punteo;
												///coloca los formatos porsible en la impresion
												if($chkzona == 1 && $chknota == 1 && $chktotal == 1){
													$formato = "$zona + $nota = $punteo";
												}else if($chkzona == 1 && $chknota == 1 && $chktotal != 1){
													$formato = "$zona | $nota";
												}else if($chkzona == 1 && $chknota != 1 && $chktotal != 1){
													$formato = "$zona";
												}else if($chkzona != 1 && $chknota == 1 && $chktotal != 1){
													$formato = "$nota";
												}else if($chkzona != 1 && $chknota != 1 && $chktotal == 1){
													$formato = "$punteo";
												}else{
													$formato = "$punteo"; ///cualquier otra variacion no contemplada se colocara con la nota unicamnete
												}
												
												$notas_validas++;
												if($punteo < $nota_minima && $punteo > 0){
													$rojos++;
													$text_color = "text-danger";
												}else if($punteo >= $nota_minima && $punteo < 70){
													$text_color = "text-info";
												}else{
													$text_color = "";
												}
												echo '<td class = "text-center '.$text_color.' font-10">'.$formato.'</td>';
											}
										}else{
											echo '<td class = "text-center font-10">-</td>';
											$pendientes++;
										}
										$cols++;
									}
									
									$notas_validas--;
									if($total > 0){
										$promedio = ($total/$notas_validas);
										$promedio = round($promedio, 2);
									}else{
										$promedio = 0;
									}
									$promedio = ($promedio > 0)?$promedio:"";
										
									//promedio
									if($promedio < $nota_minima && $promedio > 0){
										$text_color_promedio = "text-danger";
									}else if($promedio >= $nota_minima && $promedio < 70){
										$text_color_promedio = "text-info";
									}else{
										$text_color_promedio = "";
									}
									echo '<th class = "text-center '.$text_color_promedio.'">'.$promedio.'</th>';
									//rojos
									$text_color_rojos = ($rojos <= 0)?"":"text-danger";
									echo '<th class = "text-center '.$text_color_rojos.'">'.$rojos.'</th>';
									
									$i++;
								}
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
					//'copyHtml5',
					//'csvHtml5',
					//{extend: 'excel', title: '<?php echo $titulo; ?>'}
				]
			} );
		} );
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