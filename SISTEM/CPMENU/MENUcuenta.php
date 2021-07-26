<?php
  include_once('../html_fns.php');
  $nombre = $_SESSION["nombre"];
  $tipo = $_SESSION["nivel"];
  $id = $_SESSION["codigo"];
   
if ($tipo != "" && $nombre != "") {
    ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <title><?php echo $_SESSION["nombre_colegio"]; ?></title>
      <link rel="shortcut icon" href="../../CONFIG/images/logo.png">
      <!-- Bootstrap -->
      <link href="../assets.3.6.2/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
      
      <!-- Custom Fonts -->
      <link href="../assets.3.6.2/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
      
      <!-- Estilos Utilitarios -->
      <link href="../assets.3.6.2/css/menu.css" rel="stylesheet">
      
      <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
      <![endif]-->
   </head>
   <body>

	<div class="container">
      
      <!-- Static navbar -->
      <nav class="navbar navbar-default navbar-fixed-top">
         <div class="container-fluid">
            <div class="navbar-header">
               <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                 <span class="sr-only"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
               </button>
               <a class="navbar-brand" href="#"><img src = "../../CONFIG/images/logo_white.png" width = "30px"></a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
               <ul class="nav navbar-nav">
                  <li><a href="../menu.php"><span class="fa fa-arrow-left"></span> Regresar</a></li>
                  <li>&nbsp;</li>
                  <?php if ($_SESSION["GRP_GPCONTA"] == 1) { ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-tasks"></i> Programador de Boletas<span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                     <?php if ($_SESSION["NEWCUOTAS"] == 1) { ?>
                       <li><a href="../CPPFISCAL/FRMperiodo.php"><span class="fa fa-calendar-o" aria-hidden="true"></span> Periodo Fiscal</a></li>
                       <hr>
                     <?php } ?>
                     <?php if ($_SESSION["PAGOSPROG"] == 1) { ?>
                        <li><a href="../CPBOLETAPROGRAMADOR/FRMnewconfiguracion.php"><i class="fa fa-cogs"></i> <i class="fa fa-dollar"></i> Configuraciones de Pagos Programados</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["PROGBOLP"] == 1) { ?>
                        <li><a href="../CPBOLETAPROGRAMADOR/FRMsecciones.php"><i class="fa fa-calendar"></i> <i class="fa fa-dollar"></i> Programador de Boletas de Pagos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["PROGBOLPI"] == 1) { ?>
                        <li><a href="../CPBOLETAPROGRAMADOR/FRMlista_inscripciones.php"><i class="fa fa-calendar"></i> <i class="fa fa-certificate"></i> Programador de Boletas de Pagos por Inscripciones</a></li>
                     <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if ($_SESSION["GRP_GPCONTA"] == 1) { ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-money"></i> Boletas de Pago<span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                     <?php if ($_SESSION["GESBOLP"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMsecciones.php?acc=GBOL"><i class="fa fa-edit"></i> <i class="fa fa-dollar"></i> Gestor de Boletas de Pagos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["BUSBOLP"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMbusca_boleta.php"><i class="fa fa-search"></i> <i class="fa fa-dollar"></i> Buscar Boletas de Pagos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["VENBOLD"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMsecciones.php?acc=VENT"><i class="fa fa-shopping-cart"></i> <i class="fa fa-dollar"></i> Ventas con Boleta de Dep&oacute;sito</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["BOLEXT"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMsecciones.php?acc=BOLEXT"><i class="fa fa-file-text"></i> <i class="fa fa-dollar"></i> Gestor de Boletas de Extraordinarias</a></li>
                     <?php } ?>
                        <hr>
                     <?php if ($_SESSION["PAGOCUOTAS"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMsecciones.php?acc=GPAGO"><i class="fa fa-money"></i> <i class="fa fa-dollar"></i> Pagos de Boletas</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["BUSPAGEBOL"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMbusca_pago.php"><i class="fa fa-money"></i> <i class="fa fa-search"></i> Buscar Pagos Efectuados de Boletas</a></li>
                     <?php } ?>
                        <hr>
                     <?php if ($_SESSION["EJECUCIONM"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMmora.php"><i class="fa fa-clock-o"></i> <i class="fa fa-times"></i> Ejecuci&oacute;n de Moras</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["GESMOR"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMmoras.php"><i class="fa fa-clock-o"></i> <i class="fa fa-pencil"></i> Gestor de Moras</a></li>
                     <?php } ?>
                        <hr>
                     <?php if ($_SESSION["ESTADOCUEN"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMsecciones.php?acc=CUE"><i class="fa fa-file-text-o"></i> <i class="fa fa-print"></i> Estados de Cuenta</a></li>
                     <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if ($_SESSION["GRP_GPCONTA"] == 1) { ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-money"></i> Cargas Electr&oacute;nicas y Facturaci&oacute;n<span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                     <?php if ($_SESSION["CARGAELECTRO"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMcarga.php"><i class="fa fa-cloud-upload"></i> <i class="fa fa-table"></i> Cargas Elect&oacute;nicas</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["HISCARG"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMhistorial_cargas.php"><i class="fa fa-history"></i> <i class="fa fa-table"></i> Historial de Cargas</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["HISARCHSV"] == 1) { ?>
                        <li><a href="../CPBOLETA/FRMhistorial_csv.php"><i class="fa fa-history"></i> <i class="fa fa-file-excel-o"></i> Historial de Archivos .CSV</a></li>
                     <?php } ?>
                        <hr>
                     <?php if ($_SESSION["FACRECBOLPCE"] == 1) { ?>
                        <li><a href="../CPBOLETAFACTURAS/FRMlist_cargas.php"><i class="fa fa-file-text-o"></i> <i class="fa fa-table"></i> Facturas y Recibos de Boletas de Pago por Cargas Electr&oacute;nicas</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["FACRECBOLPI"] == 1) { ?>
                        <li><a href="../CPBOLETAFACTURAS/FRMlist_cargas.php"><i class="fa fa-file-text-o"></i> <i class="fa fa-money"></i> Facturas y Recibos de Boletas de Pago Individuales</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["FACPAGALUM"] == 1) { ?>
                        <li><a href="../CPBOLETAFACTURAS/FRMsecciones.php?acc=FAC"><i class="fa fa-file-text-o text-info"></i> <i class="fa fa-group"></i> Facturar Pagos por Alumnos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["GENRECPAGALUM"] == 1) { ?>
                        <li><a href="../CPBOLETAFACTURAS/FRMsecciones.php?acc=REC"><i class="fa fa-file-text-o"></i> <i class="fa fa-group"></i> Generar Recibos de Pagos por Alumnos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["GENRECPAGALUM"] == 1) { ?>
                        <li><a href="../CPBOLETAFACTURAS/FRMsecciones.php?acc=RECFACGENE"><i class="fa fa-file-text-o"></i> <i class="fa fa-group"></i> Facturas y recibos generados</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["BUSFAC"] == 1) { ?>
                        <li><a href="../CPBOLETAFACTURAS/FRMbusca_factura.php"><i class="fa fa-file-text-o text-info"></i> <i class="fa fa-search"></i> Buscar Facturas</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["BUSREC"] == 1) { ?>
                        <li><a href="../CPBOLETAFACTURAS/FRMbusca_recibo.php"><i class="fa fa-file-text-o"></i> <i class="fa fa-search"></i> Buscar Recibos</a></li>
                     <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if ($_SESSION["GRP_GPCONTA"] == 1) { ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-print"></i> Reportes<span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                        <?php if ($_SESSION["REPBOL"] == 1) {  ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMlistboletas.php"><i class="fa fa-file-text-o"></i> <i class="fa fa-print"></i> Reportes de Boletas</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPPAG"] == 1) {  ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMlistpagos.php"><i class="fa fa-file-text-o"></i> <i class="fa fa-print"></i> Reportes de Pagos</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPCARGE"] == 1) { ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMlistcarga.php"><i class="fa fa-table"></i> <i class="fa fa-print"></i> Reporte de Cargas Elect&oacute;nicas</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPCARGOS"] == 1) { ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMcargos.php"><i class="fa fa-plus"></i> <i class="fa fa-dollar"></i> Reporte de Cargos</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPDESC"] == 1) { ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMdescuentos.php"><i class="fa fa-minus"></i> <i class="fa fa-dollar"></i> Reporte de Descuentos</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPINGRE"] == 1) { ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMingresos.php"><i class="fa fa-dollar"></i> <i class="fa fa-dollar"></i> Reporte de Ingresos</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPCARTERA"] == 1) { ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMcartera.php"><i class="fa fa-folder-open"></i> <i class="fa fa-dollar"></i> Reporte de Cartera</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPVENBOL"] == 1) { ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMventas.php"><i class="fa fa-shopping-cart"></i> <i class="fa fa-print"></i> Reporte de Ventas con Boleta</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPSALDOS"] == 1) { ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMmorosos.php"><i class="fa fa-ban"></i> <i class="fa fa-dollar"></i> Reporte de Saldos</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPSOLVENTES"] == 1) { ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMsolventes.php"><i class="fa fa-check-square-o"></i> <i class="fa fa-dollar"></i> Reporte de Solventes</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPANTISALDOS"] == 1) { ?>
                           <li><a href="../CPBOLETA/CPREPORTES/FRMantiguedad.php"><i class="fa fa-calendar"></i> <i class="fa fa-dollar"></i> Reporte de Antiguedad de Saldos</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["IMPETIQSOB"] == 1) { ?>
                        <li><a href="../../CONFIG/FACTURAS/REPetiquetas.php" target="_blank"><i class="fa fa-print"></i> <i class="fa fa-envelope"></i> Impresi&oacute;n de Etiquetas para Sobres</a></li>
                        <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
               </ul>
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="../logout.php"><span class="glyphicon glyphicon-off"></span></a></li>
               </ul>
            </div><!--/.nav-collapse -->
         </div><!--/.container-fluid -->
      </nav>
      <?php
         $ClsAlu = new ClsAlumno();
         $ClsMae = new ClsMaestro();
         $ClsOtro = new ClsOtrosUsu();
         
         $alumnos = $ClsAlu->count_alumno("");
         $maestros = $ClsMae->count_maestro("");
         $otros = $ClsOtro->count_otros_usuarios("");
      ?>
      <!-- Main component for a primary marketing message or call to action -->
	   <div id = "contenedor" class="jumbotron">
         <!--================================================== /.navbar ===========================================================-->
         <!--===============================================================================================================================================-->
         <!--========================================================START WORK AREA========================================================================-->
         <!--===============================================================================================================================================-->
			<div class="text-center" >
				<h2 class='text-primary'>M&oacute;dulo de Cuenta Corriente</h2>
				<p class="lead">
					<?php
                  $nombre = $_SESSION["nombre"];
                  echo $nombre;
               ?>
				</p>
				<div>
					<br><br>
					<img src = "../../CONFIG/images/escudo.png" width='20%' >
					<br><br>
				</div>
				<br>
				<small class='text-primary'>
					Powered by ID Web Development Team.
               Copyright &copy; <?php echo date("Y"); ?>
				</small>
				<br>
				<small class='text-primary'>
					Versi&oacute;n 3.6.2
				</small>
			</div>
         <!--===============================================================================================================================================-->
         <!--======================================================END WORK AREA============================================================================-->
         <!--===============================================================================================================================================-->
         <br>
	   </div>
	</div>
   <!-- /container -->

   <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <script src="../assets.3.6.2/bower_components/jquery/dist/jquery.min.js"></script>
   <!-- Include all compiled plugins (below), or include individual files as needed -->
   <script src="../assets.3.6.2/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
   
   <!-- Custom Theme JavaScript -->
   <script type="text/javascript" src="../assets.3.6.2/js/menu.js"></script>
   <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>

   </body>
</html>
<?php
   } else {
      echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
      echo "<script>document.f1.submit();</script>";
      echo "</form>";
   }
?>
