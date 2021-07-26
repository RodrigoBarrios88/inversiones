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
                  <li><a href="../menu.php"><span class="fa fa-arrow-left" aria-hidden="true"></span> Regresar</a></li>
                  <li>&nbsp;</li>
                  <?php if ($_SESSION["GRP_GPCONTA"] == 1) { ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-money" aria-hidden="true"></span> Ventas<span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                        <?php if ($_SESSION["GCLIENTE"] == 1) { ?>
                           <li><a href="../CPCLIENTE/FRMclientes.php"><span class="fa fa-users" aria-hidden="true"></span> Clientes</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["REPCLIENTE"] == 1) { ?>
                           <li><a href="../CPCLIENTE/CPREPORTES/FRMreplistado.php"><span class="fa fa-print" aria-hidden="true"></span> Reporte de Clientes</a></li>
                        <?php } ?>
                        <hr>
                        <?php if ($_SESSION["VENTA"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMventas.php"><span class="fa fa-dollar" aria-hidden="true"></span> Ventas</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["VENTHIST"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMhistorial.php"><span class="fa fa-history" aria-hidden="true"></span> Historial de Ventas (Otros Ingresos)</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["VENTPAG"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMpago.php"><span class="fa fa-money" aria-hidden="true"></span> Pagos  (Otros Ingresos)</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["CXCOB"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMcreditos.php"><span class="fa fa-files-o" aria-hidden="true"></span> Cuentas por Cobrar (Cr&eacute;ditos de Otros Ingresos)</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["CXCOB"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMcuentaxcob.php"><span class="fa fa-credit-card" aria-hidden="true"></span> Ejecuci&oacute;n de Tarjetas y Cheques (Otros Ingresos)</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["CXCOB"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMfacturarventas.php"><span class="fa fa-file-o" aria-hidden="true"></span> Facturar Ventas Anteriores (Otros Ingresos)</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["VENTA"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMnotacredito.php"><span class="fa fa-file-text-o" aria-hidden="true"></span> Nota de Cr&eacute;dito a Clientes</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["VENTA"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMdiario.php"><span class="fa fa-calendar" aria-hidden="true"></span> Reporte Diario de Ventas  (Otros Ingresos)</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["VENTA"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMreglones.php"><span class="fa fa-suitcase" aria-hidden="true"></span> Reporte de Ventas por Reglones  (Otros Ingresos)</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["CXCOB"] == 1) { ?>
                           <li><a href="../CPVENTAS/FRMprintcopy.php"><span class="fa fa-print" aria-hidden="true"></span> Reimpresi&oacute;n de Facturas (Otros Ingresos)</a></li>
                        <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if ($_SESSION["GRP_GPCONTA"] == 1) { ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-usd" aria-hidden="true"></span> Compras y Gastos <span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                        <?php if ($_SESSION["GPROV"] == 1) { ?>
                           <li><a href="../CPPROVEEDOR/FRMproveedores.php"><span class="fa fa-users" aria-hidden="true"></span> Proveedores</a></li>
                        <?php } ?>
                        <hr>
                        <?php if ($_SESSION["COMPRA"] == 1) { ?>
                           <li><a href="../CPCOMPRA/FRMcompra.php"><span class="fa fa-dollar" aria-hidden="true"></span> Compras</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["GASTO"] == 1) { ?>
                           <li><a href="../CPCOMPRA/FRMgasto.php"><span class="fa fa-dollar" aria-hidden="true"></span> Gastos</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["COMPHIST"] == 1) { ?>
                           <li><a href="../CPCOMPRA/FRMhistorial.php"><span class="fa fa-history" aria-hidden="true"></span> Historial de Compras y Gastos</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["COMPPAG"] == 1) { ?>
                           <li><a href="../CPCOMPRA/FRMpago.php"><span class="fa fa-money" aria-hidden="true"></span> Pagos</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["CXPAG"] == 1) { ?>
                           <li><a href="../CPCOMPRA/FRMcreditos.php"><span class="fa fa-files-o" aria-hidden="true"></span> Cr&eacute;ditos por Pagar</a></li>
                        <?php } ?>
                        <?php if ($_SESSION["CXPAG"] == 1) { ?>
                           <li><a href="../CPCOMPRA/FRMporpagar.php"><span class="fa fa-credit-card" aria-hidden="true"></span> Cuentas por Pagar</a></li>
                        <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if ($_SESSION["GRP_GPCONTA"] == 1) { ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-archive" aria-hidden="true"></span> Bodegas e Inventarios <span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                     <?php if ($_SESSION["GSERV"] == 1) { ?>
                        <li><a href="../CPSERVICIOS/FRMservicios.php"><span class="fa fa-mortar-board " aria-hidden="true"></span> Gestor de Servicios y Colegiaturas</a></li>
                     <?php } ?>
                     <hr>
                     <?php if ($_SESSION["GART"] == 1) { ?>
                        <li><a href="../CPARTICULOS/FRMarticulos.php"><span class="fa fa-puzzle-piece" aria-hidden="true"></span> Gestor de Art&iacute;culos para Venta</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["INVRCAR"] == 1) { ?>
                        <li><a href="../CPINVENTARIO/FRMcarga.php"><span class="fa fa-sign-in" aria-hidden="true"></span> Carga a Inventario de Art&iacute;culos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["INVRDESC"] == 1) { ?>
                        <li><a href="../CPINVENTARIO/FRMdescarga.php"><span class="fa fa-sign-out" aria-hidden="true"></span> Descarga a Inventario de Art&iacute;culos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["INVHIST"] == 1) { ?>
                        <li><a href="../CPINVENTARIO/FRMhistorial.php"><span class="fa fa-history" aria-hidden="true"></span> Historial a Inventario de Art&iacute;culos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["KARDEX"] == 1) { ?>
                        <li><a href="../CPINVENTARIO/FRMkardex.php"><span class="fa fa-list-alt" aria-hidden="true"></span> Kardex</a></li>
                     <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if ($_SESSION["GRP_GPCONTA"] == 1) { ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-dollar" aria-hidden="true"></span> Financiero <span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                     <?php if ($_SESSION["NEWCUOTAS"] == 1) { ?>
                       <li><a href="../CPPFISCAL/FRMperiodo.php"><span class="fa fa-calendar-o" aria-hidden="true"></span> Periodo Fiscal</a></li>
                       <hr>
                     <?php } ?>
                     <?php if ($_SESSION["CIERRE"] == 1) { ?>
                        <li><a href="../CPCIERRE/FRMcierre.php"><span class="fa fa-tasks" aria-hidden="true"></span> Cierres Diarios</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["GCAJA"] == 1) { ?>
                        <li><a href="../CPCAJA/FRMcaja.php"><span class="fa fa-inbox" aria-hidden="true"></span> Cajas Monetarias</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["GPV"] == 1) { ?>
                       <li><a href="../CPPUNTOVENTA/FRMpv.php"><span class="fa fa-credit-card" aria-hidden="true"></span> POS (Puntos de Cobro o Venta)</a></li>
                       <hr>
                     <?php } ?>
                     <?php if ($_SESSION["GBANCO"] == 1) { ?>
                        <li><a href="../CPBANCO/FRMbanco.php"><span class="fa fa-bank" aria-hidden="true"></span> Bancos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["GCUEBANCO"] == 1) { ?>
                        <li><a href="../CPBANCO/FRMcuenta.php"><span class="fa fa-table" aria-hidden="true"></span> Cuentas Bancarias</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["NEWCHEQUE"] == 1) { ?>
                        <li><a href="../CPBANCO/FRMcheque.php"><span class="fa fa-suitcase" aria-hidden="true"></span> Cheques</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["CUECONCIL"] == 1) { ?>
                        <li><a href="../CPBANCO/FRMconcilia.php"><span class="fa fa-copy" aria-hidden="true"></span> Conciliaciones Bancarias</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["GBANCO"] == 1) { ?>
                        <hr>
                        <li><a href="../CPDIVISION/FRMgrupo.php"><span class="fa fa-th-large" aria-hidden="true"></span> Grupos de Boletas de Cobro</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["GCUEBANCO"] == 1) { ?>
                        <li><a href="../CPDIVISION/FRMdivision.php"><span class="fa fa-square" aria-hidden="true"></span> Divisiones de Boletas de Cobro</a></li>
                     <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  
                  <?php if ($_SESSION["GRP_GPCONTA"] == 1) { ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-money" aria-hidden="true"></span> Contable <span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                     <?php if ($_SESSION["CONTAPAR"] == 1) { ?>
                        <li><a href="../CPPOLIZA/FRMnewpoliza.php"><span class="fa fa-table" aria-hidden="true"></span> Polizas Contables</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["CONTAPAR"] == 1) { ?>
                        <li><a href="../CPCONTA/FRMpartida.php"><span class="fa fa-suitcase" aria-hidden="true"></span> Partidas y Reglones Contables</a></li>
                     <?php } ?>
                     <hr>
                     <?php if ($_SESSION["LIBVENTA"] == 1) { ?>
                        <li><a href="../CPCONTA/FRMlibroventas.php"><span class="fa fa-book" aria-hidden="true"></span> Libros de Ventas</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["LIBCOMPRA"] == 1) { ?>
                        <li><a href="../CPCONTA/FRMlibrocompras.php"><span class="fa fa-book" aria-hidden="true"></span> Libros de Compras y Gastos</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["LIBINV"] == 1) { ?>
                        <li><a href="../CPCONTA/FRMlibroinventario.php"><span class="fa fa-book" aria-hidden="true"></span> Libros de Inventario</a></li>
                     <?php } ?>
                     <?php if ($_SESSION["LIBBALANCE"] == 1) { ?>
                        <!--li><a href="../CPCONTA/FRMbalance.php"><span class="fa fa-book" aria-hidden="true"></span> Balance General</a></li-->
                    <?php } ?>
                     <?php if ($_SESSION["LIBRESULTADOS"] == 1) { ?>
                        <!--li><a href="../CPCONTA/FRMresultados.php"><span class="fa fa-book" aria-hidden="true"></span> Estado de Resultados</a></li-->
                    <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
               </ul>
               
               <ul class="nav navbar-nav navbar-right">
                  <li><a href="../logout.php"><span class="glyphicon glyphicon-off" aria-hidden="true"></span></a></li>
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
				<h2 class='text-primary'>M&oacute;dulo Contable y Financiero</h2>
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
	</div> <!-- /container -->

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
