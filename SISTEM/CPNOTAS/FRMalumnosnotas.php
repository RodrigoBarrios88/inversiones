<?php
    include_once('xajax_funct_notas.php');
    $usuario = $_SESSION["codigo"];
    $usunombre = $_SESSION["nombre"];
    $usunivel = $_SESSION["nivel"];
    $valida = $_SESSION["codigo"];
    $pensum = $_SESSION["pensum"];
    $tipo_usuario = $_SESSION['tipo_usuario'];
    $tipo_codigo = $_SESSION['tipo_codigo'];
    //$_POST
    $materia = $_REQUEST["materia"];
    $parcial = $_REQUEST["parcial"];
    $tipo = $_REQUEST["tipo"];
	$num = $_REQUEST["num"];
	$tipo = ($tipo == "")?"1":$tipo;
    //--- Configuraciones de impresión
	$materiarows = $_REQUEST["materiarows"];
	$notaminima = $_REQUEST["notaminima"];
	$notaminima = ($notaminima == "")?"65":$notaminima;
	$titulo = $_REQUEST["titulo"];
	$titulo = ($titulo == "")?"TARJETA DE CALIFICACIONES":$titulo;
	$font = $_REQUEST["font"];
	$font = ($font == "")?"6":$font;
	$anchocols = $_REQUEST["anchocols"];
	$anchocols = ($anchocols == "")?"18":$anchocols;
	$orientacion = $_REQUEST["orientacion"];
	$orientacion = ($orientacion == "")?"P":$orientacion;
	$papel = $_REQUEST["papel"];
	$papel = ($papel == "")?"Letter":$papel;
    
    $ClsAcadem = new ClsAcademico();
    $ClsPen = new ClsPensum();
    
    $hashkey1 = $_REQUEST["hashkey1"];
    $pensum = $ClsAcadem->decrypt($hashkey1, $usuario);
    $hashkey2 = $_REQUEST["hashkey2"];
    $nivel = $ClsAcadem->decrypt($hashkey2, $usuario);
    $hashkey3 = $_REQUEST["hashkey3"];
    $grado = $ClsAcadem->decrypt($hashkey3, $usuario);
    $hashkey4 = $_REQUEST["hashkey4"];
    $seccion = $ClsAcadem->decrypt($hashkey4, $usuario);
    
    
if($usunombre != "" && $valida != ""){  
?>
<!DOCTYPE html>
<html lang="en">
<head><meta charset="gb18030">
    
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
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

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
	
	<!-- Swal -->
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
                <?php echo $_SESSION["rotulos_colegio"]; ?>
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
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       <li class="active">
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                  <?php if($tipo_usuario == 5 || $tipo_usuario == 1 || $tipo_usuario == 2){ ?>
								<li>
									<a href="FRMlist_vernotas.php">
										<i class="fa fa-list-ol"></i> Ver Notas
									</a>
								</li>
								<?php } ?>
                                <?php if($tipo_usuario == 5 || $tipo_usuario == 1 || $tipo_usuario == 2){ ?>
								<li>
									<a href="FRMlist_sabana.php">
										<i class="fa fa-list-ol"></i> ver  Notas Sabana
									</a>
								</li>
								<?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 2){ ?>
								<li>
                                    <a href="FRMlist_asignotas.php">
									<i class="fa fa-save"></i> Ingreso de Notas
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMlist_certificanotas.php">
									<i class="fa fa-check-square-o"></i> Certificar  Notas
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMlist_editnotas.php">
									<i class="fa fa-edit"></i> Modificar de Notas
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
                                    <a href="FRMnominanotas.php">
									<i class="fa fa-file-text-o"></i> Nomina de Notas  por Grados
									</a>
                                </li>
                                <?php } ?>
								<?php if($tipo_usuario == 2 ||$tipo_usuario == 5 || $tipo_usuario == 1){ ?>
								<li>
                                    <a class="active" href="FRMlist_alumnosnotas.php">
									<i class="fa fa-file-text-o"></i> Tarjeta de Calificaciones
									</a>
                                </li>
                                <?php } ?>
								<hr>
                                <li>
                                    <a href="../CPMENU/MENUacademico.php">
                                    <i class="fa fa-indent"></i> Men&uacute
                                    </a>
                                </li>
                                <li>
                                    <a href="../menu.php">
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
            <form name = "f1" id = "f1" method="get">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading"> 
                            <span class="fa fa-paste" aria-hidden="true"></span>
                            Listado de Notas 
                        </div>
                        <div class="panel-body"> 
							<div class="row">
                                <div class="col-xs-5 col-xs-offset-1">
                                    <input type = "hidden" id="pensum" name = "pensum" value="<?php echo $pensum; ?>" />
                                    <input type = "hidden" id="nivel" name = "nivel" value="<?php echo $nivel; ?>" />
                                    <input type = "hidden" id="grado" name = "grado" value="<?php echo $grado; ?>" />
                                    <input type = "hidden" id="seccion" name = "seccion" value="<?php echo $seccion; ?>" />
                                    <input type = "hidden" id="maestro" name = "maestro" value="<?php echo $maestro; ?>" />
									<input type = "hidden" id="titulo" name = "titulo" value="BOLETA DE RENDIMIENTO ACADÉMICO" />
                                    <!-- -->
                                    <input type = "hidden" id="hashkey1" name = "hashkey1" value="<?php echo $hashkey1; ?>" />
                                    <input type = "hidden" id="hashkey2" name = "hashkey2" value="<?php echo $hashkey2; ?>" />
                                    <input type = "hidden" id="hashkey3" name = "hashkey3" value="<?php echo $hashkey3; ?>" />
                                    <input type = "hidden" id="hashkey4" name = "hashkey4" value="<?php echo $hashkey4; ?>" />
                                    <!-- -->
                                </div>
                            </div>
                                <br>
                                <div class="row">
                                    <div class="col-xs-5 col-xs-offset-1"><label>T&iacute;po Evaluaciones:</label></div>
                                    <div class="col-xs-5"><label>Numero de Unidad:</label></div>
                                </div>
                                <div class="row">
                                    <div class="row">
										<div class="col-xs-5 col-xs-offset-1">
											<select id = "tipo" name = "tipo" class = "form-control" onchange="Submit();">
												<option value = "">Selecciones</option>
												<option value = "1" selected >EVALUACION PARCIAL O DE UNIDAD</option>
												<option value = "3">EVALUACION FINAL</option>
											</select>
											<?php if($tipo != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("tipo").value = '<?php echo $tipo; ?>';
											</script>
											<?php } ?>
										</div>
										<div class="col-xs-5" >
											<?php echo unidades_html($nivel,'num',''); ?>
											<script type = "text/javascript">
												<?php if($num != ""){ ?>
                                                    document.getElementById("num").value = '<?php echo $num; ?>';
                                                <?php } ?>
                                                <?php if($tipo != 1){ ?>
                                                    document.getElementById("num").value = '';
                                                    document.getElementById("num").setAttribute("disabled","disabled");
                                                <?php } ?>
											</script>
										</div>
									</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-10 col-xs-offset-1"><hr></div>
                                </div>
								<div class="row">
                                    <div class="col-xs-3 col-xs-offset-1"><label>Tama&ntilde;o de Letra:</label></div>
                                    <div class="col-xs-3"><label>Ancho de Columnas (mm.):</label></div>
                                    <div class="col-xs-4"><label>Nota M&iacute;nima:</label></div>
                                </div>
									<div class="row">
										<div class="col-xs-3 col-xs-offset-1" id = "divseccion">
											<select id = "font" name = "font" class = "form-control">
												<option value = "">Selecciones</option>
												<option value = "6" selected >6</option>
												<option value = "8">8</option>
												<option value = "10">10</option>
												<option value = "12">12</option>
												<option value = "14">14</option>
											</select>
                                            <?php if($font != ""){ ?>
												<script type = "text/javascript">
													document.getElementById("font").value = '<?php echo $font; ?>';
												</script>
											<?php } ?>
										</div>
										<div class="col-xs-3">
											<input type="text" class="form-control" id ="anchocols" name="anchocols" value = "<?php echo $anchocols; ?>" onkeyup="enteros(this)" />
										</div>
										<div class="col-xs-4">
											<input type="text" class="form-control" id ="notaminima" name="notaminima" value = "<?php echo $notaminima; ?>" onkeyup="decimales(this)" />
										</div>
									</div>
                                <div class="row">
                                    <div class="col-xs-3 col-xs-offset-1"><label>Tipo de Papel:</label></div>
                                    <div class="col-xs-3"><label>Orientaci&oacute;n:</label></div>
									<div class="col-xs-3"><label>Cara o lado a imprimir:</label></div>
                                </div>
								<div class="row">
									<div class="col-xs-3 col-xs-offset-1" id = "divseccion">
										<select id = "papel" name = "papel" class = "form-control">
											<option value = "">Selecciones</option>
											<option value = "Letter" selected >CARTA</option>
											<option value = "Legal">OFICIO</option>
										</select>
                                        <?php if($papel != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("papel").value = '<?php echo $papel; ?>';
											</script>
										<?php } ?>
									</div>
									<div class="col-xs-3">
										<select id = "orientacion" name = "orientacion" class = "form-control">
											<option value = "">Selecciones</option>
											<option value = "L" >Horizontal</option>
											<option value = "P" selected >Vertical</option>
										</select>
                                        <?php if($orientacion != ""){ ?>
											<script type = "text/javascript">
												document.getElementById("orientacion").value = '<?php echo $orientacion; ?>';
											</script>
										<?php } ?>
									</div>
									<div class="col-xs-4 text-center">
										<label>Cara A</label>
										<input type = "checkbox" name = "caraA" id = "caraA" value = "A" checked= />
										&nbsp;&nbsp;
										<label>Cara B</label>
										<input type = "checkbox" name = "caraB" id = "caraB" value = "B" checked= />
									</div>
								</div>
								<hr>
								<div class="row">
									<div class="col-xs-12 text-center">
										<a class="btn btn-primary" onclick="Tarjeta_Notas_Masa(3);" title = "Desplegar Listado" ><span class="fa fa-file-text"></span> &nbsp; <strong>Revisar </strong></a> 
										<button class="btn btn-default" disabled>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</button> 
                                        <!--button class="btn btn-default" onclick="Tarjeta_Notas_Masa(3);" title = "Desplegar Listado" disabled ><span class="fa fa-file-excel-o text-success"></span> &nbsp; <strong class="text-success">Exportar</strong></button--> 
										<a class="btn btn-default" onclick="Tarjeta_Notas_Masa(1);" title = "Desplegar Listado" ><span class="fa fa-print text-primary"></span> &nbsp; <strong class="text-primary">Imprimir </strong></a> 
									</div>
								</div>
                            <hr>
							<div class="row">
                                <div class="col-lg-12" id = "result">
                                    <?php
                                        //echo "$pensum,$nivel,$grado,$seccion,$materia,$parcial";
                                        if($pensum != "" && $nivel != "" && $grado != "" && $seccion != ""){
                                            echo tabla_secciones_alumnos_hitorial_notas($pensum,$nivel,$grado,$seccion);
                                        }
                                    ?>
                                </div>
							</div>
						</div>
                    </div>
                </div>
            </div>      
            </form>
			<div>
				<form name = "f2" id = "f2" method="get" >
					<input type="hidden" name="pensum2" id="pensum2" />
					<input type="hidden" name="nivel2" id="nivel2" />
					<input type="hidden" name="grado2" id="grado2" />
					<input type="hidden" name="seccion2" id="seccion2" />
					<input type="hidden" name="tipo2" id="tipo2" />
					<input type="hidden" name="parcial2" id="parcial2" />
					<input type="hidden" name="font2" id="font2" />
					<input type="hidden" name="anchocols2" id="anchocols2" />
					<input type="hidden" name="papel2" id="papel2" />
					<input type="hidden" name="orientacion2" id="orientacion2" />
					<input type="hidden" name="titulo2" id="titulo2" />
					<input type="hidden" name="notaminima2" id="notaminima2" />
                    <input type="hidden" name="observaciones2" id="observaciones2" />
					<input type="hidden" name="cui2" id="cui2" />
					<input type="hidden" name="caraA2" id="caraA2" />
					<input type="hidden" name="caraB2" id="caraB2" />
				</form>	
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
    
    <!-- jQuery -->
    <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
    

    <!-- Custom Theme JavaScript -->
    <script src="../assets.3.6.2/dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/academico/notas.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
    
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 50,
				responsive: true,
			});
        });
    </script>   
    
</body>

</html>
<?php
}else{
    echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
    echo "<script>document.f1.submit();</script>";
    echo "</form>";
}
?>