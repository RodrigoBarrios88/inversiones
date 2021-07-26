<?php
   include_once('../html_fns.php');
   $nombre = $_SESSION["nombre"];
   $tipo = $_SESSION["nivel"];
   $id = $_SESSION["codigo"];
      
if($tipo != "" && $nombre != ""){ 	
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
		
		<!-- DataTables CSS -->
		<link href="../assets.3.6.2/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet">
	
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
                  <?php if($_SESSION["GRP_GPADMON"] == 1){ ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-users" aria-hidden="true"></span> RR.HH.<span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                        <?php if($_SESSION["NEWRRHH"] == 1){ ?>
                           <li><a href="../CPRRHH/FRMformulario.php"><span class="fa fa-user" aria-hidden="true"></span> Inscripci&oacute;n de Personal</a></li>
                        <?php } ?>
                        <?php if($_SESSION["UPDRRHH"] == 1){ ?>
                           <li><a href="../CPRRHH/FRMbuscar.php"><span class="fa fa-users" aria-hidden="true"></span> ISP <small>(Informaci&oacute;n Sobre Personal)</small></a></li>
                        <?php } ?>
                        <?php if($_SESSION["UPDRRHH"] == 1){ ?>
                           <li><a href="../CPRRHH/FRMlistplazas.php"><span class="fa fa-file-text-o" aria-hidden="true"></span> Tarjetas de Responsabilidad</a></li>
                        <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if($_SESSION["GRP_GPADMON"] == 1){ ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-building-o" aria-hidden="true"></span> Organizaci&oacute;n <span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                        <?php if($_SESSION["GSUC"] == 1){ ?>
                           <li><a href="../CPEMPRESA/FRMempresas.php"><span class="fa fa-building-o" aria-hidden="true"></span> Gestor Empresas</a></li>
                        <?php } ?>
                        <?php if($_SESSION["GDEPA"] == 1){ ?>
                           <li><a href="../CPDEPARTAMENTOS/FRMdepartamentos.php"><span class="fa fa-flag" aria-hidden="true"></span> Gestor Departamentos</a></li>
                        <?php } ?>
                        <?php if($_SESSION["GPLAZA"] == 1){ ?>
                           <li><a href="../CPORGANIZACION/FRMplazas.php"><span class="fa fa-flag" aria-hidden="true"></span> Gestor Plazas</a></li>
                        <?php } ?>
                        <?php if($_SESSION["ASIPLAZA"] == 1){ ?>
                           <li><a href="../CPORGANIZACION/FRMasigplaza.php"><span class="fa fa-history" aria-hidden="true"></span> Asignaci&oacute;n de Plazas</a></li>
                        <?php } ?>
                        <?php if($_SESSION["ASIPLAZA"] == 1){ ?>
                           <li><a href="../CPORGANIZACION/FRMbusca_organigrama.php"><span class="fa fa-sitemap" aria-hidden="true"></span> Organigrama</a></li>
                        <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if($_SESSION["GRP_GPADMON"] == 1){ ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-money" aria-hidden="true"></span> Sueldos<span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                        <?php if($_SESSION["PLANILLA"] == 1){ ?>
                           <li><a href="../CPSUELDOS/FRMtipo_nomina.php"><span class="fa fa-edit" aria-hidden="true"></span> Gestor de Tipo de Nominas</a></li>
                        <?php } ?>
                        <?php if($_SESSION["PLANILLA"] == 1){ ?>
                           <li><a href="../CPSUELDOS/FRMpersonal_planillas.php"><span class="fa fa-link" aria-hidden="true"></span> Asignaci&oacute;n de Personal a Listados de Tipo de Nominas</a></li>
                        <?php } ?>
                        <?php if($_SESSION["PLANILLA"] == 1){ ?>
                           <li><a href="../CPSUELDOS/FRMlist_personal_configuracion.php?acc=2"><span class="fa fa-money" aria-hidden="true"></span> Prestamos, Adelantos y Descuentos Regulares</a></li>
                        <?php } ?>
                        <?php if($_SESSION["PLANILLA"] == 1){ ?>
                           <li><a href="../CPSUELDOS/FRMlist_personal_configuracion.php?acc=1"><span class="fa fa-money" aria-hidden="true"></span> Bonificaciones y Comisiones Regulares</a></li>
                        <?php } ?>
                        <?php if($_SESSION["PLANILLA"] == 1){ ?>
                           <li><a href="../CPSUELDOS/FRMnewnomina.php"><span class="fa fa-folder-open" aria-hidden="true"></span> Apertura de Planillas </a></li>
                        <?php } ?>
                        <?php if($_SESSION["PLANILLA"] == 1){ ?>
                           <li><a href="../CPSUELDOS/FRMstatusnomina.php"><span class="fa fa-tasks" aria-hidden="true"></span> Status de Planilla</a></li>
                        <?php } ?>
                     </ul>
                  </li>
                  <?php } ?>
                  <?php if($_SESSION["GRP_GPADMON"] == 1){ ?>
                  <li class="dropdown">
                     <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-archive" aria-hidden="true"></span> Bodegas e Inventarios <span class="caret"></span></a>
                     <ul class="dropdown-menu" role="menu">
                     <?php if($_SESSION["GPROV"] == 1){ ?>
                        <li><a href="../CPPROVEEDOR/FRMproveedores.php"><span class="fa fa-users" aria-hidden="true"></span> Proveedores</a></li>
                     <?php } ?>
                     <hr>	
                     <?php if($_SESSION["GARTS"] == 1){ ?>
                        <li><a href="../CPSUMINISTROS/FRMarticulos.php"><span class="fa fa-eraser" aria-hidden="true"></span> Gestor de Suministros</a></li>
                     <?php } ?>
                     <?php if($_SESSION["INVRCARS"] == 1){ ?>
                        <li><a href="../CPINVENTARIOSUMINISTRO/FRMcarga.php"><span class="fa fa-sign-in" aria-hidden="true"></span> Carga a Inventario de Suministros</a></li>
                     <?php } ?>
                     <?php if($_SESSION["INVRDESCS"] == 1){ ?>
                        <li><a href="../CPINVENTARIOSUMINISTRO/FRMdescarga.php"><span class="fa fa-sign-out" aria-hidden="true"></span> Descarga a Inventario de Suministros</a></li>
                     <?php } ?>
                     <?php if($_SESSION["INVHISTS"] == 1){ ?>
                        <li><a href="../CPINVENTARIOSUMINISTRO/FRMhistorial.php"><span class="fa fa-history" aria-hidden="true"></span> Historial a Inventario de Suministros</a></li>
                     <?php } ?>
                     <?php if($_SESSION["KARDEXS"] == 1){ ?>
                        <li><a href="../CPINVENTARIOSUMINISTRO/FRMkardex.php"><span class="fa fa-list-alt" aria-hidden="true"></span> Kardex</a></li>
                     <?php } ?>
                     <hr>
                     <?php if($_SESSION["GARTP"] == 1){ ?>
                        <li><a href="../CPARTPROPIOS/FRMarticulos.php"><span class="fa fa-laptop" aria-hidden="true"></span> Maquinaria y Equipo </a></li>
                     <?php } ?>
                     <?php if($_SESSION["INVRCARP"] == 1){ ?>
                        <li><a href="../CPARTPROPIOS/FRMcarga.php"><span class="fa fa-sign-in" aria-hidden="true"></span> Carga a Inventario de Maquinaria y Equipo</a></li>
                     <?php } ?>
                     <?php if($_SESSION["ACTINVP"] == 1){ ?>
                        <li><a href="../CPARTPROPIOS/FRMmodificar.php"><span class="fa fa-edit" aria-hidden="true"></span> Actualizaci&oacute;n de Inventario de Maquinaria y Equipo</a></li>
                     <?php } ?>
                     <?php if($_SESSION["CALCDEP"] == 1){ ?>
                        <li><a href="../CPARTPROPIOS/FRMdepreciaciones.php"><span class="fa fa-unlink" aria-hidden="true"></span> Depreciaciones</a></li>
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
            <h2 class='text-primary'>M&oacute;dulo Administrativo</h2>
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
   <!-- DataTables JavaScript -->
   <script src="../assets.3.6.2/js/plugins/dataTables/datatables.min.js"></script>
   
   <!-- Custom Theme JavaScript -->
   <script type="text/javascript" src="../assets.3.6.2/js/menu.js"></script>
   <script type="text/javascript" src="../assets.3.6.2/js/core/util.js"></script>
 
   </body>
</html>
<?php 
}else{
	echo "<form id='f1' name='f1' action='../logout.php' method='post'>";
	echo "<script>document.f1.submit();</script>";
	echo "</form>";
}
?>
