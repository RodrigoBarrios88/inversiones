<?php
	include_once('xajax_funct_encuesta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	//$_POST
	$ClsEnc = new ClsEncuesta();
	$hashkey = $_REQUEST["hashkey"];
	$encuesta = $ClsEnc->decrypt($hashkey, $id);
	
	$ClsEnc = new ClsEncuesta();
	$result = $ClsEnc->get_encuesta($encuesta);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["enc_codigo"];
			$titulo = utf8_decode($row["enc_titulo"]);
			$descripcion = utf8_decode($row["enc_descripcion"]);
			$descripcion = nl2br($descripcion);
			$feclimit = trim($row["enc_fecha_limite"]);
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
	<link rel="shortcut icon" href="../images/icono.ico">
	<?php
	   //En el <head> indicamos al objeto xajax se encargue de generar el javascript necesario
	   $xajax->printJavascript("..");
	?>	
	<!-- Bootstrap Core CSS -->
    <link href="../assets.3.5.20/css/bootstrap/bootstrap.css" rel="stylesheet" />
    <link href="../assets.3.5.20/css/bootstrap/bootstrap-overrides.css" type="text/css" rel="stylesheet" />

    <!-- libraries -->
    <link href="../assets.3.5.20/css/lib/jquery-ui-1.10.2.custom.css" rel="stylesheet" type="text/css" />
    <!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- global styles -->
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/layout.css" />
    <link rel="stylesheet" type="text/css" href="../assets.3.5.20/css/compiled/elements.css" />
    
	<!-- Fonts -->
	<link rel="stylesheet" type="text/css" href="../assets.3.5.20/font-awesome/css/custom.fonts.css" />
	<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom CSS -->
    <link href="../assets.3.5.20/css/lib/shop-item.css" rel="stylesheet">
    
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

</head>

<body>
    <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" style = "z-index:500;">
		<div class="container">
			<div class="navbar-header">
				<button class="navbar-toggle collapsed" aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" type="button">
					<span class="sr-only">ASMS</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="../menu.php"><img src="../../CONFIG/images/logo_white.png" alt="logo" width="30px" /> &nbsp; <label><?php echo $_SESSION["nombre_colegio"]; ?></label> </a>
				</div>
				<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li class="active">
						<a href="#"><i class="fa fa-paste"></i> Encuesta</a>
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

             <div class="col-md-3">
                <p class="lead"><i class="fa fa-paste"></i> Encuestas</p>
                <div class="list-group">
					<?php if($_SESSION["MOD_calendario"] == 1){ ?>
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
					<?php } ?>
					<?php if($_SESSION["MOD_encuestas"] == 1){ ?>
                    <a href="../CPENCUESTAS/FRMencuestas.php" class="list-group-item active"><i class="fa fa-paste"></i> Encuestas</a>
					<?php } ?>
					<?php if($_SESSION["MOD_tareas"] == 1){ ?>
				    <a href="../CPTAREAS/FRMtareas.php" class="list-group-item"><i class="fa fa-paste"></i> Tareas</a>
					<?php } ?>
					<?php if($_SESSION["MOD_pinboard"] == 1){ ?>
                    <a href="../CPPOSTIT/FRMpinboard.php" class="list-group-item"><i class="fas fa-thumbtack"></i> Pin Board</a>
					<?php } ?>
					<?php if($_SESSION["MOD_videos"] == 1){ ?>
                	<a href="../CPMULTIMEDIA/FRMvideos.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
					<?php } ?>
					<?php if($_SESSION["MOD_photos"] == 1){ ?>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-image"></i> Photo Album</a>
					<?php } ?>
				</div>
            </div>

            <div class="col-md-9">

                <div class="thumbnail">
                    <div class="caption-full">
						<h4 class="alert alert-info">
							<?php echo $titulo; ?>
						</h4>
						<div class="row">
							<div class="col-md-12">
								<p class="text-justify"><?php echo $descripcion; ?></p>
							</div>
						</div>
                        <hr>
					<?php
						$result = $ClsEnc->get_pregunta('',$encuesta);
						if(is_array($result)){
							$i = 1;	
							foreach ($result as $row){
								$codigo = $row["pre_codigo"];
								$pregunta = utf8_decode($row["pre_descripcion"]);
								$tipo = trim($row["pre_tipo"]);
								$result_respuesta = $ClsEnc->get_respuesta_directa($encuesta,$codigo,$tipo_codigo);
								if(is_array($result_respuesta)){
									foreach ($result_respuesta as $row_respuesta){
										$ponderacion = trim($row_respuesta["resp_ponderacion"]);
										$respuesta = utf8_decode($row_respuesta["resp_respuesta"]);
									}	
								}	
								
								$salida="";
								if($tipo == 1){
									switch($ponderacion){
										case 1: $elemento = 'A'; break;
										case 2: $elemento = 'B'; break;
										case 3: $elemento = 'C'; break;
										case 4: $elemento = 'D'; break;
										case 5: $elemento = 'E'; break;
										default: $elemento = ''; break;
									}
									$salida.='<div class="form-group">';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioA'.$i.'" value="1" onclick = "xajax_Grabar_Respuesta(\''.$encuesta.'\',\''.$codigo.'\',\''.$tipo_codigo.'\',1,this.value,\'\');" /> 1';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioB'.$i.'" value="2" onclick = "xajax_Grabar_Respuesta(\''.$encuesta.'\',\''.$codigo.'\',\''.$tipo_codigo.'\',1,this.value,\'\');" /> 2';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioC'.$i.'" value="3" onclick = "xajax_Grabar_Respuesta(\''.$encuesta.'\',\''.$codigo.'\',\''.$tipo_codigo.'\',1,this.value,\'\');" /> 3';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioD'.$i.'" value="4" onclick = "xajax_Grabar_Respuesta(\''.$encuesta.'\',\''.$codigo.'\',\''.$tipo_codigo.'\',1,this.value,\'\');" /> 4';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioE'.$i.'" value="5" onclick = "xajax_Grabar_Respuesta(\''.$encuesta.'\',\''.$codigo.'\',\''.$tipo_codigo.'\',1,this.value,\'\');" /> 5';
										$salida.='</label>';
									$salida.='</div>';
									$salida.='<script>';
									if($elemento != ''){
										$salida.='document.getElementById("radio'.$elemento.''.$i.'").checked = true;';
									}
									$salida.='</script>';
								}else if($tipo == 2){
									switch($ponderacion){
										case 5: $elemento = 'V'; break;
										case 1: $elemento = 'F'; break;
										default: $elemento = ''; break;
									}
									$salida.='<div class="form-group">';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioV'.$i.'" value="5" onclick = "xajax_Grabar_Respuesta(\''.$encuesta.'\',\''.$codigo.'\',\''.$tipo_codigo.'\',2,this.value,\'\');" /> VERDADERO';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioF'.$i.'" value="1" onclick = "xajax_Grabar_Respuesta(\''.$encuesta.'\',\''.$codigo.'\',\''.$tipo_codigo.'\',2,this.value,\'\');" /> FALSO';
										$salida.='</label>';
									$salida.='</div>';
									$salida.='<script>';
									if($elemento != ''){
										$salida.='document.getElementById("radio'.$elemento.''.$i.'").checked = true;';
									}
									$salida.='</script>';
								}else if($tipo == 3){
									$salida.='<div class="form-group">';
										$salida.='<textarea class = "form-control" name = "respuesta'.$i.'" id = "respuesta'.$i.'"  onkeyup = "texto(this)"  onblur = "xajax_Grabar_Respuesta(\''.$encuesta.'\',\''.$codigo.'\',\''.$tipo_codigo.'\',3,\'0\',this.value);">'.$respuesta.'</textarea>';
									$salida.='</div>';
								}
								
					?>
						<div class="row">
							<div class="col-md-1 text-right"><label><?php echo $i; ?>.</label></div>
							<div class="col-md-10">
								<p class="text-justify"><?php echo $pregunta; ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-md-10 col-md-offset-1"><?php echo $salida; ?></div>
						</div>
						<br>
					<?php
								$i++;
							}
						}else{
							
						}
					?>
						<div class="row">
							<div class="col-md-10 col-md-offset-1">
								
							</div>
						</div>
                    </div>
                    <div class="ratings">
                        <p class="pull-right">Copyright &copy; ID <?php echo date("Y"); ?></p><br>
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
                    <p>Copyright &copy; ID <?php echo date("Y"); ?></p>
                </div>
            </div>
        </footer>

    </div>
    <!-- /.container -->
	
	<!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../images/logo.png" width = "60px;" /></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
			<img src="../images/img-loader.gif"/><br>
			<label align ="center">Transaccion en Proceso...</label>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
			</div>
	      </div>
	      <div class="modal-body" id= "Pcontainer">
		
	      </div>
	    </div>
	  </div>
	</div>
    <!-- Modal -->

    <!-- scripts -->
    <script src="../assets.3.5.20/js/jquery-latest.js"></script>
    <script src="../assets.3.5.20/js/bootstrap.min.js"></script>
    <script src="../assets.3.5.20/js/jquery-ui-1.10.2.custom.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.5.20/js/modules/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/encuestas/encuestas.js"></script>
    <script type="text/javascript" src="../assets.3.5.20/js/modules/util.js"></script>
	
</body>
</html>
