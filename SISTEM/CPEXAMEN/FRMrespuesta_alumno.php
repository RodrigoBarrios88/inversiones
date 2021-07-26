<?php
	include_once('xajax_funct_examen.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$ClsExa = new ClsExamen();
	$hashkey1 = $_REQUEST["hashkey1"];
	$examen = $ClsExa->decrypt($hashkey1, $id);
	$hashkey2 = $_REQUEST["hashkey2"];
	$alumno = $ClsExa->decrypt($hashkey2, $id);
	
	$result = $ClsExa->get_det_examen($examen,$alumno);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["exa_codigo"];
			$titulo = utf8_decode($row["exa_titulo"]);
			$descripcion = utf8_decode($row["exa_descripcion"]);
			//--
			$fini = trim($row["exa_fecha_inicio"]);
			$fini = cambia_fechaHora($fini);
			$ffin = trim($row["exa_fecha_limite"]);
			$ffin = cambia_fechaHora($ffin);
			//--
			$feclimit = trim($row["exa_fecha_limite"]);
			//--
			$situacion = trim($row["dexa_situacion"]);
		}
		if($situacion == 1){
			$situacion_desc ='<span class = "text-muted"><i class="fa fa-clock-o"></i> Sin Resolver</span> &nbsp; ';
		}else if($situacion == 2){
			$situacion_desc ='<span class = "text-info"><i class="fa fa-check"></i> Resuelto</span> &nbsp; ';
		}else if($situacion == 3){
			$situacion_desc ='<span class = "text-success"><i class="fa fa-check-circle-o"></i> Calificado</span> &nbsp; ';
		}
	}else{
		
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
	<link rel="shortcut icon" href="../img/icono.ico">
		<?php
		   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
		   $xajax->printJavascript("..");
		 ?>	
	<!-- CSS personalizado -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Custom CSS -->
    <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/shop-item.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</head>

<body>
    <!-- Navigation -->
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
						<a href="#"><i class="fa fa-paste"></i> Evaluaciones</a>
					</li>
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
					<li>
						<a href="javascript:void(0)" onclick="window.close();"><i class="fa fa-close"></i> Cerrar</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

			<div class="col-xs-3">
                <p class="lead text-success"><i class="fa fa-paste"></i> Evaluaci&oacute;n Resuelta</p>
                <div class="list-group">
					<a href="FRMlista_secciones.php?acc=gestor" class="list-group-item"><i class="fa fa-pencil"></i> Crear Examen</a>
                    <a href="FRMlista_secciones.php?acc=calificar" class="list-group-item"><i class="fa fa-key"></i> Resolver (Clave)</a>
				    <a href="javascript:void(0);" class="list-group-item active"><i class="fa fa-paste"></i> Calificar Examen</a>
                    <a href="FRMlista_secciones.php?acc=ver" class="list-group-item"><i class="fa fa-search"></i> Visualizar Examen</a>
                </div>
            </div>

            <div class="col-xs-9">
                <div class="thumbnail">
                    <div class="caption-full">
						<br>
						<div class="row">
							<div class="col-xs-12">
								<?php echo $title; ?>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-3"><?php echo $situacion_desc; ?></div>
						</div>
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-10">
								<h4><a href="javascript:void(0);"><?php echo $titulo; ?></a></h4>
								<input type= "hidden" name = "examen" id = "examen" value = "<?php echo $examen; ?>" />
								<input type= "hidden" name = "alumno" id = "alumno" value = "<?php echo $alumno; ?>" />
								<input type= "hidden" name = "feclimit" id = "feclimit" value = "<?php echo $feclimit; ?>" />
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-10">
								<p class="text-justify"><?php echo $descripcion; ?></p>
							</div>
						</div>
                        <hr>
					<?php
						$result = $ClsExa->get_pregunta('',$examen);
							if(is_array($result)){
								$i = 1;	
								foreach ($result as $row){
									$codigo = $row["pre_codigo"];
									$pregunta = utf8_decode($row["pre_descripcion"]);
									$tipo = trim($row["pre_tipo"]);
									$puntos = trim($row["pre_puntos"]);
									$result_clave = $ClsExa->get_clave_directa($examen,$codigo);
									   if(is_array($result_clave)){
										   foreach($result_clave as $row){
											   $eponderacion = trim($row["cla_ponderacion"]);
											   }
										   }
									$result_respuesta = $ClsExa->get_respuesta_directa($examen,$codigo,$alumno);
									if(is_array($result_respuesta)){
										foreach ($result_respuesta as $row_respuesta){
											$ponderacion = trim($row_respuesta["resp_ponderacion"]);
											$respuesta = utf8_decode($row_respuesta["resp_respuesta"]);
									   }
				
									}
									$salida="";
								//	echo($eponderacion);
								//	echo($result_respuesta);
									if($tipo == 1){
										$result_multiple = $ClsExa->get_multiple('',$examen);
									if(is_array($result_multiple)){
										foreach ($result_multiple as $row){
										$numero = $row["mult_numero"];
										$mdescripcion = utf8_decode($row["mult_descripcion"]);
										$codigom = $row["mult_codigo"];
										if($numero == $eponderacion){
											$total1 = $puntos;
										}else{
											$total1 = '0';
										}
										if ($codigo==$codigom){
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radio'.$numero.''.$i.'" value="'.$numero.'" onclick="javascript: return false;"  /> <label for="radio'.$numero.''.$i.'" >'.$mdescripcion.' &nbsp;</label>';
										$salida.='</label>';
									
										}
										$salida.='<script>';
										if($ponderacion != ''){
										if($ponderacion === $numero ){
										    if(is_array($result_respuesta)){
									           	$salida.='document.getElementById("radio'.$numero.''.$i.'").checked = true;';
								    		}
										}
									}
										$salida.='</script>';
										}
									}
									}else if($tipo == 2){
										$result_multiple = $ClsExa->get_multiple('',$examen);
									if(is_array($result_multiple)){
										foreach ($result_multiple as $row){
										$numero = $row["mult_numero"];
										$mdescripcion = utf8_decode($row["mult_descripcion"]);
										$codigom = $row["mult_codigo"];
										if($numero == $eponderacion){
											$total1 = $puntos;
										}else{
											$total1 = '0';
										}
										if ($codigo==$codigom){
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radio'.$numero.''.$i.'" value="'.$numero.'" onclick="javascript: return false;" /> <label for="radio'.$numero.''.$i.'" >'.$mdescripcion.' &nbsp;</label>';
										$salida.='</label>';
									
										}
										$salida.='<script>';
										if($ponderacion != ''){
										if($ponderacion === $numero ){
										    if(is_array($result_respuesta)){
									        	$salida.='document.getElementById("radio'.$numero.''.$i.'").checked = true;';
										    }
										}
									}
										$salida.='</script>';
										}
									}
								}else if($tipo == 3){
									$salida.='<div class="form-group">';
										$salida.='<label class = "form-parrafo">'.$respuesta.' </label>';
									$salida.='</div>';
								}
								
					?>
						<div class="row">
							<div class="col-xs-1 text-right"><label><?php echo $i; ?>.</label></div>
							<div class="col-xs-10">
								<p class="text-justify"><?php echo $pregunta; ?> &nbsp; <label>(<?php echo $puntos; ?> Puntos)</label></p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-1"></div>
							<div class="col-xs-10"><?php echo $salida; ?></div>
						</div>
						<br>
					<?php
								$i++;
							}
						}else{
							
						}
					?>
						<div class="row">
							<div class="col-xs-12">
								
							</div>
						</div>
                    </div>
					<hr>
					<div class="row">
						<div class="col-xs-10 col-xs-offset-1">
									<div class="row">
									<?php echo tabla_archivos_respuesta($codigo,$alumno); ?>
									</div>
						</div>
					</div>
					<hr>
                    <div class="ratings">
                        <p class="pull-right"> Visualizado el <?php echo date("d/m/Y"); ?> a las <?php echo date("H:i"); ?></p>
                        <p>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                            <span class="fa fa-star"></span>
                        </p>
                    </div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<h3><?php echo $situacion_desc; ?></h3>
						</div>
					</div>
					<br>
                </div>
            </div>
        </div>
    </div>
    <!-- /.container -->
    <div class="container">
        <hr>
        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; ID 2017.</p>
                </div>
            </div>
        </footer>
    </div>
    <!-- /.container -->
	
	<!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/academico/examen.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
</body>
</html>
<?php

function tabla_archivos_respuesta($codigo,$alumno){
	$ClsExa = new ClsExamen();
	$result = $ClsExa->get_resolucion_examen_archivo('',$codigo,$alumno,'');
	$archivo = array();
	if(is_array($result)){
	    $i = 1;	
		foreach($result as $row){
			//archivos
			$extension = trim($row["arch_extencion"]);
			switch($extension){
				case "doc": $icono = '<i class = "fa fa-file-word-o fa-2x text-info"></i>'; break;
				case "docx": $icono = '<i class = "fa fa-file-word-o fa-2x text-info"></i>'; break;
				case "ppt": $icono = '<i class = "fa fa-file-powerpoint-o fa-2x text-danger"></i>'; break;
				case "pptx": $icono = '<i class = "fa fa-file-powerpoint-o fa-2x text-danger"></i>'; break;
				case "xls": $icono = '<i class = "fa fa-file-excel-o fa-2x text-success"></i>'; break;
				case "xlsx": $icono = '<i class = "fa fa-file-excel-o fa-2x text-success"></i>'; break;
				case "jpg": $icono = '<i class = "fa fa-file-picture-o fa-2x text-muted"></i>'; break;
				case "jpeg": $icono = '<i class = "fa fa-file-picture-o fa-2x text-muted"></i>'; break;
				case "png": $icono = '<i class = "fa fa-file-picture-o fa-2x text-muted"></i>'; break;
				case "pdf": $icono = '<i class = "fa fa-file-pdf-o fa-2x text-warning"></i>'; break;
			}
			//archivo
			$archivo = trim($row["arch_codigo"])."_".trim($row["arch_examen"])."_".trim($row["arch_alumno"]).".".trim($row["arch_extencion"]);
			//iframez
			if($extension === "jpg"|| $extension === "png" || $extension === "jpeg" ){
                $iframe = '<img src="../../../../CONFIG/DATALMSALUMNOS/TEST/MATERIAS/'.$archivo.'" width="100%" height="600" />'; 
			}else{
			    $iframe = '<iframe src="//docs.google.com/gview?url=https://'.$_SERVER['HTTP_HOST'].'/CONFIG/DATALMSALUMNOS/TEST/MATERIAS/'.$archivo.'&embedded=true" width="100%" height="600"></iframe>';
			    
			}
            if($i== 1){
                $li='<li class="active"><a data-target="#'.$i.'" data-toggle="tab"> '.$icono.'</a></li>';
		    	$div='<div class="tab-pane active" id="'.$i.'">'.$iframe.'</div>';
            }else{
                $li='<li><a data-target="#'.$i.'" data-toggle="tab"> '.$icono.'</a></li>';
			    $div='<div class="tab-pane" id="'.$i.'">'.$iframe.'</div>';
            }
			
			$li2= $li.$li2;
			$div2= $div.$div2;
			$i++;
		}
		$salida.=  '<ul class="nav nav-tabs" id="myTabs">
                        '.$li2.'        
                   </ul>';
        $salida.=  '<br><div class="tab-content"> 
                        '.$div2.'
                    </div>'; 
        		            
	}else{
		$salida.= '<h5 class = "alert alert-warning text-center">';
		$salida.= '<i class = "fa fa-warning"></i> No se registran archivos adjuntos en esta tarea...';
		$salida.= '</h5>';
	}
	return $salida;
}


?>