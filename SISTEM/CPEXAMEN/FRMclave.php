<?php
	include_once('xajax_funct_examen.php');
	$id = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$ClsExa = new ClsExamen();
	$hashkey = $_REQUEST["hashkey"];
	$examen = $ClsExa->decrypt($hashkey, $id);
	
	$result = $ClsExa->get_examen($examen);
	if(is_array($result)){
		$i = 0;	
		foreach ($result as $row){
			$codigo = $row["exa_codigo"];
			$titulo = trim($row["exa_titulo"]);
			$descripcion = trim($row["exa_descripcion"]);
			$feclimit = trim($row["exa_fecha_limite"]);
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
                <p class="lead text-danger"><i class="fa fa-paste"></i> Clave de Evaluaciones</p>
                <div class="list-group">
					<a href="FRMlista_secciones.php?acc=gestor" class="list-group-item"><i class="fa fa-pencil"></i> Crear Evaluacion</a>
                    <a href="javascript:void(0);" class="list-group-item active"><i class="fa fa-key"></i> Resolver (Clave)</a>
				    <a href="FRMlista_secciones.php?acc=calificar" class="list-group-item"><i class="fa fa-paste"></i> Calificar Evaluacion</a>
                    <a href="FRMlista_secciones.php?acc=ver" class="list-group-item"><i class="fa fa-search"></i> Visualizar Evaluacion</a>
                </div>
            </div>

            <div class="col-xs-9">

                <div class="thumbnail">
                    <div class="caption-full">
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<h4><a href="javascript:void(0);"><?php echo utf8_decode($titulo); ?></a> &nbsp; <label class="text-danger">(Clave de Evaluacion)</label></h4>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-10 col-xs-offset-1">
								<p class="text-justify"><?php echo utf8_decode($descripcion); ?></p>
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
								$result_respuesta = $ClsExa->get_clave_directa($examen,$codigo);
								if(is_array($result_respuesta)){
									foreach ($result_respuesta as $row_respuesta){
										$ponderacion = trim($row_respuesta["cla_ponderacion"]);
										$respuesta = utf8_decode($row_respuesta["cla_respuesta"]);
									}	
								}else{
									$ponderacion = "";
									$respuesta = "";
								}
								$salida="";
								if($tipo == 1){
									$result_multiple = $ClsExa->get_multiple('',$examen);
									if(is_array($result_multiple)){
										foreach ($result_multiple as $row){
										$numero = $row["mult_numero"];
										$mdescripcion = utf8_decode($row["mult_descripcion"]);
										$codigom = $row["mult_codigo"];
										if ($codigo==$codigom){
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radio'.$numero.''.$i.'" value="'.$numero.'" onclick = "xajax_Grabar_Clave(\''.$examen.'\',\''.$codigo.'\',1,\''.$numero.'\',\'\');" /> '.$mdescripcion.'';
										$salida.='</label>';
										
										}
										$salida.='<script>';
										if($ponderacion != ''){
										if($ponderacion === $numero ){
										$salida.='document.getElementById("radio'.$numero.''.$i.'").checked = true;';
										}
									}
										$salida.='</script>';
										}
									}
								}else if($tipo == 2){
									switch($ponderacion){
										case 1: $elemento = 'V'; break;
										case 2: $elemento = 'F'; break;
										default: $elemento = ''; break;
									}
									$salida.='<div class="form-group">';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioV'.$i.'" value="1" onclick = "xajax_Grabar_Clave(\''.$examen.'\',\''.$codigo.'\',2,this.value,\'\');" /> VERDADERO';
										$salida.='</label>';
										$salida.='<label class="radio-inline">';
											$salida.='<input type="radio" name="radio'.$i.'" id="radioF'.$i.'" value="2" onclick = "xajax_Grabar_Clave(\''.$examen.'\',\''.$codigo.'\',2,this.value,\'\');" /> FALSO';
										$salida.='</label>';
									$salida.='</div>';
									$salida.='<script>';
									if($elemento != ''){
										$salida.='document.getElementById("radio'.$elemento.''.$i.'").checked = true;';
									}
									$salida.='</script>';
								}else if($tipo == 3){
									$salida.='<div class="form-group">';
										$salida.='<textarea class = "form-control" name = "respuesta'.$i.'" id = "respuesta'.$i.'"  rows="5" onkeyup="textoLargo(this);" onblur = "xajax_Grabar_Clave(\''.$examen.'\',\''.$codigo.'\',3,\'0\',this.value);">'.$respuesta.'</textarea>';
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
                        <p class="pull-right"> Revise el contenido de la clave para evitar errores en la calificaci&oacute;n</p>
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
						<div class="col-xs-10 col-xs-offset-1 text-center">
							<button type="button" class="btn btn-success" onclick="window.location.reload();"><i class="fa fa-check"></i> Listo !</button>
							<button type="button" class="btn btn-default" onclick="window.close();"><i class="fa fa-times"></i> Cerrar</button>
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
    <script type="text/javascript" src="../assets.3.6.2/js/modules/academico/examen.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
</body>
</html>
