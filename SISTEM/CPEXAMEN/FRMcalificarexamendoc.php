<?php
	include_once('../html_fns.php');
	include_once('xajax_funct_examen.php');
	$nombre = $_SESSION["nombre"];
	$empresa = $_SESSION["empresa"];
	$empCodigo = $_SESSION["empCodigo"];
	$pensum = $_SESSION["pensum"];
	//--
    $hashkey1 = $_REQUEST["hashkey1"];
	$alumno = $hashkey1;
	$hashkey2 = $_REQUEST["hashkey2"];
	$examen = $hashkey2;
    $hashkey3 = $_REQUEST["hashkey3"];
	$fila = $hashkey3;
	
	$ClsExa = new ClsExamen();
	$result = $ClsExa->get_det_examen($examen,$alumno);
	if(is_array($result)){
		foreach($result as $row){
			$titulo = utf8_decode($row["exa_titulo"]);
			$desc = utf8_decode($row["exa_descripcion"]);
			$desc = nl2br($desc);
			$nota = $row["dexa_nota"];
			$nota = ($nota == 0)?"":$nota;
			$obs = utf8_decode($row["dexa_observaciones"]);
			$obs = nl2br($obs);
			$situacion = trim($row["dexa_situacion"]);
			//--
			$tipocalifica = trim($row["exa_tipo_calificacion"]);
			switch($tipocalifica){
				case "Z": $tipocalifica = " Actividades"; break;
				case "E": $tipocalifica = " Evaluaciones"; break;
			}
		}
		if($situacion == 1){
			$situacion_desc ='<span class = "text-muted"><i class="fa fa-clock-o"></i> Sin Resolver</span> &nbsp; ';
		}else if($situacion == 2){
			$situacion_desc ='<span class = "text-info"><i class="fa fa-check"></i> Resuelto</span> &nbsp; ';
		}else if($situacion == 3){
			$situacion_desc ='<span class = "text-success"><i class="fa fa-check-circle-o"></i> Calificado</span> &nbsp; ';
		}
	}
	
	$result = $ClsExa->get_pregunta('',$examen);
	$maximo = 0;
	if(is_array($result)){
		foreach ($result as $row){
			$maximo+= trim($row["pre_puntos"]);
		}	
	}
	
	
	$ClsAlu = new ClsAlumno();
	$result = $ClsAlu->get_alumno($alumno,"","",1);
	if(is_array($result)){
		foreach($result as $row){
			$alu_cui = $row["alu_cui"];
			$alu_nombre = utf8_decode($row["alu_nombre"]);
			$alu_apellido = utf8_decode($row["alu_apellido"]);
		}
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
	
	<!-- Estilos Utilitarios -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
	<script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
	
	<!-- Datepicker Bootstrap v3.0 -->
	<script type="text/javascript" src="../assets.3.6.2/bower_components/moment/min/moment.min.js"></script>
	<script type="text/javascript" src="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
	<link rel="stylesheet" href="../assets.3.6.2/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />
	
	<!-- Bootstrap Core CSS -->
	<link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">
	
	<!-- MetisMenu CSS -->
	<link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">
	
	<!-- DataTables CSS -->
	<link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">
	
	<!-- Swal -->
	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<!-- Custom CSS -->
	<link href="../assets.3.6.2/dist/css/sb-admin-2.css" rel="stylesheet">
	
	<!-- Custom Fonts -->
	<link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	  <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header"> 
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <?php echo $_SESSION["rotulos_colegio"]; ?>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario de Perfil de Usuarios</a></li>
                        <li class="divider"></li>
                        <li><a href="../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-question-sign fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="glyphicon glyphicon-question-sign fa-fw"></i> Ayuda</a></li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
        </nav>
        <div id="">
            <br>
        <div class="panel panel-default">
        	<div class="panel-heading">
        		<i class="fa fa-edit"></i> Calificar Examen del Alumno <?php echo $alu_nombre." ".$alu_apellido; ?>
        	<div class="pull-right" style= "margin-left:5px;">
            <div class="btn-group">
                <button type="button" href="javascript:void(0)" onclick="window.close();" class="btn btn-primary btn-xs"> <span class="fa fa-times"></span> </button>
            </div>
        </div>
        		
        	</div>
        	<div class="panel-body col-xs-8">
        		<div class="row">
        			<div class="col-xs-10 col-xs-offset-1">
        				<?php echo tabla_archivos_respuesta($examen,$alumno); ?>
        			</div>
        		</div>
        	</div>
        	<div class="panel-body col-xs-4">
        		<div class="row">
        		    <br>
        			<div class="col-xs-10 ">
        			    <br>
        				<label>T&iacute;tulo: </label>
			        	<span class="form-info"><?php echo $titulo; ?></span>
        			</div>
        			<div class="col-xs-10">
        			    <br>
        				<label>Nota: </label>
            				<input type = "text" class = "form-control" name = "nota" id = "nota"  value = "<?php echo $nota; ?>" onkeyup="decimales(this)" onblur = "ValidaMaximoPunteo(this.value);" />
            				<input type = "hidden" name = "examen" id = "examen" value = "<?php echo $examen; ?>" />
            				<input type = "hidden" name = "alumno" id = "alumno" value = "<?php echo $alumno; ?>" />
            				<input type = "hidden" name = "maximo" id = "maximo" value = "<?php echo $maximo; ?>" />
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-xs-10 ">
        			    <br>
        				<label>Ponderaci&oacute;n M&aacute;xima: </label>
				        <span class="form-info"><?php echo $maximo; ?> Punto(s). / <?php echo $tipocalifica; ?></span>
        			</div>
        			<div class="col-xs-10 ">
        			    <br>
        				<label>Situaci&oacute;n: </label>
			        	<span class="form-control"><?php echo $situacion_desc; ?></span>
        			</div>
        		</div>
        		<div class="row">
        			<div class="col-xs-10 ">
        			    <br>
        				<label>Descripci&oacute;n: </label> <br>
			        	<span class="text-info"><?php echo $desc; ?></span>
        			</div>
        		</div>
        		<hr>
        		<div class="row">
        			<div class="col-xs-12">
        				<label>Observaciones:  <small class = "text-muted">(Opcional)</small></label>
			        	<textarea class="form-control" id = "obs" name = "obs" rows="5" onkeyup="textoLargo(this)" ><?php echo $obs; ?></textarea>
				    </div>
        		</div>
        		<div class="row">
        			<div class="col-xs-12 text-center">
        				<button type="button" class="btn btn-primary" id = "limp" onclick = "GrabarCalificacion(<?php echo $fila; ?>);"> <span class="fa fa-check"></span> Aceptar </button>
        			</div>
        		</div>
        		<br>
        	</div>
        </div>
			<!-- /.panel-default -->		<br>
		</div>
        <!-- /#page-wrapper -->
        <!-- //////////////////////////////// -->
        <!-- .footer -->

    </div>
    <!-- /#wrapper -->
    
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title text-left" id="myModalLabel"><img src = "../../CONFIG/images/escudo.png" width = "40px;" /> ASMS</h4>
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

    
    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/academico/examen.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
    <!-- Latest compiled and minified CSS for Bootstrap -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<!-- Latest compiled and minified JS for JQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<!-- Latest compiled and minified JS for Bootstrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
        $(document).ready(function(){
          // Listen with the jQuery to the tabs click:
          $('#myTabs a').click(function (link) {
            //console.log(link.currentTarget.innerText);
          })
        })
		
    </script>	
    
</body>

</html>
<?php

function tabla_archivos_respuesta($examen,$alumno){
	$ClsExa = new ClsExamen();
	$result = $ClsExa->get_resolucion_examen_archivo('',$examen,$alumno,'');
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
		$salida.= '<i class = "fa fa-warning"></i> No se registran archivos adjuntos en este Examen...';
		$salida.= '</h5>';
	}
	return $salida;
}


?>