<?php
	include_once('../../html_fns.php');
	$usuario = $_SESSION["codigo"];
	$nombre = $_SESSION["nombre"];
	$valida = $_SESSION["codigo"];
	$area = $_SESSION["area"];
	$tipo_usuario = $_SESSION['tipo_usuario'];
	$tipo_codigo = $_SESSION['tipo_codigo'];
	//$_POST
	$area = $_REQUEST["area"];
	$segmento = $_REQUEST["segmento"];
	$grupo = $_REQUEST["grupo"];
if($usuario != "" && $nombre != "" && $valida != ""){	
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
    
	<!-- Libreria de Calendarios -->
	<link type="text/css" rel="stylesheet" href ="../../ $('.dataTables-example').DataTable({dhtmlgoodies_calendar.css">
	<script type="text/javascript" src="../../assets.3.6.2/js/dhtmlgoodies_calendar.js"></script>	
    
    <!-- Bootstrap Core CSS -->
    <link href="../../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

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
	
	<!-- Sweet Alert -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

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
                <?php echo $_SESSION["rotulos_colegio_subpantalla"]; ?>
            </div>
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right">
               <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li><a href="#"><i class="glyphicon glyphicon-user fa-fw"></i> Formulario Gestor de Usuarios</a></li>
                        <li class="divider"></li>
                        <li><a href="../../logout.php"><i class="glyphicon glyphicon-off fa-fw"></i> Salir</a>
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
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<i class="glyphicon arrow"></i></a> 
							<ul class="nav nav-second-level">
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMnewalumno.php">
										<i class="fa fa-plus-circle"></i> Agregar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=1">
										<i class="fa fa-edit"></i> Actualizar Datos de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=4">
										<i class="fa fa-list-alt"></i> Ficha T&eacute;cnica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../../CPFICHAPRESCOOL/FRMsecciones.php">
										<i class="fa fa-file-text-o"></i> Ficha Preescolar
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=5">
										<i class="fa fa-comments"></i> Bit&aacute;cora Psicopedag&oacute;gica
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=3">
										<i class="fa fa-camera"></i> Re-Ingreso de Fotograf&iacute;as
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=2">
										<i class="fa fa-group"></i> Asignaci&oacute;n Extracurricular
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=6">
										<i class="fa fa-ban"></i> Inhabilitar Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 2 || $tipo_usuario == 5){ ?>
								<li>
									<a href="../FRMsecciones.php?acc=7">
										<i class="fa fa-check-circle-o"></i> Activar Alumnos
									</a>
								</li>
								<?php } ?>
								<hr>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMreplistado.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 1 || $tipo_usuario == 5){ ?>
								<li>
									<a href="FRMrepasiggrupo.php">
										<i class="glyphicon glyphicon-print"></i> Reporte de Alumnos/Grupos
									</a>
								</li>
								<?php } ?>
								<hr>
								<li>
									<a href="../../menu.php">
										<i class="glyphicon glyphicon-list"></i> Men&uacute; Principal
									</a>
								</li>
							</ul>
							<!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

		<div id="page-wrapper">
			<br>
			<div class="panel panel-default">
				<div class="panel-heading"> 
					<span class="glyphicon glyphicon-print" aria-hidden="true"></span>
					Asignaci&oacute;n de Grupos (Listado de Alumnos)
				</div>
				<div class="panel-body">
				<form name = "f1" id = "f1" method="get">
					<div class="row">
						<div class="col-xs-11 col-xs-11 text-right text-info">* Criterios de Busqueda</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>&Aacute;rea: </label> <span class="text-info">*</span>
							<?php echo Area_html("area","Submit();"); ?>
							<?php if($area != ""){ ?>
								<script type = "text/javascript">
									document.getElementById("area").value = '<?php echo $area; ?>';
								</script>
							<?php } ?>
						</div>
						<div class="col-xs-5">
							<label>Segmento: </label> <span class="text-info">*</span>
							<?php
								if($area != ""){
									echo Segmento_html('segmento',$area,'Submit();');
								}else{
									echo combos_vacios('segmento');
								}
							?>
							<?php if($area != ""){ ?>
								<script type = "text/javascript">
									document.getElementById("segmento").value = '<?php echo $segmento; ?>';
								</script>
							<?php } ?>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-5 col-xs-offset-1">
							<label>Grupo: </label> <span class="text-info">*</span>
							<?php
								if($area != "" && $segmento){
									echo Grupos_Clase_html("grupo",$area,$segmento,"");
								}else{
									echo combos_vacios('grupo');
								}
							?>
							<?php if($area != "" && $segmento){ ?>
								<script type = "text/javascript">
									document.getElementById("grupo").value = '<?php echo $grupo; ?>';
								</script>
							<?php } ?>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-xs-12 text-center">
							<a class="btn btn-default" href = "FRMrepasiggrupo.php"><span class="fa fa-eraser"></span> Limpiar</a>
							<button type="button" class="btn btn-primary" id = "busc" onclick = "Reporte();"><span class="fa fa-search"></span> Buscar</button>
							<!--button type="button" class="btn btn-success" id = "excel" onclick = "Excel();"><span class="fa fa-file-excel-o"></span> Excel</button-->
						</div>
					</div>
				</form>
				</div>
			</div>
			<br>
			<div class="row">
				<div class="col-lg-12" id = "result">
					
				</div>
			</div>
			
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    
    <!-- //////////////////////////////////////////////////////// -->
    <!-- Modal -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	  <div id = "ModalDialog" class="modal-dialog">
	    <div class="modal-content">
	      <div class="modal-header">
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../../CONFIG/images/logo.png" width = "60px;" /></h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../../../CONFIG/images/img-loader.gif"/><br>
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
    
    <!-- jQuery -->
    <script src="../../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="../../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/modules/app/alumno.js"></script>
    <script type="text/javascript" src="../../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		function Reporte(){
			area = document.getElementById("area");
			segmento = document.getElementById("segmento");
			grupo = document.getElementById("grupo");
			if(area.value !=="" && segmento.value !=="" && grupo.value !== ""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="REPasiggrupo.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(area.value ===""){
					area.className = "form-info";
				}else{
					area.className = "form-control";
				}
				if(segmento.value ===""){
					segmento.className = "form-info";
				}else{
					segmento.className = "form-control";
				}
				if(grupo.value ===""){
					grupo.className = "form-info";
				}else{
					grupo.className = "form-control";
				}
				swal("Ohoo!", "Debe llenar los campos obligatorios...", "info");
			}
		}
		
		function Excel(){
			area = document.getElementById("area");
			segmento = document.getElementById("segmento");
			grupo = document.getElementById("grupo");
			if(area.value !=="" && segmento.value !=="" && grupo.value !== ""){
				myform = document.forms.f1;
				myform.target ="_blank";
				myform.action ="EXCELasiggrupo.php";
				myform.submit();
				myform.action ="";
				myform.target ="";
			}else{
				if(area.value ===""){
					area.className = "form-info";
				}else{
					area.className = "form-control";
				}
				if(segmento.value ===""){
					segmento.className = "form-info";
				}else{
					segmento.className = "form-control";
				}
				if(grupo.value ===""){
					grupo.className = "form-info";
				}else{
					grupo.className = "form-control";
				}
				swal("Ohoo!", "Debe llenar los campos obligatorios...", "info");
			}
		}
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