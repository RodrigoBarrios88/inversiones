<?php
	include_once('xajax_funct_encuesta.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
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
	<link rel="shortcut icon" href="../../CONFIG/images/logo.png">
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
						<a href="#"><i class="fa fa-paste"></i> Encuesta</a>
					</li>
					<li>
						<a href="../menu.php"><i class="fa fa-home"></i> Men&uacute; Principal</a>
					</li>
					<li>
						<a href="../CPMENU/MENUcomunicacion.php"><i class="fa fa-indent"></i> Men&uacute; </a>
					</li>
				</ul>
			</div>
		</div>
	</nav>

    <!-- Page Content -->
    <div class="container">
        <div class="row">
             <div class="col-xs-3">
                <p class="lead"><i class="fa fa-paste"></i> Encuestas</p>
                <div class="list-group">
					<a href="../CPINFO/IFRMinformacion.php" class="list-group-item"><i class="fa fa-calendar"></i> Informaci&oacute;n de Actividades</a>
                    <a href="../CPENCUESTAS/IFRMencuestas.php" class="list-group-item active"><i class="fa fa-paste"></i> Encuestas</a>
				    <a href="../CPPOSTIT/FRMpinboard.php" class="list-group-item"><i class="fa fa-thumb-tack"></i> Pin Board</a>
                	<a href="../CPMULTIMEDIA/FRMvisualizar.php" class="list-group-item"><i class="fa fa-film"></i> Multimedia</a>
                </div>
            </div>
            <div class="col-xs-9">
                <div class="thumbnail">
                    <div class="caption-full">
						<div class="row">
							<div class="col-xs-2 col-xs-offset-6">
								<a href="IFRMencuestas.php" class="btn btn-default btn-block"><i class="fa fa-chevron-left"></i> Atras</a>
							</div>
							<div class="col-xs-2">
								<a href="FRMmodencuesta.php" class="btn btn-primary btn-outline btn-block"><i class="fa fa-pencil"></i> Editar </a>
							</div>
							<div class="col-xs-2">
								<a href="FRMnewencuesta.php" class="btn btn-success btn-outline btn-block"><i class="fa fa-plus"></i>  Nueva </a>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<h4 class="alert alert-info"><?php echo $titulo; ?></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<p class="text-justify text-info"><?php echo $descripcion; ?></p>
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
								$pregunta = nl2br($pregunta);
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
											$salida.='<input type="radio" name="radio'.$i.'" id="radioA'.$i.'" value="1" disabled /> 1';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioB'.$i.'" value="2" disabled /> 2';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioC'.$i.'" value="3" disabled /> 3';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioD'.$i.'" value="4" disabled /> 4';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioE'.$i.'" value="5" disabled /> 5';
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
											$salida.='<input type="radio" name="radio'.$i.'" id="radioV'.$i.'" value="5" disabled /> VERDADERO';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioF'.$i.'" value="1" disabled /> FALSO';
										$salida.='</label>';
									$salida.='</div>';
								}else if($tipo == 3){
									$salida.='<div class="form-group">';
										$salida.='<textarea class = "form-control" name = "respuesta'.$i.'" id = "respuesta'.$i.'"  disabled >'.$respuesta.'</textarea>';
									$salida.='</div>';
								}
								
					?>
						<div class="row">
							<div class="col-xs-1 text-right"><label><?php echo $i; ?>.</label></div>
							<div class="col-xs-10">
								<p class="text-justify"><?php echo $pregunta; ?></p>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1"><?php echo $salida; ?></div>
						</div>
						<br>
					<?php
								$i++;
							}
						}else{
							
						}
					?>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								
							</div>
						</div>
                    </div>
                    <div class="ratings">
                        <p class="pull-right text-info"> Visualizado el <?php echo date("d/m/Y"); ?> a las <?php echo date("H:i"); ?></p>
						<br>
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
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
			<img src = "../../CONFIG/images/img-loader.gif" width="100px" /><br>
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

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/app/encuestas.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
</body>
</html>
