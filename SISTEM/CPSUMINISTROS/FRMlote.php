<?php
	include_once('xajax_funct_articulos.php');
	$nombre = $_SESSION["nombre"];
	$pensum = $_SESSION["pensum"];
	$valida = $_SESSION["GRP_GPADMON"];
	//$_POST
	$gru = $_REQUEST["gru"];
	$art = $_REQUEST["art"];
	$suc = $_REQUEST["suc"];
	
if($pensum != "" && $nombre != "" && $valida != ""){	
?>
<!DOCTYPE html>
<html lang="es">
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
    
    <!-- Bootstrap Core CSS -->
    <link href="../assets.3.6.2/css/formulario.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../assets.3.6.2/bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
   <link href="../assets.3.6.2/css/plugins/dataTables/datatables.min.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    

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
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                       <li>
                            <a href="#"><i class="glyphicon glyphicon-list"></i> Men&uacute;<span class="glyphicon arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <?php if($_SESSION["GGRUPARTS"] == 1){ ?>
								<li>
									<a href="FRMgrupos.php">
									<i class="fa fa-th"></i> Gestor de Grupos
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["GARTS"] == 1){ ?>
								<li>
									<a href="FRMarticulos.php">
									<i class="fa fa-puzzle-piece"></i> Gestor de Art&iacute;culos
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["LOTMODS"] == 1){ ?>
								<li>
									<a href="FRMlote.php">
									<i class="fa fa-edit"></i> Actualizaci&oacute;n de Lotes
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["ARTPRECS"] == 1){ ?>
								<li>
									<a href="FRMartprecio.php">
									<i class="fa fa-dollar"></i> Actualizaci&oacute;n de Precios
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["GARTS"] == 1){ ?>
								<li>
									<a href="CPREPORTES/FRMrepbarcod.php">
									<i class="fa fa-barcode"></i> Codigos de Barras
									</a>
                                </li>
                                <?php } ?>
								<hr>
								<?php if($_SESSION["INVRCARS"] == 1){ ?>
								<li>
									<a href="../CPINVENTARIOSUMINISTRO/FRMcarga.php">
									<i class="fa fa-sign-in"></i> Carga a Inventario
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["INVRDESCS"] == 1){ ?>
								<li>
									<a href="../CPINVENTARIOSUMINISTRO/FRMdescarga.php">
									<i class="fa fa-sign-out"></i> Descarga a Inventario
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["INVHISTS"] == 1){ ?>
								<li>
									<a href="../CPINVENTARIOSUMINISTRO/FRMhistorial.php">
									<i class="fa fa-history"></i> Historial a Inventario
									</a>
                                </li>
                                <?php } ?>
								<?php if($_SESSION["KARDEXS"] == 1){ ?>
								<li>
									<a href="../CPINVENTARIOSUMINISTRO/FRMkardex.php">
									<i class="fa fa-list-alt"></i> Kardex de Inventario
									</a>
                                </li>
                                <?php } ?>
								<hr>
								<li>
                                    <a href="../CPMENU/MENUadministrativo.php">
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
            <div id = "cuerpo" class="panel panel-default">
				<div class="panel-heading"><i class="fa fa-edit"></i> <label>Modificar Datos del Lote</label></div>
                    <div class="panel-body">
					<form id='f1' name='f1' method='get'>
						<div class="row">
							<div class="col-xs-12 col-xs-12 text-right"><label class = " text-danger">* Campos Obligatorios</label></div>
						</div>
                        <div class="row">
                            <div class="col-xs-3 text-right"><label>Empresa: </label> <label class = " text-info">*</label><label class = " text-danger">*</label></div>
                            <div class="col-xs-3 text-left">
								<?php echo empresa_html("suc","Buscar();"); ?>
								<input type = "hidden" name = "cod" id = "cod" />
								<script type="text/javascript">
									<?php 
										$suc = ($suc != "")?$suc:$_SESSION["empresa"];
									?>
									document.getElementById('suc').value = '<?php echo $suc; ?>';
								</script>
							</div>
                            <div class="col-xs-3 text-right"><label>Codigo Interno: </label><label class = " text-info">*</label> </div>
                            <div class="col-xs-3 text-left">
								<input id="barc" name="barc" class="form-control" type="text" onkeyup="texto(this);KeyEnter(this,Buscar);" />
							</div>
                        </div>
                        <div class="row">
                            <div class="col-xs-3 text-right"><label>Grupo: </label> <label class = " text-info">*</label><label class = " text-danger">*</label></div>
                            <div class="col-xs-3 text-left">
								<?php echo grupo_suministro_html("gru","Buscar();"); ?>
								<input type = "hidden" name = "cod" id = "cod" />
							</div>
                            <div class="col-xs-3 text-right"><label>Art&iacute;culo: </label> <label class = " text-info">*</label><label class = " text-danger">*</label></div>
                            <div class="col-xs-3 text-left" id = "sart">
								<?php
									if($gru == ""){
										echo combos_vacios("art");
									}else{
										echo suministro_html($gru,"art","Buscar();");
									}
								?>
							</div>
							<script type="text/javascript">
								document.getElementById('gru').value = '<?php echo $gru; ?>';
								document.getElementById('art').value = '<?php echo $art; ?>';
							</script>
                        </div>
						<div class="row">
							<div class="col-xs-3 text-right"><label>Nit:</label> <label class = " text-info">*</label><span class = " text-danger">*</span></div>
							<div class="col-xs-3">
								<div class='input-group'>
									<input type="text" class="form-control" name = "nit" id = "nit" onkeyup = "texto(this);KeyEnter(this,Proveedor);" onblur = "Proveedor();"/>
									<input type = "hidden" name = "prov" id = "prov" />
									<span class="input-group-addon" style="cursor:pointer" onclick = "SearchProveedor();" >
										<span class="fa fa-search"></span>
									</span>
								</div>
							</div>
							<div class="col-xs-3 text-right"><label>Proveedor:</label> <span class = "text-danger">*</span><span class = " text-info">*</span></div>
							<div class="col-xs-3">
								<div class='input-group'>
									<input type="text" class="form-control" name = "nom" id = "nom" readonly />
									<span class="input-group-addon" style="cursor:pointer" onclick = "ResetProv();" >
										<span class="fa fa-refresh"></span>
									</span>
								</div>
							</div>
						</div>
                        <div class="row">
                            <div class="col-xs-3 text-right"><label>Precio de Compra: </label> <label class = " text-danger">*</label></div>
                            <div class="col-xs-3 text-left">
								<input type = "text" class="form-control" name = "prec" id = "prec" onkeyup = "decimales(this);" />
							</div>
                            <div class="col-xs-3 text-right"></div>
                            <div class="col-xs-3 text-left">
								<input type = "hidden" class="form-control" name = "prem" id = "prem" />
								<input type = "hidden" class="form-control" name = "prev" id = "prev" />
								<input type = "hidden" class="form-control" name = "marg" id = "marg" />
							</div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                <button type="button" class="btn btn-default" id = "limp" onclick = "Limpiar();"><span class="glyphicon glyphicon-erase"></span> Limpiar</button>
                                <button type="button" class="btn btn-primary" id = "mod" onclick = "Modificar();"><span class="glyphicon glyphicon-floppy-disk"></span> Grabar</button>
                            </div>
                        </div>
                    </form>
                    </div>
					<!-- /.panel-body -->
				<br>
				<div class="row">
					<div class="col-lg-12" id = "result">
						<?php
							if($gru != "" && $suc != ""){
								echo tabla_lotes($cod,$gru,$art,$barc,$suc,$prov);
							}
						?>
					</div>
				</div>
            </div>
             <!-- /.panel-default -->
	     <br>
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
			<h4 class="modal-title text-left" id="myModalLabel"><img src="../../CONFIG/images/logo.png" alt="logo" width="30px" /> &nbsp; <?php echo $_SESSION["nombre_colegio"]; ?> ASMS</h4>
	      </div>
	      <div class="modal-body text-center" id= "lblparrafo">
		<img src="../../CONFIG/images/img-loader.gif"/><br>
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
    <script src="../dist/js/sb-admin-2.js"></script>
    
    <!-- Custom Theme JavaScript -->
    <script type="text/javascript" src="../assets.3.6.2/js/core/ejecutaModal.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/modules/inventario/lotsumi.js"></script>
    <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
	
    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
		$(document).ready(function() {
			$('#dataTables-example').DataTable({
				pageLength: 50,
				responsive: true
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